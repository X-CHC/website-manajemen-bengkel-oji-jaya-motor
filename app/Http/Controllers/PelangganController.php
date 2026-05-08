<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function create()
    {
        return view('Pelanggan.create');
    }

    public function index()
    {
        $pelanggan = Pelanggan::latest()->get();

        return view('Pelanggan.index', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|max:255',
            'plat_nomor'     => 'nullable|max:50',
            'merek_motor'    => 'nullable|max:100',
            'warna_motor'    => 'nullable|max:50',
        ]);

        DB::beginTransaction();

        try {

            $pelanggan = new Pelanggan();

            // AUTO NUMBER
            $hasil = Pelanggan::select('id_pelanggan')
                ->orderBy('id_pelanggan', 'desc')
                ->first();

            if (!$hasil) {
                $id_pelanggan = 'PLG001';
            } else {

                $kode = $hasil->id_pelanggan;

                $noUrut = (int) substr($kode, -3);

                $noUrut++;

                $id_pelanggan = 'PLG' . sprintf('%03s', $noUrut);
            }

            $pelanggan->id_pelanggan   = $id_pelanggan;
            $pelanggan->nama_pelanggan = $request->nama_pelanggan;
            $pelanggan->plat_nomor     = $request->plat_nomor;
            $pelanggan->merek_motor    = $request->merek_motor;
            $pelanggan->warna_motor    = $request->warna_motor;

            $pelanggan->save();

            DB::commit();

            return redirect()
                ->route('daftar-pelanggan')
                ->with('success', 'Data pelanggan berhasil ditambahkan');
        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', 'Data pelanggan gagal disimpan');
        }
    }
}
