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

<script>

/*
|--------------------------------------------------------------------------
| FORMAT RUPIAH
|--------------------------------------------------------------------------
| Mengubah angka biasa menjadi format Indonesia
|
| Contoh:
| 50000 => 50.000
*/
function formatRupiah(angka)
{
    return new Intl.NumberFormat('id-ID').format(angka);
}


/*
|--------------------------------------------------------------------------
| PARSE RUPIAH
|--------------------------------------------------------------------------
| Menghapus titik dari format rupiah
|
| Contoh:
| 50.000 => 50000
*/
function parseRupiah(angka)
{
    return angka.replace(/\./g, '');
}


/*
|--------------------------------------------------------------------------
| UPDATE OPTION BARANG
|--------------------------------------------------------------------------
| Barang yang sudah dipilih
| tidak bisa dipilih lagi di row lain
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

    // Disable barang duplicate
    $('.barang-select').each(function(){

        let currentSelect = $(this);

        let currentValue = currentSelect.val();

        currentSelect.find('option').each(function(){

            let optionValue = $(this).val();

            // Skip option kosong
            if(optionValue == '')
            {
                return;
            }

            // Disable jika barang sudah dipilih di select lain
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
| UPDATE JUMLAH ITEM BARANG
|--------------------------------------------------------------------------
| Menghitung total card barang
|
| Contoh:
| ada 3 item barang => badge tampil 3
*/
function updateJumlahItemBarang()
{
    let totalItem = $('.barang-item').length;

    $('#jumlahItemBarang').text(totalItem);
}


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL TRANSAKSI
|--------------------------------------------------------------------------
| Menghitung:
| - subtotal tiap barang
| - grand total
| - total + jasa
| - uang kembali
*/
function hitungSemuaTotal()
{
    let grandTotal = 0;

    // Loop semua barang
    $('.barang-item').each(function(){

        // Ambil harga barang
        let harga = parseInt($(this).find('.harga-input').val()) || 0;

        // Ambil jumlah barang
        let jumlah = parseInt($(this).find('.jumlah-barang').val()) || 0;

        // Hitung subtotal
        let subtotal = harga * jumlah;

        // Simpan subtotal ke hidden input
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

    // Tampilkan uang kembali
    $('#uang_kembali_view').val(formatRupiah(kembali));

    /*
    |--------------------------------------------------------------------------
    | VALIDASI UANG BAYAR
    |--------------------------------------------------------------------------
    | Jika uang bayar kurang:
    | - field kembali merah
    | - tombol simpan disable
    */
    if(kembali < 0)
    {
        // Tambah warna merah
        $('#uang_kembali_view').addClass('is-invalid');

        // Disable tombol simpan
        $('#btnSimpan').prop('disabled', true);
    }
    else
    {
        // Hapus warna merah
        $('#uang_kembali_view').removeClass('is-invalid');

        // Enable tombol simpan
        $('#btnSimpan').prop('disabled', false);
    }
}

/*
|--------------------------------------------------------------------------
| EVENT PILIH BARANG
|--------------------------------------------------------------------------
| Saat barang dipilih:
| - ambil harga barang
| - ambil stok barang
| - set max jumlah
| - hitung total ulang
*/
$(document).on('change', '.barang-select', function(){

    // Ambil harga barang
    let harga = $(this).find(':selected').data('harga') || 0;

    // Ambil stok barang
    let stok = $(this).find(':selected').data('stok') || 0;

    // Ambil parent item
    let parent = $(this).closest('.barang-item');

    // Simpan harga asli
    parent.find('.harga-input').val(harga);

    // Tampilkan harga rupiah
    parent.find('.harga-view').val(formatRupiah(harga));

    // Set max jumlah barang
    parent.find('.jumlah-barang').attr('max', stok);

    // Placeholder max stok
    parent.find('.jumlah-barang').attr('placeholder', 'Max ' + stok);

    // Update select option
    updateBarangOptions();

    // Hitung ulang total
    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| EVENT JUMLAH BARANG
|--------------------------------------------------------------------------
| Validasi:
| jumlah tidak boleh melebihi stok
*/
$(document).on('keyup change', '.jumlah-barang', function(){

    let jumlah = parseInt($(this).val()) || 0;

    let max = parseInt($(this).attr('max')) || 0;

    // Jika melebihi stok
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
| EVENT HARGA JASA
|--------------------------------------------------------------------------
| Format otomatis rupiah
| lalu hitung ulang total
*/
$('#harga_jasa_view').on('keyup', function(){

    // Hapus titik
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
| EVENT UANG BAYAR
|--------------------------------------------------------------------------
| Format otomatis rupiah
| lalu hitung uang kembali
*/
$('#uang_bayar_view').on('keyup', function(){

    // Hapus titik
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
| TAMBAH BARANG
|--------------------------------------------------------------------------
| Clone card barang baru
*/
$('#tambahBarang').click(function(){

    // Clone item pertama
    let item = $('.barang-item:first').clone();

    // Reset select barang
    item.find('.barang-select').val('');

    // Reset harga
    item.find('.harga-view').val('');
    item.find('.harga-input').val('');

    // Reset subtotal
    item.find('.subtotal-view').val('');
    item.find('.subtotal-input').val('');

    // Reset jumlah
    item.find('.jumlah-barang').val(1);

    // Tambahkan item ke list
    $('#listBarang').append(item);

    // Update jumlah item
    updateJumlahItemBarang();
});


/*
|--------------------------------------------------------------------------
| HAPUS BARANG
|--------------------------------------------------------------------------
| Menghapus item barang
*/
$(document).on('click', '.hapusBarang', function(){

    // Minimal harus ada 1 item
    if($('.barang-item').length > 1)
    {
        // Hapus item
        $(this).closest('.barang-item').remove();

        // Update select option
        updateBarangOptions();

        // Update jumlah item
        updateJumlahItemBarang();

        // Hitung ulang total
        hitungSemuaTotal();
    }

});

</script>

@endpush
