<!-- memanggil file app.blade.php --> 
@extends('layouts.app') 

<!-- mengirimkan nilai ke title untuk ditampilkan --> 
@section('title', 'Login') 

<!-- batas awal isi konten --> 
@section('content') 
@include('layouts.navbar') 

<div class="text-center"> 
    <h1> Ringkasan Hari Ini <small class="text-muted">({{ \Carbon\Carbon::today()->locale('id')->isoFormat('dddd, D MMMM YYYY') }})</small> </h1> 

    <!-- 1. KUNCI PEMBUKA: HANYA ADMIN (ROLE 1) YANG BISA MELIHAT BLOK KEUANGAN INI -->
    @if(auth()->user()->role_id === 1)
        <!-- KOTAK SALES --> 
        <div class="row"> 
            <div class="col-md-12"> 
                <h1>Today's Sales</h1> 
            </div> 
            <div class="col-md-6"> 
                <div class="card"> 
                    <div class="card-header"> Total Nilai Penjualan Hari ini </div> 
                    <div class="card-body"> 
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_penjualan']) }}</h5> 
                    </div> 
                </div> 
            </div> 
            <div class="col-md-6"> 
                <div class="card"> 
                    <div class="card-header"> Jumlah Transaksi Hari Ini </div> 
                    <div class="card-body"> 
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_transaksi']) }}</h5> 
                    </div> 
                </div> 
            </div> 
        </div> 

        <!-- KOTAK CASH STATUS --> 
        <div class="row"> 
            <div class="col-md-12"> 
                <h1>Cash & Payment Status</h1> 
            </div> 
            <div class="col-md-6"> 
                <div class="card"> 
                    <div class="card-header"> Total Pembayaran Tunai </div> 
                    <div class="card-body"> 
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_cash']) }}</h5> 
                    </div> 
                </div> 
            </div> 
            <div class="col-md-6"> 
                <div class="card"> 
                    <div class="card-header"> Total Pembayaran non-Tunai </div> 
                    <div class="card-body"> 
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_non_tunai']) }}</h5> 
                    </div> 
                </div> 
            </div> 
        </div> 
    @endif
    <!-- 2. KUNCI PENUTUP: BATAS AKHIR KEUANGAN YANG DISEMBUNYIKAN DARI KASIR -->

    <!-- CRITICAL INVENTORY (BISA DILIHAT ADMIN & KASIR) --> 
    <div class="row"> 
        <div class="col-md-12"> 
            <h1>Critical Inventory Status</h1> 
        </div> 
        <div class="col-md-6"> 
            <h3>Daftar produk stok rendah</h3> 
            <table class="table"> 
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
                        <td>{{ $produk->stok }}</td> 
                    </tr> 
                    @empty 
                    <tr> 
                        <td colspan="3" class="text-muted text-center"> Seluruh produk berada dalam kondisi stok aman. </td> 
                    </tr> 
                    @endforelse 
                </tbody> 
            </table> 
            {{ $produkStokRendah->withQueryString()->links() }} 
        </div> 

        <div class="col-md-6"> 
            <h3>Produk habis stok</h3> 
            <table class="table"> 
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
                        <td>{{ $produk->stok }}</td> 
                    </tr> 
                    @empty 
                    <tr> 
                        <td colspan="3" class="text-muted text-center"> Seluruh produk berada dalam kondisi stok aman. </td> 
                    </tr> 
                    @endforelse 
                </tbody> 
            </table> 
            {{ $produkStokHabis->withQueryString()->links() }} 
        </div> 
    </div> 

    <!-- BEST SELLER (BISA DILIHAT ADMIN & KASIR) --> 
    <div class="row"> 
        <div class="col-md-12"> 
            <h1>Best Seller Products</h1> 
        </div> 
        <div class="col-md-12"> 
            <table class="table"> 
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
                        <td>{{ $produk->total_terjual }}</td> 
                    </tr> 
                    @empty 
                    <tr> 
                        <td colspan="3" class="text-muted text-center"> Seluruh produk berada dalam kondisi stok aman. </td> 
                    </tr> 
                    @endforelse 
                </tbody> 
            </table> 
        </div> 
    </div> 
</div> 
<!-- batas Akhir isi konten --> 
@endsection
