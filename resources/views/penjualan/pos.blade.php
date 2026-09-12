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
                            <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
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

 {{-- ================== FORM CHECKOUT ================== --}}
<form method="POST" action="{{ route('penjualan.update', $sale->id) }}"
    onsubmit="return confirm('Yakin ingin checkout?');" id="checkoutForm"
    data-total="{{ $sale->total_pembayaran }}">
    @csrf
    @method('PUT')

    <select name="payment_method" id="paymentMethod" class="form-select mb-3 @error('payment_method') is-invalid @enderror">
        <option value="">Pilih Pembayaran</option>
        <option value="CASH" {{ old('payment_method') === 'CASH' ? 'selected' : '' }}>Cash</option>
        <option value="QRIS" {{ old('payment_method') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
        <option value="BAYAR_NANTI" {{ old('payment_method') === 'BAYAR_NANTI' ? 'selected' : '' }}>Bayar Nanti</option>
    </select>
    @error('payment_method')
        <div class="text-danger small mb-2">{{ $message }}</div>
    @enderror

    {{-- Wrapper Input Cash --}}
    <div id="cashInputWrapper" class="mb-3 d-none">
        <label class="form-label small fw-semibold">Uang Dibayar</label>
        <input type="text" inputmode="numeric" name="uang_dibayar" id="uangDibayar"
        class="form-control mb-2 @error('uang_dibayar') is-invalid @enderror"
        placeholder="Masukkan jumlah uang tunai"
        value="{{ old('uang_dibayar') }}"
        autocomplete="off">
        @error('uang_dibayar')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror

        <label class="form-label small fw-semibold">Kembalian</label>
        <input type="text" id="kembalianDisplay" class="form-control" readonly value="Rp 0">
        <div id="kurangInfo" class="text-danger small mt-1 d-none"></div>
        <input type="hidden" name="kembalian" id="kembalianInput" value="0">
    </div>

    {{-- Wrapper Info QRIS --}}
    <div id="qrisInfoWrapper" class="mb-3 d-none">
        <div class="card bg-light border-0 p-3 text-center">
            <span class="small fw-semibold text-muted mb-2">Scan QRIS di bawah ini:</span>
            <img src="{{ asset('images/qr code.png') }}" alt="QRIS Code" class="img-fluid mx-auto mb-2" style="max-height: 180px;">
            <span class="small text-secondary">Silakan scan menggunakan aplikasi e-wallet atau m-banking.</span>
        </div>
    </div>

    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
        Checkout
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethod = document.getElementById('paymentMethod');
    const cashInputWrapper = document.getElementById('cashInputWrapper');
    const qrisInfoWrapper = document.getElementById('qrisInfoWrapper');
    const uangDibayar = document.getElementById('uangDibayar');
    const kembalianDisplay = document.getElementById('kembalianDisplay');
    const kembalianInput = document.getElementById('kembalianInput');
    const kurangInfo = document.getElementById('kurangInfo');
    const checkoutForm = document.getElementById('checkoutForm');
    
    if (!paymentMethod) return;

    const total = parseFloat(checkoutForm.dataset.total) || 0;

    function togglePaymentInputs() {
        // Logika untuk Cash
        if (paymentMethod.value === 'CASH') {
            cashInputWrapper.classList.remove('d-none');
        } else {
            cashInputWrapper.classList.add('d-none');
            if (uangDibayar) uangDibayar.value = '';
        }

        // Logika untuk QRIS
        if (paymentMethod.value === 'QRIS') {
            qrisInfoWrapper.classList.remove('d-none');
        } else {
            qrisInfoWrapper.classList.add('d-none');
        }
    }

    paymentMethod.addEventListener('change', togglePaymentInputs);
    togglePaymentInputs(); // Jalankan saat halaman dimuat

    if (uangDibayar) {
        uangDibayar.addEventListener('input', function () {
            let val = parseFloat(this.value.replace(/[^0-9]/g, '')) || 0;
            let kembalian = val - total;

            if (val < total && val > 0) {
                kurangInfo.textContent = 'Uang tunai kurang dari total pembayaran!';
                kurangInfo.classList.remove('d-none');
                kembalianDisplay.value = 'Rp 0';
                kembalianInput.value = 0;
            } else {
                kurangInfo.classList.add('d-none');
                let kembalianFinal = val >= total ? kembalian : 0;
                kembalianDisplay.value = 'Rp ' + kembalianFinal.toLocaleString('id-ID');
                kembalianInput.value = kembalianFinal;
            }
        });
    }
});
</script>
@endsection