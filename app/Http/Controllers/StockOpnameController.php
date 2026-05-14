<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HistoryStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function create()
    {
        $barang = Barang::with('kategori')
            ->orderBy('nama_barang')
            ->get();

        return view('Stock_Opname.create', compact('barang'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|array',
            'id_barang.*' => 'required|exists:tbl_barang,id_barang',

            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|integer|min:0',
        ], [
            'stok_fisik.*.required' => 'Stok fisik wajib diisi',
            'stok_fisik.*.integer' => 'Stok fisik harus berupa angka',
            'stok_fisik.*.min' => 'Stok fisik tidak boleh negatif',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER HISTORY STOK
            |--------------------------------------------------------------------------
            */
            $lastHistory = HistoryStok::orderBy(
                'id_history_stok',
                'desc'
            )->first();

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
                | JIKA TIDAK ADA SELISIH, LEWATI
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
                | GENERATE ID HISTORY
                |--------------------------------------------------------------------------
                */
                $idHistory = 'HS' . str_pad(
                    $numberHistory,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

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

            DB::commit();

            return redirect()
                ->route('stock-opname.create')
                ->with('success', 'Stock opname berhasil disimpan');

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
