@extends('layout.app')

@section('content')

@php
    $canCreateKategori = punyaAksesMenu('kategori.create', auth()->user());
    $canEditKategori = punyaAksesMenu('kategori.edit', auth()->user());
    $canDeleteKategori = punyaAksesMenu('kategori.destroy', auth()->user());
@endphp

<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Data Kategori Barang</h3>
                
                @if($canCreateKategori)
                    <a href="{{ route('kategori.create') }}"
                       class="btn btn-primary btn-sm ml-auto">
                        <i class="fas fa-plus"></i>
                        Tambah Kategori
                    </a>
                @endif
            </div>

            <div class="card-body">
                <table id="tableKategori" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Tanggal Dibuat</th>
                            @if($canEditKategori || $canDeleteKategori)
                                <th>Aksi</th>
                            @endif
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

                            @if($canEditKategori || $canDeleteKategori)
                                <td>
                                    <div class="d-flex">

                                        @if($canEditKategori)
                                            {{-- EDIT --}}
                                            <a href="{{ route('kategori.edit', $item->id_kategori_barang) }}"
                                            class="btn btn-warning btn-sm mr-1">

                                                <i class="fas fa-edit"></i>

                                            </a>
                                        @endif

                                        @if($canDeleteKategori)
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
                                        @endif

                                    </div>
                                </td>
                            @endif
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
    $("#tableKategori").DataTable({
        responsive: true,
        autoWidth: false,
    });
});
</script>

@endpush
