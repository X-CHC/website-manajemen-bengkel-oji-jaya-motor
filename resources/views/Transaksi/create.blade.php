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

<script>

/*
|--------------------------------------------------------------------------
| FORMAT RUPIAH
|--------------------------------------------------------------------------
*/
function formatRupiah(angka)
{
    return new Intl.NumberFormat('id-ID').format(angka);
}


/*
|--------------------------------------------------------------------------
| PARSE RUPIAH
|--------------------------------------------------------------------------
*/
function parseRupiah(angka)
{
    return angka.toString().replace(/\./g, '');
}


/*
|--------------------------------------------------------------------------
| AKTIFKAN SELECT2
|--------------------------------------------------------------------------
*/
function initSelect2()
{
    $('.barang-select').select2({
        width: '100%',
        placeholder: '-- Pilih Barang --'
    });
}


/*
|--------------------------------------------------------------------------
| UPDATE OPTION BARANG
|--------------------------------------------------------------------------
| Barang yang sudah dipilih
| tidak bisa dipilih lagi
*/
function updateBarangOptions()
{
    let selectedBarang = [];

    // Ambil semua barang terpilih
    $('.barang-select').each(function(){

        let value = $(this).val();

        if(value)
        {
            selectedBarang.push(value);
        }

    });

    // Disable duplicate option
    $('.barang-select').each(function(){

        let currentSelect = $(this);

        let currentValue = currentSelect.val();

        currentSelect.find('option').each(function(){

            let optionValue = $(this).val();

            if(optionValue == '')
            {
                return;
            }

            if(
                selectedBarang.includes(optionValue) &&
                optionValue != currentValue
            )
            {
                $(this).prop('disabled', true);
            }
            else
            {
                $(this).prop('disabled', false);
            }

        });

    });

    // Refresh select2
    $('.barang-select').trigger('change.select2');
}


/*
|--------------------------------------------------------------------------
| UPDATE JUMLAH ITEM
|--------------------------------------------------------------------------
*/
function updateJumlahItemBarang()
{
    let totalItem = $('.barang-item').length;

    $('#jumlahItemBarang').text(totalItem);
}


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL
|--------------------------------------------------------------------------
*/
function hitungSemuaTotal()
{
    let grandTotal = 0;

    $('.barang-item').each(function(){

        let harga =
            parseInt($(this).find('.harga-input').val()) || 0;

        let jumlah =
            parseInt($(this).find('.jumlah-barang').val()) || 0;

        let subtotal = harga * jumlah;

        $(this).find('.subtotal-input').val(subtotal);

        $(this).find('.subtotal-view')
               .val(formatRupiah(subtotal));

        grandTotal += subtotal;
    });

    let jasa =
        parseInt($('#harga_jasa').val()) || 0;

    let total = grandTotal + jasa;

    $('#total_harga').val(total);

    $('#total_harga_view')
        .val(formatRupiah(total));

    let bayar =
        parseInt($('#uang_bayar').val()) || 0;

    let kembali = bayar - total;

    $('#uang_kembali').val(kembali);

    $('#uang_kembali_view')
        .val(formatRupiah(kembali));

    /*
    |--------------------------------------------------------------------------
    | VALIDASI UANG KURANG
    |--------------------------------------------------------------------------
    */
    if(kembali < 0)
    {
        $('#uang_kembali_view')
            .addClass('is-invalid');

        $('#btnSimpan')
            .prop('disabled', true);
    }
    else
    {
        $('#uang_kembali_view')
            .removeClass('is-invalid');

        $('#btnSimpan')
            .prop('disabled', false);
    }
}


/*
|--------------------------------------------------------------------------
| EVENT PILIH BARANG
|--------------------------------------------------------------------------
*/
$(document).on('change', '.barang-select', function(){

    let harga =
        $(this).find(':selected').data('harga') || 0;

    let stok =
        $(this).find(':selected').data('stok') || 0;

    let parent =
        $(this).closest('.barang-item');

    parent.find('.harga-input')
          .val(harga);

    parent.find('.harga-view')
          .val(formatRupiah(harga));

    parent.find('.jumlah-barang')
          .attr('max', stok);

    parent.find('.jumlah-barang')
          .attr('placeholder', 'Max ' + stok);

    updateBarangOptions();

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| EVENT JUMLAH BARANG
|--------------------------------------------------------------------------
*/
$(document).on('keyup change', '.jumlah-barang', function(){

    let jumlah =
        parseInt($(this).val()) || 0;

    let max =
        parseInt($(this).attr('max')) || 0;

    if(jumlah > max)
    {
        alert('Jumlah barang melebihi stok!');

        $(this).val(max);
    }

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| HARGA JASA
|--------------------------------------------------------------------------
*/
$('#harga_jasa_view').on('keyup', function(){

    let angka = parseRupiah($(this).val());

    $('#harga_jasa').val(angka);

    $(this).val(formatRupiah(angka));

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| UANG BAYAR
|--------------------------------------------------------------------------
*/
$('#uang_bayar_view').on('keyup', function(){

    let angka = parseRupiah($(this).val());

    $('#uang_bayar').val(angka);

    $(this).val(formatRupiah(angka));

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| TAMBAH BARANG
|--------------------------------------------------------------------------
*/
$('#tambahBarang').click(function(){

    // Destroy select2 sementara
    $('.barang-select').select2('destroy');

    // Clone item pertama
    let item =
        $('.barang-item:first').clone();

    // Reset select
    item.find('.barang-select').val('');

    // Reset harga
    item.find('.harga-view').val('');
    item.find('.harga-input').val('');

    // Reset subtotal
    item.find('.subtotal-view').val('');
    item.find('.subtotal-input').val('');

    // Reset jumlah
    item.find('.jumlah-barang').val(1);

    // Reset max
    item.find('.jumlah-barang')
        .removeAttr('max');

    // Tambah item
    $('#listBarang').append(item);

    // Aktifkan select2 lagi
    initSelect2();

    updateJumlahItemBarang();

    updateBarangOptions();

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| HAPUS BARANG
|--------------------------------------------------------------------------
*/
$(document).on('click', '.hapusBarang', function(){

    if($('.barang-item').length > 1)
    {
        $(this)
            .closest('.barang-item')
            .remove();

        updateBarangOptions();

        updateJumlahItemBarang();

        hitungSemuaTotal();
    }

});


/*
|--------------------------------------------------------------------------
| INIT AWAL
|--------------------------------------------------------------------------
*/
$(document).ready(function(){

    initSelect2();

    updateBarangOptions();

    hitungSemuaTotal();

});

</script>

@endpush
