@extends('layout.app')

@section('content')

<section class="content">
<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                History Stok Barang
            </h3>

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

                            @if($item->jumlah_masuk > 0)

                                Barang Masuk

                            @else

                                Penjualan

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
