@extends('Layout.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            Edit Barang Masuk

        </div>

        <div class="card-body">

            <form
                action="{{ route('barang-masuk.update', $barangMasuk->id_barang_masuk) }}"
                method="POST">

                @csrf
                @method('PUT')

                @foreach($barangMasuk->detailMasuk as $index => $item)

                <div class="border p-3 mb-3">

                    <div class="mb-2">

                        <strong>
                            {{ $item->barang->nama_barang }}
                        </strong>

                    </div>

                    <div class="mb-2">

                        Qty:
                        {{ $item->jumlah_barang }}

                    </div>

                    <div>

                        <label>Harga Beli</label>

                        <input
                            type="number"
                            name="harga_beli[]"
                            class="form-control"
                            value="{{ $item->harga_beli }}"
                            required>

                    </div>

                </div>

                @endforeach

                <button
                    type="submit"
                    class="btn btn-primary">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
