$(function () {

    let allBarang = window.allBarang || [];

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
    function loadBarang(idKategori = '')
    {
        let html = '';

        allBarang.forEach(function (item) {

            if (idKategori === '') {

                html += `
                    <option value="${item.id_barang}">
                        ${item.nama_barang}
                    </option>
                `;

                return;
            }

            if (item.id_kategori_barang == idKategori) {

                html += `
                    <option value="${item.id_barang}">
                        ${item.nama_barang}
                    </option>
                `;
            }

        });

        $('#id_barang').html(html);

        $('#id_barang').trigger('change');
    }


    /*
    |--------------------------------------------------------------------------
    | GANTI KATEGORI
    |--------------------------------------------------------------------------
    */
    $('#id_kategori').on('change', function () {

        let kategori = $(this).val();

        loadBarang(kategori);
    });


    /*
    |--------------------------------------------------------------------------
    | LOAD AWAL
    |--------------------------------------------------------------------------
    */
    loadBarang();


    /*
    |--------------------------------------------------------------------------
    | CETAK LAPORAN
    |--------------------------------------------------------------------------
    | transaksi    => PDF
    | barang_masuk => Excel
    |--------------------------------------------------------------------------
    */
    $('#btnCetak').on('click', function () {

        let jenisLaporan = $('#jenis_laporan').val();

        if (jenisLaporan === '') {
            toastr.warning('Pilih jenis laporan terlebih dahulu');
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI / PENJUALAN => PDF
        |--------------------------------------------------------------------------
        */
        if (jenisLaporan === 'transaksi') {

            if (!window.canExportPdf) {
                toastr.error('Kamu tidak memiliki akses cetak PDF laporan');
                return;
            }

            $('#formLaporan')
                .attr('action', window.routeLaporanPdf)
                .submit();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK => EXCEL
        |--------------------------------------------------------------------------
        */
        if (jenisLaporan === 'barang_masuk') {

            if (!window.canExportExcel) {
                toastr.error('Kamu tidak memiliki akses cetak Excel laporan');
                return;
            }

            $('#formLaporan')
                .attr('action', window.routeLaporanExcel)
                .submit();

            return;
        }


        toastr.error('Jenis laporan tidak valid');
    });

});
