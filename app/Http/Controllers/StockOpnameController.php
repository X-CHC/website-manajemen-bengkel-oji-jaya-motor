<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HistoryStok;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function create()
    {
        $barang = Barang::with('kategori')
            ->orderBy('nama_barang')
            ->get();

        $modeStockOpname = Cache::get('stock_opname_mode', false);

        return view(
            'Stock_Opname.create',
            compact(
                'barang',
                'modeStockOpname'
            )
        );
    }


    public function modeOn()
    {
        Cache::forever('stock_opname_mode', true);

        return redirect()
            ->route('stock-opname.create')
            ->with('success', 'Mode stock opname berhasil diaktifkan');
    }


    public function modeOff()
    {
        Cache::forget('stock_opname_mode');

        return redirect()
            ->route('stock-opname.create')
            ->with('success', 'Mode stock opname berhasil dimatikan');
    }


    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK MODE STOCK OPNAME
        |--------------------------------------------------------------------------
        */
        if (!Cache::get('stock_opname_mode', false)) {
            return redirect()
                ->route('stock-opname.create')
                ->with(
                    'error',
                    'Aktifkan mode stock opname terlebih dahulu sebelum menyimpan data.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'id_barang' => 'required|array',
            'id_barang.*' => 'required|exists:tbl_barang,id_barang',

            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0',

        ], [
            'id_barang.required' => 'Data barang wajib ada.',
            'id_barang.array' => 'Format data barang tidak valid.',
            'id_barang.*.required' => 'Barang wajib dipilih.',
            'id_barang.*.exists' => 'Barang tidak ditemukan.',

            'stok_fisik.required' => 'Stok fisik wajib diisi.',
            'stok_fisik.array' => 'Format stok fisik tidak valid.',
            'stok_fisik.*.required' => 'Stok fisik wajib diisi.',
            'stok_fisik.*.integer' => 'Stok fisik harus berupa angka.',
            'stok_fisik.*.min' => 'Stok fisik tidak boleh negatif.',

        ]);


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER STOCK OPNAME
            |--------------------------------------------------------------------------
            | Format: SOP001
            |--------------------------------------------------------------------------
            */
            $lastStockOpname = StockOpname::withTrashed()
                ->orderBy('id_stock_opname', 'desc')
                ->first();

            if (!$lastStockOpname) {
                $numberStockOpname = 1;
            } else {
                $numberStockOpname = (int) substr(
                    $lastStockOpname->id_stock_opname,
                    -3
                ) + 1;
            }

            $idStockOpname = 'SOP' . sprintf('%03s', $numberStockOpname);


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER DETAIL STOCK OPNAME
            |--------------------------------------------------------------------------
            | Format: DSO001
            |--------------------------------------------------------------------------
            */
            $lastDetailStockOpname = DetailStockOpname::withTrashed()
                ->orderBy('id_detail_stock_opname', 'desc')
                ->first();

            if (!$lastDetailStockOpname) {
                $numberDetailStockOpname = 1;
            } else {
                $numberDetailStockOpname = (int) substr(
                    $lastDetailStockOpname->id_detail_stock_opname,
                    -3
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER HISTORY STOK
            |--------------------------------------------------------------------------
            | Format: HS0001
            |--------------------------------------------------------------------------
            */
            $lastHistory = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            if (!$lastHistory) {
                $numberHistory = 1;
            } else {
                $numberHistory = (int) substr(
                    $lastHistory->id_history_stok,
                    -4
                ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HEADER STOCK OPNAME
            |--------------------------------------------------------------------------
            */
            StockOpname::create([
                'id_stock_opname' => $idStockOpname,
                'id_user' => Auth::user()->id_user,
                'tanggal_opname' => now()->format('Y-m-d'),
            ]);


            /*
            |--------------------------------------------------------------------------
            | LOOP BARANG
            |--------------------------------------------------------------------------
            */
            foreach ($request->id_barang as $index => $idBarang) {

                $barang = Barang::findOrFail($idBarang);

                $stokSistem = (int) $barang->jumlah_barang;

                $stokFisik = (int) $request->stok_fisik[$index];

                $selisih = $stokFisik - $stokSistem;


                /*
                |--------------------------------------------------------------------------
                | GENERATE ID DETAIL STOCK OPNAME
                |--------------------------------------------------------------------------
                */
                $idDetailStockOpname = 'DSO' . sprintf(
                    '%03s',
                    $numberDetailStockOpname
                );

                $numberDetailStockOpname++;


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL STOCK OPNAME
                |--------------------------------------------------------------------------
                | Detail tetap disimpan walaupun selisih 0,
                | supaya hasil pengecekan barang tetap tercatat.
                |--------------------------------------------------------------------------
                */
                DetailStockOpname::create([
                    'id_detail_stock_opname' => $idDetailStockOpname,

                    'id_stock_opname' => $idStockOpname,

                    'id_barang' => $barang->id_barang,

                    'stok_sistem' => $stokSistem,

                    'stok_fisik' => $stokFisik,

                    'selisih' => $selisih,
                ]);


                /*
                |--------------------------------------------------------------------------
                | JIKA TIDAK ADA SELISIH
                |--------------------------------------------------------------------------
                | Tidak perlu update stok barang dan tidak perlu masuk history stok.
                |--------------------------------------------------------------------------
                */
                if ($selisih == 0) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE STOK DI TABEL BARANG
                |--------------------------------------------------------------------------
                */
                $barang->update([
                    'jumlah_barang' => $stokFisik,
                ]);


                /*
                |--------------------------------------------------------------------------
                | GENERATE ID HISTORY STOK
                |--------------------------------------------------------------------------
                */
                $idHistory = 'HS' . sprintf('%04s', $numberHistory);

                $numberHistory++;


                /*
                |--------------------------------------------------------------------------
                | SIMPAN HISTORY STOK
                |--------------------------------------------------------------------------
                */
                HistoryStok::create([
                    'id_history_stok' => $idHistory,

                    'id_barang' => $barang->id_barang,

                    'jumlah_masuk' => $selisih > 0 ? $selisih : 0,

                    'jumlah_keluar' => $selisih < 0 ? abs($selisih) : 0,

                    'jumlah_sisa' => $stokFisik,

                    'jumlah_barang' => $stokFisik,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | MATIKAN MODE SETELAH STOCK OPNAME DISIMPAN
            |--------------------------------------------------------------------------
            */
            Cache::forget('stock_opname_mode');

            DB::commit();

            return redirect()
                ->route('stock-opname.create')
                ->with(
                    'success',
                    'Stock opname berhasil disimpan dan mode stock opname dimatikan'
                );

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
