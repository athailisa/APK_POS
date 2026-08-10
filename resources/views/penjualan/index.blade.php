@extends('layouts.app') 

@section('title', 'Penjualan') 

@section('content') 

@include('layouts.navbar')

@if(session('errors'))
 <div class="alert alert-danger">
    {{ session('errors')}}
 </div>
 @endif

<h1>Halaman Penjualan</h1> 

<a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
    <div class="input-group"> 
        <input 
            type="text" 
            name="search" 
            value="{{ request()->search }}" 
            class="form-control" 
            placeholder="Search penjualan"
        > 
        <button class="btn btn-outline-secondary" type="submit"> 
            Search 
        </button> 
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
                <td>{{ $sale->metode_pembayaran }}</td> 
                <td>{{ $sale->status }}</td> 
                
            <td style="width: 240px; min-width: 240px;"> 
                <div class="d-flex align-items-center gap-1"> 
                    <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-primary">Detail</a> 
                    @can('view', $sale)                    
                      ||                     
                      <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>       
                           @endcan
                           @can('delete', $sale)
                       ||                    
                    <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline"> 
                        @csrf 
                        @method('DELETE') 
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')"> 
                            Hapus 
                        </button> 
                    </form> 
                    @endcan
                </div> 
            </td>

            </tr> 
            @empty 
            <tr> 
                <td colspan="8" class="text-center py-4">Data Tidak Ditemukan</td> 
            </tr> 
            @endforelse 
        </tbody> 
    </table> 
    {{ $sales->links() }} 
</div> 

@endsection
