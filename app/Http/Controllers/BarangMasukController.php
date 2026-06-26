<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailMasuk;
use App\Models\DetailPo;
use App\Models\BarangMasuk;
use App\Models\HistoryStok;
use App\Models\Po;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{

    public function index()
    {
        $barangMasuk = BarangMasuk::with([
                            'po',
                            'detailMasuk.barang'
                        ])
                        ->latest()
                        ->get();

        return view(
            'barang_masuk.index',
            compact('barangMasuk')
        );
    }

    public function create()
    {
        $po = Po::with('detailPo.barang')
            ->where('status_po', 'pending')
            ->get();

        return view('Barang_Masuk.create', compact('po'));
    }

    public function store(Request $request)
    {
        // AMBIL DATA PO
        $po = Po::findOrFail($request->id_po);

        // VALIDASI STATUS PO
        if($po->status_po == 'selesai')
        {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'PO ini sudah diproses menjadi barang masuk'
                );
        }

        // VALIDASI
        $request->validate(
            [
                'id_po' => 'required|exists:tbl_po,id_po',
                'tanggal_masuk' => 'required|date',
                'total_bayar' => 'required|integer|min:1',
                'harga_beli' => 'required|array',
                'harga_beli.*' => 'required|integer|min:1',
                'jumlah_barang' => 'required|array',
                'jumlah_barang.*' => 'required|integer|min:1',
                'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'nota_supplier' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            ],
            [
                // TOTAL BAYAR
                'total_bayar.required' => 'Total bayar wajib diisi',
                'total_bayar.min' => 'Total bayar tidak boleh kurang dari 1',

                // HARGA BELI
                'harga_beli.*.required' => 'Harga beli wajib diisi',
                'harga_beli.*.min' => 'Harga beli tidak boleh negatif atau 0',

                // JUMLAH BARANG
                'jumlah_barang.*.required' => 'Jumlah barang wajib diisi',
                'jumlah_barang.*.min' => 'Jumlah barang tidak boleh negatif atau 0',

                // TANGGAL
                'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',

                // BUKTI BAYAR
                'bukti_bayar.required' => 'Bukti bayar wajib diupload',
                'bukti_bayar.image' => 'File harus berupa gambar',
                'bukti_bayar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
                'bukti_bayar.max' => 'Ukuran gambar maksimal 2MB',

                // NOTA SUPPLIER
                'nota_supplier.mimes' => 'Format nota supplier harus JPG, JPEG, PNG, atau PDF',
                'nota_supplier.max' => 'Ukuran nota supplier maksimal 5MB',
            ]
        );

        // VALIDASI TANGGAL MASUK
        // Tidak boleh sebelum tanggal PO
        if($request->tanggal_masuk < $po->tgl_po)
        {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tanggal barang masuk tidak boleh sebelum tanggal PO'
                );
        }

        DB::beginTransaction();

        try {

            // AUTO NUMBER BARANG MASUK
            $last = BarangMasuk::withTrashed()
                ->orderBy('id_barang_masuk', 'desc')
                ->first();

            // Ambil 3 digit terakhir lalu increment
            if (!$last) {
                $idBarangMasuk = 'BMK001';
            } else {
                $kode = $last->id_barang_masuk;
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $idBarangMasuk = 'BMK' . sprintf('%03s', $noUrut);
            }

            // UPLOAD BUKTI BAYAR
            $namaFile = null;
            if($request->hasFile('bukti_bayar'))
            {
                $file = $request->file('bukti_bayar');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/bukti_bayar'), $namaFile);
            }

            // UPLOAD NOTA SUPPLIER
            $namaNotaSupplier = null;
            if($request->hasFile('nota_supplier'))
            {
                $fileNota = $request->file('nota_supplier');
                $namaNotaSupplier = time() . '_' . $fileNota->getClientOriginalName();
                $fileNota->move(public_path('assets/nota_supplier'), $namaNotaSupplier);
            }

            // SIMPAN HEADER BARANG MASUK
            BarangMasuk::create([
                'id_barang_masuk' => $idBarangMasuk,
                'id_po' => $request->id_po,
                'tanggal_masuk' => $request->tanggal_masuk,
                'total_bayar' => $request->total_bayar,
                'bukti_bayar' => $namaFile,
                'nota_supplier' => $namaNotaSupplier,
            ]);

            // AMBIL DETAIL PO
            $detailPo = DetailPo::where('id_po', $request->id_po)->get();

            // AMBIL BARANG SEKALIGUS (Menghindari N+1 Query)
            $barangList = Barang::whereIn('id_barang', $detailPo->pluck('id_barang')->unique())
                            ->get()
                            ->keyBy('id_barang');

            // AUTO NUMBER DETAIL MASUK
            $lastDetail = DetailMasuk::withTrashed()
                ->orderBy('id_detail_masuk', 'desc')
                ->first();

            if (!$lastDetail) {
                $numberDetail = 1;
            } else {
                $kode = $lastDetail->id_detail_masuk;
                $numberDetail = (int) substr($kode, -4) + 1;
            }

            $lastHistory = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            if (!$lastHistory) {
                $nextHistoryNumber = 1;
            } else {
                $kode = $lastHistory->id_history_stok;
                $nextHistoryNumber = (int) substr($kode, -4) + 1;
            }

            // LOOP DETAIL
            foreach($detailPo as $index => $item)
            {
                $jumlahMasuk = $request->jumlah_barang[$index];
                $hargaBeli = $request->harga_beli[$index];

                // VALIDASI QTY
                if($jumlahMasuk > $item->jumlah_po)
                {
                    throw new \Exception('Jumlah masuk melebihi jumlah PO');
                }

                // GENERATE ID DETAIL MASUK (DMK + 3 digit)
                $idDetail = 'DMK' . sprintf('%03s', $numberDetail);
                $numberDetail++;

                // HITUNG SUBTOTAL
                $subtotal = $jumlahMasuk * $hargaBeli;

                // SIMPAN DETAIL MASUK
                DetailMasuk::create([
                    'id_detail_masuk' => $idDetail,
                    'id_barang_masuk' => $idBarangMasuk,
                    'id_barang' => $item->id_barang,
                    'jumlah_barang' => $jumlahMasuk,
                    'harga_beli' => $hargaBeli,
                    'sub_total' => $subtotal,
                ]);

                // AMBIL DATA BARANG DARI MEMORI ($barangList)
                $barang = $barangList[$item->id_barang] ?? null;

                // PENGECEKAN JIKA BARANG TIDAK DITEMUKAN
                if (!$barang) {
                    throw new \Exception('Data barang tidak ditemukan untuk diupdate');
                }

                $stokBaru = $barang->jumlah_barang + $jumlahMasuk;

                // UPDATE STOK DAN HARGA BELI SEKALIGUS DI TBL BARANG
                $barang->update([
                    'jumlah_barang' => $stokBaru,
                    'harga_beli' => $hargaBeli,
                ]);

                $idHistory = 'HS' . sprintf('%04s', $nextHistoryNumber);
                $nextHistoryNumber++;

                // SIMPAN HISTORY STOK
                HistoryStok::create([
                    'id_history_stok' => $idHistory,
                    'id_barang' => $item->id_barang,
                    'jumlah_masuk' => $jumlahMasuk,
                    'jumlah_keluar' => 0,
                    'jumlah_sisa' => $stokBaru,
                    'jumlah_barang' => $stokBaru,
                ]);
            }

            // UPDATE STATUS PO
            Po::where('id_po', $request->id_po)
                ->update([
                    'status_po' => 'selesai'
                ]);

            DB::commit();

            return redirect()
                ->route('barang-masuk.create')
                ->with('success', 'Barang masuk berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::with([
                            'detailMasuk.barang'
                        ])
                        ->findOrFail($id);

        return view(
            'barang_masuk.edit',
            compact('barangMasuk')
        );
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'harga_beli' => 'required|array',
            'harga_beli.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Eager load relasi barang untuk menghindari N+1 dan mempermudah update harga master
            $barangMasuk = BarangMasuk::with('detailMasuk.barang')->findOrFail($id);

            $totalBayar = 0;

            foreach($barangMasuk->detailMasuk as $index => $detail)
            {
                $hargaBeli = $request->harga_beli[$index];
                $subtotal = $hargaBeli * $detail->jumlah_barang;

                // UPDATE HARGA BELI DI DETAIL MASUK
                $detail->update([
                    'harga_beli' => $hargaBeli,
                    'sub_total' => $subtotal,
                ]);

                // UPDATE HARGA BELI TERBARU KE TABEL MASTER BARANG
                if ($detail->barang) {
                    $detail->barang->update([
                        'harga_beli' => $hargaBeli
                    ]);
                }

                $totalBayar += $subtotal;
            }

            $barangMasuk->update([
                'total_bayar' => $totalBayar
            ]);

            DB::commit();

            return redirect()
                ->route('barang-masuk.index')
                ->with('success', 'Barang masuk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $barangMasuk = BarangMasuk::with('detailMasuk')
                ->findOrFail($id);

            //AUTO NUMBER HISTORY STOK
            $lastHistory = HistoryStok::withTrashed()
                ->orderBy('id_history_stok', 'desc')
                ->first();

            if (!$lastHistory) {
                $nextHistoryNumber = 1;
            } else {
                $kode = $lastHistory->id_history_stok;
                $nextHistoryNumber = (int) substr($kode, -4) + 1;
            }

            //KEMBALIKAN STOK BARANG
            foreach ($barangMasuk->detailMasuk as $detail) {

                $barang = Barang::findOrFail($detail->id_barang);
                $stokBaru = $barang->jumlah_barang - $detail->jumlah_barang;

                //VALIDASI STOK TIDAK BOLEH MINUS
                if ($stokBaru < 0) {
                    throw new \Exception(
                        'Stok barang ' . $barang->nama_barang . ' tidak cukup untuk dikurangi'
                    );
                }

                $barang->update([
                    'jumlah_barang' => $stokBaru,
                ]);

                //GENERATE ID HISTORY
                $idHistory = 'HS' . sprintf('%04s', $nextHistoryNumber);
                $nextHistoryNumber++;

                //SIMPAN HISTORY STOK
                HistoryStok::create([
                    'id_history_stok' => $idHistory,
                    'id_barang' => $detail->id_barang,
                    'jumlah_masuk' => 0,
                    'jumlah_keluar' => $detail->jumlah_barang,
                    'jumlah_sisa' => $stokBaru,
                    'jumlah_barang' => $stokBaru,
                ]);
            }

            //BALIKKAN STATUS PO JADI PENDING
            Po::where('id_po', $barangMasuk->id_po)
                ->update([
                    'status_po' => 'pending',
                ]);

            //HAPUS DETAIL MASUK
            DetailMasuk::where(
                'id_barang_masuk',
                $barangMasuk->id_barang_masuk
            )->delete();

            //HAPUS HEADER BARANG MASUK
            $barangMasuk->delete();

            DB::commit();

            return redirect()
                ->route('barang-masuk.index')
                ->with('success', 'Barang masuk berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
