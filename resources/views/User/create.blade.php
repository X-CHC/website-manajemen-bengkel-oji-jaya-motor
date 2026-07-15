@extends('Layout.app')

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


        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Tambah Akun
                        </h3>
                    </div>

                    <form action="{{ route('user.store') }}"
                          method="POST">

                        @csrf

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6">

                                    {{-- ROLE --}}
                                    <div class="form-group">

                                        <label>Role</label>

                                        <select name="id_role"
                                                id="id_role"
                                                class="form-control @error('id_role') is-invalid @enderror">

                                            <option value="">
                                                -- Pilih Role --
                                            </option>

                                            @foreach($role as $item)

                                                <option value="{{ $item->id_role }}"
                                                    {{ old('id_role') == $item->id_role ? 'selected' : '' }}>

                                                    {{ ucfirst($item->nama_role) }}

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('id_role')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <small class="text-muted">
                                            Akses akun baru akan otomatis mengikuti akses default role.
                                        </small>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    {{-- EMAIL --}}
                                    <div class="form-group">

                                        <label>Email</label>

                                        <input type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Masukkan email">

                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    {{-- PASSWORD --}}
                                    <div class="form-group">

                                        <label>Password</label>

                                        <input type="password"
                                               name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Masukkan password">

                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    {{-- KONFIRMASI PASSWORD --}}
                                    <div class="form-group">

                                        <label>Konfirmasi Password</label>

                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control"
                                               placeholder="Ulangi password">

                                    </div>

                                </div>

                            </div>


                            <hr>


                            <div class="form-group">

                                <label class="mb-3">
                                    Preview Akses Default Role
                                </label>

                                <div class="alert alert-info">
                                    Pilih role terlebih dahulu untuk melihat akses default role.
                                </div>

                                <div class="row">

                                    @foreach($menu as $groupName => $items)

                                        <div class="col-md-6 mb-4">

                                            <div class="card card-outline card-secondary">

                                                <div class="card-header">

                                                    <strong>
                                                        {{ ucwords(str_replace('-', ' ', $groupName)) }}
                                                    </strong>

                                                </div>

                                                <div class="card-body">

                                                    <div class="row">

                                                        @foreach($items as $item)

                                                            <div class="col-md-6 mb-3">

                                                                <div class="border rounded p-3 h-100 shadow-sm akses-menu-item">

                                                                    <div class="custom-control custom-checkbox">

                                                                        <input type="checkbox"
                                                                               value="{{ $item->id_menu }}"
                                                                               class="custom-control-input check-menu-default"
                                                                               id="menu_{{ $item->id_menu }}"
                                                                               disabled>

                                                                        <label class="custom-control-label"
                                                                               for="menu_{{ $item->id_menu }}">

                                                                            <span class="font-weight-bold">
                                                                                {{ $item->nama_menu }}
                                                                            </span>

                                                                            <br>

                                                                            <small class="text-muted">
                                                                                ({{ $item->route_name }})
                                                                            </small>

                                                                        </label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit"
                                    class="btn btn-primary">

                                Simpan

                            </button>

                            <a href="{{ route('user.index') }}"
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


@push('scripts')

<script>
$(function () {

    let roleMenuMap = @json($roleMenuMap);

    function updateAksesDefault()
    {
        let idRole = $('#id_role').val();

        let aksesDefault = roleMenuMap[idRole] || [];

        $('.check-menu-default').each(function () {

            let idMenu = $(this).val();

            let item = $(this).closest('.akses-menu-item');

            if (aksesDefault.includes(idMenu)) {

                $(this).prop('checked', true);

                item.removeClass('border')
                    .addClass('border border-primary bg-light');

            } else {

                $(this).prop('checked', false);

                item.removeClass('border-primary bg-light')
                    .addClass('border');

            }

        });
    }

    $('#id_role').on('change', function () {
        updateAksesDefault();
    });

    updateAksesDefault();

});
</script>

@endpush
