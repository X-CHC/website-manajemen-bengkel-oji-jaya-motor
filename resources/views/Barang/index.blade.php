@extends('layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}

                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            Data Barang
                        </h3>

                        <a href="{{ route('barang.create') }}"
                           class="btn btn-primary btn-sm ml-auto">
                            <i class="fas fa-plus"></i>
                            Tambah Barang
                        </a>
                    </div>

                    <div class="card-body">

                        <table id="tableBarang"
                               class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th width="10%">NO</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Alert</th>
                                    <th>Dibuat</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($barang as $item)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->nama_barang }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{ $item->jumlah_barang }}
                                        </td>

                                        <td>
                                            @if($item->jumlah_barang <= $item->alert_jumlah_barang)

                                                <span class="badge badge-danger">
                                                    {{ $item->alert_jumlah_barang }}
                                                </span>

                                            @else

                                                <span class="badge badge-success">
                                                    {{ $item->alert_jumlah_barang }}
                                                </span>

                                            @endif
                                        </td>

                                        <td>
                                            {{ $item->created_at->format('d-m-Y H:i') }}
                                        </td>

                                        <td>

                                            <a href="{{ route('barang.index', $item->id_barang) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('barang.index', $item->id_barang) }}"
                                                  method="POST"
                                                  style="display:inline-block;">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data?')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </td>

                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            Data barang belum tersedia
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection




@push('scripts')


<script>
$(function () {

    $('#tableBarang').DataTable({
        responsive: true,
        autoWidth: false,
    });

});
</script>

@endpush
