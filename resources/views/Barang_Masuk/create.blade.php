@extends('layout.app')

@section('content')

<section class="content">
<div class="container-fluid">

    {{-- ALERT ERROR VALIDATION --}}
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

    <form action="{{ route('barang-masuk.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="row">

            <div class="col-md-8">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Form Barang Masuk
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">

                            <label>Pilih PO</label>

                            <select name="id_po"
                                    id="id_po"
                                    class="form-control"
                                    required>

                                <option value="">
                                    -- Pilih PO --
                                </option>

                                @foreach($po as $item)

                                    <option value="{{ $item->id_po }}">

                                        {{ $item->id_po }}
                                        -
                                        {{ $item->mitra_po }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label>Tanggal Masuk</label>

                            <input type="date"
                                   name="tanggal_masuk"
                                   class="form-control"
                                   required>

                        </div>

                    </div>

                </div>


                <div class="card card-info">

                    <div class="card-header">
                        <h3 class="card-title">
                            Detail Barang
                        </h3>
                    </div>

                    <div class="card-body">

                        <div id="detailBarang">

                            <div class="text-muted">
                                Pilih PO terlebih dahulu
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card card-success sticky-top">

                    <div class="card-header">
                        <h3 class="card-title">
                            Pembayaran
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">

                            <label>Bukti Bayar</label>

                            <input type="file"
                                name="bukti_bayar"
                                class="form-control"
                                required>

                        </div>
                        <div class="form-group">

                            <label>Total Bayar</label>

                            <input type="text"
                                id="total_bayar_view"
                                class="form-control"
                                readonly>

                            <input type="hidden"
                                name="total_bayar"
                                id="total_bayar">

                        </div>

                        <button type="submit"
                                class="btn btn-success btn-block">

                            Simpan Barang Masuk

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>
</section>

<script>

window.poData = @json($po);

</script>

@push('scripts')

<script src="{{ asset('assets/js/barang-masuk.js') }}"></script>

@endpush
@endsection
