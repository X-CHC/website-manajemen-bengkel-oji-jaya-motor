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

            <div class="col-md-6">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Form Tambah Akun
                        </h3>
                    </div>

                    <form action="{{ route('user.store') }}"
                          method="POST">

                        @csrf

                        <div class="card-body">

                            {{-- ROLE --}}
                            <div class="form-group">

                                <label>Role</label>

                                <select name="id_role"
                                        class="form-control @error('id_role') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Role --
                                    </option>

                                    @foreach($role as $item)

                                        <option value="{{ $item->id_role }}"
                                            {{ old('id_role') == $item->id_role ? 'selected' : '' }}>

                                            {{ $item->nama_role }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('id_role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


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


                            {{-- KONFIRMASI PASSWORD --}}
                            <div class="form-group">

                                <label>Konfirmasi Password</label>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi password">

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
