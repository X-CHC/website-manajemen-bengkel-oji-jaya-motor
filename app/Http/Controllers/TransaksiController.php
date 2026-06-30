<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\HistoryStok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // AMBIL DATA TRANSAKSI
        $transaksi = Transaksi::with([
                'user',
                'detailTransaksi.barang'
            ])
            ->orderBy(
                'tanggal_transaksi',
                'desc'
            )
            ->get();

        return view(
            'transaksi.index',
            compact('transaksi')
        );
    }

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
        $request->validate([
            'id_barang'            => 'required|array',
            'id_barang.*'          => 'required|exists:tbl_barang,id_barang',
            'jumlah_barang'        => 'required|array',
            'jumlah_barang.*'      => 'required|integer|min:1',
            'harga_barang'         => 'required|array',
            'harga_barang.*'       => 'required|integer',
            'sub_total'            => 'required|array',
            'sub_total.*'          => 'required|integer',
            'harga_jasa'           => 'nullable|integer',
            'total_harga'          => 'required|integer',
            'uang_bayar'           => 'required|integer',
            'uang_kembali'         => 'required|integer',
            'id_pelanggan'         => 'nullable',
            'nama_pelanggan_lain'  => 'nullable|max:100',
        ]);

        // ====================================================================
        // VALIDASI PELANGGAN (Wajib isi salah satu)
        // ====================================================================
        if (empty($request->id_pelanggan) && empty($request->nama_pelanggan_lain)) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pelanggan belum diisi! Silakan pilih Pelanggan Member atau ketik Nama Pelanggan Lain.'
                );
        }

        DB::beginTransaction();

        try {

            // AUTO NUMBER TRANSAKSI
            $transaksiTerakhir = Transaksi::withTrashed()
                ->orderBy('id_transaksi', 'desc')
                ->first();

            // Ambil 3 digit terakhir lalu increment
            if (!$transaksiTerakhir) {
                $id_transaksi = 'TRX001';
            } else {
                $kode = $transaksiTerakhir->id_transaksi;
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id_transaksi = 'TRX' . sprintf('%03s', $noUrut);
            }

            // VALIDASI BARANG
            if(empty($request->id_barang))
            {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Barang belum dipilih'
                    );
            }

            // VALIDASI UANG BAYAR
            if($request->uang_bayar < $request->total_harga)
            {
                throw new \Exception(
                    'Uang bayar kurang dari total harga'
                );
            }

            // SIMPAN TRANSAKSI
            Transaksi::create([
                'id_transaksi' => $id_transaksi,
                'id_user' => Auth::user()->id_user,
                'id_pelanggan' => $request->id_pelanggan,
                'nama_pelanggan_lain' => $request->nama_pelanggan_lain,
                'tanggal_transaksi' => now(),
                'total_harga' => str_replace('.', '', $request->total_harga),
                'harga_jasa' => str_replace('.', '', $request->harga_jasa ?? 0),
                'uang_bayar' => str_replace('.', '', $request->uang_bayar),
                'uang_kembali' => str_replace('.', '', $request->uang_kembali),
            ]);

            $barangList = Barang::whereIn('id_barang', $request->id_barang)
                                ->get()
                                ->keyBy('id_barang');

            // AUTO NUMBER DETAIL TRANSAKSI
            $detailTerakhir = DetailTransaksi::withTrashed()
                ->orderBy('id_detail_transaksi', 'desc')
                ->first();

            if (!$detailTerakhir) {
                $nomorDetail = 1;
            } else {
                $kode = $detailTerakhir->id_detail_transaksi;
                $nomorDetail = (int) substr($kode, -3) + 1;
            }

            // AUTO NUMBER HISTORY STOK
            $historyTerakhir = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            if (!$historyTerakhir) {
                $nomorHistory = 1;
            } else {
                $kode = $historyTerakhir->id_history_stok;
                $nomorHistory = (int) substr($kode, -4) + 1;
            }

            // LOOP DETAIL TRANSAKSI
            foreach ($request->id_barang as $index => $barangId) {

                // SKIP JIKA KOSONG
                if(empty($barangId))
                {
                    continue;
                }

                // AMBIL DATA BARANG
                $barang = $barangList->get($barangId);
                $jumlah = $request->jumlah_barang[$index];

                if (!$barang) {
                    throw new \Exception(
                        'Barang dengan ID ' . $barangId . ' tidak ditemukan'
                    );
                }

                // VALIDASI STOK
                if ($barang->jumlah_barang < $jumlah) {
                    throw new \Exception(
                        'Stok barang ' . $barang->nama_barang . ' tidak mencukupi'
                    );
                }

                // GENERATE ID DETAIL TRANSAKSI
                $id_detail = 'DTR' . sprintf('%03s', $nomorDetail);
                $nomorDetail++;

                // HITUNG SUBTOTAL
                $subtotal = $barang->harga_jual * $jumlah;

                // SIMPAN DETAIL TRANSAKSI
                DetailTransaksi::create([
                    'id_detail_transaksi' => $id_detail,
                    'id_transaksi' => $id_transaksi,
                    'id_barang' => $barang->id_barang,
                    'jumlah_barang' => $jumlah,
                    'harga_barang' => $barang->harga_jual,
                    'sub_total' => $subtotal,
                ]);

                // UPDATE STOK BARANG
                $stokSisa = $barang->jumlah_barang - $jumlah;
                $barang->update([
                    'jumlah_barang' => $stokSisa
                ]);

                // GENERATE ID HISTORY STOK
                $id_history = 'HS' . sprintf('%04s', $nomorHistory);
                $nomorHistory++;

                // SIMPAN HISTORY STOK
                HistoryStok::create([
                    'id_history_stok' => $id_history,
                    'id_barang' => $barang->id_barang,
                    'jumlah_masuk' => 0,
                    'jumlah_keluar' => $jumlah,
                    'jumlah_sisa' => $stokSisa,
                    'jumlah_barang' => $stokSisa,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('transaksi.index')
                ->with(
                    'success',
                    'Transaksi berhasil disimpan'
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

    public function cetakNota($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'pelanggan',
            'detailTransaksi.barang'
        ])->findOrFail($id);

        $namaPelanggan = $transaksi->pelanggan->nama_pelanggan
            ?? $transaksi->nama_pelanggan_lain
            ?? '-';

        $pdf = Pdf::loadView('transaksi.nota', [
            'transaksi' => $transaksi,
            'namaPelanggan' => $namaPelanggan,
        ]);

        $pdf->setPaper('A5', 'portrait');

        return $pdf->stream('nota-' . $transaksi->id_transaksi . '.pdf');
    }
}
