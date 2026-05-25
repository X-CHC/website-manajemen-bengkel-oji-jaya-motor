/*
|--------------------------------------------------------------------------
| FORMAT RUPIAH UNTUK TAMPILAN READONLY
|--------------------------------------------------------------------------
*/
function formatRupiah(angka)
{
    angka = parseInt(angka) || 0;

    return new Intl.NumberFormat('id-ID').format(angka);
}


/*
|--------------------------------------------------------------------------
| AMBIL ANGKA DARI INPUT
|--------------------------------------------------------------------------
| Jika Inputmask aktif, ambil unmaskedvalue.
| Jika Inputmask tidak aktif, fallback ambil angka manual.
|--------------------------------------------------------------------------
*/
function getAngka(selector)
{
    let element = $(selector);

    if(
        typeof $.fn.inputmask !== 'undefined' &&
        element.data('_inputmask')
    )
    {
        let value = element.inputmask('unmaskedvalue');

        return parseInt(value) || 0;
    }

    let value = element.val() || '0';

    value = value.toString().replace(/[^0-9]/g, '');

    return parseInt(value) || 0;
}


/*
|--------------------------------------------------------------------------
| AKTIFKAN INPUTMASK RUPIAH
|--------------------------------------------------------------------------
*/
function initRupiahMask()
{
    if(typeof $.fn.inputmask === 'undefined')
    {
        console.log('Inputmask belum ter-load. Cek path script inputmask di layout.');

        return;
    }

    $('#harga_jasa_view, #uang_bayar_view').inputmask({
        alias: 'numeric',
        groupSeparator: '.',
        radixPoint: ',',
        digits: 0,
        autoGroup: true,
        rightAlign: false,
        allowMinus: false,
        min: 0,
        placeholder: '0',
        removeMaskOnSubmit: false
    });
}


/*
|--------------------------------------------------------------------------
| HANYA IZINKAN ANGKA UNTUK INPUT ANGKA
|--------------------------------------------------------------------------
*/
function blokHurufInputAngka()
{
    $(document).on(
        'keydown',
        '#harga_jasa_view, #uang_bayar_view, .jumlah-barang',
        function(e)
        {
            let tombolDilarang = [
                'e',
                'E',
                '+',
                '-',
                ',',
                '.'
            ];

            if(tombolDilarang.includes(e.key))
            {
                e.preventDefault();
            }
        }
    );

    $(document).on(
        'input',
        '#harga_jasa_view, #uang_bayar_view',
        function()
        {
            if(typeof $.fn.inputmask === 'undefined')
            {
                let angka = $(this)
                    .val()
                    .toString()
                    .replace(/[^0-9]/g, '');

                $(this).val(formatRupiah(angka));
            }
        }
    );

    $(document).on(
        'input',
        '.jumlah-barang',
        function()
        {
            let angka = $(this)
                .val()
                .toString()
                .replace(/[^0-9]/g, '');

            $(this).val(angka);
        }
    );
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
| Barang yang sudah dipilih tidak bisa dipilih lagi.
| Barang dengan stok 0 tetap tampil, tapi disabled.
|--------------------------------------------------------------------------
*/
function updateBarangOptions()
{
    let selectedBarang = [];

    $('.barang-select').each(function(){

        let value = $(this).val();

        if(value)
        {
            selectedBarang.push(value);
        }

    });

    $('.barang-select').each(function(){

        let currentSelect = $(this);

        let currentValue = currentSelect.val();

        currentSelect.find('option').each(function(){

            let optionValue = $(this).val();

            let stok = parseInt($(this).data('stok')) || 0;

            if(optionValue == '')
            {
                return;
            }

            if(stok <= 0)
            {
                $(this).prop('disabled', true);
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

    let jasa = getAngka('#harga_jasa_view');

    $('#harga_jasa').val(jasa);

    let total = grandTotal + jasa;

    $('#total_harga').val(total);

    $('#total_harga_view')
        .val(formatRupiah(total));

    let bayar = getAngka('#uang_bayar_view');

    $('#uang_bayar').val(bayar);

    let kembali = bayar - total;

    $('#uang_kembali').val(kembali);

    $('#uang_kembali_view')
        .val(formatRupiah(kembali));

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
        parseInt($(this).find(':selected').data('stok')) || 0;

    let parent =
        $(this).closest('.barang-item');

    if(stok <= 0 && $(this).val() != '')
    {
        alert('Barang ini stoknya habis dan tidak bisa dipilih.');

        $(this).val('').trigger('change.select2');

        parent.find('.harga-input').val('');
        parent.find('.harga-view').val('');

        parent.find('.subtotal-input').val('');
        parent.find('.subtotal-view').val('');

        parent.find('.jumlah-barang')
              .val(1)
              .removeAttr('max')
              .removeAttr('placeholder');

        hitungSemuaTotal();

        return;
    }

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
$(document).on('keyup change input', '.jumlah-barang', function(){

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
$(document).on('keyup change input', '#harga_jasa_view', function(){

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| UANG BAYAR
|--------------------------------------------------------------------------
*/
$(document).on('keyup change input', '#uang_bayar_view', function(){

    hitungSemuaTotal();
});


/*
|--------------------------------------------------------------------------
| TAMBAH BARANG
|--------------------------------------------------------------------------
*/
$(document).on('click', '#tambahBarang', function(){

    $('.barang-select').select2('destroy');

    let item =
        $('.barang-item:first').clone();

    item.find('.barang-select').val('');

    item.find('.harga-view').val('');
    item.find('.harga-input').val('');

    item.find('.subtotal-view').val('');
    item.find('.subtotal-input').val('');

    item.find('.jumlah-barang').val(1);

    item.find('.jumlah-barang')
        .removeAttr('max')
        .removeAttr('placeholder');

    $('#listBarang').append(item);

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

    initRupiahMask();

    blokHurufInputAngka();

    initSelect2();

    updateBarangOptions();

    hitungSemuaTotal();

});
