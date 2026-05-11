@extends('layout.app')

@section('content')
<section class="content pt-4">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pendapatan Hari Ini</span>
                        <span class="info-box-number">
                            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Transaksi Hari Ini</span>
                        <span class="info-box-number">{{ $transaksiHariIni }} <small>Nota</small></span>
                    </div>
                </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users text-white"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pelanggan</span>
                        <span class="info-box-number">{{ $totalPelanggan }} <small>Orang</small></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stok Menipis</span>
                        <span class="info-box-number">{{ $stokMenipis }} <small>Barang</small></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h5 class="card-title">Grafik Pendapatan Bulan Ini</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Periode: {{ $teksPeriode }}</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="salesChart" height="250" style="height: 250px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header border-transparent bg-primary text-white">
                        <h3 class="card-title">Transaksi Terbaru</h3>
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
                                        <td><a href="#">{{ $trx->id_transaksi }}</a></td>
                                        <td>{{ $trx->pelanggan->nama_pelanggan ?? $trx->nama_pelanggan_lain }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                        <td><span class="badge badge-success">Selesai</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada transaksi</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="#" class="btn btn-sm btn-secondary float-right">Lihat Semua Transaksi</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">Pelanggan Terbaru</h3>
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($plg->nama_pelanggan) }}&background=random" alt="User Image">
                                <a class="users-list-name" href="#">{{ $plg->nama_pelanggan }}</a>
                                <span class="users-list-date">{{ \Carbon\Carbon::parse($plg->created_at)->diffForHumans() }}</span>
                            </li>
                            @empty
                                <li class="w-100 text-center py-3 text-muted">Belum ada pelanggan</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#">Lihat Semua Pelanggan</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Barang Terbaru</h3>
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
                                    <span class="info-box-icon bg-secondary rounded" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-box"></i>
                                    </span>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{ $brg->nama_barang }}
                                        <span class="badge badge-success float-right">Rp {{ number_format($brg->harga_jual, 0, ',', '.') }}</span>
                                    </a>
                                    <span class="product-description">
                                        Sisa Stok: {{ $brg->jumlah_barang }} Pcs
                                    </span>
                                </div>
                            </li>
                            @empty
                            <li class="item text-center text-muted py-3">Belum ada barang</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="uppercase">Lihat Semua Barang</a>
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
$(function () {
    var areaChartCanvas = $('#salesChart').get(0).getContext('2d');

    var labelTanggal = {!! json_encode($chartLabels) !!};
    var dataPendapatan = {!! json_encode($chartData) !!};

    var areaChartData = {
        labels: labelTanggal,
        datasets: [
            {
                label               : 'Pendapatan (Rp)',
                // Konfigurasi ini yang membuat efek bergelombang dan area isian warna
                type                : 'line',
                tension             : 0.4, // Memberikan efek kurva/gelombang yang smooth
                fill                : true, // Mengisi area di bawah garis
                backgroundColor     : 'rgba(60,141,188,0.4)', // Warna isian biru semi transparan
                borderColor         : 'rgba(60,141,188,1)', // Warna garis tepi biru solid
                pointRadius         : 3, // Ukuran titik
                pointBackgroundColor: 'rgba(60,141,188,1)',
                data                : dataPendapatan
            }
        ]
    }

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        plugins: {
            legend: {
                display: false // Disembunyikan agar tampilan mirip bawaan AdminLTE
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += 'Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false // Menghilangkan garis bantu vertikal agar lebih bersih
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        if(parseInt(value) >= 1000){
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        } else {
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    }

    new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
    });
});
</script>
@endpush
