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

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER BARANG
            |--------------------------------------------------------------------------
            */

            $barangTerakhir = Barang::orderBy('id_barang', 'desc')->first();

            if (!$barangTerakhir) {

                $id_barang = 'BRG001';

            } else {

                $kode = $barangTerakhir->id_barang;

                $noUrut = (int) substr($kode, -3);

                $noUrut++;

                $id_barang = 'BRG' . sprintf('%03s', $noUrut);
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN BARANG
            |--------------------------------------------------------------------------
            */

            Barang::create([

                'id_barang' => $id_barang,

                'id_kategori_barang' => $request->id_kategori_barang,

                'nama_barang' => $request->nama_barang,

                'harga_beli' => str_replace('.', '', $request->harga_beli),

                'harga_jual' => str_replace('.', '', $request->harga_jual),

                'jumlah_barang' => $request->jumlah_barang,

                'alert_jumlah_barang' => $request->alert_jumlah_barang,
            ]);

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER HISTORY STOK
            |--------------------------------------------------------------------------
            */

            $historyTerakhir = HistoryStok::orderBy(
                'id_history_stok',
                'desc'
            )->first();

            if (!$historyTerakhir) {

                $id_history_stok = 'HST001';

            } else {

                $kodeHistory = $historyTerakhir->id_history_stok;

                $noUrutHistory = (int) substr($kodeHistory, -3);

                $noUrutHistory++;

                $id_history_stok = 'HST' .
                    sprintf('%03s', $noUrutHistory);
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN HISTORY STOK AWAL
            |--------------------------------------------------------------------------
            */

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
