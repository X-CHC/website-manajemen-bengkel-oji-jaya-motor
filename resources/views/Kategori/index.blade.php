@extends('layout.app')

@section('content')



<section class="content">
    <div class="container-fluid">

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Kategori Barang</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->id_kategori_barang }}</td>

                            <td>{{ $item->nama_kategori }}</td>

                            <td>
                                {{ $item->created_at->format('d-m-Y H:i') }}
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
    $("#example1").DataTable({
        responsive: true,
        autoWidth: false,
    });
});
</script>

@endpush
