<!DOCTYPE html>
<html>
<head>

    <title>Laporan Transaksi</title>

    <style>

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 7px;
        }

        th {
            background-color: #eeeeee;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: 60%;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .summary-table td {
            padding: 6px;
        }

        .summary-label {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .note {
            font-size: 11px;
            margin-top: 8px;
        }

    </style>

</head>
<body>

    <h2>
        Laporan Transaksi / Penjualan
    </h2>

    <p>
        Periode:
        @if($request->tanggal_awal && $request->tanggal_akhir)

            {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d-m-Y') }}
            sampai
            {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d-m-Y') }}

        @else

            Semua Periode

        @endif
    </p>


    <table class="summary-table">

        <tr>
            <td class="summary-label">
                Total Penjualan Barang
            </td>

            <td class="text-right">
                Rp {{ number_format($totalPenjualanBarang, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="summary-label">
                Total Modal Barang
            </td>

            <td class="text-right">
                Rp {{ number_format($totalModalBarang, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="summary-label">
                Laba Kotor Barang
            </td>

            <td class="text-right">
                Rp {{ number_format($labaKotor, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="summary-label">
                Total Jasa
            </td>

            <td class="text-right">
                Rp {{ number_format($totalJasa, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="summary-label">
                Total Pendapatan
            </td>

            <td class="text-right">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="summary-label">
                Laba Bersih Sementara
            </td>

            <td class="text-right">
                Rp {{ number_format($labaBersih, 0, ',', '.') }}
            </td>
        </tr>

    </table>

    <p class="note">
        Catatan: Laba bersih sementara dihitung dari laba penjualan barang ditambah jasa,
        belum dikurangi biaya operasional lain.
    </p>


    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Barang</th>

                <th>Jumlah Terjual</th>

                <th>Harga Beli</th>

                <th>Harga Jual</th>

                <th>Total Modal</th>

                <th>Total Harga</th>

                <th>Laba Barang</th>

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
