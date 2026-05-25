/*
|--------------------------------------------------------------------------
| AKTIFKAN SELECT2
|--------------------------------------------------------------------------
*/
function initSelect2()
{
    $('.select2').select2({
        width: '100%',
        placeholder: '-- Pilih Barang --'
    });
}


/*
|--------------------------------------------------------------------------
| UPDATE OPTION BARANG
|--------------------------------------------------------------------------
| Barang yang sudah dipilih tidak bisa dipilih lagi.
| Barang stok 0 tetap boleh dipilih untuk PO.
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

            if(optionValue == '')
            {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | DISABLE HANYA JIKA BARANG SUDAH DIPILIH DI ROW LAIN
            |--------------------------------------------------------------------------
            | Stok 0 tidak didisable karena PO dipakai untuk restock.
            |--------------------------------------------------------------------------
            */
            if(
                selectedBarang.includes(optionValue)
                &&
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
| PREVIEW LIST BARANG PO
|--------------------------------------------------------------------------
*/
function updatePreviewBarangPo()
{
    let html = '';

    $('.barang-item').each(function(){

        let optionSelected = $(this)
            .find('.barang-select option:selected');

        let namaBarang = optionSelected
            .text()
            .trim();

        let stok = parseInt(optionSelected.data('stok')) || 0;

        let jumlah = $(this)
            .find('input[name="jumlah_po[]"]')
            .val();

        let valueBarang = $(this)
            .find('.barang-select')
            .val();

        if(valueBarang == '')
        {
            return;
        }

        html += `
            <div class="border rounded p-2 mb-2">

                <strong>${namaBarang}</strong>

                <br>

                Stok Sekarang :
                <span class="${stok <= 0 ? 'text-danger' : 'text-success'}">
                    ${stok}
                </span>

                <br>

                Jumlah PO :
                ${jumlah}

            </div>
        `;
    });

    if(html == '')
    {
        html = `
            <div class="text-muted">
                Belum ada barang dipilih
            </div>
        `;
    }

    $('#previewBarangPo').html(html);
}


/*
|--------------------------------------------------------------------------
| PILIH BARANG
|--------------------------------------------------------------------------
*/
$(document).on('change', '.barang-select', function(){

    updateBarangOptions();

    updatePreviewBarangPo();
});


/*
|--------------------------------------------------------------------------
| UPDATE JUMLAH PO
|--------------------------------------------------------------------------
*/
$(document).on('input', 'input[name="jumlah_po[]"]', function(){

    updatePreviewBarangPo();
});


/*
|--------------------------------------------------------------------------
| TAMBAH BARANG
|--------------------------------------------------------------------------
*/
$('#tambahBarang').click(function(){

    $('.barang-select').select2('destroy');

    let newItem = `

    <div class="barang-item border rounded p-3 mb-3">

        <div class="row">

            <div class="col-md-8">

                <div class="form-group">

                    <label>Barang</label>

                    <select name="id_barang[]"
                            class="form-control barang-select select2"
                            required>

                        <option value="">
                            -- Pilih Barang --
                        </option>

                        ${window.barangOptions}

                    </select>

                </div>

            </div>


            <div class="col-md-3">

                <div class="form-group">

                    <label>Jumlah PO</label>

                    <input type="number"
                           name="jumlah_po[]"
                           class="form-control"
                           min="1"
                           value="1"
                           required>

                </div>

            </div>


            <div class="col-md-1 d-flex align-items-center">

                <button type="button"
                        class="btn btn-danger btn-sm hapusBarang mt-3">

                    <i class="fas fa-trash"></i>

                </button>

            </div>

        </div>

    </div>
    `;

    $('#listBarang').append(newItem);

    initSelect2();

    updateBarangOptions();

    updatePreviewBarangPo();
});


/*
|--------------------------------------------------------------------------
| HAPUS BARANG
|--------------------------------------------------------------------------
*/
$(document).on('click', '.hapusBarang', function(){

    if($('.barang-item').length > 1)
    {
        $(this).closest('.barang-item').remove();

        updateBarangOptions();

        updatePreviewBarangPo();
    }
});


/*
|--------------------------------------------------------------------------
| LOAD PERTAMA
|--------------------------------------------------------------------------
*/
$(document).ready(function(){

    initSelect2();

    updateBarangOptions();

    updatePreviewBarangPo();
});
