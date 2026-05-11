<?php

namespace App\Http\Controllers;

use App\Models\HistoryStok;

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
}
