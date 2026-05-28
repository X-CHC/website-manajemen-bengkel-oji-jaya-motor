@extends('layout.app')

@section('content')

    <section class="content pt-4">
        <div class="container-fluid">

            {{-- INFO BOX --}}
            <div class="row">

                {{-- Pendapatan Hari Ini --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">

                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Pendapatan Hari Ini
                            </span>

                            <span class="info-box-number">
                                Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>
                </div>


                {{-- Transaksi Hari Ini --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">

                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-shopping-cart"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Transaksi Hari Ini
                            </span>

                            <span class="info-box-number">
                                {{ $transaksiHariIni }}
                                <small>Nota</small>
                            </span>
                        </div>

                    </div>
                </div>


                {{-- Total Pelanggan --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">

                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-users text-white"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Total Pelanggan
                            </span>

                            <span class="info-box-number">
                                {{ $totalPelanggan }}
                                <small>Orang</small>
                            </span>
                        </div>

                    </div>
                </div>


                {{-- Stok Menipis - hanya Adming --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">

                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Stok Menipis
                            </span>

                            <span class="info-box-number">
                                {{ $stokMenipis }}
                                <small>Barang</small>
                            </span>
                        </div>

                    </div>
                </div>


            </div>


            {{-- DETAIL STOK MENIPIS --}}

            @if ($stokMenipis > 0)
                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-danger">

                            <div class="card-header">

                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Peringatan Stok Menipis
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">

                                        <i class="fas fa-minus"></i>

                                    </button>
                                </div>

                            </div>

                            <div class="card-body p-0">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover mb-0">

                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Stok Sekarang</th>
                                                <th>Batas Alert</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($barangStokMenipis->take(5) as $item)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        {{ $item->nama_barang }}
                                                    </td>

                                                    <td>
                                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $item->jumlah_barang }}
                                                    </td>

                                                    <td>
                                                        {{ $item->alert_jumlah_barang }}
                                                    </td>

                                                    <td>
                                                        @if ($item->jumlah_barang == 0)
                                                            <span class="badge badge-danger">
                                                                Habis
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                Menipis
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <div class="card-footer clearfix">

                                <div class="float-left text-muted mt-1">
                                    Menampilkan 5 dari {{ $stokMenipis }} barang yang stoknya menipis/habis.
                                </div>

                                <a href="{{ route('barang.index') }}" class="btn btn-sm btn-danger float-right">
                                    Lihat Data Barang
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="alert alert-success">
                    Semua stok barang masih aman.
                </div>
            @endif

            {{-- GRAFIK PENDAPATAN --}}
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header border-transparent">

                            <h5 class="card-title">
                                Grafik Pendapatan
                            </h5>

                            <div class="card-tools">

                                <button type="button" class="btn btn-tool" data-card-widget="collapse">

                                    <i class="fas fa-minus"></i>

                                </button>

                            </div>

                        </div>

                        <div class="card-body">

                            {{-- NAVIGASI BULAN TANPA REFRESH --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <button type="button" id="btnBulanSebelumnya" class="btn btn-outline-primary btn-sm">

                                    <i class="fas fa-chevron-left"></i>

                                </button>


                                <div class="text-center">

                                    <h5 class="mb-0" id="namaPeriodeGrafik">

                                        {{ \Carbon\Carbon::create($tahunDipilih, $bulanDipilih, 1)->translatedFormat('F Y') }}

                                    </h5>

                                    <small class="text-muted" id="teksPeriodeGrafik">

                                        Periode: {{ $teksPeriode }}

                                    </small>

                                </div>


                                <button type="button" id="btnBulanBerikutnya" class="btn btn-outline-primary btn-sm">

                                    <i class="fas fa-chevron-right"></i>

                                </button>

                            </div>


                            {{-- CHART --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="chart">
                                        <canvas id="salesChart" height="250" style="height: 250px;"></canvas>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


            {{-- TRANSAKSI, PELANGGAN, BARANG TERBARU --}}
            <div class="row">

                {{-- Transaksi Terbaru --}}
                <div class="col-md-8">

                    <div class="card">

                        <div class="card-header border-transparent bg-primary text-white">

                            <h3 class="card-title">
                                Transaksi Terbaru
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">

                                    <i class="fas fa-minus"></i>

                                </button>
                            </div>

                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table m-0 table-hover">

                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Pelanggan</th>
                                            <th>Tanggal</th>
                                            <th>Total Bayar</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($transaksiTerbaru as $trx)
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        {{ $trx->id_transaksi }}
                                                    </a>
                                                </td>

                                                <td>
                                                    {{ $trx->pelanggan->nama_pelanggan ?? $trx->nama_pelanggan_lain }}
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}
                                                </td>

                                                <td>
                                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                                </td>

                                                <td>
                                                    <span class="badge badge-success">
                                                        Selesai
                                                    </span>
                                                </td>
                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="5" class="text-center text-muted">

                                                    Belum ada transaksi

                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <div class="card-footer clearfix">

                            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-secondary float-right">

                                Lihat Semua Transaksi

                            </a>

                        </div>

                    </div>

                </div>


                {{-- Sidebar Kanan --}}
                <div class="col-md-4">

                    {{-- Pelanggan Terbaru --}}
                    <div class="card">

                        <div class="card-header bg-warning">

                            <h3 class="card-title">
                                Pelanggan Terbaru
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">

                                    <i class="fas fa-minus"></i>

                                </button>
                            </div>

                        </div>

                        <div class="card-body p-0">

                            <ul class="users-list clearfix">

                                @forelse($pelangganTerbaru as $plg)
                                    <li>
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($plg->nama_pelanggan) }}&background=random"
                                            alt="User Image">

                                        <a class="users-list-name" href="#">

                                            {{ $plg->nama_pelanggan }}

                                        </a>

                                        <span class="users-list-date">
                                            {{ \Carbon\Carbon::parse($plg->created_at)->diffForHumans() }}
                                        </span>
                                    </li>

                                @empty

                                    <li class="w-100 text-center py-3 text-muted">
                                        Belum ada pelanggan
                                    </li>
                                @endforelse

                            </ul>

                        </div>

                        <div class="card-footer text-center">

                            <a href="{{ route('pelanggan.index') }}">
                                Lihat Semua Pelanggan
                            </a>

                        </div>

                    </div>


                    {{-- Barang Terbaru --}}
                    <div class="card">

                        <div class="card-header bg-info">

                            <h3 class="card-title">
                                Barang Terbaru
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">

                                    <i class="fas fa-minus"></i>

                                </button>
                            </div>

                        </div>

                        <div class="card-body p-0">

                            <ul class="products-list product-list-in-card pl-2 pr-2">

                                @forelse($barangTerbaru as $brg)
                                    <li class="item">

                                        <div class="product-img">

                                            <span class="info-box-icon bg-secondary rounded"
                                                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">

                                                <i class="fas fa-box"></i>

                                            </span>

                                        </div>

                                        <div class="product-info">

                                            <a href="javascript:void(0)" class="product-title">

                                                {{ $brg->nama_barang }}

                                                <span class="badge badge-success float-right">
                                                    Rp {{ number_format($brg->harga_jual, 0, ',', '.') }}
                                                </span>

                                            </a>

                                            <span class="product-description">
                                                Sisa Stok: {{ $brg->jumlah_barang }} Pcs
                                            </span>

                                        </div>

                                    </li>

                                @empty

                                    <li class="item text-center text-muted py-3">
                                        Belum ada barang
                                    </li>
                                @endforelse

                            </ul>

                        </div>

                        <div class="card-footer text-center">

                            <a href="{{ route('barang.index') }}" class="uppercase">

                                Lihat Semua Barang

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(function() {

            /*
            |--------------------------------------------------------------------------
            | DATA AWAL DARI CONTROLLER
            |--------------------------------------------------------------------------
            */
            let bulanAktif = Number(@json($bulanDipilih));

            let tahunAktif = Number(@json($tahunDipilih));

            let labelTanggal = @json($chartLabels);

            let dataPendapatan = @json($chartData);

            let routeGrafik = "{{ route('dashboard.grafik2') }}";

            let chartPendapatan = null;


            /*
            |--------------------------------------------------------------------------
            | FORMAT RUPIAH
            |--------------------------------------------------------------------------
            */
            function formatRupiah(angka) {
                return 'Rp ' + angka
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }


            /*
            |--------------------------------------------------------------------------
            | BUAT / RENDER CHART
            |--------------------------------------------------------------------------
            */
            function renderChart(labels, data) {
                let areaChartCanvas = $('#salesChart').get(0).getContext('2d');

                let areaChartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        type: 'line',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(60,141,188,0.4)',
                        borderColor: 'rgba(60,141,188,1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(60,141,188,1)',
                        data: data
                    }]
                };

                let areaChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';

                                    if (label) {
                                        label += ': ';
                                    }

                                    if (context.parsed.y !== null) {
                                        label += formatRupiah(context.parsed.y);
                                    }

                                    return label;
                                }
                            }
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },

                        y: {
                            beginAtZero: true,

                            ticks: {
                                callback: function(value) {
                                    return formatRupiah(value);
                                }
                            }
                        }
                    }
                };

                if (chartPendapatan !== null) {
                    chartPendapatan.destroy();
                }

                chartPendapatan = new Chart(areaChartCanvas, {
                    type: 'line',
                    data: areaChartData,
                    options: areaChartOptions
                });
            }


            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA GRAFIK TANPA REFRESH
            |--------------------------------------------------------------------------
            */
            function ambilDataGrafik(bulan, tahun) {
                $('#btnBulanSebelumnya').prop('disabled', true);

                $('#btnBulanBerikutnya').prop('disabled', true);

                fetch(routeGrafik + '?bulan=' + bulan + '&tahun=' + tahun, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(result) {

                        bulanAktif = Number(result.bulan);

                        tahunAktif = Number(result.tahun);

                        $('#namaPeriodeGrafik').text(result.namaPeriode);

                        $('#teksPeriodeGrafik').text('Periode: ' + result.teksPeriode);

                        renderChart(result.labels, result.data);
                    })
                    .catch(function(error) {

                        alert('Gagal mengambil data grafik');

                        console.log(error);
                    })
                    .finally(function() {

                        $('#btnBulanSebelumnya').prop('disabled', false);

                        $('#btnBulanBerikutnya').prop('disabled', false);
                    });
            }


            /*
            |--------------------------------------------------------------------------
            | TOMBOL BULAN SEBELUMNYA
            |--------------------------------------------------------------------------
            */
            $('#btnBulanSebelumnya').click(function() {

                bulanAktif--;

                if (bulanAktif < 1) {
                    bulanAktif = 12;

                    tahunAktif--;
                }

                ambilDataGrafik(bulanAktif, tahunAktif);
            });


            /*
            |--------------------------------------------------------------------------
            | TOMBOL BULAN BERIKUTNYA
            |--------------------------------------------------------------------------
            */
            $('#btnBulanBerikutnya').click(function() {

                bulanAktif++;

                if (bulanAktif > 12) {
                    bulanAktif = 1;

                    tahunAktif++;
                }

                ambilDataGrafik(bulanAktif, tahunAktif);
            });


            /*
            |--------------------------------------------------------------------------
            | RENDER CHART PERTAMA
            |--------------------------------------------------------------------------
            */
            renderChart(labelTanggal, dataPendapatan);

        });
    </script>
@endpush
