@extends('layouts.app') 

@section('title', 'Detail Produk') 

@section('content') 
@include('layouts.navbar') 

<div class="container mt-4"> 
    <h1 class="mb-4">Detail Produk</h1> 
    
    <div class="mb-3"> 
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a> 
    </div> 

    <!-- Tampilan detail berbentuk Card Bootstrap sesuai tugas tambahan gurumu --> 
    <div class="card" style="max-width: 540px;"> 
        <div class="row g-0"> 
            
            <!-- Sisi Kiri: Kotak Gambar Kecil Bawaan Modul --> 
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light p-2"> 
                <!-- PERBAIKAN: Membuka akses folder storage dan menambah pengkondisian jika foto kosong -->
                @if ($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}" width="80" height="80" class="img-thumbnail" alt="Foto Mawar"> 
                @else
                    <span class="text-muted small">No Photo</span>
                @endif
            </div> 

            <!-- Sisi Kanan: Informasi Lengkap Teks Produk --> 
            <div class="col-md-8"> 
                <div class="card-body"> 
                    <h5 class="card-title fw-bold text-primary">{{ $produk->nama }}</h5> 
                    <hr> 
                    <p class="card-text"><strong>Harga Beli:</strong> {{ $produk->harga_beli }}</p> 
                    <p class="card-text"><strong>Harga Jual:</strong> {{ $produk->harga_jual }}</p> 
                    <p class="card-text"><strong>Stok Tersedia:</strong> {{ $produk->stok }}</p> 
                    <p class="card-text"><small class="text-muted">Petugas Input: {{ $produk->user->name ?? '-' }}</small></p> 
                </div> 
            </div> 
            
        </div> 
    </div> 
</div> 
@endsection
