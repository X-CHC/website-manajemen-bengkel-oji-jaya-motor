<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\KategoriBarang;

use App\Models\DetailTransaksi;
use App\Models\DetailMasuk;
use App\Models\HistoryStok;

use Barryvdh\DomPDF\Facade\Pdf;

use Rap2hpoutre\FastExcel\FastExcel;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $barang = Barang::select(
                'id_barang',
                'nama_barang',
                'id_kategori_barang'
            )->get();

        $kategori = KategoriBarang::all();

        return view(
            'laporan.index',
            compact(
                'barang',
                'kategori'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI
        |--------------------------------------------------------------------------
        */
        if($request->jenis_laporan == 'transaksi')
        {
            $query = DetailTransaksi::with([
                        'barang',
                        'transaksi'
                    ]);


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */
            if(
                $request->tanggal_awal &&
                $request->tanggal_akhir
            )
            {
                $query->whereHas(
                    'transaksi',
                    function($q) use ($request){

                    $q->whereDate(
                        'tanggal_transaksi',
                        '>=',
                        $request->tanggal_awal
                    )
                    ->whereDate(
                        'tanggal_transaksi',
                        '<=',
                        $request->tanggal_akhir
                    );
                });
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER KATEGORI
            |--------------------------------------------------------------------------
            */
            if($request->id_kategori)
            {
                $query->whereHas(
                    'barang',
                    function($q) use ($request){

                    $q->where(
                        'id_kategori',
                        $request->id_kategori
                    );
                });
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER BARANG
            |--------------------------------------------------------------------------
            */
            if($request->id_barang)
            {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }


            /*
            |--------------------------------------------------------------------------
            | REKAP
            |--------------------------------------------------------------------------
            */
            // 1. Ambil semua data hasil filter terlebih dahulu
            $rawData = $query->get();

            // 2. Hitung Total Pendapatan dengan menjumlahkan kolom 'sub_total' dari detail transaksi
            $totalPendapatan = $rawData->sum('sub_total');

            // 3. Kelompokkan data ke dalam variabel $rekap (sesuai nama di View)
            $rekap = $rawData->groupBy('id_barang')->map(function($items){
                return [
                    'nama_barang' => $items->first()->barang->nama_barang,
                    // Ubah key 'total' menjadi 'jumlah_terjual' agar sesuai dengan View
                    'jumlah_terjual' => $items->sum('jumlah_barang'),
                ];
            });

            // 4. Kirim variabel $rekap dan $totalPendapatan ke dalam View
            $pdf = Pdf::loadView(
                'laporan.view',
                compact('rekap', 'totalPendapatan') // Kirim kedua variabel ke PDF
            );

            return $pdf->download(
                'laporan-transaksi.pdf'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */
        if($request->jenis_laporan == 'barang_masuk')
        {
            $query = DetailMasuk::with([
                        'barang',
                        'barangMasuk'
                    ]);


            if(
                $request->tanggal_awal &&
                $request->tanggal_akhir
            )
            {
                $query->whereHas(
                    'barangMasuk',
                    function($q) use ($request){

                    $q->whereDate(
                        'tanggal_masuk',
                        '>=',
                        $request->tanggal_awal
                    )
                    ->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $request->tanggal_akhir
                    );
                });
            }


            if($request->id_kategori)
            {
                $query->whereHas(
                    'barang',
                    function($q) use ($request){

                    $q->where(
                        'id_kategori',
                        $request->id_kategori
                    );
                });
            }


            if($request->id_barang)
            {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }


            $data = $query->get()
                        ->groupBy('id_barang')
                        ->map(function($items){

                return [

                    'nama_barang' =>
                        $items->first()
                              ->barang
                              ->nama_barang,

                    'total' =>
                        $items->sum('jumlah_barang'),
                ];
            });

            $pdf = Pdf::loadView(
                'laporan.pdf.barang_masuk',
                compact('data')
            );

            return $pdf->download(
                'laporan-barang-masuk.pdf'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HISTORY STOK
        |--------------------------------------------------------------------------
        */
        if($request->jenis_laporan == 'history_stok')
        {
            $query = HistoryStok::with('barang');


            if($request->id_kategori)
            {
                $query->whereHas(
                    'barang',
                    function($q) use ($request){

                    $q->where(
                        'id_kategori',
                        $request->id_kategori
                    );
                });
            }


            if($request->id_barang)
            {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }


            $data = $query->get()
                        ->groupBy('id_barang')
                        ->map(function($items){

                return [

                    'nama_barang' =>
                        $items->first()
                              ->barang
                              ->nama_barang,

                    'masuk' =>
                        $items->sum('jumlah_masuk'),

                    'keluar' =>
                        $items->sum('jumlah_keluar'),
                ];
            });

            $pdf = Pdf::loadView(
                'laporan.pdf.history_stok',
                compact('data')
            );

            return $pdf->download(
                'laporan-history-stok.pdf'
            );
        }


        return back()->with(
            'error',
            'Jenis laporan tidak valid'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI
        |--------------------------------------------------------------------------
        */
        if($request->jenis_laporan == 'transaksi')
        {
            $query = DetailTransaksi::with([
                        'barang',
                        'transaksi'
                    ]);


            if(
                $request->tanggal_awal &&
                $request->tanggal_akhir
            )
            {
                $query->whereHas(
                    'transaksi',
                    function($q) use ($request){

                    $q->whereDate(
                        'tanggal_transaksi',
                        '>=',
                        $request->tanggal_awal
                    )
                    ->whereDate(
                        'tanggal_transaksi',
                        '<=',
                        $request->tanggal_akhir
                    );
                });
            }


            if($request->id_kategori)
            {
                $query->whereHas(
                    'barang',
                    function($q) use ($request){

                    $q->where(
                        'id_kategori',
                        $request->id_kategori
                    );
                });
            }


            if($request->id_barang)
            {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }


            $data = $query->get()->map(function($item){

                return [

                    'Tanggal' =>
                        date(
                            'd-m-Y',
                            strtotime(
                                $item->transaksi
                                     ->tanggal_transaksi
                            )
                        ),

                    'Barang' =>
                        $item->barang
                             ->nama_barang,

                    'Jumlah' =>
                        $item->jumlah_barang,

                    'Harga' =>
                        $item->harga_barang,

                    'Subtotal' =>
                        $item->sub_total,
                ];
            });


            return (new FastExcel($data))
                    ->download(
                        'laporan-transaksi.xlsx'
                    );
        }


        return back()->with(
            'error',
            'Jenis laporan tidak valid'
        );
    }
}
