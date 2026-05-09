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
}


/*
|--------------------------------------------------------------------------
| UPDATE SUBTOTAL
|--------------------------------------------------------------------------
*/
$(document).on('keyup change', '.jumlah-masuk, .harga-beli', function(){

    let parent = $(this).closest('.barang-item');

    let qty = parseInt(
        parent.find('.jumlah-masuk').val()
    ) || 0;

    let harga = parseInt(
        parent.find('.harga-beli').val()
    ) || 0;

    let subtotal = qty * harga;

    parent.find('.subtotal-view')
          .val(formatRupiah(subtotal));

    parent.find('.subtotal-input')
          .val(subtotal);

    hitungTotal();
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

    /*
    |--------------------------------------------------------------------------
    | JIKA PO BELUM DIPILIH
    |--------------------------------------------------------------------------
    */
    if(!selectedPo)
    {
        $('#detailBarang').html(`
            <div class="text-muted">
                Pilih PO terlebih dahulu
            </div>
        `);

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
                           required>

                </div>


                <div class="col-md-2">

                    <label>Harga Beli</label>

                    <input type="number"
                           name="harga_beli[]"
                           class="form-control harga-beli"
                           required>

                </div>


                <div class="col-md-3">

                    <label>Sub Total</label>

                    <input type="text"
                           class="form-control subtotal-view"
                           readonly>

                    <input type="hidden"
                           class="subtotal-input"
                           name="sub_total[]">

                </div>

            </div>

        </div>
        `;
    });

    $('#detailBarang').html(html);

    /*
    |--------------------------------------------------------------------------
    | TRIGGER HITUNG PERTAMA
    |--------------------------------------------------------------------------
    */
    $('.harga-beli').trigger('keyup');
});
