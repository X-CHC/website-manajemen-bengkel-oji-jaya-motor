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
function getAngka(element)
{
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

    $('.harga-beli-view').inputmask({
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
| BLOK HURUF DI INPUT ANGKA
|--------------------------------------------------------------------------
*/
function blokHurufInputAngka()
{
    $(document).on(
        'keydown',
        '.jumlah-masuk, .harga-beli-view',
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
        '.jumlah-masuk',
        function()
        {
            let angka = $(this)
                .val()
                .toString()
                .replace(/[^0-9]/g, '');

            $(this).val(angka);
        }
    );

    $(document).on(
        'input',
        '.harga-beli-view',
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
}


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL
|--------------------------------------------------------------------------
*/
function hitungTotal()
{
    let total = 0;

    $('.subtotal-input').each(function(){

        total += parseInt($(this).val()) || 0;
    });

    $('#total_bayar').val(total);

    $('#total_bayar_view')
        .val(formatRupiah(total));
}


/*
|--------------------------------------------------------------------------
| HITUNG SUBTOTAL PER BARANG
|--------------------------------------------------------------------------
*/
function hitungSubtotal(parent)
{
    let hargaInput = parent.find('.harga-beli-view');

    let hargaAngka = getAngka(hargaInput);

    parent.find('.harga-beli')
          .val(hargaAngka);

    let qty = parseInt(
        parent.find('.jumlah-masuk').val()
    ) || 0;

    let max = parseInt(
        parent.find('.jumlah-masuk').attr('max')
    ) || 0;

    if(qty > max)
    {
        alert('Jumlah masuk tidak boleh melebihi jumlah PO');

        qty = max;

        parent.find('.jumlah-masuk').val(max);
    }

    let subtotal = qty * hargaAngka;

    parent.find('.subtotal-view')
          .val(formatRupiah(subtotal));

    parent.find('.subtotal-input')
          .val(subtotal);

    hitungTotal();
}


/*
|--------------------------------------------------------------------------
| UPDATE SUBTOTAL
|--------------------------------------------------------------------------
*/
$(document).on('keyup change input', '.jumlah-masuk, .harga-beli-view', function(){

    let parent = $(this).closest('.barang-item');

    hitungSubtotal(parent);
});


/*
|--------------------------------------------------------------------------
| PILIH PO
|--------------------------------------------------------------------------
*/
$('#id_po').change(function(){

    let idPo = $(this).val();

    let selectedPo = window.poData.find(function(item){

        return item.id_po == idPo;
    });

    let html = '';

    if(!selectedPo)
    {
        $('#detailBarang').html(`
            <div class="text-muted">
                Pilih PO terlebih dahulu
            </div>
        `);

        $('#total_bayar').val(0);

        $('#total_bayar_view').val('0');

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | SET MIN TANGGAL MASUK
    |--------------------------------------------------------------------------
    */
    $('input[name="tanggal_masuk"]')
        .attr('min', selectedPo.tgl_po);

    /*
    |--------------------------------------------------------------------------
    | LOOP DETAIL PO
    |--------------------------------------------------------------------------
    */
    selectedPo.detail_po.forEach(function(detail){

        html += `

        <div class="barang-item border rounded p-3 mb-3">

            <div class="row">

                <div class="col-md-3">

                    <label>Barang</label>

                    <input type="text"
                           class="form-control"
                           value="${detail.barang.nama_barang}"
                           readonly>

                    <input type="hidden"
                           name="id_barang[]"
                           value="${detail.id_barang}">

                </div>


                <div class="col-md-2">

                    <label>Qty PO</label>

                    <input type="number"
                           class="form-control"
                           value="${detail.jumlah_po}"
                           readonly>

                </div>


                <div class="col-md-2">

                    <label>Qty Masuk</label>

                    <input type="number"
                           name="jumlah_barang[]"
                           class="form-control jumlah-masuk"
                           min="1"
                           max="${detail.jumlah_po}"
                           value="${detail.jumlah_po}"
                           inputmode="numeric"
                           pattern="[0-9]*"
                           required>

                </div>


                <div class="col-md-2">

                    <label>Harga Beli</label>

                    <input type="text"
                           class="form-control harga-beli-view"
                           inputmode="numeric"
                           required>

                    <input type="hidden"
                           name="harga_beli[]"
                           class="harga-beli">

                </div>


                <div class="col-md-3">

                    <label>Sub Total</label>

                    <input type="text"
                           class="form-control subtotal-view"
                           value="0"
                           readonly>

                    <input type="hidden"
                           class="subtotal-input"
                           name="sub_total[]"
                           value="0">

                </div>

            </div>

        </div>
        `;
    });

    $('#detailBarang').html(html);

    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN INPUTMASK SETELAH HTML BARU DIBUAT
    |--------------------------------------------------------------------------
    */
    initRupiahMask();

    /*
    |--------------------------------------------------------------------------
    | HITUNG AWAL
    |--------------------------------------------------------------------------
    */
    $('.barang-item').each(function(){

        let parent = $(this);

        hitungSubtotal(parent);
    });
});


/*
|--------------------------------------------------------------------------
| INIT AWAL
|--------------------------------------------------------------------------
*/
$(document).ready(function(){

    blokHurufInputAngka();

    initRupiahMask();

    hitungTotal();
});
