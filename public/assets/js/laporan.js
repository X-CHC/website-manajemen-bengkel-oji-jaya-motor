$(document).ready(function() {

    /*
    |--------------------------------------------------------------------------
    | SELECT2 BARANG
    |--------------------------------------------------------------------------
    */
    $('#id_barang').select2({
        placeholder: '-- Pilih Barang --',
        width: '100%'
    });


    /*
    |--------------------------------------------------------------------------
    | LOAD BARANG BERDASARKAN KATEGORI
    |--------------------------------------------------------------------------
    */
    function loadBarang(idKategori = '') {
        let html = '';

        let kategoriPilihan = String(idKategori).trim();

        window.allBarang.forEach(function(item) {

            let kategoriBarang = String(item.id_kategori_barang || '').trim();

            let idBrg = String(item.id_barang || '').trim();

            let namaBrg = item.nama_barang || 'Tanpa Nama';

            if(kategoriPilihan === '' || kategoriBarang === kategoriPilihan) {
                html += `
                    <option value="${idBrg}">
                        ${namaBrg}
                    </option>
                `;
            }
        });

        $('#id_barang').html(html);

        $('#id_barang').val(null).trigger('change');
    }


    /*
    |--------------------------------------------------------------------------
    | SAAT KATEGORI DIGANTI
    |--------------------------------------------------------------------------
    */
    $('#id_kategori').change(function() {
        let kategori = $(this).val();

        loadBarang(kategori);
    });


    /*
    |--------------------------------------------------------------------------
    | LOAD PERTAMA
    |--------------------------------------------------------------------------
    */
    loadBarang();


    /*
    |--------------------------------------------------------------------------
    | TOMBOL PDF
    |--------------------------------------------------------------------------
    | PDF hanya transaksi.
    |--------------------------------------------------------------------------
    */
    $('#btnPdf').click(function() {

        let jenis = $('#jenis_laporan').val();

        if(!jenis) {
            alert('Silakan pilih jenis laporan terlebih dahulu!');
            return;
        }

        if(jenis !== 'transaksi') {
            alert('Export PDF hanya tersedia untuk laporan transaksi / penjualan.');
            return;
        }

        $('#formLaporan').attr('action', window.routeLaporanPdf);

        $('#formLaporan').submit();
    });


    /*
    |--------------------------------------------------------------------------
    | TOMBOL EXCEL
    |--------------------------------------------------------------------------
    | Excel bisa semua jenis laporan.
    |--------------------------------------------------------------------------
    */
    $('#btnExcel').click(function() {

        let jenis = $('#jenis_laporan').val();

        if(!jenis) {
            alert('Silakan pilih jenis laporan terlebih dahulu!');
            return;
        }

        $('#formLaporan').attr('action', window.routeLaporanExcel);

        $('#formLaporan').submit();
    });

});
