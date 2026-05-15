<?php

namespace App\Http\Controllers;
use App\Models\KategoriBarang;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{


    public function index()
    {
        $kategori = KategoriBarang::orderBy('created_at', 'desc')->get();

        return view('Kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('Kategori.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'nama_kategori' => 'required|max:100|unique:tbl_kategori_barang,nama_kategori',
            ]);

            $modelKategori = new KategoriBarang();

            // Auto Number
            $kategoriTerakhir = KategoriBarang::withTrashed()
                                ->orderBy('id_kategori_barang', 'desc')
                                ->first();

            if (!$kategoriTerakhir) {
                $id_kategori = 'KTG001';
            } else {
                $kode = $kategoriTerakhir->id_kategori_barang;

                $noUrut = (int) substr($kode, -3);

                $noUrut++;

                $id_kategori = 'KTG' . sprintf('%03s', $noUrut);
            }

            // Simpan
            $modelKategori->id_kategori_barang = $id_kategori;
            $modelKategori->nama_kategori = $request->nama_kategori;

            $modelKategori->save();

            DB::commit();

            return redirect()->route('kategori.index')
                            ->with('success', 'Kategori berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        return view('Kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:tbl_kategori_barang,nama_kategori,' . $id . ',id_kategori_barang',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
        ]);

        DB::beginTransaction();

        try {

            $kategori = KategoriBarang::findOrFail($id);

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            DB::commit();

            return redirect()
                ->route('kategori.index')
                ->with('success', 'Kategori berhasil diupdate');

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

            $kategori = KategoriBarang::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | CEK APAKAH KATEGORI SUDAH DIPAKAI BARANG
            |--------------------------------------------------------------------------
            */
            $dipakaiBarang = Barang::where('id_kategori_barang', $id)->exists();

            if ($dipakaiBarang) {
                return redirect()
                    ->route('kategori.index')
                    ->with(
                        'error',
                        'Kategori tidak bisa dihapus karena sudah dipakai oleh barang'
                    );
            }

            $kategori->delete();

            DB::commit();

            return redirect()
                ->route('kategori.index')
                ->with('success', 'Kategori berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('kategori.index')
                ->with('error', $e->getMessage());
        }
    }
}

