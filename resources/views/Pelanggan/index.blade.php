@extends('layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button type="button"
                        class="close"
                        data-dismiss="alert">

                    <span>&times;</span>

                </button>

            </div>

        @endif


        <div class="row">

            <div class="col-12">

                <div class="card">

                    {{-- HEADER --}}
                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center w-100">

                            <h3 class="card-title">
                                Data Pelanggan
                            </h3>

                            <a href="{{ route('pelanggan.create') }}"
                               class="btn btn-primary btn-sm">

                                <i class="fas fa-plus"></i>

                                Tambah Pelanggan

                            </a>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body">

                        <table id="tablePelanggan"
                               class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th width="5%">
                                        No
                                    </th>

                                    <th>
                                        ID Pelanggan
                                    </th>

                                    <th>
                                        Nama Pelanggan
                                    </th>

                                    <th>
                                        Plat Nomor
                                    </th>

                                    <th>
                                        Merek Motor
                                    </th>

                                    <th>
                                        Warna Motor
                                    </th>

                                    <th>
                                        Dibuat
                                    </th>

                                    <th width="15%">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($pelanggan as $item)

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->id_pelanggan }}
                                        </td>

                                        <td>
                                            {{ $item->nama_pelanggan }}
                                        </td>

                                        <td>
                                            {{ $item->plat_nomor }}
                                        </td>

                                        <td>
                                            {{ $item->merek_motor }}
                                        </td>

                                        <td>
                                            {{ $item->warna_motor }}
                                        </td>

                                        <td>
                                            {{ $item->created_at->format('d-m-Y H:i') }}
                                        </td>

                                        <td>

                                            <div class="d-flex">

                                                {{-- EDIT --}}
                                                <a href="{{ route('pelanggan.index', $item->id_pelanggan) }}"
                                                   class="btn btn-warning btn-sm mr-1">

                                                    <i class="fas fa-edit"></i>

                                                </a>

                                                {{-- HAPUS --}}
                                                <form action="{{ route('pelanggan.index', $item->id_pelanggan) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus pelanggan?')">

                                                        <i class="fas fa-trash"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="8"
                                            class="text-center">

                                            Data pelanggan belum ada

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

    $('#tablePelanggan').DataTable({
        responsive: true,
        autoWidth: false,
    });

});

</script>

@endpush
