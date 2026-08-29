@extends('Layout.app')

@section('title', 'Data Transaksi')

@section('content')

@php
    $canCetakTransaksi = punyaAksesMenu('transaksi.cetak', auth()->user());
    $canCreateTransaksi = punyaAksesMenu('transaksi.create', auth()->user());
    $canExportTransaksiExcel = punyaAksesMenu('transaksi.export-excel', auth()->user());
@endphp

<div class="container-fluid pt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Transaksi</h4>

        <div class="d-flex">
            @if($canCreateTransaksi)
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary mr-2">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            @endif

            @if($canExportTransaksiExcel)
                <a href="{{ route('transaksi.export-excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Cetak Excel
                </a>
            @endif
        </div>
    </div>

    {{-- CARD --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Transaksi</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tableTransaksi" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Uang Bayar</th>
                            <th>Kembalian</th>
                            <th>Jumlah Item</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pelanggan?->nama_pelanggan ?? $item->nama_pelanggan_lain }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->uang_bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->uang_kembali, 0, ',', '.') }}</td>
                            <td>{{ $item->detailTransaksi->count() }} Barang</td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- TOMBOL DETAIL --}}
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail{{ $item->id_transaksi }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- TOMBOL CETAK --}}
                                    @if($canCetakTransaksi)
                                        <a href="{{ route('transaksi.cetak', $item->id_transaksi) }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{--
  PENTING:
  Modal diletakkan DI LUAR tabel agar tidak merusak struktur HTML DataTables.
  Kita buat looping terpisah untuk modalnya.
--}}
@foreach($transaksi as $item)
<div class="modal fade" id="detail{{ $item->id_transaksi }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi ({{ $item->id_transaksi }})</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            {{-- Detail Barang --}}
                            @forelse($item->detailTransaksi as $detail)
                            <tr>
                                <td>Barang</td>
                                <td>{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                                <td>{{ $detail->jumlah_barang }}</td>
                                <td>Rp {{ number_format($detail->harga_barang,0,',','.') }}</td>
                                <td>Rp {{ number_format($detail->sub_total,0,',','.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada barang.</td>
                            </tr>
                            @endforelse

                            {{-- Jasa --}}
                            @if($item->harga_jasa > 0)
                            <tr class="table-center">
                                <td>Jasa</td>
                                <td>Biaya Servis</td>
                                <td>1</td>
                                <td>Rp {{ number_format($item->harga_jasa,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->harga_jasa,0,',','.') }}</td>
                            </tr>
                            @endif

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total Transaksi</td>
                                <td>Rp {{ number_format($item->total_harga,0,',','.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
$(function(){
    $('#tableTransaksi').DataTable({
        responsive: true,
        autoWidth: false,
    });
});
</script>
@endpush
