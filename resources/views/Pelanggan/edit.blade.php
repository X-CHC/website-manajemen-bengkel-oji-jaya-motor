@extends('Layout.app')

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

            <div class="col-md-8">

                <div class="card card-warning">

                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Pelanggan
                        </h3>
                    </div>

                    <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">

                                {{-- KIRI --}}
                                <div class="col-md-6">

                                    {{-- Nama Pelanggan --}}
                                    <div class="form-group">

                                        <label>Nama Pelanggan</label>

                                        <input type="text"
                                               name="nama_pelanggan"
                                               value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}"
                                               class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                               placeholder="Masukkan nama pelanggan">

                                        @error('nama_pelanggan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Plat Nomor --}}
                                    <div class="form-group">

                                        <label>Plat Nomor</label>

                                        <input type="text"
                                               name="plat_nomor"
                                               value="{{ old('plat_nomor', $pelanggan->plat_nomor) }}"
                                               class="form-control @error('plat_nomor') is-invalid @enderror"
                                               placeholder="Contoh: B 1234 XYZ">

                                        @error('plat_nomor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- KANAN --}}
                                <div class="col-md-6">

                                    {{-- Merek Motor --}}
                                    <div class="form-group">

                                        <label>Merek Motor</label>

                                        <input type="text"
                                               name="merek_motor"
                                               value="{{ old('merek_motor', $pelanggan->merek_motor) }}"
                                               class="form-control @error('merek_motor') is-invalid @enderror"
                                               placeholder="Contoh: Honda Vario">

                                        @error('merek_motor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Warna Motor --}}
                                    <div class="form-group">

                                        <label>Warna Motor</label>

                                        <input type="text"
                                               name="warna_motor"
                                               value="{{ old('warna_motor', $pelanggan->warna_motor) }}"
                                               class="form-control @error('warna_motor') is-invalid @enderror"
                                               placeholder="Contoh: Hitam">

                                        @error('warna_motor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit"
                                    class="btn btn-warning">

                                Update

                            </button>

                            <a href="{{ route('pelanggan.index') }}"
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
