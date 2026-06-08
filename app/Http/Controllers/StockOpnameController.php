<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HistoryStok;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Rap2hpoutre\FastExcel\FastExcel;

class StockOpnameController extends Controller
{

    public function create()
    {
        $barang = Barang::with('kategori')
            ->orderBy('nama_barang', 'asc')
            ->get();

        $modeStockOpname = Cache::get('stock_opname_mode', false);

        /*
        |--------------------------------------------------------------------------
        | CEK STOCK OPNAME BULAN INI
        |--------------------------------------------------------------------------
        */
        $jumlahStockOpnameBulanIni = StockOpname::whereMonth('tanggal_opname', now()->month)
            ->whereYear('tanggal_opname', now()->year)
            ->count();

        return view(
            'Stock_Opname.create',
            compact(
                'barang',
                'modeStockOpname',
                'jumlahStockOpnameBulanIni'
            )
        );
    }

    public function index()
    {
        $stockOpname = StockOpname::with([
                'user.role',
                'detailStockOpname.barang.kategori',
            ])
            ->orderBy('tanggal_opname', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'Stock_Opname.index',
            compact('stockOpname')
        );
    }

    public function modeOn()
    {
        $jumlahStockOpnameBulanIni = StockOpname::whereMonth('tanggal_opname', now()->month)
            ->whereYear('tanggal_opname', now()->year)
            ->count();

        if ($jumlahStockOpnameBulanIni > 0) {
            return redirect()
                ->route('stock-opname.create')
                ->with('error', 'Bulan ini sudah ada stock opname. Mode stock opname tidak bisa diaktifkan lagi.');
        }

        Cache::put('stock_opname_mode', true);

        return redirect()
            ->route('stock-opname.create')
            ->with('success', 'Mode stock opname berhasil diaktifkan');
    }


    /*
    |--------------------------------------------------------------------------
    | MATIKAN MODE STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    public function modeOff()
    {
        Cache::forget('stock_opname_mode');

        return redirect()
            ->route('stock-opname.create')
            ->with('success', 'Mode stock opname berhasil dimatikan');
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN HASIL STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $modeStockOpname = Cache::get('stock_opname_mode', false);

        if (!$modeStockOpname) {
            return redirect()
                ->route('stock-opname.create')
                ->with('error', 'Mode stock opname belum aktif');
        }

        $request->validate([
            'id_barang' => 'required|array',
            'id_barang.*' => 'required|exists:tbl_barang,id_barang',

            'stok_toko' => 'required|array',
            'stok_toko.*' => 'required|integer|min:0',
        ], [
            'id_barang.required' => 'Data barang tidak ditemukan',
            'id_barang.*.exists' => 'Barang tidak valid',

            'stok_toko.required' => 'Stok toko wajib diisi',
            'stok_toko.*.required' => 'Stok toko wajib diisi',
            'stok_toko.*.integer' => 'Stok toko harus berupa angka',
            'stok_toko.*.min' => 'Stok toko tidak boleh negatif',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA BARANG
            |--------------------------------------------------------------------------
            */
            $barangList = Barang::whereIn('id_barang', $request->id_barang)
                ->get()
                ->keyBy('id_barang');


            /*
            |--------------------------------------------------------------------------
            | CEK BARANG YANG BERUBAH SAJA
            |--------------------------------------------------------------------------
            | Barang yang stok toko sama dengan stok sistem tidak akan disimpan.
            |--------------------------------------------------------------------------
            */
            $barangBerubah = [];

            foreach ($request->id_barang as $index => $idBarang) {

                $barang = $barangList->get($idBarang);

                if (!$barang) {
                    continue;
                }

                $stokSistem = (int) $barang->jumlah_barang;

                $stokToko = (int) $request->stok_toko[$index];

                $selisih = $stokToko - $stokSistem;

                if ($selisih == 0) {
                    continue;
                }

                $barangBerubah[] = [
                    'barang' => $barang,
                    'stok_sistem' => $stokSistem,
                    'stok_toko' => $stokToko,
                    'selisih' => $selisih,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | JIKA TIDAK ADA BARANG YANG BERUBAH
            |--------------------------------------------------------------------------
            | Tidak perlu membuat header stock opname, detail, history, atau update stok.
            |--------------------------------------------------------------------------
            */
            if (count($barangBerubah) == 0) {

                DB::rollBack();

                return redirect()
                    ->route('stock-opname.create')
                    ->with('info', 'Tidak ada perubahan stok yang disimpan');
            }


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER STOCK OPNAME
            |--------------------------------------------------------------------------
            */
            $stockOpnameTerakhir = StockOpname::withTrashed()
                ->orderBy('id_stock_opname', 'desc')
                ->first();

            if (!$stockOpnameTerakhir) {
                $id_stock_opname = 'SO0001';
            } else {
                $kode = $stockOpnameTerakhir->id_stock_opname;

                $noUrut = (int) substr($kode, -4);

                $noUrut++;

                $id_stock_opname = 'SO' . sprintf('%04s', $noUrut);
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HEADER STOCK OPNAME
            |--------------------------------------------------------------------------
            | Header hanya dibuat kalau ada barang yang benar-benar berubah.
            |--------------------------------------------------------------------------
            */
            StockOpname::create([
                'id_stock_opname' => $id_stock_opname,
                'id_user' => Auth::user()->id_user,
                'tanggal_opname' => now()->toDateString(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER DETAIL STOCK OPNAME
            |--------------------------------------------------------------------------
            | DSO001 = 6 karakter, sesuai char(6).
            |--------------------------------------------------------------------------
            */
            $detailTerakhir = DetailStockOpname::withTrashed()
                ->orderBy('id_detail_stock_opname', 'desc')
                ->first();

            if (!$detailTerakhir) {
                $nomorDetail = 1;
            } else {
                $nomorDetail = (int) substr(
                    $detailTerakhir->id_detail_stock_opname,
                    -3
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER HISTORY STOK
            |--------------------------------------------------------------------------
            */
            $historyTerakhir = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            if (!$historyTerakhir) {
                $nomorHistory = 1;
            } else {
                $nomorHistory = (int) substr(
                    $historyTerakhir->id_history_stok,
                    -4
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HANYA BARANG YANG BERUBAH
            |--------------------------------------------------------------------------
            */
            foreach ($barangBerubah as $data) {

                $barang = $data['barang'];

                $stokSistem = $data['stok_sistem'];

                $stokToko = $data['stok_toko'];

                $selisih = $data['selisih'];


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL STOCK OPNAME
                |--------------------------------------------------------------------------
                */
                $id_detail_stock_opname = 'DSO' . sprintf('%03s', $nomorDetail);

                $nomorDetail++;

                DetailStockOpname::create([
                    'id_detail_stock_opname' => $id_detail_stock_opname,
                    'id_stock_opname' => $id_stock_opname,
                    'id_barang' => $barang->id_barang,
                    'stok_sistem' => $stokSistem,
                    'stok_toko' => $stokToko,
                    'selisih' => $selisih,
                ]);


                /*
                |--------------------------------------------------------------------------
                | UPDATE STOK BARANG
                |--------------------------------------------------------------------------
                */
                $barang->update([
                    'jumlah_barang' => $stokToko,
                ]);


                /*
                |--------------------------------------------------------------------------
                | SIMPAN HISTORY STOK
                |--------------------------------------------------------------------------
                */
                $id_history_stok = 'HS' . sprintf('%04s', $nomorHistory);

                $nomorHistory++;

                HistoryStok::create([
                    'id_history_stok' => $id_history_stok,
                    'id_barang' => $barang->id_barang,
                    'jumlah_masuk' => $selisih > 0 ? $selisih : 0,
                    'jumlah_keluar' => $selisih < 0 ? abs($selisih) : 0,
                    'jumlah_sisa' => $stokToko,
                    'jumlah_barang' => $stokToko,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | MATIKAN MODE STOCK OPNAME SETELAH SIMPAN
            |--------------------------------------------------------------------------
            */
            Cache::forget('stock_opname_mode');

            DB::commit();

            return redirect()
                ->route('stock-opname.create')
                ->with('success', 'Stock opname berhasil disimpan');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL RIWAYAT STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'id_stock_opname' => 'required|exists:tbl_stock_opname,id_stock_opname',
        ], [
            'id_stock_opname.required' => 'Data stock opname wajib dipilih',
            'id_stock_opname.exists' => 'Data stock opname tidak ditemukan',
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA STOCK OPNAME
        |--------------------------------------------------------------------------
        */
        $stockOpname = StockOpname::with([
                'user.role',
                'detailStockOpname.barang.kategori',
            ])
            ->where('id_stock_opname', $request->id_stock_opname)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | FORMAT PERIODE
        |--------------------------------------------------------------------------
        */
        $periode = $stockOpname->tanggal_opname
            ? date('d-m-Y', strtotime($stockOpname->tanggal_opname))
            : '-';

        $periodeFile = $stockOpname->tanggal_opname
            ? date('Y-m-d', strtotime($stockOpname->tanggal_opname))
            : now()->format('Y-m-d');


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA EXCEL
        |--------------------------------------------------------------------------
        */
        $data = collect();

        $nomor = 1;

        foreach ($stockOpname->detailStockOpname as $detail) {

            if ($detail->selisih > 0) {
                $status = 'Stok toko lebih banyak';
            } elseif ($detail->selisih < 0) {
                $status = 'Stok toko lebih sedikit';
            } else {
                $status = 'Sesuai';
            }

            $data->push([
                'No' => $nomor++,

                'ID Stock Opname' => $stockOpname->id_stock_opname,

                'Tanggal Opname' => $periode,

                'Petugas' => $stockOpname->user->email ?? '-',

                'Role Petugas' => $stockOpname->user->role->nama_role ?? '-',

                'ID Detail' => $detail->id_detail_stock_opname,

                'ID Barang' => $detail->id_barang,

                'Nama Barang' => $detail->barang->nama_barang ?? '-',

                'Kategori' => $detail->barang->kategori->nama_kategori ?? '-',

                'Stok Sistem' => $detail->stok_sistem,

                'Stok Toko' => $detail->stok_toko,

                'Selisih' => $detail->selisih,

                'Status' => $status,

                'Keterangan' => $stockOpname->keterangan ?? '-',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA DATA KOSONG
        |--------------------------------------------------------------------------
        */
        if ($data->isEmpty()) {

            $data = collect([
                [
                    'No' => '-',
                    'ID Stock Opname' => $stockOpname->id_stock_opname,
                    'Tanggal Opname' => $periode,
                    'Petugas' => $stockOpname->user->email ?? '-',
                    'Role Petugas' => $stockOpname->user->role->nama_role ?? '-',
                    'ID Detail' => '-',
                    'ID Barang' => '-',
                    'Nama Barang' => '-',
                    'Kategori' => '-',
                    'Stok Sistem' => '-',
                    'Stok Toko' => '-',
                    'Selisih' => '-',
                    'Status' => 'Belum ada detail stock opname',
                    'Keterangan' => $stockOpname->keterangan ?? '-',
                ]
            ]);
        }

        return (new FastExcel($data))
            ->download(
                'stock-opname-' .
                $stockOpname->id_stock_opname .
                '-' .
                $periodeFile .
                '.xlsx'
            );
    }
}
