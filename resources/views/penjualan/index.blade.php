@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@if(session('errors'))
<div class="alert alert-danger">
    {{ session('errors')}}
</div>
@endif

<h1><i class="bi bi-receipt"></i> Halaman Penjualan</h1>

<a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
    <div class="input-group" style="max-width: 400px;">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="text" name="search" value="{{ request()->search }}" class="form-control"
            placeholder="Cari nama kasir...">
    </div>
</form>

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

                <td style="width: 240px; min-width: 240px;">
                    <div class="d-flex align-items-center gap-1">
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-eye"></i> Detail</a>
                            @can('view', $sale)
                            <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-warning"><i
                                    class="bi bi-pencil"></i> Edit</a>
                            @endcan
                            @can('delete', $sale)
                            <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                            @endcan
                        </div>
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