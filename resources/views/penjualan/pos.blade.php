@extends('layouts.app') 

@section('title', 'POS') 

@section('content') 
@if (session('errors')) 
    <div class="alert alert-danger"> 
        {{ session('errors') }} 
    </div> 
@endif 

<h4 class="mb-3"> 
    {{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }} 
</h4> 

<div class="row"> 
    {{-- ==================== PRODUK ==================== --}} 
    <div class="col-md-6"> 
        <div class="card"> 
            <div class="card-body" style="max-height:70vh; overflow:auto"> 
                <div class="mb-3"> 
                    <form method="GET" action="{{ $mode === 'edit' ? route('penjualan.edit', $sale->id) : route('penjualan.create') }}"> 
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk..." onkeyup="this.form.submit()"> 
                    </form> 
                </div> 
                
                @foreach($products as $product) 
                    <form method="POST" action="{{ route('itempenjualan.store') }}" class="row mb-2 align-items-center"> 
                        @csrf 
                        <input type="hidden" name="product_id" value="{{ $product->id }}"> 
                        
                        {{-- 🌟 PERBAIKAN: Tombol nama produk dimunculkan kembali tanpa elemen <img> --}}
                        <div class="col-7"> 
                            <button type="button" class="btn btn-outline-primary w-100 text-start p-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                                <div class="text-start text-truncate"> 
                                    <div class="fw-semibold text-truncate" title="{{ $product->nama }}">{{ $product->nama }}</div> 
                                    <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small> 
                                </div> 
                            </button> 
                        </div> 
                        
                        <div class="col-3"> 
                            <input type="number" name="quantity" value="1" min="1" class="form-control {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}"> 
                        </div> 
                        
                        <div class="col-2"> 
                            <button type="submit" class="btn btn-primary w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">+</button> 
                        </div> 
                    </form> 
                @endforeach 
            </div> {{-- Tutup card-body produk --}} 
        </div> {{-- Tutup card produk --}} 
    </div> {{-- Tutup col-md-6 produk --}} 

    {{-- ==================== KERANJANG ==================== --}} 
    <div class="col-md-6"> 
        <div class="card"> 
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
                                    <input type="number" name="quantity" value="{{ $item->kuantitas }}" class="form-control form-control-sm" onchange="this.form.submit()"> 
                                </form> 
                            </td> 
                            <td>Rp {{ number_format($item->subtotal) }}</td> 
                            <td> 
                                @can('delete', $item)
                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}"> 
                                    @csrf  @method('DELETE') 
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button> 
                                </form> 
                                @endcan
                            </td> 
                        </tr> 
                    @empty 
                        <tr> 
                            <td colspan="5" class="text-center text-muted">Keranjang masih kosong</td> 
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
                <form method="POST" action="{{ route('penjualan.checkout', $sale->id) }}" onsubmit="return confirm('Yakin ingin checkout?')" class="mt-2"> 
                    @csrf 
                    @method('PUT') 
                    
                    <select name="payment_method" class="form-select mb-2" required> 
                        <option value="">Pilih Pembayaran</option> 
                        <option value="CASH">Cash</option> 
                        <option value="QRIS">QRIS</option> 
                    </select> 
                    <button type="submit" class="btn btn-success w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                        Checkout 
                    </button> 
                </form> 
                
                {{-- Form Batalkan Transaksi --}}
                @can('delete', $sale)
                <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan transaksi?')"> 
                    @csrf 
                    @method('DELETE') 
                    <button type="submit" class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                        Batalkan Transaksi 
                    </button> 
                </form> 
                @endcan
            </div> {{-- Tutup card-footer --}} 
        </div> {{-- Tutup card keranjang --}} 
    </div> {{-- Tutup col-md-6 keranjang --}} 
</div> {{-- TUTUP INDUK UTAMA ROW DI PALING BAWAH --}} 
@endsection
