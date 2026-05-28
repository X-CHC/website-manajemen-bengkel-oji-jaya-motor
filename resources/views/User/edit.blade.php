@extends('layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ERROR SESSION --}}
        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        <div class="row">

            <div class="col-md-12">

                <div class="card card-warning">

                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Akun
                        </h3>
                    </div>

                    <form action="{{ route('user.update', $user->id_user) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">

                                {{-- ID USER --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>ID User</label>

                                        <input type="text"
                                               class="form-control"
                                               value="{{ $user->id_user }}"
                                               readonly>

                                    </div>

                                </div>


                                {{-- ROLE --}}
                                <div class="col-md-6">

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
                                                    {{ old('id_role', $user->id_role) == $item->id_role ? 'selected' : '' }}>

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
                                            Checklist akan mengikuti default role, lalu bisa kamu ubah khusus untuk user ini.
                                        </small>

                                    </div>

                                </div>


                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Email</label>

                                        <input type="email"
                                               name="email"
                                               value="{{ old('email', $user->email) }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Masukkan email">

                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- PASSWORD --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Password Baru</label>

                                        <input type="password"
                                               name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Kosongkan jika tidak ingin mengganti password">

                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- KONFIRMASI PASSWORD --}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Konfirmasi Password Baru</label>

                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control"
                                               placeholder="Ulangi password baru">

                                    </div>

                                </div>

                            </div>


                            <hr>


                            <div class="form-group">

                                <label class="mb-3">
                                    Akses Menu User
                                </label>

                                <div class="alert alert-info">
                                    Akses default berasal dari role. Jika checkbox diubah dari default role,
                                    perubahan khusus akan disimpan ke <b>tbl_user_menu</b>.
                                </div>

                                <div class="row">

                                    @foreach($menu as $groupName => $items)

                                        <div class="col-md-6 mb-4">

                                            <div class="card card-outline card-secondary">

                                                <div class="card-header">

                                                    <div class="custom-control custom-checkbox">

                                                        <input type="checkbox"
                                                               class="custom-control-input check-parent"
                                                               id="parent_{{ $groupName }}"
                                                               data-group="{{ $groupName }}">

                                                        <label class="custom-control-label font-weight-bold"
                                                               for="parent_{{ $groupName }}">

                                                            {{ ucwords(str_replace('-', ' ', $groupName)) }}

                                                        </label>

                                                    </div>

                                                </div>

                                                <div class="card-body">

                                                    <div class="row">

                                                        @foreach($items as $item)

                                                            <div class="col-md-6 mb-3">

                                                                <div class="border rounded p-3 h-100 shadow-sm akses-menu-item">

                                                                    <div class="custom-control custom-checkbox">

                                                                        <input type="checkbox"
                                                                               name="id_menu[]"
                                                                               value="{{ $item->id_menu }}"
                                                                               class="custom-control-input check-child check-menu-user child-{{ $groupName }}"
                                                                               id="menu_{{ $item->id_menu }}"
                                                                               data-id-menu="{{ $item->id_menu }}">

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

                                                                    <small class="status-akses text-muted d-block mt-2">
                                                                    </small>

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
                                    class="btn btn-warning">

                                Update

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

    let userMenuMap = @json($userMenuMap);

    /*
    |--------------------------------------------------------------------------
    | SET CHECKBOX BERDASARKAN ROLE + USER OVERRIDE
    |--------------------------------------------------------------------------
    */
    function setAksesAwal()
    {
        let idRole = $('#id_role').val();

        let aksesDefault = roleMenuMap[idRole] || [];

        $('.check-menu-user').each(function () {

            let idMenu = $(this).data('id-menu');

            let item = $(this).closest('.akses-menu-item');

            let statusText = item.find('.status-akses');

            let defaultPunyaAkses = aksesDefault.includes(idMenu);

            /*
            |--------------------------------------------------------------------------
            | USER PUNYA OVERRIDE
            |--------------------------------------------------------------------------
            */
            if (userMenuMap.hasOwnProperty(idMenu)) {

                let canAccess = parseInt(userMenuMap[idMenu]) === 1;

                $(this).prop('checked', canAccess);

                if (canAccess) {

                    item.removeClass('border-danger border-secondary')
                        .addClass('border border-warning bg-light');

                    statusText
                        .removeClass('text-danger text-muted')
                        .addClass('text-warning')
                        .text('Akses tambahan khusus user');

                } else {

                    item.removeClass('border-warning border-secondary')
                        .addClass('border border-danger');

                    statusText
                        .removeClass('text-warning text-muted')
                        .addClass('text-danger')
                        .text('Akses default role dimatikan khusus user');

                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | TIDAK ADA OVERRIDE, IKUT DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            $(this).prop('checked', defaultPunyaAkses);

            if (defaultPunyaAkses) {

                item.removeClass('border-warning border-danger')
                    .addClass('border border-primary bg-light');

                statusText
                    .removeClass('text-warning text-danger')
                    .addClass('text-muted')
                    .text('Akses default role');

            } else {

                item.removeClass('border-primary border-warning border-danger bg-light')
                    .addClass('border');

                statusText
                    .removeClass('text-warning text-danger')
                    .addClass('text-muted')
                    .text('');

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STYLE SETELAH CHECKBOX DIUBAH MANUAL
    |--------------------------------------------------------------------------
    */
    function updateStyleManual()
    {
        let idRole = $('#id_role').val();

        let aksesDefault = roleMenuMap[idRole] || [];

        $('.check-menu-user').each(function () {

            let idMenu = $(this).data('id-menu');

            let item = $(this).closest('.akses-menu-item');

            let statusText = item.find('.status-akses');

            let defaultPunyaAkses = aksesDefault.includes(idMenu);

            let userPilihAkses = $(this).prop('checked');

            /*
            |--------------------------------------------------------------------------
            | SAMA DENGAN DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            if (defaultPunyaAkses === userPilihAkses) {

                if (defaultPunyaAkses) {

                    item.removeClass('border-warning border-danger')
                        .addClass('border border-primary bg-light');

                    statusText
                        .removeClass('text-warning text-danger')
                        .addClass('text-muted')
                        .text('Akses default role');

                } else {

                    item.removeClass('border-primary border-warning border-danger bg-light')
                        .addClass('border');

                    statusText
                        .removeClass('text-warning text-danger')
                        .addClass('text-muted')
                        .text('');

                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | BERBEDA DARI DEFAULT ROLE
            |--------------------------------------------------------------------------
            */
            if (userPilihAkses) {

                item.removeClass('border-primary border-danger')
                    .addClass('border border-warning bg-light');

                statusText
                    .removeClass('text-danger text-muted')
                    .addClass('text-warning')
                    .text('Akses tambahan khusus user');

            } else {

                item.removeClass('border-primary border-warning bg-light')
                    .addClass('border border-danger');

                statusText
                    .removeClass('text-warning text-muted')
                    .addClass('text-danger')
                    .text('Akses default role dimatikan khusus user');

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK PARENT
    |--------------------------------------------------------------------------
    */
    $('.check-parent').on('change', function () {

        let group = $(this).data('group');

        $('.child-' + group).prop(
            'checked',
            $(this).prop('checked')
        );

        updateStyleManual();

    });


    /*
    |--------------------------------------------------------------------------
    | CHECK CHILD
    |--------------------------------------------------------------------------
    */
    $('.check-child').on('change', function () {

        updateStyleManual();

    });


    /*
    |--------------------------------------------------------------------------
    | ROLE DIGANTI
    |--------------------------------------------------------------------------
    | Jika role diganti, akses mengikuti default role baru.
    | Override lama direset di tampilan.
    |--------------------------------------------------------------------------
    */
    $('#id_role').on('change', function () {

        userMenuMap = {};

        setAksesAwal();

    });


    /*
    |--------------------------------------------------------------------------
    | LOAD AWAL
    |--------------------------------------------------------------------------
    */
    setAksesAwal();

});
</script>

@endpush
