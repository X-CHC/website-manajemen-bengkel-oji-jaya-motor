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

        /*
        |--------------------------------------------------------------------------
        | TRUNCATE DATA
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_detail_stock_opname')->truncate(); // id_detail_stock_opname = DSO001
        DB::table('tbl_stock_opname')->truncate();        // id_stock_opname = SOP001

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
            [
                'id_pelanggan' => 'PLG004',
                'nama_pelanggan' => 'Rizky Pratama',
                'plat_nomor' => 'F 3344 GH',
                'merek_motor' => 'Honda Scoopy',
                'warna_motor' => 'Coklat',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG005',
                'nama_pelanggan' => 'Dewi Lestari',
                'plat_nomor' => 'B 7788 IJ',
                'merek_motor' => 'Yamaha Mio',
                'warna_motor' => 'Biru',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG006',
                'nama_pelanggan' => 'Agus Setiawan',
                'plat_nomor' => 'F 1122 KL',
                'merek_motor' => 'Honda Beat Street',
                'warna_motor' => 'Silver',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG007',
                'nama_pelanggan' => 'Nina Kartika',
                'plat_nomor' => 'D 4455 MN',
                'merek_motor' => 'Yamaha Fino',
                'warna_motor' => 'Merah',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG008',
                'nama_pelanggan' => 'Hendra Saputra',
                'plat_nomor' => 'F 6677 OP',
                'merek_motor' => 'Honda PCX',
                'warna_motor' => 'Hitam',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG009',
                'nama_pelanggan' => 'Maya Sari',
                'plat_nomor' => 'A 8899 QR',
                'merek_motor' => 'Yamaha Aerox',
                'warna_motor' => 'Kuning',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pelanggan' => 'PLG010',
                'nama_pelanggan' => 'Fajar Nugroho',
                'plat_nomor' => 'F 1010 ST',
                'merek_motor' => 'Suzuki Nex',
                'warna_motor' => 'Putih',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tbl_pelanggan')->insert($pelanggan);


        /*
        |--------------------------------------------------------------------------
        | STOK AWAL
        |--------------------------------------------------------------------------
        */
        $stokAwal = [
            'BRG001' => 40,
            'BRG002' => 30,
            'BRG003' => 60,
            'BRG004' => 36,
            'BRG005' => 20,
            'BRG006' => 16,
        ];


        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        | jumlah_barang awal akan di-update lagi di bawah setelah transaksi dummy dibuat.
        |--------------------------------------------------------------------------
        */
        $barang = [
            [
                'id_barang' => 'BRG001',
                'id_kategori_barang' => 'KTG001',
                'nama_barang' => 'Yamalube Matic 800ml',
                'harga_beli' => 40000,
                'harga_jual' => 45000,
                'jumlah_barang' => $stokAwal['BRG001'],
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
                'jumlah_barang' => $stokAwal['BRG002'],
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
                'jumlah_barang' => $stokAwal['BRG003'],
                'alert_jumlah_barang' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_barang' => 'BRG004',
                'id_kategori_barang' => 'KTG003',
                'nama_barang' => 'Kampas Rem Depan Honda',
                'harga_beli' => 35000,
                'harga_jual' => 45000,
                'jumlah_barang' => $stokAwal['BRG004'],
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
                'jumlah_barang' => $stokAwal['BRG005'],
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
                'jumlah_barang' => $stokAwal['BRG006'],
                'alert_jumlah_barang' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('tbl_barang')->insert($barang);


        /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_po')->insert([
            [
                'id_po' => 'PO0001',
                'tgl_po' => '2026-05-01',
                'mitra_po' => 'Jaya Motor Part',
                'status_po' => 'selesai',
                'created_at' => Carbon::parse('2026-05-01'),
                'updated_at' => Carbon::parse('2026-05-01'),
            ],
            [
                'id_po' => 'PO0002',
                'tgl_po' => '2026-05-08',
                'mitra_po' => 'Sumber Sparepart',
                'status_po' => 'selesai',
                'created_at' => Carbon::parse('2026-05-08'),
                'updated_at' => Carbon::parse('2026-05-08'),
            ],
            [
                'id_po' => 'PO0003',
                'tgl_po' => '2026-05-15',
                'mitra_po' => 'Mitra Ban & Aki',
                'status_po' => 'selesai',
                'created_at' => Carbon::parse('2026-05-15'),
                'updated_at' => Carbon::parse('2026-05-15'),
            ],
            [
                'id_po' => 'PO0004',
                'tgl_po' => '2026-05-25',
                'mitra_po' => 'Gudang Sparepart Motor',
                'status_po' => 'pending',
                'created_at' => Carbon::parse('2026-05-25'),
                'updated_at' => Carbon::parse('2026-05-25'),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DETAIL PO (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_detail_po')->insert([
            [
                'id_detail_po' => 'DPO001',
                'id_po' => 'PO0001',
                'id_barang' => 'BRG001',
                'jumlah_po' => 15,
                'created_at' => Carbon::parse('2026-05-01'),
                'updated_at' => Carbon::parse('2026-05-01'),
            ],
            [
                'id_detail_po' => 'DPO002',
                'id_po' => 'PO0001',
                'id_barang' => 'BRG003',
                'jumlah_po' => 20,
                'created_at' => Carbon::parse('2026-05-01'),
                'updated_at' => Carbon::parse('2026-05-01'),
            ],
            [
                'id_detail_po' => 'DPO003',
                'id_po' => 'PO0002',
                'id_barang' => 'BRG002',
                'jumlah_po' => 10,
                'created_at' => Carbon::parse('2026-05-08'),
                'updated_at' => Carbon::parse('2026-05-08'),
            ],
            [
                'id_detail_po' => 'DPO004',
                'id_po' => 'PO0002',
                'id_barang' => 'BRG004',
                'jumlah_po' => 15,
                'created_at' => Carbon::parse('2026-05-08'),
                'updated_at' => Carbon::parse('2026-05-08'),
            ],
            [
                'id_detail_po' => 'DPO005',
                'id_po' => 'PO0003',
                'id_barang' => 'BRG005',
                'jumlah_po' => 5,
                'created_at' => Carbon::parse('2026-05-15'),
                'updated_at' => Carbon::parse('2026-05-15'),
            ],
            [
                'id_detail_po' => 'DPO006',
                'id_po' => 'PO0003',
                'id_barang' => 'BRG006',
                'jumlah_po' => 4,
                'created_at' => Carbon::parse('2026-05-15'),
                'updated_at' => Carbon::parse('2026-05-15'),
            ],
            [
                'id_detail_po' => 'DPO007',
                'id_po' => 'PO0004',
                'id_barang' => 'BRG001',
                'jumlah_po' => 20,
                'created_at' => Carbon::parse('2026-05-25'),
                'updated_at' => Carbon::parse('2026-05-25'),
            ],
            [
                'id_detail_po' => 'DPO008',
                'id_po' => 'PO0004',
                'id_barang' => 'BRG002',
                'jumlah_po' => 15,
                'created_at' => Carbon::parse('2026-05-25'),
                'updated_at' => Carbon::parse('2026-05-25'),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_barang_masuk')->insert([
            [
                'id_barang_masuk' => 'BMK001',
                'id_po' => 'PO0001',
                'tanggal_masuk' => '2026-05-03',
                'total_bayar' => 900000,
                'bukti_bayar' => '1778323222_ane statis 1.png',
                'created_at' => Carbon::parse('2026-05-03'),
                'updated_at' => Carbon::parse('2026-05-03'),
            ],
            [
                'id_barang_masuk' => 'BMK002',
                'id_po' => 'PO0002',
                'tanggal_masuk' => '2026-05-10',
                'total_bayar' => 905000,
                'bukti_bayar' => '1778474747_Screenshot (7).png',
                'created_at' => Carbon::parse('2026-05-10'),
                'updated_at' => Carbon::parse('2026-05-10'),
            ],
            [
                'id_barang_masuk' => 'BMK003',
                'id_po' => 'PO0003',
                'tanggal_masuk' => '2026-05-17',
                'total_bayar' => 1860000,
                'bukti_bayar' => '1778474747_Screenshot (7).png',
                'created_at' => Carbon::parse('2026-05-17'),
                'updated_at' => Carbon::parse('2026-05-17'),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DETAIL BARANG MASUK (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        DB::table('tbl_detail_masuk')->insert([
            [
                'id_detail_masuk' => 'DM0001',
                'id_barang_masuk' => 'BMK001',
                'id_barang' => 'BRG001',
                'jumlah_barang' => 15,
                'harga_beli' => 40000,
                'sub_total' => 600000,
                'created_at' => Carbon::parse('2026-05-03'),
                'updated_at' => Carbon::parse('2026-05-03'),
            ],
            [
                'id_detail_masuk' => 'DM0002',
                'id_barang_masuk' => 'BMK001',
                'id_barang' => 'BRG003',
                'jumlah_barang' => 20,
                'harga_beli' => 15000,
                'sub_total' => 300000,
                'created_at' => Carbon::parse('2026-05-03'),
                'updated_at' => Carbon::parse('2026-05-03'),
            ],
            [
                'id_detail_masuk' => 'DM0003',
                'id_barang_masuk' => 'BMK002',
                'id_barang' => 'BRG002',
                'jumlah_barang' => 10,
                'harga_beli' => 38000,
                'sub_total' => 380000,
                'created_at' => Carbon::parse('2026-05-10'),
                'updated_at' => Carbon::parse('2026-05-10'),
            ],
            [
                'id_detail_masuk' => 'DM0004',
                'id_barang_masuk' => 'BMK002',
                'id_barang' => 'BRG004',
                'jumlah_barang' => 15,
                'harga_beli' => 35000,
                'sub_total' => 525000,
                'created_at' => Carbon::parse('2026-05-10'),
                'updated_at' => Carbon::parse('2026-05-10'),
            ],
            [
                'id_detail_masuk' => 'DM0005',
                'id_barang_masuk' => 'BMK003',
                'id_barang' => 'BRG005',
                'jumlah_barang' => 5,
                'harga_beli' => 180000,
                'sub_total' => 900000,
                'created_at' => Carbon::parse('2026-05-17'),
                'updated_at' => Carbon::parse('2026-05-17'),
            ],
            [
                'id_detail_masuk' => 'DM0006',
                'id_barang_masuk' => 'BMK003',
                'id_barang' => 'BRG006',
                'jumlah_barang' => 4,
                'harga_beli' => 240000,
                'sub_total' => 960000,
                'created_at' => Carbon::parse('2026-05-17'),
                'updated_at' => Carbon::parse('2026-05-17'),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK HISTORY (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        $barangMasukHistory = [
            [
                'tanggal' => '2026-05-03',
                'id_barang' => 'BRG001',
                'jumlah' => 15,
            ],
            [
                'tanggal' => '2026-05-03',
                'id_barang' => 'BRG003',
                'jumlah' => 20,
            ],
            [
                'tanggal' => '2026-05-10',
                'id_barang' => 'BRG002',
                'jumlah' => 10,
            ],
            [
                'tanggal' => '2026-05-10',
                'id_barang' => 'BRG004',
                'jumlah' => 15,
            ],
            [
                'tanggal' => '2026-05-17',
                'id_barang' => 'BRG005',
                'jumlah' => 5,
            ],
            [
                'tanggal' => '2026-05-17',
                'id_barang' => 'BRG006',
                'jumlah' => 4,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | HITUNG STOK TERSEDIA SETELAH BARANG MASUK
        |--------------------------------------------------------------------------
        */
        $stokTersedia = $stokAwal;

        foreach ($barangMasukHistory as $masuk) {
            $stokTersedia[$masuk['id_barang']] += $masuk['jumlah'];
        }


        /*
        |--------------------------------------------------------------------------
        | TARGET STOK AKHIR
        |--------------------------------------------------------------------------
        | 4 barang sengaja dibuat habis untuk testing:
        | BRG001, BRG002, BRG003, BRG004
        |--------------------------------------------------------------------------
        */
        $targetStokAkhir = [
            'BRG001' => 2,
            'BRG002' => 0,
            'BRG003' => 15,
            'BRG004' => 0,
            'BRG005' => 3,
            'BRG006' => 2,
        ];


        /*
        |--------------------------------------------------------------------------
        | TARGET JUMLAH TERJUAL
        |--------------------------------------------------------------------------
        */
        $sisaTargetJual = [];

        foreach ($stokTersedia as $idBarang => $stokTotal) {
            $sisaTargetJual[$idBarang] = $stokTotal - $targetStokAkhir[$idBarang];
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI & DETAIL TRANSAKSI
        |--------------------------------------------------------------------------
        */
        $transaksiData = [];
        $detailTransaksiData = [];

        $idTransaksiCounter = 1;
        $idDetailTransaksiCounter = 1;

        // DIUBAH MULAI DARI 1 MEI 2026
        $tanggalMulai = Carbon::create(2026, 5, 1);
        $tanggalAkhir = Carbon::now();

        $tanggalBerjalan = $tanggalMulai->copy();

        /*
        |--------------------------------------------------------------------------
        | BUAT TRANSAKSI DUMMY SAMPAI TARGET TERJUAL HABIS
        |--------------------------------------------------------------------------
        */
        while (array_sum($sisaTargetJual) > 0) {

            if ($tanggalBerjalan->greaterThan($tanggalAkhir)) {
                $tanggalBerjalan = $tanggalMulai->copy();
            }

            $idTransaksi = 'TRX' . str_pad(
                $idTransaksiCounter,
                3,
                '0',
                STR_PAD_LEFT
            );

            $pakaiMember = rand(0, 1);

            $idPelanggan = $pakaiMember
                ? 'PLG' . str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT)
                : null;

            $namaPelangganLain = $pakaiMember
                ? null
                : 'Pelanggan Umum ' . rand(1, 150);

            $totalBarang = 0;

            $jumlahJenisBarang = rand(1, 2);

            $barangBisaDijual = collect($barang)
                ->filter(function ($item) use ($sisaTargetJual, $stokTersedia) {
                    return isset($sisaTargetJual[$item['id_barang']])
                        && $sisaTargetJual[$item['id_barang']] > 0
                        && $stokTersedia[$item['id_barang']] > 0;
                })
                ->shuffle()
                ->take($jumlahJenisBarang);

            foreach ($barangBisaDijual as $barangItem) {

                $idBarang = $barangItem['id_barang'];

                $qtyMaksimal = min(
                    3,
                    $sisaTargetJual[$idBarang],
                    $stokTersedia[$idBarang]
                );

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
                    'created_at' => $tanggalBerjalan->copy(),
                    'updated_at' => $tanggalBerjalan->copy(),
                ];

                $stokTersedia[$idBarang] -= $qty;

                $sisaTargetJual[$idBarang] -= $qty;

                $idDetailTransaksiCounter++;
            }

            if ($totalBarang > 0) {

                $hargaJasa = rand(2, 5) * 10000;

                $totalHarga = $totalBarang + $hargaJasa;

                $transaksiData[] = [
                    'id_transaksi' => $idTransaksi,
                    'id_user' => 'USR002',
                    'id_pelanggan' => $idPelanggan,
                    'nama_pelanggan_lain' => $namaPelangganLain,
                    'tanggal_transaksi' => $tanggalBerjalan->format('Y-m-d'),
                    'total_harga' => $totalHarga,
                    'harga_jasa' => $hargaJasa,
                    'uang_bayar' => $totalHarga + 50000,
                    'uang_kembali' => 50000,
                    'created_at' => $tanggalBerjalan->copy(),
                    'updated_at' => $tanggalBerjalan->copy(),
                ];

                $idTransaksiCounter++;
            }

            $tanggalBerjalan->addDay();
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

        $stokBerjalan = [];


        /*
        |--------------------------------------------------------------------------
        | HISTORY STOK AWAL (Digeser ke bulan Mei)
        |--------------------------------------------------------------------------
        */
        foreach ($stokAwal as $idBarang => $jumlahAwal) {

            $stokBerjalan[$idBarang] = $jumlahAwal;

            $history[] = [
                'id_history_stok' => 'HS' . str_pad($historyCounter, 4, '0', STR_PAD_LEFT),
                'id_barang' => $idBarang,
                'jumlah_masuk' => $jumlahAwal,
                'jumlah_keluar' => 0,
                'jumlah_sisa' => $jumlahAwal,
                'jumlah_barang' => $jumlahAwal,
                'created_at' => Carbon::parse('2026-05-01'),
                'updated_at' => Carbon::parse('2026-05-01'),
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
                'created_at' => Carbon::parse($masuk['tanggal']),
                'updated_at' => Carbon::parse($masuk['tanggal']),
            ];

            $historyCounter++;
        }


        /*
        |--------------------------------------------------------------------------
        | HISTORY TRANSAKSI KELUAR
        |--------------------------------------------------------------------------
        */
        foreach ($detailTransaksiData as $detail) {

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
        | URUTKAN HISTORY BERDASARKAN TANGGAL
        |--------------------------------------------------------------------------
        */
        usort($history, function ($a, $b) {
            return strtotime($a['created_at']) <=> strtotime($b['created_at']);
        });


        /*
        |--------------------------------------------------------------------------
        | RESET ULANG ID HISTORY SETELAH DIURUTKAN
        |--------------------------------------------------------------------------
        */
        foreach ($history as $index => $item) {
            $history[$index]['id_history_stok'] = 'HS' . str_pad(
                $index + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        }


        /*
        |--------------------------------------------------------------------------
        | INSERT HISTORY STOK
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($history, 50) as $chunk) {
            DB::table('tbl_history_stok')->insert($chunk);
        }

        $this->command->info('Data dummy bengkel berhasil dibuat (Mulai Mei 2026).');
    }
}
