<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard')

<!-- batas awal isi konten -->
@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0">Ringkasan Hari Ini</h3>
    <p class="text-muted">{{ \Carbon\Carbon::today()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
</div>

<!-- 1. KUNCI PEMBUKA: HANYA ADMIN (ROLE 1) YANG BISA MELIHAT BLOK KEUANGAN INI -->
@if(auth()->user()->role_id === 1)
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-cash-coin me-1"></i>Total Penjualan</div>
                <h4 class="fw-bold mb-0">Rp {{ number_format($ringkasan['total_penjualan']) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-receipt me-1"></i>Jumlah Transaksi</div>
                <h4 class="fw-bold mb-0">{{ number_format($ringkasan['total_transaksi']) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-wallet2 me-1"></i>Pembayaran Tunai</div>
                <h4 class="fw-bold mb-0">Rp {{ number_format($ringkasan['total_cash']) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-qr-code me-1"></i>Pembayaran Non-Tunai</div>
                <h4 class="fw-bold mb-0">Rp {{ number_format($ringkasan['total_non_tunai']) }}</h4>
            </div>
        </div>
    </div>
</div>
@endif
<!-- 2. KUNCI PENUTUP: BATAS AKHIR KEUANGAN YANG DISEMBUNYIKAN DARI KASIR -->

<!-- CRITICAL INVENTORY (BISA DILIHAT ADMIN & KASIR) -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-exclamation-triangle text-warning me-1"></i> Stok Menipis
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkStokRendah as $index => $produk)
                        <tr>
                            <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $produk->stok }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center"> Seluruh produk berada dalam kondisi stok
                                aman. </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $produkStokRendah->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-x-circle text-danger me-1"></i> Stok Habis
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkStokHabis as $index => $produk)
                        <tr>
                            <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td><span class="badge bg-danger">{{ $produk->stok }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center"> Seluruh produk berada dalam kondisi stok
                                aman. </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $produkStokHabis->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- BEST SELLER (BISA DILIHAT ADMIN & KASIR) -->
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-trophy text-warning me-1"></i> Produk Terlaris
    </div>
    <div class="card-body">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Unit Terjual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produkTerlaris as $produk)
                <tr>
                    <td>{{ $produk->nama }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td><span class="badge bg-success">{{ $produk->total_terjual }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-muted text-center"> Belum ada data penjualan. </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- batas Akhir isi konten -->
@endsection