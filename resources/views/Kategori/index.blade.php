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
                            <th>Aksi</th>
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

                            <td>
                                <div class="d-flex">

                                    {{-- EDIT --}}
                                    <a href="{{ route('kategori.edit', $item->id_kategori_barang) }}"
                                    class="btn btn-warning btn-sm mr-1">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    {{-- HAPUS --}}
                                    <form action="{{ route('kategori.destroy', $item->id_kategori_barang) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus kategori ini?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>
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
