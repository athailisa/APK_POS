@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@if(session('errors'))
<div class="alert alert-danger">
    {{ session('errors')}}
</div>
@endif

<h1><i class="bi bi-receipt"></i> Halaman Penjualan</h1>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Transaksi Baru
    </a>

    <form action="{{ route('penjualan.index') }}" method="GET" style="min-width: 260px;">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                placeholder="Cari nama kasir...">
        </div>
    </form>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal Transaksi</th>
                <th scope="col">Kasir</th>
                <th scope="col">Produk</th>
                <th scope="col">Total Pembayaran</th>
                <th scope="col">Metode Pembayaran</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <th scope="row">{{ ($sales->firstItem() + $loop->index) }}</th>

                <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>
                    @foreach($sale->itemPenjualan as $item)
                    {{ $item->produk->nama }} ({{ $item->kuantitas }})@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>Rp. {{ number_format($sale->total_pembayaran) }}</td>
                <td>
                    <span class="badge {{ $sale->metode_pembayaran === 'CASH' ? 'bg-secondary' : 'bg-dark' }}">
                        <i class="bi {{ $sale->metode_pembayaran === 'CASH' ? 'bi-cash' : 'bi-qr-code' }}"></i>
                        {{ $sale->metode_pembayaran }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $sale->status === 'COMPLETED' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $sale->status === 'COMPLETED' ? 'Selesai' : 'Berlangsung' }}
                    </span>
                </td>

                <td style="width: 140px; min-width: 140px;">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('penjualan.show', $sale->id) }}" class="btn-icon btn-icon-primary"
                            title="Detail" data-bs-toggle="tooltip">
                            <i class="bi bi-eye"></i>
                        </a>
                        @can('view', $sale)
                        <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn-icon btn-icon-warning"
                            title="Edit" data-bs-toggle="tooltip">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan
                        @can('delete', $sale)
                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-icon btn-icon-danger" title="Hapus" data-bs-toggle="tooltip"
                                onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        Belum ada transaksi penjualan.
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $sales->links() }}
</div>

@endsection