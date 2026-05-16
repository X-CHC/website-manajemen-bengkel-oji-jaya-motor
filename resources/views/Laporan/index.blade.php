@extends('layout.app')

@section('content')

<div class="container-fluid pt-4">


    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">
                Cetak Laporan Bengkel
            </h3>
        </div>

        <div class="card-body">

            <form id="formLaporan" method="POST" target="_blank">

                @csrf

                {{-- JENIS LAPORAN --}}
                <div class="mb-3">

                    <label>Jenis Laporan</label>

                    <select name="jenis_laporan"
                            id="jenis_laporan"
                            class="form-control"
                            required>

                        <option value="">
                            -- Pilih Laporan --
                        </option>

                        <option value="transaksi">
                            Transaksi / Penjualan
                        </option>

                        <option value="barang_masuk">
                            Barang Masuk
                        </option>

                        <option value="history_stok">
                            History Stok
                        </option>

                    </select>

                    <small class="text-muted">
                        PDF hanya tersedia untuk laporan transaksi / penjualan.
                        Excel tersedia untuk semua jenis laporan.
                    </small>

                </div>


                {{-- TANGGAL --}}
                <div class="row mb-3">

                    <div class="col-md-6">

                        <label>Tanggal Awal</label>

                        <input type="date"
                               name="tanggal_awal"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label>Tanggal Akhir</label>

                        <input type="date"
                               name="tanggal_akhir"
                               class="form-control"
                               required>

                    </div>

                </div>


                {{-- KATEGORI --}}
                <div class="mb-3">

                    <label>Kategori</label>

                    <select name="id_kategori"
                            id="id_kategori"
                            class="form-control">

                        <option value="">
                            -- Semua Kategori --
                        </option>

                        @foreach($kategori as $item)

                            <option value="{{ $item->id_kategori_barang }}">
                                {{ $item->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BARANG --}}
                <div class="mb-3">

                    <label>
                        Barang
                        <small class="text-muted">
                            Bisa pilih lebih dari satu
                        </small>
                    </label>

                    <select name="id_barang[]"
                            id="id_barang"
                            class="form-control"
                            multiple>
                    </select>

                </div>


                {{-- BUTTON EXPORT --}}
                <div class="d-flex gap-2 mt-4">

                    <button type="button"
                            id="btnPdf"
                            class="btn btn-danger">

                        <i class="fas fa-file-pdf"></i>
                        Export PDF

                    </button>

                    <button type="button"
                            id="btnExcel"
                            class="btn btn-success">

                        <i class="fas fa-file-excel"></i>
                        Export Excel

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
    window.allBarang = @json($barang);

    window.routeLaporanPdf = "{{ route('laporan.pdf') }}";

    window.routeLaporanExcel = "{{ route('laporan.excel') }}";
</script>

<script src="{{ asset('assets/js/laporan.js') }}"></script>

@endpush
