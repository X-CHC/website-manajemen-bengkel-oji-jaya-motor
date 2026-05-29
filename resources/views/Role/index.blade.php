@extends('layout.app')

@section('content')

@php
    $canCreateRole = punyaAksesMenu('role.create', auth()->user());
    $canEditRole = punyaAksesMenu('role.edit', auth()->user());
    $canDeleteRole = punyaAksesMenu('role.destroy', auth()->user());
@endphp

<section class="content">
    <div class="container-fluid">

        <div class="card">

            <div class="card-header d-flex align-items-center">

                <h3 class="card-title">
                    Data Role
                </h3>

                @if($canCreateRole)
                    <a href="{{ route('role.create') }}"
                       class="btn btn-primary btn-sm ml-auto">

                        <i class="fas fa-plus"></i>
                        Tambah Role

                    </a>
                @endif

            </div>

            <div class="card-body">

                <table id="tableRole"
                       class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Role</th>
                            <th>Nama Role</th>
                            <th>Tingkat Role</th>
                            <th>Tanggal Dibuat</th>
                            @if($canEditRole || $canDeleteRole)
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($role as $item)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $item->id_role }}</td>

                                <td>{{ ucfirst($item->nama_role) }}</td>

                                <td>{{ $item->tingkat_role }}</td>

                                <td>
                                    {{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : '-' }}
                                </td>

                                @if($canEditRole || $canDeleteRole)
                                    <td>
                                        <div class="d-flex">

                                            @if($canEditRole)
                                                <a href="{{ route('role.edit', $item->id_role) }}"
                                                   class="btn btn-warning btn-sm mr-1">

                                                    <i class="fas fa-edit"></i>

                                                </a>
                                            @endif

                                            @if($canDeleteRole)
                                                <form action="{{ route('role.destroy', $item->id_role) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus role ini?')">

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
    $('#tableRole').DataTable({
        responsive: true,
        autoWidth: false,
    });
});
</script>

@endpush
