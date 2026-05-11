@extends('layout.app')

@section('content')
<div class="container-fluid pt-4">
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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Cetak Laporan Bengkel</h3>
        </div>

        <div class="card-body">
            <form id="formLaporan" method="POST" target="_blank">
                @csrf

                {{-- 1. JENIS LAPORAN --}}
                <div class="mb-3">
                    <label>Jenis Laporan</label>
                    <select name="jenis_laporan" class="form-control" required>
                        <option value="">-- Pilih Laporan --</option>
                        <option value="transaksi">Transaksi / Penjualan</option>
                        <option value="barang_masuk">Barang Masuk</option>
                        <option value="history_stok">History Stok</option>
                    </select>
                </div>

                {{-- 2. TANGGAL --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" required>
                    </div>
                </div>

                {{-- 3. KATEGORI --}}
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id_kategori_barang }}">
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. BARANG --}}
                <div class="mb-3">
                    <label>Barang <small class="text-muted">(Bisa pilih lebih dari satu)</small></label>
                    <select name="id_barang[]" id="id_barang" class="form-control" multiple>
                        </select>
                </div>

                {{-- 5. BUTTON EXPORT --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="button" id="btnPdf" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>

                    <button type="button" id="btnExcel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    // Ambil data barang dari Controller dengan aman
    let allBarang = {!! json_encode($barang) !!};

    $(document).ready(function() {

        /*
        | 1. INISIALISASI SELECT2
        */
        $('#id_barang').select2({

            placeholder: '-- Pilih Barang --',

            width: '100%'
        });

        /*
        | 2. FUNGSI FILTER BARANG BERDASARKAN KATEGORI
        */
        function loadBarang(idKategori = '') {
            let html = '';

            // Ubah ke string lalu bersihkan spasi agar presisi
            let kategoriPilihan = String(idKategori).trim();

            allBarang.forEach(function(item) {
                // Bersihkan spasi bawaan char(6) dari database
                let kategoriBarang = String(item.id_kategori_barang || '').trim();
                let idBrg = String(item.id_barang || '').trim();
                let namaBrg = item.nama_barang || 'Tanpa Nama';

                // Jika 'Semua Kategori' ATAU Kategori Cocok
                if(kategoriPilihan === '' || kategoriBarang === kategoriPilihan) {
                    html += `
                        <option value="${idBrg}">
                            ${namaBrg}
                        </option>
                    `;
                }
            });

            // Masukkan daftar option ke dalam select box
            $('#id_barang').html(html);

            // Kosongkan pilihan yang sebelumnya sudah ter-klik agar tidak nyangkut
            $('#id_barang').val(null).trigger('change');
        }

        /*
        | 3. EVENT KETIKA KATEGORI DIGANTI
        */
        $('#id_kategori').change(function() {
            let kategori = $(this).val();
            loadBarang(kategori);
        });

        /*
        | 4. LOAD PERTAMA KALI HALAMAN DIBUKA
        */
        loadBarang();

        /*
        | 5. LOGIKA TOMBOL EXPORT
        */
        $('#btnPdf').click(function() {
            // Validasi: pastikan jenis laporan tidak kosong
            if(!$('select[name="jenis_laporan"]').val()) {
                alert('Silakan pilih Jenis Laporan terlebih dahulu!');
                return;
            }

            // Arahkan action form ke rute PDF dan eksekusi
            $('#formLaporan').attr('action', '{{ route("laporan.pdf") }}');
            $('#formLaporan').submit();
        });

        $('#btnExcel').click(function() {
            // Validasi: pastikan jenis laporan tidak kosong
            if(!$('select[name="jenis_laporan"]').val()) {
                alert('Silakan pilih Jenis Laporan terlebih dahulu!');
                return;
            }

            // Arahkan action form ke rute Excel dan eksekusi
            $('#formLaporan').attr('action', '{{ route("laporan.excel") }}');
            $('#formLaporan').submit();
        });

    });
</script>
@endpush
