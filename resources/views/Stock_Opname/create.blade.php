@extends('layout.app')

@section('content')

@php
    $canModeOn = punyaAksesMenu('stock-opname.mode-on', auth()->user());
    $canModeOff = punyaAksesMenu('stock-opname.mode-off', auth()->user());
    $canStore = punyaAksesMenu('stock-opname.store', auth()->user());
    $canExportExcel = punyaAksesMenu('stock-opname.export-excel', auth()->user());
@endphp

<section class="content">
<div class="container-fluid">

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- CARD MODE STOCK OPNAME --}}
    <div class="card {{ $modeStockOpname ? 'card-danger' : 'card-secondary' }}">

        <div class="card-header">

            <h3 class="card-title">
                Stock Opname
            </h3>

        </div>

        <div class="card-body">

            @if($modeStockOpname)

                <div class="alert alert-warning mb-3">

                    <i class="fas fa-exclamation-triangle"></i>

                    Mode stock opname sedang aktif.
                    Semua fitur selain stock opname sementara dinonaktifkan.

                </div>

                @if($canModeOff)
                    <form action="{{ route('stock-opname.mode-off') }}"
                          method="POST"
                          class="d-inline">

                        @csrf

                        <button type="submit"
                                class="btn btn-secondary"
                                onclick="return confirm('Matikan mode stock opname?')">

                            <i class="fas fa-power-off"></i>
                            Matikan Mode Stock Opname

                        </button>

                    </form>
                @endif

            @else

                <div class="alert alert-info mb-3">

                    <i class="fas fa-info-circle"></i>

                    Mode stock opname sedang mati.
                    Aktifkan mode ini jika ingin melakukan pengecekan stok toko.

                </div>

                @if($canModeOn)
                    <form action="{{ route('stock-opname.mode-on') }}"
                          method="POST"
                          class="d-inline">

                        @csrf

                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Aktifkan mode stock opname? Fitur lain akan dinonaktifkan sementara.')">

                            <i class="fas fa-power-off"></i>
                            Aktifkan Mode Stock Opname

                        </button>

                    </form>
                @endif

            @endif

        </div>

    </div>


    @if($canStore || $modeStockOpname || $canExportExcel)

        <form id="formStockOpname"
              action="{{ route('stock-opname.store') }}"
              method="POST">

            @csrf

            <div class="card card-primary">

                <div class="card-body">

                    <table id="tableStockOpname"
                           class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Barang</th>

                                <th>Kategori</th>

                                <th>Stok Sistem</th>

                                <th>Stok Toko</th>

                                <th>Selisih</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($barang as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->nama_barang }}

                                        <input type="hidden"
                                               name="id_barang[]"
                                               value="{{ $item->id_barang }}">
                                    </td>

                                    <td>
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </td>

                                    <td>
                                        <input type="number"
                                               class="form-control stok-sistem"
                                               value="{{ $item->jumlah_barang }}"
                                               readonly>
                                    </td>

                                    <td>
                                        <input type="number"
                                               name="stok_toko[]"
                                               class="form-control stok-toko"
                                               value="{{ old('stok_toko.' . $loop->index, $item->jumlah_barang) }}"
                                               min="0"
                                               required
                                               {{ !$modeStockOpname ? 'readonly' : '' }}>
                                    </td>

                                    <td>
                                        <input type="text"
                                               class="form-control selisih"
                                               value="0"
                                               readonly>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @if($canStore || ($canExportExcel && !$modeStockOpname))
                    <div class="card-footer">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <div>

                                @if($canStore)
                                    <button type="button"
                                            id="btnSimpanStockOpname"
                                            class="btn btn-primary"
                                            {{ !$modeStockOpname ? 'disabled' : '' }}>

                                        <i class="fas fa-save"></i>
                                        Simpan Stock Opname

                                    </button>
                                @endif

                                @if($canExportExcel && !$modeStockOpname)
                                    <button type="button"
                                            id="btnExportStockOpname"
                                            class="btn btn-success">

                                        <i class="fas fa-file-excel"></i>
                                        Export Excel

                                    </button>
                                @endif

                            </div>


                            @if($canExportExcel && !$modeStockOpname)
                                <div class="small mt-2 mt-md-0">

                                    @if($jumlahStockOpnameBulanIni > 0)

                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i>
                                            Bulan ini sudah ada {{ $jumlahStockOpnameBulanIni }} stock opname.
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            Bulan ini belum ada perubahan / stock opname.
                                        </span>

                                    @endif

                                </div>
                            @endif

                        </div>

                    </div>
                @endif

            </div>

        </form>
    @endif

</div>
</section>

@endsection


@push('scripts')

<script>

function hitungSelisih(row)
{
    let stokSistem = parseInt(
        row.find('.stok-sistem').val()
    ) || 0;

    let stokToko = parseInt(
        row.find('.stok-toko').val()
    ) || 0;

    let selisih = stokToko - stokSistem;

    let inputSelisih = row.find('.selisih');

    inputSelisih.val(selisih);

    /*
    |--------------------------------------------------------------------------
    | RESET CLASS SELISIH
    |--------------------------------------------------------------------------
    */
    inputSelisih.removeClass(
        'text-success text-danger text-dark font-weight-bold'
    );

    if (selisih < 0) {

        inputSelisih.addClass('text-danger font-weight-bold');

    } else if (selisih > 0) {

        inputSelisih.addClass('text-success font-weight-bold');

    } else {

        inputSelisih.addClass('text-dark');

    }
}


$(document).on('input', '.stok-toko', function(){

    if(parseInt($(this).val()) < 0)
    {
        alert('Stok toko tidak boleh negatif');

        $(this).val(0);
    }

    let row = $(this).closest('tr');

    hitungSelisih(row);
});


$(function () {

    $("#tableStockOpname").DataTable({
        responsive: true,
        autoWidth: false,
    });


    $('.stok-toko').each(function(){

        let row = $(this).closest('tr');

        hitungSelisih(row);
    });


    /*
    |--------------------------------------------------------------------------
    | SIMPAN STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    $('#btnSimpanStockOpname').on('click', function () {

        if (!confirm('Simpan hasil stock opname? Mode stock opname akan dimatikan setelah data disimpan.')) {
            return;
        }

        $('#formStockOpname')
            .attr('action', "{{ route('stock-opname.store') }}")
            .attr('target', '_self')
            .submit();

    });


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    $('#btnExportStockOpname').on('click', function () {

        $('#formStockOpname')
            .attr('action', "{{ route('stock-opname.export-excel') }}")
            .attr('target', '_blank')
            .submit();

    });


    });

</script>

@endpush
