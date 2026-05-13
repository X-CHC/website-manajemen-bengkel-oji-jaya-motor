<?php

namespace App\Http\Controllers;
use App\Models\KategoriBarang;
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
            $hasil = KategoriBarang::selectRaw('MAX(id_kategori_barang) as max_id')->first();

            $nextKategoriNumber = 1;

            if ($hasil && $hasil->max_id) {
                $nextKategoriNumber =
                    (int) preg_replace('/\D/', '', $hasil->max_id) +
                    1;
            }

            $id_kategori = 'KTG' .
                str_pad($nextKategoriNumber, 3, '0', STR_PAD_LEFT);

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
}

