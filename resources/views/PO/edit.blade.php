@extends('Layout.app')

@section('title', 'Edit Purchase Order')

@section('content')
<div class="container-fluid pt-4">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Purchase Order ({{ $po->id_po }})</h3>
        </div>

        <form action="{{ route('po.update', $po->id_po) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                {{-- MITRA --}}
                <div class="form-group mb-4">
                    <label for="mitra_po">Mitra / Supplier</label>
                    <input type="text" name="mitra_po" id="mitra_po"
                           class="form-control @error('mitra_po') is-invalid @enderror"
                           value="{{ old('mitra_po', $po->mitra_po) }}" required>
                    @error('mitra_po')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <hr>
                <h5>Daftar Barang dalam PO</h5>
                <p class="text-muted small">Silakan ubah jumlah pesanan jika diperlukan.</p>

                {{-- DETAIL BARANG --}}
                <div class="row">
                    @foreach($po->detailPo as $index => $item)
                    <div class="col-md-6">
                        <div class="card card-outline card-secondary mb-3">
                            <div class="card-body">
                                <input type="hidden" name="id_detail_po[]" value="{{ $item->id_detail_po }}">

                                <div class="form-group mb-0">
                                    <label class="d-block">{{ $item->barang->nama_barang }}</label>
                                    <div class="input-group">
                                        <input type="number" name="jumlah_po[]"
                                               class="form-control"
                                               value="{{ $item->jumlah_po }}"
                                               min="1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Pcs</span>
                                        </div>
                                    </div>
                                    <small class="text-info">Stok saat ini di gudang: {{ $item->barang->jumlah_barang }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('po.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
