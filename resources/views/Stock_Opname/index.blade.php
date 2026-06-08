@extends('layout.app')

@section('content')

@php
    $canCreate = punyaAksesMenu('stock-opname.create', auth()->user());
    $canExportExcel = punyaAksesMenu('stock-opname.export-excel', auth()->user());

    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp

<section class="content">
<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header d-flex align-items-center">

            <h3 class="card-title">
                Riwayat Stock Opname
            </h3>

            @if($canCreate)

                <a href="{{ route('stock-opname.create') }}"
                   class="btn btn-secondary btn-sm ml-auto">

                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Stock Opname

                </a>

            @endif

        </div>

        <div class="card-body">

            <div class="alert {{ $stockOpname->count() > 0 ? 'alert-success' : 'alert-info' }}">

                <i class="fas {{ $stockOpname->count() > 0 ? 'fa-check-circle' : 'fa-info-circle' }}"></i>

                @if($stockOpname->count() > 0)

                    Terdapat {{ $stockOpname->count() }} data riwayat stock opname.

                @else

                    Belum ada perubahan / stock opname.

                @endif

            </div>


            {{-- TABEL RIWAYAT --}}
            <table id="tableStockOpnameIndex"
                   class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>ID Stock Opname</th>

                        <th>Tanggal</th>

                        <th>Bulan</th>

                        <th>Tahun</th>

                        <th>Petugas</th>

                        <th>Jumlah Barang Diubah</th>

                        @if($canExportExcel)
                            <th>Aksi</th>
                        @endif

                    </tr>

                </thead>

                <tbody>

                    @forelse($stockOpname as $item)

                        @php
                            $tanggalOpname = \Carbon\Carbon::parse($item->tanggal_opname);

                            $bulanOpname = (int) $tanggalOpname->format('n');

                            $tahunOpname = $tanggalOpname->format('Y');
                        @endphp

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->id_stock_opname }}
                            </td>

                            <td>
                                {{ $tanggalOpname->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $namaBulan[$bulanOpname] }}
                            </td>

                            <td>
                                {{ $tahunOpname }}
                            </td>

                            <td>
                                {{ $item->user->email ?? '-' }}

                                <br>

                                <small class="text-muted">
                                    {{ $item->user->role->nama_role ?? '-' }}
                                </small>
                            </td>

                            <td>
                                {{ $item->detailStockOpname->count() }}
                            </td>

                            @if($canExportExcel)
                                <td>
                                    <form action="{{ route('stock-opname.export-excel') }}"
                                          method="POST"
                                          target="_blank"
                                          class="d-inline">

                                        @csrf

                                        <input type="hidden"
                                               name="id_stock_opname"
                                               value="{{ $item->id_stock_opname }}">

                                        <button type="submit"
                                                class="btn btn-success btn-sm">

                                            <i class="fas fa-file-excel"></i>
                                            Excel

                                        </button>

                                    </form>
                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>
                            <td colspan="{{ $canExportExcel ? 8 : 7 }}"
                                class="text-center">

                                Data stock opname belum tersedia

                            </td>
                        </tr>

                    @endforelse

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

    $('#tableStockOpnameIndex').DataTable({
        responsive: true,
        autoWidth: false,
    });

});
</script>

@endpush
