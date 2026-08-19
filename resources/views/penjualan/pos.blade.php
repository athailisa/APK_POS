@extends('layouts.app')

@section('title', 'POS')

@section('content')
@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif

<h4 class="mb-3">
    <i class="bi bi-cart-check"></i> {{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
</h4>

<div class="row">
    {{-- ==================== PRODUK ==================== --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-shop me-1"></i> Daftar Produk
            </div>
            <div class="card-body" style="max-height:70vh; overflow:auto">
                <div class="mb-3">
                    <form method="GET"
                        action="{{ $mode === 'edit' ? route('penjualan.edit', $sale->id) : route('penjualan.create') }}">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari produk..." onkeyup="this.form.submit()">
                        </div>
                    </form>
                </div>

                <div class="row g-3">
                    @foreach($products as $product)
                    <div class="col-6">
                        <form method="POST" action="{{ route('itempenjualan.store') }}" class="h-100">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div
                                class="card h-100 product-card {{ ($sale->status === 'COMPLETED' || $product->stok <= 0) ? 'opacity-50' : '' }}">
                                <div class="position-relative">
                                    @if ($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top"
                                        style="height:170px; object-fit:contain; background-color:#F7F1EA; padding:8px;"
                                        alt="{{ $product->nama }}">
                                    @else
                                    <div class="d-flex align-items-center justify-content-center bg-light"
                                        style="height:170px;">
                                        <i class="bi bi-cup-hot text-muted" style="font-size: 2.8rem;"></i>
                                    </div>
                                    @endif
                                    <span
                                        class="badge stock-badge {{ $product->stok > 10 ? 'bg-success' : ($product->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ $product->stok }} tersisa
                                    </span>
                                </div>

                                <div class="card-body p-3">
                                    <div class="fw-semibold text-truncate mb-1" title="{{ $product->nama }}">
                                        {{ $product->nama }}</div>
                                    <div class="mb-3" style="color:var(--dbk-accent-dark); font-weight:600;">Rp
                                        {{ number_format($product->harga_jual) }}</div>

                                    <div class="qty-stepper">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="form-control form-control-sm"
                                            {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            {{ ($sale->status === 'COMPLETED' || $product->stok <= 0) ? 'disabled' : '' }}>
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div> {{-- Tutup card-body produk --}}
        </div> {{-- Tutup card produk --}}
    </div> {{-- Tutup col-md-6 produk --}}

    {{-- ==================== KERANJANG ==================== --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-cart3 me-1"></i> Keranjang Belanja
            </div>
            <table class="table table-bordered mb-0 w-100">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sale->itemPenjualan as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>Rp {{ number_format($item->produk->harga_jual) }}</td>
                        <td>
                            <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->kuantitas }}"
                                    class="form-control form-control-sm" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->subtotal) }}</td>
                        <td>
                            @can('delete', $item)
                            <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state py-3">
                                <i class="bi bi-cart-x"></i>
                                Keranjang masih kosong
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="card-footer bg-white pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-dark fw-bold">Total:</span>
                    <strong class="fs-5">Rp {{ number_format($sale->total_pembayaran) }}</strong>
                </div>

                {{-- Form Checkout Selesai Transaksi --}}
                <form method="POST" action="{{ route('penjualan.checkout', $sale->id) }}"
                    onsubmit="return confirm('Yakin ingin checkout?')" class="mt-2">
                    @csrf
                    @method('PUT')

                    <select name="payment_method" class="form-select mb-2" required>
                        <option value="">Pilih Pembayaran</option>
                        <option value="CASH">Cash</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                    <button type="submit"
                        class="btn btn-success w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                        Checkout
                    </button>
                </form>

                {{-- Form Batalkan Transaksi --}}
                @can('delete', $sale)
                <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                        Batalkan Transaksi
                    </button>
                </form>
                @endcan

                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary w-100 mt-2">
                    Kembali
                </a>
            </div> {{-- Tutup card-footer --}}
        </div> {{-- Tutup card keranjang --}}
    </div> {{-- Tutup col-md-6 keranjang --}}
</div> {{-- TUTUP INDUK UTAMA ROW DI PALING BAWAH --}}
@endsection