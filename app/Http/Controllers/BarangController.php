<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\HistoryStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{

    public function index()
    {
        $barang = Barang::with('kategori')
                    ->latest()
                    ->get();

        return view('Barang.index', compact('barang'));
    }
    public function create()
    {
        $kategori = KategoriBarang::all();

        return view('Barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_barang' => 'required',
            'nama_barang' => 'required|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'jumlah_barang' => 'required|integer',
            'alert_jumlah_barang' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {

            // AUTO NUMBER BARANG


            $barangTerakhir = Barang::orderBy('id_barang', 'desc')->first();
            $nextBarangNumber = 1;

            if ($barangTerakhir) {
                $nextBarangNumber =
                    (int) preg_replace('/\D/', '', $barangTerakhir->id_barang) +
                    1;
            }

            $id_barang = 'BRG' .
                str_pad($nextBarangNumber, 3, '0', STR_PAD_LEFT);

            // SIMPAN BARANG


            Barang::create([

                'id_barang' => $id_barang,

                'id_kategori_barang' => $request->id_kategori_barang,

                'nama_barang' => $request->nama_barang,

                'harga_beli' => str_replace('.', '', $request->harga_beli),

                'harga_jual' => str_replace('.', '', $request->harga_jual),

                'jumlah_barang' => $request->jumlah_barang,

                'alert_jumlah_barang' => $request->alert_jumlah_barang,
            ]);

            // AUTO NUMBER HISTORY STOK


            $historyTerakhir = HistoryStok::orderBy(
                'id_history_stok',
                'desc'
            )->first();

            $nextHistoryNumber = 1;

            if ($historyTerakhir) {
                $nextHistoryNumber =
                    (int) preg_replace('/\D/', '', $historyTerakhir->id_history_stok) +
                    1;
            }

            $id_history_stok = 'HS' .
                str_pad($nextHistoryNumber, 4, '0', STR_PAD_LEFT);

            // SIMPAN HISTORY STOK AWAL


            HistoryStok::create([

                'id_history_stok' => $id_history_stok,

                'id_barang' => $id_barang,

                'jumlah_masuk' => $request->jumlah_barang,

                'jumlah_keluar' => 0,

                'jumlah_sisa' => $request->jumlah_barang,

                'jumlah_barang' => $request->jumlah_barang,
            ]);

            DB::commit();

            return redirect()
                    ->route('barang.index')
                    ->with('success', 'Barang berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                    ->withInput()
                    ->with('error', 'Barang gagal ditambahkan');
        }
    }
}
