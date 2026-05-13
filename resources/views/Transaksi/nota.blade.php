<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Transaksi</title>

    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .nota {
            width: 100%;
        }

        .header {
            width: 100%;
            margin-bottom: 8px;
        }

        .header td {
            vertical-align: top;
        }

        .logo-box {
            width: 22%;
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            border: 2px solid #000;
            width: 45px;
            height: 45px;
            line-height: 45px;
            margin: auto;
        }

        .header-title {
            width: 48%;
            text-align: center;
        }

        .header-title h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 10px;
        }

        .header-info {
            width: 30%;
            font-size: 10px;
        }

        .line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 90px;
            height: 12px;
        }

        .service-info {
            margin-top: 5px;
            margin-bottom: 8px;
            font-size: 10px;
        }

        .service-info p {
            margin: 2px 0;
        }

        .motor-brand {
            text-align: center;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 10px;
        }

        table.detail {
            width: 100%;
            border-collapse: collapse;
        }

        table.detail th,
        table.detail td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 10px;
        }

        table.detail th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nama-barang {
            width: 45%;
        }

        .qty {
            width: 12%;
            text-align: center;
        }

        .harga {
            width: 20%;
            text-align: right;
        }

        .jumlah {
            width: 23%;
            text-align: right;
        }

        .total-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .total-table td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 10px;
        }

        .footer {
            width: 100%;
            margin-top: 35px;
            font-size: 10px;
        }

        .footer td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-space {
            height: 45px;
        }
    </style>
</head>
<body>

<div class="nota">

    {{-- HEADER --}}
    <table class="header">
        <tr>
            <td class="logo-box">
                <div class="logo">B</div>
            </td>

            <td class="header-title">
                <h2>BENGKEL MOTOR</h2>
                <p>Jl. Contoh Alamat No. 123</p>
                <p>Telp. 0812 3456 7890</p>
            </td>

            <td class="header-info">
                <p>
                    Bogor,
                    <span class="line">
                        {{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}
                    </span>
                </p>

                <p>
                    Tuan
                    <span class="line">
                        {{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}
                    </span>
                </p>

                <p>
                    Toko
                    <span class="line"></span>
                </p>
            </td>
        </tr>
    </table>


    {{-- INFO SERVICE --}}
    <div class="service-info">
        <p>Menerima Service, Ganti Oli, Tune Up</p>
        <p>Menyediakan sparepart dan accessories</p>
        <p>Berbagai Merk Motor</p>
    </div>


    {{-- NO NOTA --}}
    <p style="margin: 0 0 5px 0;">
        <strong>No. Nota :</strong> {{ $transaksi->id_transaksi }}
    </p>


    {{-- MERK MOTOR --}}
    <div class="motor-brand">
        HONDA &nbsp; YAMAHA &nbsp; SUZUKI
    </div>


    {{-- DETAIL BARANG --}}
    <table class="detail">
        <thead>
            <tr>
                <th>Banyaknya</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
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
                        {{ $detail->barang->nama_barang }}
                    </td>

                    <td class="harga">
                        Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}
                    </td>

                    <td class="jumlah">
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach

            {{-- Baris kosong supaya bentuk nota tetap panjang --}}
            @for($i = count($transaksi->detailTransaksi); $i < 10; $i++)
                <tr>
                    <td style="height: 18px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>


    {{-- TOTAL --}}
    <table class="total-table">
        <tr>
            <td width="45%">
                <strong>Jumlah Rp.</strong>
            </td>
            <td class="text-right">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td>
                Uang Muka
            </td>
            <td class="text-right">
                Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td>
                Sisa
            </td>
            <td class="text-right">
                Rp {{ number_format($transaksi->uang_kembali, 0, ',', '.') }}
            </td>
        </tr>
    </table>


    {{-- FOOTER --}}
    <table class="footer">
        <tr>
            <td>
                <strong>Tanda Terima,</strong>
                <div class="signature-space"></div>
                (.................................)
            </td>

            <td>
                <strong>Hormat kami,</strong>
                <div class="signature-space"></div>
                (.................................)
            </td>
        </tr>
    </table>

</div>

</body>
</html>
