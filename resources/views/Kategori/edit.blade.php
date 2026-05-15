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
                            Edit Kategori Barang
                        </h3>
                    </div>

                    <form action="{{ route('kategori.update', $kategori->id_kategori_barang) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">

                                <label>ID Kategori</label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $kategori->id_kategori_barang }}"
                                       readonly>

                            </div>


                            <div class="form-group">

                                <label>Nama Kategori</label>

                                <input type="text"
                                       name="nama_kategori"
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                       class="form-control @error('nama_kategori') is-invalid @enderror"
                                       placeholder="Masukkan nama kategori">

                                @error('nama_kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <div class="card-footer">

                            <button type="submit"
                                    class="btn btn-warning">

                                Update

                            </button>

                            <a href="{{ route('kategori.index') }}"
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
