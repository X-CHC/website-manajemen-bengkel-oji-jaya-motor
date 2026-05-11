@extends('layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

        {{-- ALERT ERROR --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ALERT ERROR SESSION --}}
        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif


        {{-- ALERT SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <form action="{{ route('transaksi.store') }}"
              method="POST">

            @csrf

            <div class="row">

                {{-- KIRI --}}
                <div class="col-md-8">

                    {{-- CARD TRANSAKSI --}}
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                Form Transaksi
                            </h3>
                        </div>

                        <div class="card-body">

                            {{-- PELANGGAN --}}
                            <div class="form-group">
                                <label>Pilih Pelanggan Member</label>

                                <select name="id_pelanggan"
                                        class="form-control">

                                    <option value="">
                                        -- Pelanggan Umum --
                                    </option>

                                    @foreach($pelanggan as $item)

                                        <option value="{{ $item->id_pelanggan }}">

                                            {{ $item->nama_pelanggan }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>


                            {{-- PELANGGAN LAIN --}}
                            <div class="form-group">
                                <label>Nama Pelanggan Lain</label>

                                <input type="text"
                                       name="nama_pelanggan_lain"
                                       class="form-control"
                                       placeholder="Isi jika bukan member">
                            </div>

                        </div>

                    </div>


                    {{-- CARD DETAIL BARANG --}}
                    <div class="card card-info">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h3 class="card-title">

                                Detail Barang

                                <span class="badge badge-light ml-1"
                                      id="jumlahItemBarang">

                                    1

                                </span>

                            </h3>

                            <button type="button"
                                    class="btn btn-sm btn-primary"
                                    id="tambahBarang">

                                <i class="fas fa-plus"></i>
                                Tambah Barang

                            </button>

                        </div>

                        <div class="card-body">

                            <div id="listBarang">

                                {{-- ITEM BARANG --}}
                                <div class="barang-item border rounded p-3 mb-3">

                                    <div class="row">

                                        {{-- BARANG --}}
                                        <div class="col-md-5">

                                            <div class="form-group">
                                                <label>Pilih Barang</label>

                                                <select name="id_barang[]"
                                                    class="form-control barang-select select2">

                                                    <option value="">
                                                        -- Pilih Barang --
                                                    </option>

                                                    @foreach($barang as $item)

                                                        <option
                                                            value="{{ $item->id_barang }}"
                                                            data-harga="{{ $item->harga_jual }}"
                                                            data-stok="{{ $item->jumlah_barang }}">

                                                            {{ $item->nama_barang }}
                                                            -
                                                            Stok:
                                                            {{ $item->jumlah_barang }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>


                                        {{-- JUMLAH --}}
                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label>Jumlah</label>

                                                <input type="number"
                                                       name="jumlah_barang[]"
                                                       class="form-control jumlah-barang"
                                                       min="1"
                                                       value="1">
                                            </div>

                                        </div>


                                        {{-- HARGA --}}
                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label>Harga</label>

                                                <input type="text"
                                                       class="form-control harga-view"
                                                       readonly>

                                                <input type="hidden"
                                                       name="harga_barang[]"
                                                       class="harga-input">
                                            </div>

                                        </div>


                                        {{-- SUBTOTAL --}}
                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label>Subtotal</label>

                                                <input type="text"
                                                       class="form-control subtotal-view"
                                                       readonly>

                                                <input type="hidden"
                                                       name="sub_total[]"
                                                       class="subtotal-input">
                                            </div>

                                        </div>


                                        {{-- HAPUS --}}
                                        <div class="col-md-1 d-flex align-items-center">

                                            <button type="button"
                                                    class="btn btn-danger btn-sm hapusBarang mt-3">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- KANAN --}}
                <div class="col-md-4">

                    <div class="card card-success sticky-top">

                        <div class="card-header">
                            <h3 class="card-title">
                                Pembayaran
                            </h3>
                        </div>

                        <div class="card-body">

                            {{-- HARGA JASA --}}
                            <div class="form-group">

                                <label>Harga Jasa</label>

                                <input type="text"
                                       id="harga_jasa_view"
                                       class="form-control"
                                       value="0">

                                <input type="hidden"
                                       name="harga_jasa"
                                       id="harga_jasa"
                                       value="0">

                            </div>


                            {{-- TOTAL --}}
                            <div class="form-group">

                                <label>Total Harga</label>

                                <input type="text"
                                       id="total_harga_view"
                                       class="form-control"
                                       readonly>

                                <input type="hidden"
                                       name="total_harga"
                                       id="total_harga">

                            </div>


                            {{-- BAYAR --}}
                            <div class="form-group">

                                <label>Uang Bayar</label>

                                <input type="text"
                                       id="uang_bayar_view"
                                       class="form-control"
                                       value="0">

                                <input type="hidden"
                                       name="uang_bayar"
                                       id="uang_bayar"
                                       value="0">

                            </div>


                            {{-- KEMBALI --}}
                            <div class="form-group">

                                <label>Uang Kembali</label>

                                <input type="text"
                                       id="uang_kembali_view"
                                       class="form-control"
                                       readonly>

                                <input type="hidden"
                                       name="uang_kembali"
                                       id="uang_kembali">

                            </div>

                        </div>


                        <div class="card-footer">

                            <button type="submit" id="btnSimpan"
                                    class="btn btn-success btn-block">

                                Simpan Transaksi

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</section>

@endsection





@push('scripts')

<script src="{{ asset('assets/js/transaksi.js') }}"></script>

@endpush
