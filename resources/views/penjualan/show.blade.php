@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
@include('layouts.navbar')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Detail Transaksi #{{ $penjualan->id }}</h4>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row">
        {{-- Ringkasan Informasi Transaksi --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white fw-bold">Data Transaksi</div>
                <div class="card-body">
                    <table class="table table-borderless sm mb-0">
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>: {{ $penjualan->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kasir</strong></td>
                            <td>: {{ $penjualan->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Metode</strong></td>
                            <td>: <span class="badge bg-info">{{ $penjualan->metode_pembayaran }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <span class="badge {{ $penjualan->status === 'COMPLETED' ? 'bg-success' : 'bg-warning' }}">{{ $penjualan->status }}</span></td>
                        </tr>
                        <tr class="border-top">
                            <td><strong class="fs-5">Total</strong></td>
                            <td>: <strong class="fs-5 text-primary">Rp {{ number_format($penjualan->total_pembayaran) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Daftar Item Produk yang Dibeli --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white fw-bold">Produk Yang Dibeli</div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualan->itemPenjualan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->produk->nama }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_satuan) }}</td>
                                    <td class="text-center">{{ $item->kuantitas }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada produk dalam transaksi ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
