<?php

namespace App\Http\Controllers;

use App\Models\Po;
use App\Models\Barang;
use App\Models\DetailPo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoController extends Controller
{
    public function index()
    {
        $po = Po::with([
                    'detailPo.barang'
                ])
                ->latest()
                ->get();

        return view(
            'po.index',
            compact('po')
        );
    }


    public function create()
    {
        $barang = Barang::orderBy('nama_barang')->get();

        return view('po.create', compact('barang'));
    }


    public function store(Request $request)
    {
        $request->validate([

            'mitra_po' => 'required|max:255',

            'id_barang' => 'required|array',

            'id_barang.*' => 'required|exists:tbl_barang,id_barang',

            'jumlah_po' => 'required|array',

            'jumlah_po.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER PO
            |--------------------------------------------------------------------------
            */
            $poTerakhir = Po::orderBy(
                                'id_po',
                                'desc'
                            )->first();

            if(!$poTerakhir)
            {
                $id_po = 'PO0001';
            }
            else
            {
                $noUrut = (int) substr(
                                    $poTerakhir->id_po,
                                    -4
                                );

                $noUrut++;

                $id_po =
                    'PO' .
                    sprintf('%04s', $noUrut);
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN PO
            |--------------------------------------------------------------------------
            */
            Po::create([

                'id_po' => $id_po,

                'tgl_po' => now(),

                'mitra_po' => $request->mitra_po,

                'status_po' => 'pending',
            ]);


            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER DETAIL PO
            |--------------------------------------------------------------------------
            */
            $lastDetail = DetailPo::orderBy(
                                'id_detail_po',
                                'desc'
                            )->first();

            if(!$lastDetail)
            {
                $numberDetail = 1;
            }
            else
            {
                $numberDetail = (int) substr(
                                            $lastDetail->id_detail_po,
                                            -3
                                        ) + 1;
            }


            /*
            |--------------------------------------------------------------------------
            | LOOP DETAIL
            |--------------------------------------------------------------------------
            */
            foreach($request->id_barang as $index => $barangId)
            {

                $id_detail =
                    'DPO' .
                    sprintf('%03s', $numberDetail);

                $numberDetail++;

                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL PO
                |--------------------------------------------------------------------------
                */
                DetailPo::create([

                    'id_detail_po' => $id_detail,

                    'id_po' => $id_po,

                    'id_barang' => $barangId,

                    'jumlah_po' => $request->jumlah_po[$index],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('po.index')
                ->with(
                    'success',
                    'PO berhasil dibuat'
                );

        }
        catch(\Exception $e)
        {
            DB::rollback();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $po = Po::with([
                    'detailPo.barang'
                ])
                ->findOrFail($id);

        return view(
            'po.edit',
            compact('po')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request,$id)
    {
        $request->validate([

            'mitra_po' =>
                'required|max:255',

            'jumlah_po' =>
                'required|array',

            'jumlah_po.*' =>
                'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $po = Po::with(
                        'detailPo'
                    )
                    ->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | UPDATE HEADER
            |--------------------------------------------------------------------------
            */
            $po->update([

                'mitra_po' =>
                    $request->mitra_po
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE DETAIL
            |--------------------------------------------------------------------------
            */
            foreach(
                $po->detailPo
                as $index => $detail
            )
            {
                $detail->update([

                    'jumlah_po' =>
                        $request->jumlah_po[$index]
                ]);
            }

            DB::commit();

            return redirect()
                ->route('po.index')
                ->with(
                    'success',
                    'PO berhasil diupdate'
                );

        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $po = Po::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | VALIDASI
            |--------------------------------------------------------------------------
            */
            if($po->status_po == 'selesai')
            {
                return back()->with(

                    'error',
                    'PO yang sudah diproses tidak bisa dihapus'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS DETAIL
            |--------------------------------------------------------------------------
            */
            DetailPo::where(
                'id_po',
                $po->id_po
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | HAPUS HEADER
            |--------------------------------------------------------------------------
            */
            $po->delete();

            DB::commit();

            return redirect()
                ->route('po.index')
                ->with(
                    'success',
                    'PO berhasil dihapus'
                );

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with(

                'error',
                $e->getMessage()
            );
        }
    }
}
