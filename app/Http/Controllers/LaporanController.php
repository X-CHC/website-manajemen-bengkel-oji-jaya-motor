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

        // FILTER TANGGAL
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

        // FILTER KATEGORI
        if ($request->id_kategori) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where(
                    'id_kategori_barang',
                    $request->id_kategori
                );
            });
        }

        // FILTER BARANG MULTI SELECT
        if ($request->id_barang) {
            $query->whereIn(
                'id_barang',
                $request->id_barang
            );
        }

        $rawData = $query->get();


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL PENJUALAN BARANG
        |--------------------------------------------------------------------------
        | Total ini hanya dari detail barang, belum termasuk jasa.
        |--------------------------------------------------------------------------
        */
        $totalPenjualanBarang = $rawData->sum('sub_total');


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL MODAL BARANG
        |--------------------------------------------------------------------------
        | Modal = harga_beli barang x jumlah terjual.
        |--------------------------------------------------------------------------
        */
        $totalModalBarang = $rawData->sum(function ($item) {

            $hargaBeli = $item->barang->harga_beli ?? 0;

            return $hargaBeli * $item->jumlah_barang;
        });


        /*
        |--------------------------------------------------------------------------
        | HITUNG LABA KOTOR BARANG
        |--------------------------------------------------------------------------
        */
        $labaKotor = $totalPenjualanBarang - $totalModalBarang;


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL JASA
        |--------------------------------------------------------------------------
        | Distinct id_transaksi supaya harga_jasa tidak dobel saat transaksi
        | punya banyak detail barang.
        |--------------------------------------------------------------------------
        */
        $transaksiUnik = $rawData
            ->pluck('transaksi')
            ->filter()
            ->unique('id_transaksi');

        $totalJasa = $transaksiUnik->sum('harga_jasa');


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL PENDAPATAN DAN LABA BERSIH SEMENTARA
        |--------------------------------------------------------------------------
        | Laba bersih sementara = laba barang + jasa.
        | Belum dikurangi biaya operasional karena belum ada tabel biaya.
        |--------------------------------------------------------------------------
        */
        $totalPendapatan = $totalPenjualanBarang + $totalJasa;

        $labaBersih = $labaKotor + $totalJasa;


        /*
        |--------------------------------------------------------------------------
        | REKAP PER BARANG
        |--------------------------------------------------------------------------
        */
        $rekap = $rawData
            ->groupBy('id_barang')
            ->map(function ($items) {

                $barang = $items->first()->barang;

                $jumlahTerjual = $items->sum('jumlah_barang');

                $hargaBeli = $barang->harga_beli ?? 0;

                $hargaJual = $barang->harga_jual ?? $items->first()->harga_barang ?? 0;

                $totalModal = $hargaBeli * $jumlahTerjual;

                $totalHarga = $items->sum('sub_total');

                $labaBarang = $totalHarga - $totalModal;

                return [
                    'nama_barang' => $barang->nama_barang ?? '-',

                    'jumlah_terjual' => $jumlahTerjual,

                    'harga_beli' => $hargaBeli,

                    'harga_jual' => $hargaJual,

                    'total_modal' => $totalModal,

                    'total_harga' => $totalHarga,

                    'laba_barang' => $labaBarang,
                ];
            });

        $pdf = Pdf::loadView(
            'laporan.view',
            compact(
                'rekap',
                'totalPenjualanBarang',
                'totalModalBarang',
                'labaKotor',
                'totalJasa',
                'totalPendapatan',
                'labaBersih',
                'request'
            )
        );

        return $pdf->download('laporan-transaksi.pdf');
    }

    //EXPORT EXCEL

    public function exportExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FORMAT PERIODE (Hanya untuk Nama File)
        |--------------------------------------------------------------------------
        */
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        if ($tanggalAwal && $tanggalAkhir) {
            $periodeFile = $tanggalAwal . '-sampai-' . $tanggalAkhir;
        } else {
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

            // Hapus use ($periode) karena sudah tidak dipakai
            $data = $query->get()->map(function ($item) {
                return [
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

            // Hapus use ($periode) karena sudah tidak dipakai
            $data = $query->get()->map(function ($item) {
                return [
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

        return back()->with(
            'error',
            'Jenis laporan tidak valid'
        );
    }
}
