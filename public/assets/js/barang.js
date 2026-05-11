function formatRupiah(angka)
{
    return angka
        .replace(/\D/g, '')
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


/*
|--------------------------------------------------------------------------
| HARGA BELI
|--------------------------------------------------------------------------
*/
const hargaBeli =
    document.getElementById('harga_beli');

if(hargaBeli)
{
    hargaBeli.addEventListener('keyup', function(){

        this.value = formatRupiah(this.value);
    });
}


/*
|--------------------------------------------------------------------------
| HARGA JUAL
|--------------------------------------------------------------------------
*/
const hargaJual =
    document.getElementById('harga_jual');

if(hargaJual)
{
    hargaJual.addEventListener('keyup', function(){

        this.value = formatRupiah(this.value);
    });
}