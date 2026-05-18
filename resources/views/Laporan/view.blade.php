<!DOCTYPE html>
<html>
<head>

    <title>Laporan Transaksi</title>

    <style>

        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid black;
        }

        th, td{
            padding:8px;
        }

    </style>

</head>
<body>

    <h2>
        Laporan Transaksi
    </h2>

    <p>
        Periode:
        {{ \Carbon\Carbon::parse($request->tanggal_awal)->format('d-m-Y') }}
        sampai
        {{ \Carbon\Carbon::parse($request->tanggal_akhir)->format('d-m-Y') }}
    </p>

    <p>
        Total Pendapatan :
        Rp {{ number_format($totalPendapatan,0,',','.') }}
    </p>

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Barang</th>

                <th>Jumlah Terjual</th>

            </tr>

        </thead>

        <tbody>

            @foreach($rekap as $item)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item['nama_barang'] }}
                </td>

                <td>
                    {{ $item['jumlah_terjual'] }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>
