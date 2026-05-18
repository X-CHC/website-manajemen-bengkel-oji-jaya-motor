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
    public function index()
    {
        $barang = Barang::select(
                'id_barang',
                'nama_barang',
                'id_kategori_barang'
            )
            ->orderBy('nama_barang', 'asc')
            ->get();

        $kategori = KategoriBarang::orderBy('nama_kategori', 'asc')
            ->get();

        return view(
            'laporan.index',
            compact(
                'barang',
                'kategori'
            )
        );
    }

    //EXPORT PDF
    //PDF hanya untuk laporan transaksi / penjualan.
    //Isinya rekap, bukan tabel mentah.

    public function exportPdf(Request $request)
    {
        if ($request->jenis_laporan != 'transaksi') {
            return back()->with(
                'error',
                'Cetak PDF hanya tersedia untuk laporan transaksi / penjualan'
            );
        }

        $query = DetailTransaksi::with([
            'barang',
            'transaksi'
        ]);

        //FILTER TANGGAL
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereHas('transaksi', function ($q) use ($request) {
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

        //FILTER KATEGORI
        if ($request->id_kategori) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where(
                    'id_kategori_barang',
                    $request->id_kategori
                );
            });
        }

        //FILTER BARANG MULTI SELECT
        if ($request->id_barang) {
            $query->whereIn(
                'id_barang',
                $request->id_barang
            );
        }

        $rawData = $query->get();

        $totalPendapatan = $rawData->sum('sub_total');

        $rekap = $rawData
            ->groupBy('id_barang')
            ->map(function ($items) {
                return [
                    'nama_barang' => $items->first()->barang->nama_barang ?? '-',
                    'jumlah_terjual' => $items->sum('jumlah_barang'),
                ];
            });

        $pdf = Pdf::loadView(
            'laporan.view',
            compact(
                'rekap',
                'totalPendapatan',
                'request'
            )
        );

        return $pdf->download('laporan-transaksi.pdf');
    }

    //EXPORT EXCEL
    //Excel bisa untuk transaksi, barang masuk, dan history stok.
    //Isinya tabel detail.

    public function exportExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FORMAT PERIODE
        |--------------------------------------------------------------------------
        */
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if ($tanggalAwal && $tanggalAkhir) {
            $periode = date('d-m-Y', strtotime($tanggalAwal)) .
                ' sampai ' .
                date('d-m-Y', strtotime($tanggalAkhir));

            $periodeFile = $tanggalAwal . '-sampai-' . $tanggalAkhir;
        } else {
            $periode = 'Semua Periode';
            $periodeFile = 'semua-periode';
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI
        |--------------------------------------------------------------------------
        */
        if ($request->jenis_laporan == 'transaksi') {
            $query = DetailTransaksi::with([
                'barang',
                'transaksi'
            ]);

            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereHas('transaksi', function ($q) use ($request) {
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

            if ($request->id_kategori) {
                $query->whereHas('barang', function ($q) use ($request) {
                    $q->where(
                        'id_kategori_barang',
                        $request->id_kategori
                    );
                });
            }

            if ($request->id_barang) {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }

            $data = $query->get()->map(function ($item) use ($periode) {
                return [
                    'Periode' => $periode,

                    'Tanggal' => date(
                        'd-m-Y',
                        strtotime($item->transaksi->tanggal_transaksi)
                    ),

                    'ID Transaksi' => $item->id_transaksi,

                    'Barang' => $item->barang->nama_barang ?? '-',

                    'Jumlah' => $item->jumlah_barang,

                    'Harga Barang' => $item->harga_barang,

                    'Subtotal' => $item->sub_total,
                ];
            });

            return (new FastExcel($data))
                ->download('laporan-transaksi-' . $periodeFile . '.xlsx');
        }


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */
        if ($request->jenis_laporan == 'barang_masuk') {
            $query = DetailMasuk::with([
                'barang',
                'barangMasuk'
            ]);

            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereHas('barangMasuk', function ($q) use ($request) {
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

            if ($request->id_kategori) {
                $query->whereHas('barang', function ($q) use ($request) {
                    $q->where(
                        'id_kategori_barang',
                        $request->id_kategori
                    );
                });
            }

            if ($request->id_barang) {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }

            $data = $query->get()->map(function ($item) use ($periode) {
                return [
                    'Periode' => $periode,

                    'Tanggal Masuk' => date(
                        'd-m-Y',
                        strtotime($item->barangMasuk->tanggal_masuk)
                    ),

                    'ID Barang Masuk' => $item->id_barang_masuk,

                    'Barang' => $item->barang->nama_barang ?? '-',

                    'Jumlah Masuk' => $item->jumlah_barang,

                    'Harga Beli' => $item->harga_beli,

                    'Subtotal' => $item->sub_total,
                ];
            });

            return (new FastExcel($data))
                ->download('laporan-barang-masuk-' . $periodeFile . '.xlsx');
        }


        /*
        |--------------------------------------------------------------------------
        | HISTORY STOK
        |--------------------------------------------------------------------------
        */
        if ($request->jenis_laporan == 'history_stok') {
            $query = HistoryStok::with('barang');

            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $request->tanggal_awal
                )
                ->whereDate(
                    'created_at',
                    '<=',
                    $request->tanggal_akhir
                );
            }

            if ($request->id_kategori) {
                $query->whereHas('barang', function ($q) use ($request) {
                    $q->where(
                        'id_kategori_barang',
                        $request->id_kategori
                    );
                });
            }

            if ($request->id_barang) {
                $query->whereIn(
                    'id_barang',
                    $request->id_barang
                );
            }

            $data = $query->get()->map(function ($item) use ($periode) {
                return [
                    'Periode' => $periode,

                    'Tanggal' => date(
                        'd-m-Y H:i',
                        strtotime($item->created_at)
                    ),

                    'Barang' => $item->barang->nama_barang ?? '-',

                    'Jumlah Masuk' => $item->jumlah_masuk,

                    'Jumlah Keluar' => $item->jumlah_keluar,

                    'Jumlah Sisa' => $item->jumlah_sisa,

                    'Jumlah Barang' => $item->jumlah_barang,
                ];
            });

            return (new FastExcel($data))
                ->download('laporan-history-stok-' . $periodeFile . '.xlsx');
        }

        return back()->with(
            'error',
            'Jenis laporan tidak valid'
        );
    }
}
