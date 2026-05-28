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


                {{-- Stok Menipis --}}
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
            @if($stokMenipis > 0)

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

                                            @foreach($barangStokMenipis->take(5) as $item)

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
                                                        @if($item->jumlah_barang == 0)

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

                            {{-- FILTER BULAN --}}
                            <form action="{{ route('dashboard.index') }}" method="GET" class="mb-3">

                                <div class="row">

                                    <div class="col-md-4">

                                        <label>Bulan</label>

                                        <select name="bulan" class="form-control">

                                            <option value="1" {{ $bulanDipilih == 1 ? 'selected' : '' }}>
                                                Januari
                                            </option>

                                            <option value="2" {{ $bulanDipilih == 2 ? 'selected' : '' }}>
                                                Februari
                                            </option>

                                            <option value="3" {{ $bulanDipilih == 3 ? 'selected' : '' }}>
                                                Maret
                                            </option>

                                            <option value="4" {{ $bulanDipilih == 4 ? 'selected' : '' }}>
                                                April
                                            </option>

                                            <option value="5" {{ $bulanDipilih == 5 ? 'selected' : '' }}>
                                                Mei
                                            </option>

                                            <option value="6" {{ $bulanDipilih == 6 ? 'selected' : '' }}>
                                                Juni
                                            </option>

                                            <option value="7" {{ $bulanDipilih == 7 ? 'selected' : '' }}>
                                                Juli
                                            </option>

                                            <option value="8" {{ $bulanDipilih == 8 ? 'selected' : '' }}>
                                                Agustus
                                            </option>

                                            <option value="9" {{ $bulanDipilih == 9 ? 'selected' : '' }}>
                                                September
                                            </option>

                                            <option value="10" {{ $bulanDipilih == 10 ? 'selected' : '' }}>
                                                Oktober
                                            </option>

                                            <option value="11" {{ $bulanDipilih == 11 ? 'selected' : '' }}>
                                                November
                                            </option>

                                            <option value="12" {{ $bulanDipilih == 12 ? 'selected' : '' }}>
                                                Desember
                                            </option>

                                        </select>

                                    </div>


                                    <div class="col-md-4">

                                        <label>Tahun</label>

                                        <select name="tahun" class="form-control">

                                            @for($tahun = now()->year; $tahun >= now()->year - 5; $tahun--)

                                                <option value="{{ $tahun }}" {{ $tahunDipilih == $tahun ? 'selected' : '' }}>

                                                    {{ $tahun }}

                                                </option>

                                            @endfor

                                        </select>

                                    </div>


                                    <div class="col-md-4 d-flex align-items-end">

                                        <button type="submit" class="btn btn-primary">

                                            <i class="fas fa-filter"></i>
                                            Tampilkan

                                        </button>

                                    </div>

                                </div>

                            </form>


                            <div class="row">
                                <div class="col-md-12">

                                    <p class="text-center">
                                        <strong>
                                            Periode: {{ $teksPeriode }}
                                        </strong>
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

        $(function () {

            var areaChartCanvas = $('#salesChart').get(0).getContext('2d');

            var labelTanggal = {!! json_encode($chartLabels) !!};

            var dataPendapatan = {!! json_encode($chartData) !!};

            var areaChartData = {
                labels: labelTanggal,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        type: 'line',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(60,141,188,0.4)',
                        borderColor: 'rgba(60,141,188,1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(60,141,188,1)',
                        data: dataPendapatan
                    }
                ]
            };

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }

                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y
                                        .toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
                            callback: function (value) {

                                if (parseInt(value) >= 1000) {
                                    return 'Rp ' + value
                                        .toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }

                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            };

            new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            });

        });

    </script>

@endpush
