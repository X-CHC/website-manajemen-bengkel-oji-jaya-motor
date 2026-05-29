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
    /*
    |--------------------------------------------------------------------------
    | HALAMAN STOCK OPNAME
    |--------------------------------------------------------------------------
    */
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


    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN MODE STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    public function modeOn()
    {
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

            'keterangan' => 'nullable|max:255',
        ], [
            'id_barang.required' => 'Data barang tidak ditemukan',
            'id_barang.*.exists' => 'Barang tidak valid',

            'stok_toko.required' => 'Stok toko wajib diisi',
            'stok_toko.*.required' => 'Stok toko wajib diisi',
            'stok_toko.*.integer' => 'Stok toko harus berupa angka',
            'stok_toko.*.min' => 'Stok toko tidak boleh negatif',

            'keterangan.max' => 'Keterangan maksimal 255 karakter',
        ]);

        DB::beginTransaction();

        try {

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
            */
            StockOpname::create([
                'id_stock_opname' => $id_stock_opname,
                'id_user' => Auth::user()->id_user,
                'tanggal_opname' => now()->toDateString(),
                'keterangan' => $request->keterangan,
            ]);


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER DETAIL STOCK OPNAME
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
                    -4
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
            | AMBIL DATA BARANG
            |--------------------------------------------------------------------------
            */
            $barangList = Barang::whereIn('id_barang', $request->id_barang)
                ->get()
                ->keyBy('id_barang');


            /*
            |--------------------------------------------------------------------------
            | LOOP BARANG
            |--------------------------------------------------------------------------
            */
            foreach ($request->id_barang as $index => $idBarang) {

                $barang = $barangList->get($idBarang);

                if (!$barang) {
                    continue;
                }

                $stokSistem = (int) $barang->jumlah_barang;

                $stokToko = (int) $request->stok_toko[$index];

                $selisih = $stokToko - $stokSistem;


                /*
                |--------------------------------------------------------------------------
                | JIKA STOK SAMA, DETAIL TETAP DISIMPAN
                |--------------------------------------------------------------------------
                | Supaya laporan stock opname tetap menunjukkan barang yang dicek.
                |--------------------------------------------------------------------------
                */
                $id_detail_stock_opname = 'DSO' . sprintf('%03s', $nomorDetail);

                $nomorDetail++;


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL STOCK OPNAME
                |--------------------------------------------------------------------------
                */
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
                | JIKA TIDAK ADA SELISIH, TIDAK PERLU UPDATE STOK / HISTORY
                |--------------------------------------------------------------------------
                */
                if ($selisih == 0) {
                    continue;
                }


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
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ], [
            'tanggal_awal.required' => 'Tanggal awal wajib diisi',
            'tanggal_awal.date' => 'Tanggal awal tidak valid',

            'tanggal_akhir.required' => 'Tanggal akhir wajib diisi',
            'tanggal_akhir.date' => 'Tanggal akhir tidak valid',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal',
        ]);

        $tanggalAwal = $request->tanggal_awal;

        $tanggalAkhir = $request->tanggal_akhir;

        $periode = date('d-m-Y', strtotime($tanggalAwal)) .
            ' sampai ' .
            date('d-m-Y', strtotime($tanggalAkhir));

        $periodeFile = $tanggalAwal . '-sampai-' . $tanggalAkhir;


        /*
        |--------------------------------------------------------------------------
        | AMBIL DETAIL RIWAYAT STOCK OPNAME
        |--------------------------------------------------------------------------
        */
        $detailStockOpname = DetailStockOpname::with([
                'stockOpname.user.role',
                'barang.kategori',
            ])
            ->whereHas('stockOpname', function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->whereDate('tanggal_opname', '>=', $tanggalAwal)
                    ->whereDate('tanggal_opname', '<=', $tanggalAkhir);
            })
            ->orderBy('created_at', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA EXCEL
        |--------------------------------------------------------------------------
        */
        $data = $detailStockOpname->map(function ($item, $index) use ($periode) {

            if ($item->selisih > 0) {
                $status = 'Stok toko lebih banyak';
            } elseif ($item->selisih < 0) {
                $status = 'Stok toko lebih sedikit';
            } else {
                $status = 'Sesuai';
            }

            return [
                'No' => $index + 1,

                'Periode' => $periode,

                'ID Stock Opname' => $item->id_stock_opname,

                'Tanggal Opname' => optional($item->stockOpname)->tanggal_opname
                    ? date('d-m-Y', strtotime($item->stockOpname->tanggal_opname))
                    : '-',

                'Petugas' => $item->stockOpname->user->email ?? '-',

                'Role Petugas' => $item->stockOpname->user->role->nama_role ?? '-',

                'ID Barang' => $item->id_barang,

                'Nama Barang' => $item->barang->nama_barang ?? '-',

                'Kategori' => $item->barang->kategori->nama_kategori ?? '-',

                'Stok Sistem' => $item->stok_sistem,

                'Stok Toko' => $item->stok_toko,

                'Selisih' => $item->selisih,

                'Status' => $status,

                'Keterangan' => $item->stockOpname->keterangan ?? '-',
            ];
        });


        /*
        |--------------------------------------------------------------------------
        | JIKA DATA KOSONG
        |--------------------------------------------------------------------------
        */
        if ($data->isEmpty()) {
            $data = collect([
                [
                    'No' => '-',
                    'Periode' => $periode,
                    'ID Stock Opname' => '-',
                    'Tanggal Opname' => '-',
                    'Petugas' => '-',
                    'Role Petugas' => '-',
                    'ID Barang' => '-',
                    'Nama Barang' => '-',
                    'Kategori' => '-',
                    'Stok Sistem' => '-',
                    'Stok Toko' => '-',
                    'Selisih' => '-',
                    'Status' => 'Tidak ada data stock opname pada periode ini',
                    'Keterangan' => '-',
                ]
            ]);
        }

        return (new FastExcel($data))
            ->download('riwayat-stock-opname-' . $periodeFile . '.xlsx');
    }
}
