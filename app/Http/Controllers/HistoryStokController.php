<?php

namespace App\Http\Controllers;

use App\Models\HistoryStok;
use Rap2hpoutre\FastExcel\FastExcel;

class HistoryStokController extends Controller
{
    public function index()
    {
        $history = HistoryStok::with('barang')
            ->latest()
            ->get();

        return view(
            'History_Stok.index',
            compact('history')
        );
    }


    public function exportExcel()
    {
        $history = HistoryStok::with('barang')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'ID History' => $item->id_history_stok,

                    'Tanggal' => $item->created_at
                        ? $item->created_at->format('d-m-Y H:i')
                        : '-',

                    'Barang' => $item->barang->nama_barang ?? '-',

                    'Barang Masuk' => $item->jumlah_masuk > 0
                        ? $item->jumlah_masuk
                        : 0,

                    'Barang Keluar' => $item->jumlah_keluar > 0
                        ? $item->jumlah_keluar
                        : 0,

                    'Sisa Stok' => $item->jumlah_sisa,

                    'Jumlah Barang' => $item->jumlah_barang,
                ];
            });

        return (new FastExcel($history))
            ->download('laporan-history-stok.xlsx');
    }



}
