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
        $po = Po::latest()->get();

        return view('po.index', compact('po'));
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

            $poTerakhir = Po::orderBy('id_po', 'desc')->first();

            if(!$poTerakhir)
            {
                $id_po = 'PO0001';
            }
            else
            {
                $noUrut = (int) substr($poTerakhir->id_po, -4);

                $noUrut++;

                $id_po = 'PO' . sprintf('%04s', $noUrut);
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
            ]);


            /*
            |--------------------------------------------------------------------------
            | LOOP DETAIL PO
            |--------------------------------------------------------------------------
            */

            foreach($request->id_barang as $key => $barangId)
            {
                /*
                |--------------------------------------------------------------------------
                | AUTO NUMBER DETAIL PO
                |--------------------------------------------------------------------------
                */

                $detailTerakhir = DetailPo::orderBy('id_detail_po', 'desc')->first();

                if(!$detailTerakhir)
                {
                    $id_detail_po = 'DPO001';
                }
                else
                {
                    $noUrutDetail = (int) substr($detailTerakhir->id_detail_po, -3);

                    $noUrutDetail++;

                    $id_detail_po = 'DPO' . sprintf('%03s', $noUrutDetail + $key);
                }

                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL PO
                |--------------------------------------------------------------------------
                */

                DetailPo::create([

                    'id_detail_po' => $id_detail_po,

                    'id_po' => $id_po,

                    'id_barang' => $barangId,

                    'jumlah_po' => $request->jumlah_po[$key],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('po.index')
                ->with('success', 'PO berhasil dibuat');
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
