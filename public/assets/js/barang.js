/*
|--------------------------------------------------------------------------
| AKTIFKAN INPUTMASK RUPIAH
|--------------------------------------------------------------------------
*/
function initRupiahMask()
{
    if(typeof $.fn.inputmask === 'undefined')
    {
        console.log('Inputmask belum ter-load. Cek path inputmask di layout.');

        return;
    }

    $('#harga_beli, #harga_jual').inputmask({
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
| BLOK INPUT HURUF
|--------------------------------------------------------------------------
| Supaya input harga tidak bisa diisi huruf, e, +, -, koma, titik manual.
|--------------------------------------------------------------------------
*/
function blokHurufHarga()
{
    $(document).on('keydown', '#harga_beli, #harga_jual', function(e){

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

    });
}


/*
|--------------------------------------------------------------------------
| INIT
|--------------------------------------------------------------------------
*/
$(document).ready(function(){

    initRupiahMask();

    blokHurufHarga();

});
