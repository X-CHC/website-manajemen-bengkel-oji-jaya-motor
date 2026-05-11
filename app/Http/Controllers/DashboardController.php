<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | 1. INFO BOXES (Statistik Atas)
        |--------------------------------------------------------------------------
        */
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->sum('total_harga');
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->count();
        $totalPelanggan = Pelanggan::count();
        $stokMenipis = Barang::whereColumn('jumlah_barang', '<=', 'alert_jumlah_barang')->count();

        /*
        |--------------------------------------------------------------------------
        | 2. DATA TABEL (Konten Bawah)
        |--------------------------------------------------------------------------
        */
        $transaksiTerbaru = Transaksi::with('pelanggan')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        $pelangganTerbaru = Pelanggan::orderBy('created_at', 'desc')
                                ->limit(8)
                                ->get();

        $barangTerbaru = Barang::orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        /*
        |--------------------------------------------------------------------------
        | 3. DATA GRAFIK (Pendapatan Bulanan: Tanggal 01 - Akhir Bulan)
        |--------------------------------------------------------------------------
        */
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();
        $jumlahHari = $akhirBulan->day; // Mendapatkan total hari di bulan ini (misal 30 atau 31)

        // Ambil data transaksi bulan ini, kelompokkan per tanggal
        $transaksiBulanan = Transaksi::whereBetween('tanggal_transaksi', [$awalBulan->format('Y-m-d'), $akhirBulan->format('Y-m-d')])
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $chartLabels = [];
        $chartData = [];

        // Looping dari tanggal 1 sampai akhir bulan
        for ($i = 1; $i <= $jumlahHari; $i++) {
            // Format tanggal lengkap untuk pencocokan ke database (contoh: 2026-05-01)
            $tanggalLoop = $awalBulan->copy()->addDays($i - 1)->format('Y-m-d');

            // Format label untuk sumbu X di grafik (hanya ambil angka tanggalnya saja: 01, 02, dst)
            $labelTanggal = str_pad($i, 2, '0', STR_PAD_LEFT);
            $chartLabels[] = $labelTanggal;

            // Jika di tanggal tersebut ada pemasukan, masukkan totalnya. Jika tidak, isi 0.
            if ($transaksiBulanan->has($tanggalLoop)) {
                $chartData[] = $transaksiBulanan[$tanggalLoop];
            } else {
                $chartData[] = 0;
            }
        }

        // Teks untuk periode di atas grafik
        $teksPeriode = $awalBulan->format('d M Y') . ' - ' . $akhirBulan->format('d M Y');

        return view('dashboard.index', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalPelanggan',
            'stokMenipis',
            'transaksiTerbaru',
            'pelangganTerbaru',
            'barangTerbaru',
            'chartLabels',
            'chartData',
            'teksPeriode'
        ));
    }
}
