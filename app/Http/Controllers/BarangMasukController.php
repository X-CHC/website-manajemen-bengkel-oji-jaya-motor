<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailMasuk;
use App\Models\DetailPo;
use App\Models\BarangMasuk;
use App\Models\HistoryStok;
use App\Models\Po;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function create()
    {
        $po = Po::with('detailPo.barang')
                ->get();

        return view('Barang_Masuk.create', compact('po'));
    }


    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PO
        |--------------------------------------------------------------------------
        */
        $po = Po::findOrFail($request->id_po);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $request->validate(

        [

            'id_po' => 'required',

            'tanggal_masuk' => 'required|date',

            'total_bayar' => 'required|integer|min:1',

            'harga_beli' => 'required|array',

            'harga_beli.*' => 'required|integer|min:1',

            'jumlah_barang' => 'required|array',

            'jumlah_barang.*' => 'required|integer|min:1',

            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],

        [

        /*
        |--------------------------------------------------------------------------
        | TOTAL BAYAR
        |--------------------------------------------------------------------------
        */
        'total_bayar.required' => 'Total bayar wajib diisi',

        'total_bayar.min' => 'Total bayar tidak boleh kurang dari 1',


        /*
        |--------------------------------------------------------------------------
        | HARGA BELI
        |--------------------------------------------------------------------------
        */
        'harga_beli.*.required' => 'Harga beli wajib diisi',

        'harga_beli.*.min' => 'Harga beli tidak boleh negatif atau 0',


        /*
        |--------------------------------------------------------------------------
        | JUMLAH BARANG
        |--------------------------------------------------------------------------
        */
        'jumlah_barang.*.required' => 'Jumlah barang wajib diisi',

        'jumlah_barang.*.min' => 'Jumlah barang tidak boleh negatif atau 0',


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */
        'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',


        /*
        |--------------------------------------------------------------------------
        | BUKTI BAYAR
        |--------------------------------------------------------------------------
        */
        'bukti_bayar.required' => 'Bukti bayar wajib diupload',

        'bukti_bayar.image' => 'File harus berupa gambar',

        'bukti_bayar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',

        'bukti_bayar.max' => 'Ukuran gambar maksimal 2MB',
    ]
);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TANGGAL MASUK
        |--------------------------------------------------------------------------
        | Tidak boleh sebelum tanggal PO
        */
        if($request->tanggal_masuk < $po->tgl_po)
        {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tanggal barang masuk tidak boleh sebelum tanggal PO'
                );
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO NUMBER BARANG MASUK
            |--------------------------------------------------------------------------
            */
            $last = BarangMasuk::orderBy(
                        'id_barang_masuk',
                        'desc'
                    )->first();

            if(!$last)
            {
                $idBarangMasuk = 'BM0001';
            }
            else
            {
                $number = (int) substr(
                    $last->id_barang_masuk,
                    2
                );

                $number++;

                $idBarangMasuk =
                    'BM' .
                    str_pad($number, 4, '0', STR_PAD_LEFT);
            }


            /*
            |--------------------------------------------------------------------------
            | UPLOAD BUKTI BAYAR
            |--------------------------------------------------------------------------
            */
            $namaFile = null;

            if($request->hasFile('bukti_bayar'))
            {
                $file = $request->file('bukti_bayar');

                $namaFile =
                    time() .
                    '_' .
                    $file->getClientOriginalName();

                $file->move(
                    public_path('assets/bukti_bayar'),
                    $namaFile
                );
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HEADER BARANG MASUK
            |--------------------------------------------------------------------------
            */
            BarangMasuk::create([

                'id_barang_masuk' => $idBarangMasuk,

                'id_po' => $request->id_po,

                'tanggal_masuk' => $request->tanggal_masuk,

                'total_bayar' => $request->total_bayar,

                'bukti_bayar' => $namaFile,
            ]);


            /*
            |--------------------------------------------------------------------------
            | AMBIL DETAIL PO
            |--------------------------------------------------------------------------
            */
            $detailPo = DetailPo::where(
                            'id_po',
                            $request->id_po
                        )->get();


            /*
            |--------------------------------------------------------------------------
            | LOOP DETAIL
            |--------------------------------------------------------------------------
            */
            foreach($detailPo as $index => $item)
            {
                $jumlahMasuk =
                    $request->jumlah_barang[$index];

                $hargaBeli =
                    $request->harga_beli[$index];


                /*
                |--------------------------------------------------------------------------
                | VALIDASI QTY
                |--------------------------------------------------------------------------
                */
                if($jumlahMasuk > $item->jumlah_po)
                {
                    throw new \Exception(
                        'Jumlah masuk melebihi jumlah PO'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | AUTO NUMBER DETAIL
                |--------------------------------------------------------------------------
                */
                $lastDetail = DetailMasuk::orderBy(
                                'id_detail_masuk',
                                'desc'
                            )->first();

                if(!$lastDetail)
                {
                    $idDetail = 'DM0001';
                }
                else
                {
                    $numberDetail = (int) substr(
                        $lastDetail->id_detail_masuk,
                        2
                    );

                    $numberDetail++;

                    $idDetail =
                        'DM' .
                        str_pad(
                            $numberDetail,4,'0',STR_PAD_LEFT
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG SUBTOTAL
                |--------------------------------------------------------------------------
                */
                $subtotal =
                    $jumlahMasuk *
                    $hargaBeli;


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DETAIL MASUK
                |--------------------------------------------------------------------------
                */
                DetailMasuk::create([

                    'id_detail_masuk' => $idDetail,

                    'id_barang_masuk' => $idBarangMasuk,

                    'id_barang' => $item->id_barang,

                    'jumlah_barang' => $jumlahMasuk,

                    'harga_beli' => $hargaBeli,

                    'sub_total' => $subtotal,
                ]);


                /*
                |--------------------------------------------------------------------------
                | UPDATE STOK
                |--------------------------------------------------------------------------
                */
                $barang = Barang::find(
                    $item->id_barang
                );

                $stokBaru =
                    $barang->jumlah_barang +
                    $jumlahMasuk;

                $barang->update([

                    'jumlah_barang' => $stokBaru
                ]);


                /*
                |--------------------------------------------------------------------------
                | AUTO NUMBER HISTORY
                |--------------------------------------------------------------------------
                */
                $lastHistory = HistoryStok::orderBy(
                                    'id_history_stok',
                                    'desc'
                                )->first();

                if(!$lastHistory)
                {
                    $idHistory = 'HS0001';
                }
                else
                {
                    $numberHistory = (int) substr(
                        $lastHistory->id_history_stok,
                        2
                    );

                    $numberHistory++;

                    $idHistory =
                        'HS' .
                        str_pad(
                            $numberHistory,
                            4,
                            '0',
                            STR_PAD_LEFT
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN HISTORY STOK
                |--------------------------------------------------------------------------
                */
                HistoryStok::create([

                    'id_history_stok' => $idHistory,

                    'id_barang' => $item->id_barang,

                    'jumlah_masuk' => $jumlahMasuk,

                    'jumlah_keluar' => 0,

                    'jumlah_sisa' => $stokBaru,

                    'jumlah_barang' => $stokBaru,
                ]);
            }


            DB::commit();

            return redirect()
                ->route('barang-masuk.create')
                ->with(
                    'success',
                    'Barang masuk berhasil disimpan'
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
}
