<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
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
        | Stok menipis jika:
        | jumlah_barang <= alert_jumlah_barang
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
        | GRAFIK PENDAPATAN BULAN INI
        |--------------------------------------------------------------------------
        */
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        $chartLabels = [];
        $chartData = [];

        for ($tanggal = $awalBulan->copy(); $tanggal <= $akhirBulan; $tanggal->addDay()) {
            $chartLabels[] = $tanggal->format('d M');

            $chartData[] = Transaksi::whereDate(
                'tanggal_transaksi',
                $tanggal->format('Y-m-d')
            )->sum('total_harga');
        }

        $teksPeriode = $awalBulan->format('d M Y') . ' - ' . $akhirBulan->format('d M Y');

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
            'teksPeriode'
        ));
    }
}
