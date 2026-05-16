@extends('layout.app')

@section('content')

<section class="content">
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

            <div class="card-header d-flex align-items-center">

                <h3 class="card-title">
                    Data Akun
                </h3>

                <a href="{{ route('user.create') }}"
                   class="btn btn-primary btn-sm ml-auto">

                    <i class="fas fa-plus"></i>
                    Tambah Akun

                </a>

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
                            <th>Aksi</th>
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

                                <td>
                                    <div class="d-flex">

                                        {{-- EDIT --}}
                                        <a href="{{ route('user.edit', $item->id_user) }}"
                                        class="btn btn-warning btn-sm mr-1">

                                            <i class="fas fa-edit"></i>

                                        </a>

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

                                    </div>
                                </td>
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
