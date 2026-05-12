<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyBengkelSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nonaktifkan Foreign Key Check sementara agar bisa menghapus data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('tbl_detail_transaksi')->truncate();
        DB::table('tbl_transaksi')->truncate();
        DB::table('tbl_history_stok')->truncate();
        DB::table('tbl_detail_masuk')->truncate();
        DB::table('tbl_barang_masuk')->truncate();
        DB::table('tbl_detail_po')->truncate();
        DB::table('tbl_po')->truncate();
        DB::table('tbl_barang')->truncate();
        DB::table('tbl_pelanggan')->truncate();
        DB::table('tbl_kategori_barang')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | 2. SEEDER KATEGORI & PELANGGAN
        |--------------------------------------------------------------------------
        */
        $kategori = [
            ['id_kategori_barang' => 'KAT001', 'nama_kategori' => 'Oli Mesin', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_barang' => 'KAT002', 'nama_kategori' => 'Busi', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_barang' => 'KAT003', 'nama_kategori' => 'Kampas Rem', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_barang' => 'KAT004', 'nama_kategori' => 'Ban Motor', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('tbl_kategori_barang')->insert($kategori);

        $pelanggan = [
            ['id_pelanggan' => 'PLG001', 'nama_pelanggan' => 'Budi Santoso', 'plat_nomor' => 'F 1234 AB', 'merek_motor' => 'Honda Vario', 'warna_motor' => 'Hitam', 'created_at' => $now, 'updated_at' => $now],
            ['id_pelanggan' => 'PLG002', 'nama_pelanggan' => 'Andi Wijaya', 'plat_nomor' => 'B 5678 CD', 'merek_motor' => 'Yamaha NMAX', 'warna_motor' => 'Putih', 'created_at' => $now, 'updated_at' => $now],
            ['id_pelanggan' => 'PLG003', 'nama_pelanggan' => 'Siti Aminah', 'plat_nomor' => 'F 9012 EF', 'merek_motor' => 'Honda Beat', 'warna_motor' => 'Merah', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('tbl_pelanggan')->insert($pelanggan);

        /*
        |--------------------------------------------------------------------------
        | 3. SEEDER BARANG
        |--------------------------------------------------------------------------
        */
        $barang = [
            ['id_barang' => 'BRG001', 'id_kategori_barang' => 'KAT001', 'nama_barang' => 'Yamalube Matic 800ml', 'harga_beli' => 40000, 'harga_jual' => 45000, 'jumlah_barang' => 50, 'alert_jumlah_barang' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['id_barang' => 'BRG002', 'id_kategori_barang' => 'KAT001', 'nama_barang' => 'Federal Oil 800ml', 'harga_beli' => 38000, 'harga_jual' => 43000, 'jumlah_barang' => 5, 'alert_jumlah_barang' => 10, 'created_at' => $now, 'updated_at' => $now], // Sengaja dibuat < alert (Stok menipis)
            ['id_barang' => 'BRG003', 'id_kategori_barang' => 'KAT002', 'nama_barang' => 'Busi NGK CPR9EA-9', 'harga_beli' => 15000, 'harga_jual' => 20000, 'jumlah_barang' => 100, 'alert_jumlah_barang' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['id_barang' => 'BRG004', 'id_kategori_barang' => 'KAT003', 'nama_barang' => 'Kampas Rem Depan Honda', 'harga_beli' => 35000, 'harga_jual' => 45000, 'jumlah_barang' => 30, 'alert_jumlah_barang' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['id_barang' => 'BRG005', 'id_kategori_barang' => 'KAT004', 'nama_barang' => 'Ban IRC 90/90-14 Tubeless', 'harga_beli' => 180000, 'harga_jual' => 210000, 'jumlah_barang' => 8, 'alert_jumlah_barang' => 10, 'created_at' => $now, 'updated_at' => $now], // Stok menipis
        ];
        DB::table('tbl_barang')->insert($barang);

        /*
        |--------------------------------------------------------------------------
        | 4. SEEDER TRANSAKSI (Membuat Grafik Bergelombang)
        |--------------------------------------------------------------------------
        */
        $transaksiData = [];
        $detailTransaksiData = [];
        $idTrxCounter = 1;
        $idDetailCounter = 1;

        // Kita buat looping mundur dari 30 hari yang lalu sampai hari ini
        for ($i = 30; $i >= 0; $i--) {
            $tanggalTrx = Carbon::now()->subDays($i);

            // Random berapa jumlah transaksi di hari tersebut (1 sampai 4 transaksi per hari)
            // Sengaja dibuat random agar grafiknya naik turun (bergelombang)
            $jumlahTrxPerHari = rand(1, 4);

            for ($j = 0; $j < $jumlahTrxPerHari; $j++) {
                $idTrxStr = 'TRX' . str_pad($idTrxCounter, 3, '0', STR_PAD_LEFT);

                // Pilih pelanggan random (bisa terdaftar atau pelanggan lewat/umum)
                $isPelangganTerdaftar = rand(0, 1);
                $idPelanggan = $isPelangganTerdaftar ? 'PLG00' . rand(1, 3) : null;
                $namaPelangganLain = $isPelangganTerdaftar ? null : 'Pelanggan Umum ' . rand(1, 99);

                // Buat 1 atau 2 detail barang yang dibeli per transaksi
                $totalHargaTransaksi = 0;
                $jumlahBarangDibeli = rand(1, 2);

                for ($k = 0; $k < $jumlahBarangDibeli; $k++) {
                    $idDetailStr = 'DTL' . str_pad($idDetailCounter, 3, '0', STR_PAD_LEFT);
                    $barangRandom = $barang[array_rand($barang)]; // Ambil barang random

                    $qty = rand(1, 2);
                    $subTotal = $barangRandom['harga_jual'] * $qty;
                    $totalHargaTransaksi += $subTotal;

                    $detailTransaksiData[] = [
                        'id_detail_transaksi' => $idDetailStr,
                        'id_transaksi' => $idTrxStr,
                        'id_barang' => $barangRandom['id_barang'],
                        'jumlah_barang' => $qty,
                        'harga_barang' => $barangRandom['harga_jual'],
                        'sub_total' => $subTotal,
                        'created_at' => $tanggalTrx,
                        'updated_at' => $tanggalTrx,
                    ];
                    $idDetailCounter++;
                }

                $hargaJasa = rand(2, 5) * 10000; // Harga jasa random 20rb - 50rb
                $totalHargaTransaksi += $hargaJasa;

                $transaksiData[] = [
                    'id_transaksi' => $idTrxStr,
                    'id_pelanggan' => $idPelanggan,
                    'nama_pelanggan_lain' => $namaPelangganLain,
                    'tanggal_transaksi' => $tanggalTrx->format('Y-m-d'),
                    'total_harga' => $totalHargaTransaksi,
                    'harga_jasa' => $hargaJasa,
                    'uang_bayar' => $totalHargaTransaksi + 50000, // Simulasi uang lebih
                    'uang_kembali' => 50000,
                    'created_at' => $tanggalTrx,
                    'updated_at' => $tanggalTrx,
                ];

                $idTrxCounter++;
            }
        }

        // Pecah insert jadi beberapa bagian agar tidak berat/error jika datanya terlalu banyak
        foreach (array_chunk($transaksiData, 50) as $chunk) {
            DB::table('tbl_transaksi')->insert($chunk);
        }
        foreach (array_chunk($detailTransaksiData, 50) as $chunk) {
            DB::table('tbl_detail_transaksi')->insert($chunk);
        }

        $this->command->info('Data Dummy Bengkel Berhasil Ditambahkan! Cek Dashboard-mu sekarang.');
    }
}
