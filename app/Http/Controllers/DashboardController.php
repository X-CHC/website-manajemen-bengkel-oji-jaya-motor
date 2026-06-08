<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Transaksi;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ROLE USER
        |--------------------------------------------------------------------------
        */
        $role = strtolower(Auth::user()->role->nama_role ?? '');


        /*
        |--------------------------------------------------------------------------
        | PENDAPATAN HARI INI
        |--------------------------------------------------------------------------
        */
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', today())
            ->sum('total_harga');


        /*
        |--------------------------------------------------------------------------
        | JUMLAH TRANSAKSI HARI INI
        |--------------------------------------------------------------------------
        */
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', today())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PELANGGAN
        |--------------------------------------------------------------------------
        */
        $totalPelanggan = Pelanggan::count();


        /*
        |--------------------------------------------------------------------------
        | BARANG STOK MENIPIS
        |--------------------------------------------------------------------------
        | Stok menipis jika jumlah_barang <= alert_jumlah_barang.
        |--------------------------------------------------------------------------
        */
        $barangStokMenipis = Barang::with('kategori')
            ->whereColumn('jumlah_barang', '<=', 'alert_jumlah_barang')
            ->orderBy('jumlah_barang', 'asc')
            ->get();

        $stokMenipis = $barangStokMenipis->count();


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */
        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PELANGGAN TERBARU
        |--------------------------------------------------------------------------
        */
        $pelangganTerbaru = Pelanggan::latest()
            ->limit(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BARANG TERBARU
        |--------------------------------------------------------------------------
        */
        $barangTerbaru = Barang::latest()
            ->limit(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN DAN TAHUN GRAFIK
        |--------------------------------------------------------------------------
        */
        $bulanDipilih = $request->bulan ?? now()->month;

        $tahunDipilih = $request->tahun ?? now()->year;

        /*
        |--------------------------------------------------------------------------
        | VALIDASI BULAN DAN TAHUN
        |--------------------------------------------------------------------------
        | Supaya jika user ubah URL manual ke bulan/tahun aneh, sistem tetap aman.
        |--------------------------------------------------------------------------
        */
        if ($bulanDipilih < 1 || $bulanDipilih > 12) {
            $bulanDipilih = now()->month;
        }

        if ($tahunDipilih < 2000 || $tahunDipilih > now()->year + 1) {
            $tahunDipilih = now()->year;
        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK PENDAPATAN BERDASARKAN BULAN DAN TAHUN
        |--------------------------------------------------------------------------
        */
        $awalBulan = Carbon::create(
            $tahunDipilih,
            $bulanDipilih,
            1
        )->startOfMonth();

        $akhirBulan = Carbon::create(
            $tahunDipilih,
            $bulanDipilih,
            1
        )->endOfMonth();

        $chartLabels = [];

        $chartData = [];

        for (
            $tanggal = $awalBulan->copy();
            $tanggal <= $akhirBulan;
            $tanggal->addDay()
        ) {
            $chartLabels[] = $tanggal->format('d M');

            $chartData[] = Transaksi::whereDate(
                'tanggal_transaksi',
                $tanggal->format('Y-m-d')
            )->sum('total_harga');
        }

        $teksPeriode = $awalBulan->format('d M Y') .
            ' - ' .
            $akhirBulan->format('d M Y');


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */
        return view('dashboard.index', compact(
            'role',
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalPelanggan',
            'stokMenipis',
            'barangStokMenipis',
            'transaksiTerbaru',
            'pelangganTerbaru',
            'barangTerbaru',
            'chartLabels',
            'chartData',
            'teksPeriode',
            'bulanDipilih',
            'tahunDipilih'
        ));
    }

    public function grafik(Request $request)
    {
        $bulan = (int) $request->bulan;

        $tahun = (int) $request->tahun;

        if ($bulan < 1 || $bulan > 12) {
            $bulan = now()->month;
        }

        if ($tahun < 2000 || $tahun > now()->year + 1) {
            $tahun = now()->year;
        }

        $tanggalAwal = Carbon::create($tahun, $bulan, 1)
            ->startOfMonth();

        $tanggalAkhir = Carbon::create($tahun, $bulan, 1)
            ->endOfMonth();

        $chartLabels = [];

        $chartData = [];

        for (
            $tanggal = $tanggalAwal->copy();
            $tanggal <= $tanggalAkhir;
            $tanggal->addDay()
        ) {
            $chartLabels[] = $tanggal->format('d M');

            $pendapatan = Transaksi::whereDate(
                    'tanggal_transaksi',
                    $tanggal->format('Y-m-d')
                )
                ->sum('total_harga');

            $chartData[] = $pendapatan;
        }

        $teksPeriode = $tanggalAwal->format('d M Y') .
            ' - ' .
            $tanggalAkhir->format('d M Y');

        return response()->json([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaPeriode' => $tanggalAwal->translatedFormat('F Y'),
            'teksPeriode' => $teksPeriode,
            'labels' => $chartLabels,
            'data' => $chartData,
        ]);
    }
}
