@extends('Layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        @php
            $canCreateBarang = punyaAksesMenu('barang.create', auth()->user());
            $canEditBarang = punyaAksesMenu('barang.edit', auth()->user());
            $canDeleteBarang = punyaAksesMenu('barang.destroy', auth()->user());

            $barangMenipis = $barang->filter(function ($item) {
                return $item->jumlah_barang > 0 &&
                       $item->jumlah_barang <= $item->alert_jumlah_barang;
            });

            $barangHabis = $barang->filter(function ($item) {
                return $item->jumlah_barang <= 0;
            });

            $totalPerluRestock = $barangMenipis->count() + $barangHabis->count();

            $listPeringatan = $barangHabis->merge($barangMenipis);
        @endphp


        {{-- NOTIF STOK MENIPIS / HABIS --}}
        @if($totalPerluRestock > 0)

            <div class="card card-danger collapsed-card">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Peringatan Stok Menipis / Habis
                    </h3>

                    <div class="card-tools">

                        <span class="badge badge-light mr-2">
                            {{ $totalPerluRestock }} Barang
                        </span>

                        <button type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse">

                            <i class="fas fa-plus"></i>

                        </button>

                    </div>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive p-3">

                        <table id="tablePeringatanStok"
                               class="table table-bordered table-hover mb-0">

                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok Sekarang</th>
                                    <th>Batas Alert</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($listPeringatan as $item)

                                    <tr class="{{ $item->jumlah_barang <= 0 ? 'stok-habis' : 'stok-menipis' }}">

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->nama_barang }}
                                        </td>

                                        <td>
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->jumlah_barang }}
                                        </td>

                                        <td>
                                            {{ $item->alert_jumlah_barang }}
                                        </td>

                                        <td>
                                            @if($item->jumlah_barang <= 0)

                                                <span class="badge badge-danger">
                                                    Habis
                                                </span>

                                            @else

                                                <span class="badge badge-warning">
                                                    Menipis
                                                </span>

                                            @endif
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        @else

            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Semua stok barang masih aman.
            </div>

        @endif


        {{-- TABLE BARANG --}}
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">
                            Data Barang
                        </h3>

                        @if($canCreateBarang)

                            <a href="{{ route('barang.create') }}"
                               class="btn btn-primary btn-sm ml-auto">

                                <i class="fas fa-plus"></i>
                                Tambah Barang

                            </a>

                        @endif

                    </div>

                    <div class="card-body">

                        <table id="tableBarang"
                               class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Alert</th>
                                    <th>Status Stok</th>
                                    <th>Dibuat</th>

                                    @if($canEditBarang || $canDeleteBarang)
                                        <th width="15%">Action</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($barang as $item)

                                    <tr class="
                                        @if($item->jumlah_barang <= 0)
                                            stok-habis
                                        @elseif($item->jumlah_barang <= $item->alert_jumlah_barang)
                                            stok-menipis
                                        @endif
                                    ">

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

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
                                            {{ $item->alert_jumlah_barang }}
                                        </td>

                                        <td>
                                            @if($item->jumlah_barang <= 0)

                                                <span class="badge badge-danger">
                                                    Habis
                                                </span>

                                            @elseif($item->jumlah_barang <= $item->alert_jumlah_barang)

                                                <span class="badge badge-warning">
                                                    Menipis
                                                </span>

                                            @else

                                                <span class="badge badge-success">
                                                    Aman
                                                </span>

                                            @endif
                                        </td>

                                        <td>
                                            {{ $item->created_at->format('d-m-Y H:i') }}
                                        </td>

                                        @if($canEditBarang || $canDeleteBarang)

                                            <td>

                                                @if($canEditBarang)

                                                    <a href="{{ route('barang.edit', $item->id_barang) }}"
                                                       class="btn btn-warning btn-sm">

                                                        <i class="fas fa-edit"></i>

                                                    </a>

                                                @endif


                                                @if($canDeleteBarang)

                                                    <form action="{{ route('barang.destroy', $item->id_barang) }}"
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

                                                @endif

                                            </td>

                                        @endif

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="{{ ($canEditBarang || $canDeleteBarang) ? 10 : 9 }}"
                                            class="text-center">

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


@push('styles')

<style>
    .stok-habis td {
        background-color: #f8d7da !important;
    }

    .stok-menipis td {
        background-color: #fff3cd !important;
    }
</style>

@endpush


@push('scripts')

<script>
$(function () {

    $('#tablePeringatanStok').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 5,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: true,
    });


    $('#tableBarang').DataTable({
        responsive: true,
        autoWidth: false,
    });

});
</script>

@endpush
