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

            <div class="col-md-8">

                <div class="card card-warning">

                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Barang
                        </h3>
                    </div>

                    <form action="{{ route('barang.update', $barang->id_barang) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">

                                {{-- KIRI --}}
                                <div class="col-md-6">

                                    {{-- Kategori --}}
                                    <div class="form-group">

                                        <label>Kategori Barang</label>

                                        <select name="id_kategori_barang"
                                                class="form-control @error('id_kategori_barang') is-invalid @enderror">

                                            <option value="">
                                                -- Pilih Kategori --
                                            </option>

                                            @foreach($kategori as $item)

                                                <option value="{{ $item->id_kategori_barang }}"
                                                    {{ old('id_kategori_barang', $barang->id_kategori_barang) == $item->id_kategori_barang ? 'selected' : '' }}>

                                                    {{ $item->nama_kategori }}

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('id_kategori_barang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Nama Barang --}}
                                    <div class="form-group">

                                        <label>Nama Barang</label>

                                        <input type="text"
                                               name="nama_barang"
                                               value="{{ old('nama_barang', $barang->nama_barang) }}"
                                               class="form-control @error('nama_barang') is-invalid @enderror">

                                        @error('nama_barang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Harga Beli --}}
                                    <div class="form-group">

                                        <label>Harga Beli</label>

                                        <input type="text"
                                               name="harga_beli"
                                               id="harga_beli"
                                               value="{{ old('harga_beli', number_format($barang->harga_beli, 0, ',', '.')) }}"
                                               class="form-control @error('harga_beli') is-invalid @enderror">

                                        @error('harga_beli')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- KANAN --}}
                                <div class="col-md-6">

                                    {{-- Harga Jual --}}
                                    <div class="form-group">

                                        <label>Harga Jual</label>

                                        <input type="text"
                                               name="harga_jual"
                                               id="harga_jual"
                                               value="{{ old('harga_jual', number_format($barang->harga_jual, 0, ',', '.')) }}"
                                               class="form-control @error('harga_jual') is-invalid @enderror">

                                        @error('harga_jual')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Stok Saat Ini --}}
                                    <div class="form-group">

                                        <label>Stok Saat Ini</label>

                                        <input type="number"
                                               value="{{ $barang->jumlah_barang }}"
                                               class="form-control"
                                               readonly>

                                        <small class="text-muted">
                                            Stok tidak bisa diedit di sini. Gunakan fitur Stock Opname.
                                        </small>

                                    </div>


                                    {{-- Alert Stok --}}
                                    <div class="form-group">

                                        <label>Alert Jumlah Barang</label>

                                        <input type="number"
                                               name="alert_jumlah_barang"
                                               value="{{ old('alert_jumlah_barang', $barang->alert_jumlah_barang) }}"
                                               class="form-control @error('alert_jumlah_barang') is-invalid @enderror">

                                        @error('alert_jumlah_barang')
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

                            <a href="{{ route('barang.index') }}"
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

function formatRupiah(angka)
{
    return angka
        .replace(/\D/g, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

const hargaBeli = document.getElementById('harga_beli');

if(hargaBeli)
{
    hargaBeli.addEventListener('keyup', function(){

        this.value = formatRupiah(this.value);
    });
}

const hargaJual = document.getElementById('harga_jual');

if(hargaJual)
{
    hargaJual.addEventListener('keyup', function(){

        this.value = formatRupiah(this.value);
    });
}

</script>

@endpush
