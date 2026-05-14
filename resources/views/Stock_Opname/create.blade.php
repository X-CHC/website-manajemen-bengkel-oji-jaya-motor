@extends('layout.app')

@section('content')

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


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <form action="{{ route('stock-opname.store') }}"
          method="POST">

        @csrf

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    Stock Opname
                </h3>

            </div>

            <div class="card-body">

                <table id="tableStockOpname"
                       class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Barang</th>

                            <th>Kategori</th>

                            <th>Stok Sistem</th>

                            <th>Stok Fisik</th>

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
                                           name="stok_fisik[]"
                                           class="form-control stok-fisik"
                                           value="{{ old('stok_fisik.' . $loop->index, $item->jumlah_barang) }}"
                                           min="0"
                                           required>
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

            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary">

                    Simpan Stock Opname

                </button>

            </div>

        </div>

    </form>

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

    let stokFisik = parseInt(
        row.find('.stok-fisik').val()
    ) || 0;

    let selisih = stokFisik - stokSistem;

    row.find('.selisih').val(selisih);

    if(selisih < 0)
    {
        row.find('.selisih')
            .removeClass('is-valid')
            .addClass('is-invalid');
    }
    else if(selisih > 0)
    {
        row.find('.selisih')
            .removeClass('is-invalid')
            .addClass('is-valid');
    }
    else
    {
        row.find('.selisih')
            .removeClass('is-invalid is-valid');
    }
}


$(document).on('input', '.stok-fisik', function(){

    if(parseInt($(this).val()) < 0)
    {
        alert('Stok fisik tidak boleh negatif');

        $(this).val(0);
    }

    let row = $(this).closest('tr');

    hitungSelisih(row);
});


$(document).ready(function(){

    $('#tableStockOpname').DataTable({
        responsive: true,
        autoWidth: false,
        paging: false,
    });

    $('.stok-fisik').each(function(){

        let row = $(this).closest('tr');

        hitungSelisih(row);
    });
});

</script>

@endpush
