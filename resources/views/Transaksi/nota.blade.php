<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Transaksi</title>

    <style>
        @page {
            margin: 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #2b62ad;
        }

        .nota {
            width: 100%;
        }

        table {
            border-collapse: collapse;
        }

        .header {
            width: 100%;
            margin-bottom: 4px;
        }

        .header td {
            vertical-align: top;
        }

        .logo-box {
            width: 18%;
            text-align: center;
            padding-top: 8px;
        }

        .logo-img {
            width: 58px;
            height: auto;
        }

        .header-title {
            width: 52%;
            text-align: center;
            padding-top: 8px;
        }

        .header-title h2 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 11px;
            font-weight: bold;
        }

        .header-info {
            width: 30%;
            font-size: 11px;
            color: #2b62ad;
            padding-top: 33px;
        }

        .header-info p {
            margin: 0 0 5px 0;
        }

        .line {
            border-bottom: 1px dotted #2b62ad;
            display: inline-block;
            min-width: 95px;
            height: 13px;
            color: #000;
            font-size: 11px;
            padding-left: 4px;
        }

        .service-row {
            width: 100%;
            margin-top: 2px;
            margin-bottom: 5px;
        }

        .service-left {
            width: 58%;
            font-size: 11px;
            font-weight: bold;
        }

        .service-left p {
            margin: 3px 0;
        }

        .nota-info {
            width: 42%;
            font-size: 11px;
            vertical-align: bottom;
        }

        .no-nota {
            margin-top: 22px;
            font-weight: bold;
        }

        .brand-row {
            width: 100%;
            text-align: center;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        table.detail {
            width: 100%;
            border-collapse: collapse;
        }

        table.detail th,
        table.detail td {
            border: 1px solid #2b62ad;
            padding: 4px;
            font-size: 11px;
        }

        table.detail th {
            text-align: center;
            font-weight: bold;
        }

        .qty {
            width: 12%;
            text-align: center;
            color: #000;
        }

        .nama-barang {
            width: 43%;
            color: #000;
        }

        .harga {
            width: 21%;
            text-align: right;
            color: #000;
        }

        .jumlah {
            width: 24%;
            text-align: right;
            color: #000;
        }

        .empty-row td {
            height: 20px;
        }

        .bottom-area {
            width: 100%;
            margin-top: 0;
        }

        .bottom-left {
            width: 67%;
        }

        .bottom-right {
            width: 33%;
        }

        .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-table td {
            border: 1px solid #2b62ad;
            padding: 5px;
            font-size: 11px;
        }

        .total-label {
            width: 45%;
            font-weight: bold;
            color: #2b62ad;
        }

        .total-value {
            width: 55%;
            text-align: right;
            color: #000;
        }

        .footer {
            width: 100%;
            margin-top: 38px;
            font-size: 11px;
            color: #2b62ad;
        }

        .footer td {
            width: 50%;
            vertical-align: top;
        }

        .footer-left {
            text-align: left;
            padding-left: 22px;
        }

        .footer-right {
            text-align: center;
        }

        .signature-space {
            height: 48px;
        }
    </style>
</head>

<body>

<div class="nota">

    {{-- HEADER --}}
    <table class="header">
        <tr>
            <td class="logo-box">
                <img src="{{ public_path('assets/img/logo-nota.jpeg') }}" class="logo-img">
            </td>

            <td class="header-title">
                <h2>OJI JAYA MOTOR</h2>
                <p>Arah Perum TOA RT. 02/10</p>
                <p>Alfalah Cikaret, Cibinong - Bogor</p>
                <p>Tlp. 0812 8924 1229, 0856 0742 4875</p>
            </td>

            <td class="header-info">
                <p>
                    Bogor,
                    <span class="line">
                        @if($transaksi->tanggal_transaksi)
                            {{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}
                        @else
                            -
                        @endif
                    </span>
                </p>

                <p>
                    Tuan
                    <span class="line">
                        {{ $namaPelanggan }}
                    </span>
                </p>

                <p>
                    Toko
                    <span class="line"></span>
                </p>
            </td>
        </tr>
    </table>


    {{-- INFO SERVICE DAN NO NOTA --}}
    <table class="service-row">
        <tr>
            <td class="service-left">
                <p>Menerima Service, Ganti Oli, Tune Up</p>
                <p>Menyediakan sparepart dan Accessories</p>
                <p>Berbagai Merk Motor</p>
            </td>

            <td class="nota-info">
                <div class="no-nota">
                    No. Nota : {{ $transaksi->id_transaksi }}
                </div>
            </td>
        </tr>
    </table>


    {{-- MERK MOTOR --}}
    <div class="brand-row">
        HONDA &nbsp;&nbsp; YAMAHA &nbsp;&nbsp; SUZUKI &nbsp;&nbsp; KAWASAKI
    </div>


    {{-- DETAIL BARANG --}}
    <table class="detail">
        <thead>
            <tr>
                <th>Banyak-<br>nya</th>
                <th>Nama Barang</th>
                <th>Harga<br>Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
                <tr>
                    <td class="qty">
                        {{ $detail->jumlah_barang }}
                    </td>

                    <td class="nama-barang">
                        {{ $detail->barang->nama_barang ?? '-' }}
                    </td>

                    <td class="harga">
                        Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}
                    </td>

                    <td class="jumlah">
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach

            {{-- Harga jasa --}}
            @if($transaksi->harga_jasa && $transaksi->harga_jasa > 0)
                <tr>
                    <td class="qty">1</td>
                    <td class="nama-barang">Jasa Service</td>
                    <td class="harga">
                        Rp {{ number_format($transaksi->harga_jasa, 0, ',', '.') }}
                    </td>
                    <td class="jumlah">
                        Rp {{ number_format($transaksi->harga_jasa, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

            {{-- Hitung jumlah baris --}}
            @php
                $jumlahBaris = $transaksi->detailTransaksi->count();

                if ($transaksi->harga_jasa && $transaksi->harga_jasa > 0) {
                    $jumlahBaris++;
                }

                $minimalBaris = 10;
            @endphp

            {{-- Baris kosong supaya mirip nota asli --}}
            @for($i = $jumlahBaris; $i < $minimalBaris; $i++)
                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>


    {{-- TOTAL --}}
    <table class="bottom-area">
        <tr>
            <td class="bottom-left"></td>

            <td class="bottom-right">
                <table class="total-table">
                    <tr>
                        <td class="total-label">
                            Jumlah Rp.
                        </td>
                        <td class="total-value">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="total-label">
                            Uang Muka
                        </td>
                        <td class="total-value">
                            Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="total-label">
                            Sisa
                        </td>
                        <td class="total-value">
                            Rp {{ number_format($transaksi->uang_kembali, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    {{-- FOOTER --}}
    <table class="footer">
        <tr>
            <td class="footer-left">
                <strong>Tanda Terima,</strong>
                <div class="signature-space"></div>
                (.................................)
            </td>

            <td class="footer-right">
                <strong>Hormat kami,</strong>
                <div class="signature-space"></div>
                (.................................)
            </td>
        </tr>
    </table>

</div>

</body>
</html>
