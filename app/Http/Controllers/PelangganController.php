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
            $pelangganTerakhir = Pelanggan::withTrashed()
                ->orderBy('id_pelanggan', 'desc')
                ->first();

            // Ambil 3 digit terakhir lalu increment
            if (!$pelangganTerakhir) {
                $id_pelanggan = 'PLG001';
            } else {
                $kode = $pelangganTerakhir->id_pelanggan;

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
                ->route('pelanggan.index')
                ->with('success', 'Data pelanggan berhasil ditambahkan');
        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', 'Data pelanggan gagal disimpan');
        }
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('Pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|max:255',
            'plat_nomor'     => 'nullable|max:50',
            'merek_motor'    => 'nullable|max:100',
            'warna_motor'    => 'nullable|max:50',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'nama_pelanggan.max'      => 'Nama pelanggan maksimal 255 karakter',
            'plat_nomor.max'          => 'Plat nomor maksimal 50 karakter',
            'merek_motor.max'         => 'Merek motor maksimal 100 karakter',
            'warna_motor.max'         => 'Warna motor maksimal 50 karakter',
        ]);

        DB::beginTransaction();

        try {

            $pelanggan = Pelanggan::findOrFail($id);

            $pelanggan->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'plat_nomor'     => $request->plat_nomor,
                'merek_motor'    => $request->merek_motor,
                'warna_motor'    => $request->warna_motor,
            ]);

            DB::commit();

            return redirect()
                ->route('pelanggan.index')
                ->with('success', 'Data pelanggan berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', 'Data pelanggan gagal diupdate');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $pelanggan = Pelanggan::findOrFail($id);

            $pelanggan->delete();

            DB::commit();

            return redirect()
                ->route('pelanggan.index')
                ->with('success', 'Data pelanggan berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->with('error', 'Data pelanggan gagal dihapus');
        }
    }
}
