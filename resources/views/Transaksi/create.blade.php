@extends('layout.app')

@section('content')

<section class="content">
    <div class="container-fluid">

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
                                                        class="form-control barang-select">

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

                            {{-- JASA --}}
                            <div class="form-group">
                                <label>Harga Jasa</label>

                                <input type="text"
                                       id="harga_jasa_view"
                                       class="form-control">
                            </div>

                            <input type="hidden"
                                   name="harga_jasa"
                                   id="harga_jasa">

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
                                       class="form-control">
                            </div>

                            <input type="hidden"
                                   name="uang_bayar"
                                   id="uang_bayar">

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

                        <div class="card-footer">

                            <button type="submit"
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

<script>

/*
|--------------------------------------------------------------------------
| Format angka jadi format rupiah Indonesia
|--------------------------------------------------------------------------
| Contoh:
| 50000 => 50.000
*/
function formatRupiah(angka)
{
    return new Intl.NumberFormat('id-ID').format(angka);
}


/*
|--------------------------------------------------------------------------
| Menghapus titik dari format rupiah
|--------------------------------------------------------------------------
| Contoh:
| 50.000 => 50000
|
| Dipakai supaya value bisa dihitung matematika
*/
function parseRupiah(angka)
{
    return angka.replace(/\./g, '');
}


/*
|--------------------------------------------------------------------------
| Disable barang yang sudah dipilih
|--------------------------------------------------------------------------
| Tujuan:
| Barang yang sudah dipilih di row A
| tidak bisa dipilih lagi di row B
*/
function updateBarangOptions()
{
    let selectedBarang = [];

    // Ambil semua barang yang sudah dipilih
    $('.barang-select').each(function(){

        let value = $(this).val();

        if(value)
        {
            selectedBarang.push(value);
        }
    });

    // Loop semua select barang
    $('.barang-select').each(function(){

        let currentSelect = $(this);

        let currentValue = currentSelect.val();

        // Loop semua option di dalam select
        currentSelect.find('option').each(function(){

            let optionValue = $(this).val();

            // Skip option kosong
            if(optionValue == '')
            {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Jika barang sudah dipilih di select lain
            | maka disable option tersebut
            |--------------------------------------------------------------------------
            */
            if(selectedBarang.includes(optionValue) &&
               optionValue != currentValue)
            {
                $(this).prop('disabled', true);
            }
            else
            {
                $(this).prop('disabled', false);
            }
        });
    });
}


/*
|--------------------------------------------------------------------------
| Menghitung subtotal dan total transaksi
|--------------------------------------------------------------------------
| Yang dihitung:
| - subtotal tiap barang
| - grand total
| - total + jasa
| - uang kembali
*/
function hitungSemuaTotal()
{
    let grandTotal = 0;

    // Loop semua item barang
    $('.barang-item').each(function(){

        let harga = parseInt($(this).find('.harga-input').val()) || 0;

        let jumlah = parseInt($(this).find('.jumlah-barang').val()) || 0;

        // Hitung subtotal barang
        let subtotal = harga * jumlah;

        // Simpan subtotal ke input hidden
        $(this).find('.subtotal-input').val(subtotal);

        // Tampilkan subtotal format rupiah
        $(this).find('.subtotal-view').val(formatRupiah(subtotal));

        // Tambahkan ke grand total
        grandTotal += subtotal;
    });

    // Ambil harga jasa
    let jasa = parseInt($('#harga_jasa').val()) || 0;

    // Hitung total akhir
    let total = grandTotal + jasa;

    // Simpan total
    $('#total_harga').val(total);

    // Tampilkan total format rupiah
    $('#total_harga_view').val(formatRupiah(total));

    // Ambil uang bayar
    let bayar = parseInt($('#uang_bayar').val()) || 0;

    // Hitung uang kembali
    let kembali = bayar - total;

    // Simpan uang kembali
    $('#uang_kembali').val(kembali);

    // Tampilkan uang kembali format rupiah
    $('#uang_kembali_view').val(formatRupiah(kembali));
}


/*
|--------------------------------------------------------------------------
| Saat barang dipilih
|--------------------------------------------------------------------------
| Yang dilakukan:
| - ambil harga barang
| - ambil stok barang
| - tampilkan harga
| - set max jumlah sesuai stok
| - update total
*/
$(document).on('change', '.barang-select', function(){

    // Ambil harga barang dari data-harga
    let harga = $(this).find(':selected').data('harga') || 0;

    // Ambil stok barang dari data-stok
    let stok = $(this).find(':selected').data('stok') || 0;

    // Ambil parent card barang
    let parent = $(this).closest('.barang-item');

    // Simpan harga asli ke hidden input
    parent.find('.harga-input').val(harga);

    // Tampilkan harga format rupiah
    parent.find('.harga-view').val(formatRupiah(harga));

    // Set jumlah maksimal sesuai stok
    parent.find('.jumlah-barang').attr('max', stok);

    // Tampilkan placeholder max stok
    parent.find('.jumlah-barang').attr('placeholder', 'Max ' + stok);

    // Update option barang agar tidak duplicate
    updateBarangOptions();

    // Hitung ulang total
    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| Saat jumlah barang berubah
|--------------------------------------------------------------------------
| Validasi:
| jumlah tidak boleh lebih dari stok
*/
$(document).on('keyup change', '.jumlah-barang', function(){

    let jumlah = parseInt($(this).val()) || 0;

    let max = parseInt($(this).attr('max')) || 0;

    // Jika jumlah melebihi stok
    if(jumlah > max)
    {
        alert('Jumlah barang melebihi stok!');

        // Kembalikan ke max stok
        $(this).val(max);
    }

    // Hitung ulang total
    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| Saat input harga jasa
|--------------------------------------------------------------------------
| - format rupiah otomatis
| - update total transaksi
*/
$('#harga_jasa_view').on('keyup', function(){

    let angka = parseRupiah($(this).val());

    // Simpan angka asli
    $('#harga_jasa').val(angka);

    // Tampilkan format rupiah
    $(this).val(formatRupiah(angka));

    // Hitung ulang total
    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| Saat input uang bayar
|--------------------------------------------------------------------------
| - format rupiah otomatis
| - hitung uang kembali
*/
$('#uang_bayar_view').on('keyup', function(){

    let angka = parseRupiah($(this).val());

    // Simpan angka asli
    $('#uang_bayar').val(angka);

    // Tampilkan format rupiah
    $(this).val(formatRupiah(angka));

    // Hitung ulang total
    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| Tombol tambah barang
|--------------------------------------------------------------------------
| Fungsi:
| clone row barang sebelumnya
*/
$('#tambahBarang').click(function(){

    // Clone item barang pertama
    let item = $('.barang-item:first').clone();

    // Reset semua input
    item.find('input').val('');

    // Reset select barang
    item.find('select').val('');

    // Default jumlah = 1
    item.find('.jumlah-barang').val(1);

    // Tambahkan item ke list
    $('#listBarang').append(item);
});


/*
|--------------------------------------------------------------------------
| Tombol hapus barang
|--------------------------------------------------------------------------
| Hapus item barang
*/
$(document).on('click', '.hapusBarang', function(){

    // Minimal harus ada 1 item
    if($('.barang-item').length > 1)
    {
        // Hapus item
        $(this).closest('.barang-item').remove();

        // Update option barang
        updateBarangOptions();

        // Hitung ulang total
        hitungSemuaTotal();
    }

});

</script>

@endpush
