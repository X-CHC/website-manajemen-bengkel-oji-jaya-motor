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

            <div class="col-md-12">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Tambah Role
                        </h3>
                    </div>

                    <form action="{{ route('role.store') }}"
                          method="POST">

                        @csrf

                        <div class="card-body">

                            <div class="form-group">

                                <label>Nama Role</label>

                                <input type="text"
                                       name="nama_role"
                                       value="{{ old('nama_role') }}"
                                       class="form-control @error('nama_role') is-invalid @enderror"
                                       placeholder="Contoh: supervisor">

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
                                       value="{{ old('tingkat_role') }}"
                                       class="form-control @error('tingkat_role') is-invalid @enderror"
                                       placeholder="Contoh: 5">

                                @error('tingkat_role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <hr>


                            <div class="form-group">

                                <label class="mb-3">
                                    Akses Menu
                                </label>

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
                                                                               class="custom-control-input check-child child-{{ $groupName }}"
                                                                               id="menu_{{ $item->id_menu }}"
                                                                               {{ in_array($item->id_menu, old('id_menu', [])) ? 'checked' : '' }}>

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


@push('scripts')

<script>
$(function () {

    /*
    |--------------------------------------------------------------------------
    | UPDATE STYLE ITEM YANG DICENTANG
    |--------------------------------------------------------------------------
    */
    function updateItemChecked()
    {
        $('.check-child').each(function () {

            let item = $(this).closest('.akses-menu-item');

            if ($(this).prop('checked')) {

                item.removeClass('border')
                    .addClass('border border-primary bg-light');

            } else {

                item.removeClass('border-primary bg-light')
                    .addClass('border');

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK PARENT
    |--------------------------------------------------------------------------
    | Jika checkbox modul dicentang, semua akses di bawahnya ikut dicentang.
    |--------------------------------------------------------------------------
    */
    $('.check-parent').on('change', function () {

        let group = $(this).data('group');

        $('.child-' + group).prop(
            'checked',
            $(this).prop('checked')
        );

        updateItemChecked();

    });


    /*
    |--------------------------------------------------------------------------
    | CHECK CHILD
    |--------------------------------------------------------------------------
    | Child bisa dicentang satu-satu tanpa harus mencentang parent.
    |--------------------------------------------------------------------------
    */
    $('.check-child').on('change', function () {

        updateItemChecked();

    });


    /*
    |--------------------------------------------------------------------------
    | LOAD AWAL
    |--------------------------------------------------------------------------
    */
    updateItemChecked();

});
</script>

@endpush
