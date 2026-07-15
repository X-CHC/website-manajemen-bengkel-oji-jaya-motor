@extends('Layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Barang</h3>
                    </div>

                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf

                        <div class="card-body">

                            {{-- Error Global --}}
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="row">

                                {{-- KOLOM KIRI --}}
                                <div class="col-md-6">

                                    {{-- Kategori --}}
                                    <div class="form-group">
                                        <label>Kategori Barang</label>

                                        <select name="id_kategori_barang"
                                                class="form-control @error('id_kategori_barang') is-invalid @enderror">

                                            <option value="">-- Pilih Kategori --</option>

                                            @foreach($kategori as $item)
                                                <option value="{{ $item->id_kategori_barang }}"
                                                    {{ old('id_kategori_barang') == $item->id_kategori_barang ? 'selected' : '' }}>
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
                                               value="{{ old('nama_barang') }}"
                                               class="form-control @error('nama_barang') is-invalid @enderror"
                                               placeholder="Masukkan nama barang">

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
                                            id="harga_beli"
                                            name="harga_beli"
                                            value="{{ old('harga_beli') }}"
                                            class="form-control @error('harga_beli') is-invalid @enderror"
                                            placeholder="Masukkan harga beli">

                                        @error('harga_beli')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- KOLOM KANAN --}}
                                <div class="col-md-6">

                                    {{-- Harga Jual --}}
                                    <div class="form-group">
                                        <label>Harga Jual</label>

                                        <input type="text"
                                            id="harga_jual"
                                            name="harga_jual"
                                            value="{{ old('harga_jual') }}"
                                            class="form-control @error('harga_jual') is-invalid @enderror"
                                            placeholder="Masukkan harga jual">

                                        @error('harga_jual')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Jumlah Barang --}}
                                    <div class="form-group">
                                        <label>Jumlah Barang</label>

                                        <input type="number"
                                               name="jumlah_barang"
                                               value="{{ old('jumlah_barang') }}"
                                               class="form-control @error('jumlah_barang') is-invalid @enderror"
                                               placeholder="Masukkan jumlah barang">

                                        @error('jumlah_barang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Alert Stok --}}
                                    <div class="form-group">
                                        <label>Alert Jumlah Barang</label>

                                        <input type="number"
                                               name="alert_jumlah_barang"
                                               value="{{ old('alert_jumlah_barang') }}"
                                               class="form-control @error('alert_jumlah_barang') is-invalid @enderror"
                                               placeholder="Masukkan batas alert stok">

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
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>
@push('scripts')
<script src="{{ asset('assets/js/barang.js') }}"></script>
@endpush
@endsection
