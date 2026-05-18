<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyBengkelSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NONAKTIFKAN FOREIGN KEY
        |--------------------------------------------------------------------------
        */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('tbl_history_stok')->truncate();        // id_history_stok = HS0001
        DB::table('tbl_detail_transaksi')->truncate();    // id_detail_transaksi = DTR001
        DB::table('tbl_transaksi')->truncate();           // id_transaksi = TRX001
        DB::table('tbl_detail_masuk')->truncate();        // id_detail_masuk = DM0001
        DB::table('tbl_barang_masuk')->truncate();        // id_barang_masuk = BMK001
        DB::table('tbl_detail_po')->truncate();           // id_detail_po = DPO001
        DB::table('tbl_po')->truncate();                  // id_po = PO0001
        DB::table('tbl_barang')->truncate();              // id_barang = BRG001
        DB::table('tbl_pelanggan')->truncate();           // id_pelanggan = PLG001
        DB::table('tbl_kategori_barang')->truncate();     // id_kategori_barang = KTG001

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | KATEGORI BARANG
        |--------------------------------------------------------------------------
        */
        $kategori = [
            [
                'id_kategori_barang' => 'KTG001',
                'nama_kategori' => 'Oli Mesin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_kategori_barang' => 'KTG002',
                'nama_kategori' => 'Busi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_kategori_barang' => 'KTG003',
                'nama_kategori' => 'Kampas Rem',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_kategori_barang' => 'KTG004',
                'nama_kategori' => 'Ban Motor',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_kategori_barang' => 'KTG005',
                'nama_kategori' => 'Aki',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tbl_kategori_barang')->insert($kategori);


        /*
        |--------------------------------------------------------------------------
        | PELANGGAN
        |--------------------------------------------------------------------------
        */
        $pelanggan = [
            [
                'id_pelanggan' => 'PLG001',
                'nama_pelanggan' => 'Budi Santoso',
                'plat_nomor' => 'F 1234 AB',
                'merek_motor' => 'Honda Vario',
                'warna_motor' => 'Hitam',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG002',
                'nama_pelanggan' => 'Andi Wijaya',
                'plat_nomor' => 'B 5678 CD',
                'merek_motor' => 'Yamaha NMAX',
                'warna_motor' => 'Putih',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG003',
                'nama_pelanggan' => 'Siti Aminah',
                'plat_nomor' => 'F 9012 EF',
                'merek_motor' => 'Honda Beat',
                'warna_motor' => 'Merah',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tbl_pelanggan')->insert($pelanggan);


        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        | jumlah_barang di sini sudah disesuaikan dengan:
        | stok awal + barang masuk - transaksi keluar
        |--------------------------------------------------------------------------
        */
        $barang = [
            [
                'id_barang' => 'BRG001',
                'id_kategori_barang' => 'KTG001',
                'nama_barang' => 'Yamalube Matic 800ml',
                'harga_beli' => 40000,
                'harga_jual' => 45000,
                'jumlah_barang' => 55,
                'alert_jumlah_barang' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG002',
                'id_kategori_barang' => 'KTG001',
                'nama_barang' => 'Federal Oil 800ml',
                'harga_beli' => 38000,
                'harga_jual' => 43000,
                'jumlah_barang' => 17,
                'alert_jumlah_barang' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG003',
                'id_kategori_barang' => 'KTG002',
                'nama_barang' => 'Busi NGK CPR9EA-9',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
                'jumlah_barang' => 114,
                'alert_jumlah_barang' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG004',
                'id_kategori_barang' => 'KTG003',
                'nama_barang' => 'Kampas Rem Depan Honda',
                'harga_beli' => 35000,
                'harga_jual' => 45000,
                'jumlah_barang' => 37,
                'alert_jumlah_barang' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG005',
                'id_kategori_barang' => 'KTG004',
                'nama_barang' => 'Ban IRC 90/90-14 Tubeless',
                'harga_beli' => 180000,
                'harga_jual' => 210000,
                'jumlah_barang' => 11,
                'alert_jumlah_barang' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG006',
                'id_kategori_barang' => 'KTG005',
                'nama_barang' => 'Aki GS Astra GTZ5S',
                'harga_beli' => 240000,
                'harga_jual' => 300000,
                'jumlah_barang' => 6,
                'alert_jumlah_barang' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tbl_barang')->insert($barang);


        /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_po')->insert([
            [
                'id_po' => 'PO0001',
                'tgl_po' => '2026-05-01',
                'mitra_po' => 'Jaya Motor Part',
                'status_po' => 'selesai',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_po' => 'PO0002',
                'tgl_po' => '2026-05-04',
                'mitra_po' => 'Sumber Sparepart',
                'status_po' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_po' => 'PO0003',
                'tgl_po' => '2026-05-07',
                'mitra_po' => 'Mitra Ban & Aki',
                'status_po' => 'selesai',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DETAIL PO
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_detail_po')->insert([
            [
                'id_detail_po' => 'DPO001',
                'id_po' => 'PO0001',
                'id_barang' => 'BRG001',
                'jumlah_po' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO002',
                'id_po' => 'PO0001',
                'id_barang' => 'BRG003',
                'jumlah_po' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO003',
                'id_po' => 'PO0001',
                'id_barang' => 'BRG004',
                'jumlah_po' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO004',
                'id_po' => 'PO0002',
                'id_barang' => 'BRG002',
                'jumlah_po' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO005',
                'id_po' => 'PO0002',
                'id_barang' => 'BRG005',
                'jumlah_po' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO006',
                'id_po' => 'PO0003',
                'id_barang' => 'BRG005',
                'jumlah_po' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_po' => 'DPO007',
                'id_po' => 'PO0003',
                'id_barang' => 'BRG006',
                'jumlah_po' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_barang_masuk')->insert([
            [
                'id_barang_masuk' => 'BMK001',
                'id_po' => 'PO0001',
                'tanggal_masuk' => '2026-05-02',
                'total_bayar' => 1150000,
                'bukti_bayar' => 'bukti_bayar_001.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang_masuk' => 'BMK002',
                'id_po' => 'PO0003',
                'tanggal_masuk' => '2026-05-08',
                'total_bayar' => 1620000,
                'bukti_bayar' => 'bukti_bayar_002.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DETAIL BARANG MASUK
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_detail_masuk')->insert([
            [
                'id_detail_masuk' => 'DM0001',
                'id_barang_masuk' => 'BMK001',
                'id_barang' => 'BRG001',
                'jumlah_barang' => 10,
                'harga_beli' => 40000,
                'sub_total' => 400000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_masuk' => 'DM0002',
                'id_barang_masuk' => 'BMK001',
                'id_barang' => 'BRG003',
                'jumlah_barang' => 20,
                'harga_beli' => 15000,
                'sub_total' => 300000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_masuk' => 'DM0003',
                'id_barang_masuk' => 'BMK001',
                'id_barang' => 'BRG004',
                'jumlah_barang' => 10,
                'harga_beli' => 35000,
                'sub_total' => 350000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_masuk' => 'DM0004',
                'id_barang_masuk' => 'BMK002',
                'id_barang' => 'BRG005',
                'jumlah_barang' => 5,
                'harga_beli' => 180000,
                'sub_total' => 900000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_detail_masuk' => 'DM0005',
                'id_barang_masuk' => 'BMK002',
                'id_barang' => 'BRG006',
                'jumlah_barang' => 3,
                'harga_beli' => 240000,
                'sub_total' => 720000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI & DETAIL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transaksiData = [];
        $detailTransaksiData = [];

        $idTransaksiCounter = 1;
        $idDetailTransaksiCounter = 1;

        /*
        |--------------------------------------------------------------------------
        | STOK AWAL
        |--------------------------------------------------------------------------
        */
        $stokAwal = [
            'BRG001' => 50,
            'BRG002' => 5,
            'BRG003' => 100,
            'BRG004' => 30,
            'BRG005' => 8,
            'BRG006' => 6,
        ];

        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */
        $barangMasukHistory = [
            ['id_barang' => 'BRG001', 'jumlah' => 10],
            ['id_barang' => 'BRG003', 'jumlah' => 20],
            ['id_barang' => 'BRG004', 'jumlah' => 10],
            ['id_barang' => 'BRG005', 'jumlah' => 5],
            ['id_barang' => 'BRG006', 'jumlah' => 3],
        ];

        /*
        |--------------------------------------------------------------------------
        | STOK TERSEDIA UNTUK TRANSAKSI
        |--------------------------------------------------------------------------
        | Stok ini dipakai untuk memastikan transaksi dummy tidak membuat stok minus.
        |--------------------------------------------------------------------------
        */
        $stokTersedia = $stokAwal;

        foreach ($barangMasukHistory as $masuk) {
            $stokTersedia[$masuk['id_barang']] += $masuk['jumlah'];
        }

        /*
        |--------------------------------------------------------------------------
        | BUAT TRANSAKSI RANDOM
        |--------------------------------------------------------------------------
        */
        for ($i = 30; $i >= 0; $i--) {

            $tanggal = Carbon::now()->subDays($i);

            $jumlahTransaksiPerHari = rand(1, 3);

            for ($j = 0; $j < $jumlahTransaksiPerHari; $j++) {

                /*
                |--------------------------------------------------------------------------
                | CEK BARANG YANG MASIH PUNYA STOK
                |--------------------------------------------------------------------------
                */
                $barangBisaDijual = collect($barang)->filter(function ($item) use ($stokTersedia) {
                    return isset($stokTersedia[$item['id_barang']])
                        && $stokTersedia[$item['id_barang']] > 0;
                });

                /*
                |--------------------------------------------------------------------------
                | JIKA STOK SEMUA HABIS, STOP BUAT TRANSAKSI
                |--------------------------------------------------------------------------
                */
                if ($barangBisaDijual->isEmpty()) {
                    break 2;
                }

                $idTransaksi = 'TRX' . str_pad(
                    $idTransaksiCounter,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

                $pakaiMember = rand(0, 1);

                $idPelanggan = $pakaiMember
                    ? 'PLG00' . rand(1, 3)
                    : null;

                $namaPelangganLain = $pakaiMember
                    ? null
                    : 'Pelanggan Umum ' . rand(1, 99);

                $totalBarang = 0;

                /*
                |--------------------------------------------------------------------------
                | JUMLAH DETAIL TRANSAKSI
                |--------------------------------------------------------------------------
                */
                $jumlahDetail = rand(1, min(2, $barangBisaDijual->count()));

                $barangTerpilih = $barangBisaDijual
                    ->shuffle()
                    ->take($jumlahDetail);

                foreach ($barangTerpilih as $barangItem) {

                    $idBarang = $barangItem['id_barang'];

                    /*
                    |--------------------------------------------------------------------------
                    | QTY TIDAK BOLEH LEBIH DARI STOK TERSEDIA
                    |--------------------------------------------------------------------------
                    */
                    $qtyMaksimal = min(2, $stokTersedia[$idBarang]);

                    if ($qtyMaksimal <= 0) {
                        continue;
                    }

                    $qty = rand(1, $qtyMaksimal);

                    $idDetailTransaksi = 'DTR' . str_pad(
                        $idDetailTransaksiCounter,
                        3,
                        '0',
                        STR_PAD_LEFT
                    );

                    $subTotal = $barangItem['harga_jual'] * $qty;

                    $totalBarang += $subTotal;

                    $detailTransaksiData[] = [
                        'id_detail_transaksi' => $idDetailTransaksi,
                        'id_transaksi' => $idTransaksi,
                        'id_barang' => $idBarang,
                        'jumlah_barang' => $qty,
                        'harga_barang' => $barangItem['harga_jual'],
                        'sub_total' => $subTotal,
                        'created_at' => $tanggal,
                        'updated_at' => $tanggal,
                    ];

                    /*
                    |--------------------------------------------------------------------------
                    | KURANGI STOK TERSEDIA
                    |--------------------------------------------------------------------------
                    */
                    $stokTersedia[$idBarang] -= $qty;

                    $idDetailTransaksiCounter++;
                }

                /*
                |--------------------------------------------------------------------------
                | JIKA TIDAK ADA DETAIL, JANGAN BUAT TRANSAKSI
                |--------------------------------------------------------------------------
                */
                if ($totalBarang <= 0) {
                    continue;
                }

                $hargaJasa = rand(2, 5) * 10000;

                $totalHarga = $totalBarang + $hargaJasa;

                $transaksiData[] = [
                    'id_transaksi' => $idTransaksi,
                    'id_pelanggan' => $idPelanggan,
                    'nama_pelanggan_lain' => $namaPelangganLain,
                    'tanggal_transaksi' => $tanggal->format('Y-m-d'),
                    'total_harga' => $totalHarga,
                    'harga_jasa' => $hargaJasa,
                    'uang_bayar' => $totalHarga + 50000,
                    'uang_kembali' => 50000,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ];

                $idTransaksiCounter++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | INSERT TRANSAKSI
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($transaksiData, 50) as $chunk) {
            DB::table('tbl_transaksi')->insert($chunk);
        }

        foreach (array_chunk($detailTransaksiData, 50) as $chunk) {
            DB::table('tbl_detail_transaksi')->insert($chunk);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE STOK AKHIR DI TABEL BARANG
        |--------------------------------------------------------------------------
        | Supaya tbl_barang.jumlah_barang sesuai dengan history stok.
        |--------------------------------------------------------------------------
        */
        foreach ($stokTersedia as $idBarang => $stokAkhir) {
            DB::table('tbl_barang')
                ->where('id_barang', $idBarang)
                ->update([
                    'jumlah_barang' => $stokAkhir,
                    'updated_at' => $now,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | HISTORY STOK
        |--------------------------------------------------------------------------
        */
        $history = [];

        $historyCounter = 1;

        /*
        |--------------------------------------------------------------------------
        | HISTORY STOK AWAL
        |--------------------------------------------------------------------------
        */
        $stokBerjalan = [];

        foreach ($stokAwal as $idBarang => $jumlahAwal) {

            $stokBerjalan[$idBarang] = $jumlahAwal;

            $history[] = [
                'id_history_stok' => 'HS' . str_pad($historyCounter, 4, '0', STR_PAD_LEFT),
                'id_barang' => $idBarang,
                'jumlah_masuk' => $jumlahAwal,
                'jumlah_keluar' => 0,
                'jumlah_sisa' => $jumlahAwal,
                'jumlah_barang' => $jumlahAwal,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $historyCounter++;
        }

        /*
        |--------------------------------------------------------------------------
        | HISTORY BARANG MASUK
        |--------------------------------------------------------------------------
        */
        foreach ($barangMasukHistory as $masuk) {

            $stokBerjalan[$masuk['id_barang']] += $masuk['jumlah'];

            $history[] = [
                'id_history_stok' => 'HS' . str_pad($historyCounter, 4, '0', STR_PAD_LEFT),
                'id_barang' => $masuk['id_barang'],
                'jumlah_masuk' => $masuk['jumlah'],
                'jumlah_keluar' => 0,
                'jumlah_sisa' => $stokBerjalan[$masuk['id_barang']],
                'jumlah_barang' => $stokBerjalan[$masuk['id_barang']],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $historyCounter++;
        }

        /*
        |--------------------------------------------------------------------------
        | HISTORY TRANSAKSI KELUAR
        |--------------------------------------------------------------------------
        */
        foreach ($detailTransaksiData as $detail) {

            /*
            |--------------------------------------------------------------------------
            | SAFETY CHECK
            |--------------------------------------------------------------------------
            | Seharusnya tidak minus karena transaksi sudah divalidasi dari stokTersedia.
            |--------------------------------------------------------------------------
            */
            if ($stokBerjalan[$detail['id_barang']] < $detail['jumlah_barang']) {
                continue;
            }

            $stokBerjalan[$detail['id_barang']] -= $detail['jumlah_barang'];

            $history[] = [
                'id_history_stok' => 'HS' . str_pad($historyCounter, 4, '0', STR_PAD_LEFT),
                'id_barang' => $detail['id_barang'],
                'jumlah_masuk' => 0,
                'jumlah_keluar' => $detail['jumlah_barang'],
                'jumlah_sisa' => $stokBerjalan[$detail['id_barang']],
                'jumlah_barang' => $stokBerjalan[$detail['id_barang']],
                'created_at' => $detail['created_at'],
                'updated_at' => $detail['updated_at'],
            ];

            $historyCounter++;
        }

        /*
        |--------------------------------------------------------------------------
        | INSERT HISTORY STOK
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($history, 50) as $chunk) {
            DB::table('tbl_history_stok')->insert($chunk);
        }

        $this->command->info('Data dummy bengkel berhasil dibuat.');
    }
}
