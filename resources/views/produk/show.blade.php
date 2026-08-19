@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0">Detail Produk</h3>
</div>

<div class="card" style="max-width: 600px;">
    <div class="row g-0">

        <div class="col-md-5 d-flex align-items-center justify-content-center bg-light p-3">
            @if ($produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}" class="img-fluid rounded"
                style="max-height: 220px; object-fit: cover;" alt="{{ $produk->nama }}">
            @else
            <div class="text-center text-muted">
                <i class="bi bi-cup-hot" style="font-size: 3rem;"></i>
                <div class="small mt-1">Belum ada foto</div>
            </div>
            @endif
        </div>

        <div class="col-md-7">
            <div class="card-body">
                <h4 class="fw-bold" style="color:var(--dbk-accent-dark);">{{ $produk->nama }}</h4> @if ($produk->jenis)
                <span class="badge bg-secondary mb-2">{{ $produk->jenis->nama }}</span>
                @endif
                <hr>
                <div class="mb-2">
                    <span class="text-muted small d-block">Harga Beli</span>
                    <span class="fw-semibold">Rp {{ number_format($produk->harga_beli) }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-muted small d-block">Harga Jual</span>
                    <span class="fw-semibold">Rp {{ number_format($produk->harga_jual) }}</span>
                </div>
                <div class="mb-3">
                    <span class="text-muted small d-block">Stok Tersedia</span>
                    <span
                        class="badge {{ $produk->stok > 10 ? 'bg-success' : ($produk->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $produk->stok }}
                    </span>
                </div>
                <p class="text-muted small mb-0">Petugas Input: {{ $produk->user->name ?? '-' }}</p>
            </div>
        </div>

    </div>
</div>
@endsection