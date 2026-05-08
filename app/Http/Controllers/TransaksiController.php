<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;

class TransaksiController extends Controller
{
    public function create()
    {
        $pelanggan = Pelanggan::all();

        $barang = Barang::all();

        return view('Transaksi.create', compact(
            'pelanggan',
            'barang'
        ));
    }

    public function store(Request $request)
    {
        // Logic for storing transaction
    }
}
