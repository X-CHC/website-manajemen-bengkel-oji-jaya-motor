<!DOCTYPE html>
<html>
<head>

    <title>Laporan Transaksi</title>

    <style>

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2 {
            margin-bottom: 4px;
            text-align: center;
        }

        h4 {
            margin: 18px 0 8px 0;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 7px;
        }

        th {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .header-info {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .summary-wrapper {
            width: 100%;
            margin-top: 15px;
        }

        .summary-left {
            width: 49%;
            float: left;
        }

        .summary-right {
            width: 49%;
            float: right;
        }

        .summary-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .summary-title {
            background-color: #d9edf7;
            font-weight: bold;
            text-align: center;
        }

        .summary-label {
            background-color: #f8f8f8;
            font-weight: bold;
            width: 55%;
        }

        .summary-value {
            text-align: right;
            width: 45%;
        }

        .grand-total {
            background-color: #eeeeee;
            font-weight: bold;
        }

        .clear {
            clear: both;
        }

        .note {
            font-size: 11px;
            margin-top: 8px;
            padding: 7px;
            border: 1px solid #999;
            background-color: #f9f9f9;
        }

        .detail-table {
            margin-top: 10px;
        }

        .small-text {
            font-size: 10px;
        }

    </style>

</head>
<body>

    <h2>
        Laporan Transaksi / Penjualan
    </h2>

    <div class="header-info">

        <p>
            <strong>Periode:</strong>

            @if($request->tanggal_awal && $request->tanggal_akhir)

                {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d-m-Y') }}
                sampai
                {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d-m-Y') }}

            @else

                Semua Periode

            @endif
        </p>

    </div>


    {{-- RINGKASAN --}}
    <div class="summary-wrapper">

        {{-- RINGKASAN PENDAPATAN --}}
        <div class="summary-left">

            <table class="summary-table">

                <tr>
                    <td colspan="2" class="summary-title">
                        Ringkasan Pendapatan
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Penjualan Barang
                    </td>

                    <td class="summary-value">
                        Rp {{ number_format($totalPenjualanBarang, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Jasa
                    </td>

                    <td class="summary-value">
                        Rp {{ number_format($totalJasa, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label grand-total">
                        Total Pendapatan
                    </td>

                    <td class="summary-value grand-total">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </td>
                </tr>

            </table>

        </div>


        {{-- RINGKASAN MODAL DAN LABA --}}
        <div class="summary-right">

            <table class="summary-table">

                <tr>
                    <td colspan="2" class="summary-title">
                        Ringkasan Modal & Laba
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Modal Barang
                    </td>

                    <td class="summary-value">
                        Rp {{ number_format($totalModalBarang, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        keuntungan Kotor
                    </td>

                    <td class="summary-value">
                        Rp {{ number_format($labaKotor, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label grand-total">
                        Total Pendapatan Kasar
                    </td>

                    <td class="summary-value grand-total">
                        Rp {{ number_format($labaBersih, 0, ',', '.') }}
                    </td>
                </tr>

            </table>

        </div>

        <div class="clear"></div>

    </div>


    {{-- PENJELASAN SINGKAT --}}
    <div class="note">

        <strong>Keterangan:</strong>
        Total pendapatan berasal dari penjualan barang ditambah jasa.
        Keuntungan Kotor berasal dari penjualan barang dikurangi modal barang.
        Total Pendapatan Kasar berasal dari Keuntungan Kotor ditambah jasa,
        dan belum dikurangi biaya operasional lain seperti listrik, sewa, atau gaji.

    </div>


    {{-- DETAIL BARANG --}}
    <h4>
        Detail Penjualan Barang
    </h4>

    <table class="detail-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Barang</th>

                <th>Jumlah</th>

                <th>Harga Beli</th>

                <th>Harga Jual</th>

                <th>Total Modal</th>

                <th>Total Penjualan</th>

                <th>Selisih Harga</th>

            </tr>

        </thead>

        <tbody>

            @forelse($rekap as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item['nama_barang'] }}
                    </td>

                    <td class="text-center">
                        {{ $item['jumlah_terjual'] }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item['harga_beli'], 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item['total_modal'], 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item['total_harga'], 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item['laba_barang'], 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center">
                        Data transaksi tidak tersedia
                    </td>
                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr>

                <th colspan="5" class="text-right">
                    Total
                </th>

                <th class="text-right">
                    Rp {{ number_format($totalModalBarang, 0, ',', '.') }}
                </th>

                <th class="text-right">
                    Rp {{ number_format($totalPenjualanBarang, 0, ',', '.') }}
                </th>

                <th class="text-right">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </th>

            </tr>

        </tfoot>

    </table>

</body>
</html>
