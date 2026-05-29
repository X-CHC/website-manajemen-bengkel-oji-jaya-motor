@extends('layout.app')

@section('content')

@php
    $canCreateUser = punyaAksesMenu('user.create', auth()->user());
    $canEditUser = punyaAksesMenu('user.edit', auth()->user());
    $canDeleteUser = punyaAksesMenu('user.destroy', auth()->user());
@endphp

<section class="content">
    <div class="container-fluid">


        <div class="card">

            <div class="card-header d-flex align-items-center">

                <h3 class="card-title">
                    Data Akun
                </h3>

                @if($canCreateUser)
                    <a href="{{ route('user.create') }}"
                       class="btn btn-primary btn-sm ml-auto">

                        <i class="fas fa-plus"></i>
                        Tambah Akun

                    </a>
                @endif

            </div>

            <div class="card-body">

                <table id="tableUser"
                       class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            @if($canEditUser || $canDeleteUser)
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($user as $item)

                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item->id_user }}
                                </td>

                                <td>
                                    {{ $item->email }}
                                </td>

                                <td>
                                    {{ $item->role->nama_role ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->created_at->format('d-m-Y H:i') }}
                                </td>

                                @if($canEditUser || $canDeleteUser)
                                    <td>
                                        <div class="d-flex">

                                            @if($canEditUser)
                                                {{-- EDIT --}}
                                                <a href="{{ route('user.edit', $item->id_user) }}"
                                                class="btn btn-warning btn-sm mr-1">

                                                    <i class="fas fa-edit"></i>

                                                </a>
                                            @endif

                                            @if($canDeleteUser)
                                                {{-- HAPUS --}}
                                                <form action="{{ route('user.destroy', $item->id_user) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus akun ini?')"
                                                            {{ auth()->user()->id_user == $item->id_user ? 'disabled' : '' }}>

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

    $('#tableUser').DataTable({
        responsive: true,
        autoWidth: false,
    });

});

</script>

@endpush
