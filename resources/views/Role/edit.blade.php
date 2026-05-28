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

        <div class="row">

            <div class="col-md-8">

                <div class="card card-warning">

                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Role
                        </h3>
                    </div>

                    <form action="{{ route('role.update', $role->id_role) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">

                                <label>ID Role</label>

                                <input type="text"
                                       value="{{ $role->id_role }}"
                                       class="form-control"
                                       readonly>

                            </div>


                            <div class="form-group">

                                <label>Nama Role</label>

                                <input type="text"
                                       name="nama_role"
                                       value="{{ old('nama_role', $role->nama_role) }}"
                                       class="form-control @error('nama_role') is-invalid @enderror"
                                       placeholder="Masukkan nama role">

                                @error('nama_role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="form-group">

                                <label>Tingkat Role</label>

                                <input type="number"
                                       name="tingkat_role"
                                       value="{{ old('tingkat_role', $role->tingkat_role) }}"
                                       class="form-control @error('tingkat_role') is-invalid @enderror"
                                       placeholder="Masukkan tingkat role">

                                @error('tingkat_role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <hr>


                            <div class="form-group">

                                <label>Akses Menu</label>

                                <div class="row">

                                    @foreach($menu as $item)

                                        <div class="col-md-6">

                                            <div class="custom-control custom-checkbox mb-2">

                                                <input type="checkbox"
                                                       name="id_menu[]"
                                                       value="{{ $item->id_menu }}"
                                                       class="custom-control-input"
                                                       id="menu_{{ $item->id_menu }}"
                                                       {{ in_array($item->id_menu, old('id_menu', $aksesRole)) ? 'checked' : '' }}>

                                                <label class="custom-control-label"
                                                       for="menu_{{ $item->id_menu }}">

                                                    {{ $item->nama_menu }}

                                                    <small class="text-muted">
                                                        ({{ $item->route_name }})
                                                    </small>

                                                </label>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit"
                                    class="btn btn-warning">

                                Update

                            </button>

                            <a href="{{ route('role.index') }}"
                               class="btn btn-secondary">

                                Kembali

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
