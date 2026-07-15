@extends('Layout.app')

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

    <form action="{{ route('po.store') }}"
          method="POST">

        @csrf

        <div class="row">

            <div class="col-md-8">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Form Purchase Order
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Mitra / Supplier</label>

                            <input type="text"
                                   name="mitra_po"
                                   class="form-control"
                                   required>
                        </div>

                    </div>

                </div>


                <div class="card card-info">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">
                            Detail Barang
                        </h3>

                        <button type="button"
                                class="btn btn-primary btn-sm"
                                id="tambahBarang">

                            <i class="fas fa-plus"></i>
                            Tambah Barang
                        </button>

                    </div>

                    <div class="card-body">

                        <div id="listBarang">

                            <div class="barang-item border rounded p-3 mb-3">

                                <div class="row">

                                    <div class="col-md-8">

                                        <div class="form-group">

                                            <label>Barang</label>

                                            <select name="id_barang[]"
                                                    class="form-control barang-select select2"
                                                    required>

                                                <option value="">
                                                    -- Pilih Barang --
                                                </option>

                                                @foreach($barang as $item)

                                                    <option value="{{ $item->id_barang }}"
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


                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>Jumlah PO</label>

                                            <input type="number"
                                                   name="jumlah_po[]"
                                                   class="form-control"
                                                   min="1"
                                                   value="1"
                                                   required>

                                        </div>

                                    </div>


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


            <div class="col-md-4">

                <div class="card card-success sticky-top">

                    <div class="card-header">
                        <h3 class="card-title">
                            Simpan PO
                        </h3>
                    </div>

                    <div class="card-body">

                        <h6>
                            List Barang PO
                        </h6>

                        <div id="previewBarangPo">

                            <div class="text-muted">
                                Belum ada barang dipilih
                            </div>

                        </div>

                        <hr>

                        <button type="submit"
                                class="btn btn-success btn-block">

                            Simpan Purchase Order

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>
</section>
@endsection


<script>
    window.barangOptions = `
        @foreach($barang as $item)
            <option value="{{ $item->id_barang }}"
                    data-stok="{{ $item->jumlah_barang }}">

                {{ $item->nama_barang }}
                -
                Stok:
                {{ $item->jumlah_barang }}

            </option>
        @endforeach
    `;
</script>


@push('scripts')

<script src="{{ asset('assets/js/po.js') }}"></script>

@endpush
