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

                            {{-- ID USER --}}
                            <div class="form-group">

                                <label>ID User</label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $user->id_user }}"
                                       readonly>

                            </div>


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
                                            {{ old('id_role', $user->id_role) == $item->id_role ? 'selected' : '' }}>

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
                                       value="{{ old('email', $user->email) }}"
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


                            {{-- KONFIRMASI PASSWORD --}}
                            <div class="form-group">

                                <label>Konfirmasi Password Baru</label>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Ulangi password baru">

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
