<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>Nota Transaksi</title>

    <style>

        body{
            font-family: sans-serif;
            font-size: 12px;
        }

        .text-center{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td{
            border: 1px solid #000;
            padding: 5px;
        }

        .mt{
            margin-top: 20px;
        }

    </style>

</head>
<body>

    {{-- HEADER --}}
    <div class="text-center">

        <h2>BENGKEL MOTOR</h2>

        <p>
            Jl. Contoh Alamat No. 123
        </p>

        <hr>

    </div>


    {{-- INFO TRANSAKSI --}}
    <table>

        <tr>

            <td width="30%">
                ID Transaksi
            </td>

            <td>
                {{ $transaksi->id_transaksi }}
            </td>

        </tr>

        <tr>

            <td>
                Tanggal
            </td>

            <td>
                {{ $transaksi->tanggal_transaksi }}
            </td>

        </tr>

        <tr>

            <td>
                Kasir
            </td>

            <td>
                {{ $transaksi->nama_kasir }}
            </td>

        </tr>

    </table>


    {{-- DETAIL BARANG --}}
    <table class="mt">

        <thead>

            <tr>

                <th>No</th>

                <th>Barang</th>

                <th>Qty</th>

                <th>Harga</th>

                <th>Subtotal</th>

            </tr>

        </thead>

        <tbody>

            @foreach($transaksi->detailTransaksi as $index => $detail)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $detail->barang->nama_barang }}
                    </td>

                    <td>
                        {{ $detail->jumlah_barang }}
                    </td>

                    <td>
                        Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}
                    </td>

                    <td>
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    {{-- TOTAL --}}
    <table class="mt">

        <tr>

            <td width="70%">
                Total
            </td>

            <td>
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td>
                Bayar
            </td>

            <td>
                Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td>
                Kembalian
            </td>

            <td>
                Rp {{ number_format($transaksi->uang_kembali, 0, ',', '.') }}
            </td>

        </tr>

    </table>


    {{-- FOOTER --}}
    <div class="text-center mt">

        <p>
            Terima kasih telah berbelanja
        </p>

    </div>

</body>
</html>
