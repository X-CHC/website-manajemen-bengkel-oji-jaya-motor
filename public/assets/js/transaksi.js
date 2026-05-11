
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
$(document).on('keyup', '#harga_jasa_view', function(){

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
$(document).on('keyup', '#uang_bayar_view', function(){

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
$(document).on('click', '#tambahBarang', function(){

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
