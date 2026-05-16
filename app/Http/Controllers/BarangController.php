<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\HistoryStok;
use App\Models\DetailTransaksi;
use App\Models\DetailMasuk;
use App\Models\DetailPo;
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


            $barangTerakhir = Barang::withTrashed()
                ->orderBy('id_barang', 'desc')
                ->first();

            // Ambil 3 digit terakhir lalu increment
            if (!$barangTerakhir) {
                $id_barang = 'BRG001';
            } else {
                $kode = $barangTerakhir->id_barang;

                $noUrut = (int) substr($kode, -3);

                $noUrut++;

                $id_barang = 'BRG' . sprintf('%03s', $noUrut);
            }

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


            $historyTerakhir = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            // Ambil 4 digit terakhir lalu increment
            if (!$historyTerakhir) {
                $id_history_stok = 'HS0001';
            } else {
                $kode = $historyTerakhir->id_history_stok;

                $noUrut = (int) substr($kode, -4);

                $noUrut++;

                $id_history_stok = 'HS' . sprintf('%04s', $noUrut);
            }

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
                    ->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        $kategori = KategoriBarang::all();

        return view('Barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {

        //HILANGKAN FORMAT RUPIAH
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $request->validate([
            'id_kategori_barang' => 'required|exists:tbl_kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|max:255',
            'harga_beli' => 'required|integer|min:1',
            'harga_jual' => 'required|integer|min:1',
            'alert_jumlah_barang' => 'required|integer|min:0',
        ], [
            'id_kategori_barang.required' => 'Kategori barang wajib dipilih',
            'id_kategori_barang.exists' => 'Kategori barang tidak valid',

            'nama_barang.required' => 'Nama barang wajib diisi',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter',

            'harga_beli.required' => 'Harga beli wajib diisi',
            'harga_beli.integer' => 'Harga beli harus berupa angka',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 1',

            'harga_jual.required' => 'Harga jual wajib diisi',
            'harga_jual.integer' => 'Harga jual harus berupa angka',
            'harga_jual.min' => 'Harga jual tidak boleh kurang dari 1',

            'alert_jumlah_barang.required' => 'Alert stok wajib diisi',
            'alert_jumlah_barang.integer' => 'Alert stok harus berupa angka',
            'alert_jumlah_barang.min' => 'Alert stok tidak boleh negatif',
        ]);

        DB::beginTransaction();

        try {

            $barang = Barang::findOrFail($id);

            $barang->update([
                'id_kategori_barang' => $request->id_kategori_barang,
                'nama_barang' => $request->nama_barang,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'alert_jumlah_barang' => $request->alert_jumlah_barang,
            ]);

            DB::commit();

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $barang = Barang::findOrFail($id);

            //CEK APAKAH BARANG SUDAH DIPAKAI DI TRANSAKSI / PO / BARANG MASUK
            //Jika sudah dipakai di salah satu tabel ini, barang tidak boleh dihapus.
            $dipakaiTransaksi = DetailTransaksi::where('id_barang', $id)->exists();

            $dipakaiBarangMasuk = DetailMasuk::where('id_barang', $id)->exists();

            $dipakaiPo = DetailPo::where('id_barang', $id)->exists();

            if (
                $dipakaiTransaksi ||
                $dipakaiBarangMasuk ||
                $dipakaiPo
            ) {
                return redirect()
                    ->route('barang.index')
                    ->with(
                        'error',
                        'Barang tidak bisa dihapus karena sudah dipakai di transaksi, PO, atau barang masuk'
                    );
            }

            //HAPUS HISTORY STOK AWAL
            //Karena barang belum dipakai transaksi/PO/barang masuk,
            //history stok yang ada dianggap history awal saat barang dibuat.
            HistoryStok::where('id_barang', $id)->delete();

            //HAPUS BARANG
            $barang->delete();

            DB::commit();

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('barang.index')
                ->with('error', $e->getMessage());
        }
    }
    }
