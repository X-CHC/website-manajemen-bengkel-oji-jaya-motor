@extends('layout.app')

@section('content')

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

            <h3 class="card-title">
                Data Purchase Order
            </h3>

        </div>

        <div class="card-body">

            <table
                id="tablePo"
                class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>ID PO</th>

                        <th>Tanggal</th>

                        <th>Mitra</th>

                        <th>Status</th>

                        <th>Detail</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($po as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->id_po }}
                        </td>

                        <td>
                            {{ $item->tgl_po }}
                        </td>

                        <td>
                            {{ $item->mitra_po }}
                        </td>

                        <td>

                            @if($item->status_po == 'pending')

                                <span class="badge badge-warning">
                                    Pending
                                </span>

                            @else

                                <span class="badge badge-success">
                                    Selesai
                                </span>

                            @endif

                        </td>

                        <td>

                            <button
                                class="btn btn-info btn-sm btnDetail"
                                data-detail='@json($item->detailPo)'>

                                Detail

                            </button>

                        </td>

                        <td>

                            <a
                                href="{{ route('po.edit', $item->id_po) }}"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form
                                action="{{ route('po.destroy', $item->id_po) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus PO ini?')">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- MODAL DETAIL --}}
<div
    class="modal fade"
    id="modalDetail">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">
                    Detail PO
                </h4>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Barang</th>

                            <th>Qty PO</th>

                        </tr>

                    </thead>

                    <tbody id="detailBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

$(function(){

    $('#tablePo').DataTable();
});


/*
|--------------------------------------------------------------------------
| DETAIL PO
|--------------------------------------------------------------------------
*/
$(document).on(
    'click',
    '.btnDetail',
    function()
{
    let detail =
        $(this).data('detail');

    let html = '';

    detail.forEach(function(item){

        html += `

            <tr>

                <td>
                    ${item.barang.nama_barang}
                </td>

                <td>
                    ${item.jumlah_po}
                </td>

            </tr>
        `;
    });

    $('#detailBody').html(html);

    $('#modalDetail').modal('show');
});

</script>

@endpush
