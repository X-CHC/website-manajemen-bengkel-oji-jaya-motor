@extends('Layout.app')

@section('content')

@php
    $canCreatePO = punyaAksesMenu('po.create', auth()->user());
    $canEditPO = punyaAksesMenu('po.edit', auth()->user());
    $canDeletePO = punyaAksesMenu('po.destroy', auth()->user());
@endphp

<div class="container-fluid">



    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                Data Purchase Order
            </h3>

            @if($canCreatePO)
                <a href="{{ route('po.create') }}"
                   class="btn btn-primary btn-sm ml-auto">

                    <i class="fas fa-plus"></i>
                    Tambah PO

                </a>
            @endif

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

                        @if($canEditPO || $canDeletePO)
                            <th>Aksi</th>
                        @endif

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

                        @if($canEditPO || $canDeletePO)
                            <td>
                                @if($item->status_po == 'pending')

                                    @if($canEditPO)
                                        <a href="{{ route('po.edit', $item->id_po) }}"
                                        class="btn btn-warning btn-sm">

                                            <i class="fas fa-edit"></i>
                                            Edit

                                        </a>
                                    @endif

                                    @if($canDeletePO)
                                        <form action="{{ route('po.destroy', $item->id_po) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Hapus PO ini?')">

                                                <i class="fas fa-trash"></i>
                                                Hapus

                                            </button>

                                        </form>
                                    @endif

                                @else

                                    <span class="badge badge-secondary">
                                        Terkunci
                                    </span>

                                @endif

                            </td>
                        @endif

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


/* DETAIL PO*/
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
