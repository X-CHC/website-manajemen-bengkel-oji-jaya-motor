@extends('layout.app')

@section('content')

@php
    $canExportHistoryExcel = punyaAksesMenu('history.export-excel', auth()->user());
@endphp

<section class="content">
<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex align-items-center">

            <h3 class="card-title">
                History Stok Barang
            </h3>

            @if($canExportHistoryExcel)
                <a href="{{ route('history.export-excel') }}"
                   class="btn btn-success btn-sm ml-auto">

                    <i class="fas fa-file-excel"></i>
                    Cetak Excel

                </a>
            @endif

        </div>

        <div class="card-body">

            <table id="tableHistory"
                   class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>ID History</th>

                        <th>Tanggal</th>

                        <th>Barang</th>

                        <th>Barang Masuk</th>

                        <th>Barang Keluar</th>

                        <th>Sisa Stok</th>

                        <th>Keterangan</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($history as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->id_history_stok }}
                        </td>

                        <td>
                            {{ $item->created_at->format('d-m-Y H:i') }}
                        </td>

                        <td>
                            {{ $item->barang->nama_barang ?? '-' }}
                        </td>

                        <td>

                            @if($item->jumlah_masuk > 0)

                                <span class="badge badge-success">

                                    +{{ $item->jumlah_masuk }}

                                </span>

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            @if($item->jumlah_keluar > 0)

                                <span class="badge badge-danger">

                                    -{{ $item->jumlah_keluar }}

                                </span>

                            @else

                                -

                            @endif

                        </td>

                        <td>
                            {{ $item->jumlah_sisa }}
                        </td>

                        <td>

                            @if($item->jumlah_masuk > 0 && $item->jumlah_keluar == 0)

                                Barang Masuk / Penambahan Stok

                            @elseif($item->jumlah_keluar > 0 && $item->jumlah_masuk == 0)

                                Penjualan / Pengurangan Stok

                            @else

                                Stock Opname / Penyesuaian Stok

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
</section>

@endsection


@push('scripts')

<script>

$(function () {

    $('#tableHistory').DataTable();

});

</script>

@endpush
