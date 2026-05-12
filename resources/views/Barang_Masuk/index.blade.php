@extends('layout.app')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Data Barang Masuk
            </h3>

        </div>

        <div class="card-body">

            <table
                id="tableBarangMasuk"
                class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>ID</th>

                        <th>Tanggal</th>

                        <th>PO</th>

                        <th>Total</th>

                        <th>Detail</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($barangMasuk as $index => $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->id_barang_masuk }}
                        </td>

                        <td>
                            {{ $item->tanggal_masuk }}
                        </td>

                        <td>
                            {{ $item->id_po }}
                        </td>

                        <td>
                            Rp
                            {{ number_format($item->total_bayar,0,',','.') }}
                        </td>

                        <td>

                            <button
                                class="btn btn-info btn-sm btnDetail"
                                data-detail='@json($item->detailMasuk)'>

                                Detail

                            </button>

                        </td>

                        <td>

                            <a
                                href="{{ route('barang-masuk.edit', $item->id_barang_masuk) }}"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form
                                action="{{ route('barang-masuk.destroy', $item->id_barang_masuk) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus data ini?')">

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
                    Detail Barang Masuk
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

                            <th>Qty</th>

                            <th>Harga</th>

                            <th>Subtotal</th>

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

    $('#tableBarangMasuk').DataTable();
});


/*
|--------------------------------------------------------------------------
| DETAIL
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
                    ${item.jumlah_barang}
                </td>

                <td>
                    Rp ${new Intl.NumberFormat('id-ID')
                        .format(item.harga_beli)}
                </td>

                <td>
                    Rp ${new Intl.NumberFormat('id-ID')
                        .format(item.sub_total)}
                </td>

            </tr>
        `;
    });

    $('#detailBody').html(html);

    $('#modalDetail').modal('show');
});

</script>

@endpush
