@extends('layouts.app') 

@section('title', 'Produk') 

@section('content') 

@include('layouts.navbar') 

<h1>Halaman Produk</h1> 

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('errors'))
    <div class="alert alert-danger">
        {{ session('errors') }}
    </div>
@endif

@can('create', App\Models\Produk::class) 

<div class="mb-3"> 
    <a href="{{ route('produk.create') }}" class="btn btn-primary">create</a> 
</div> 
@endcan 

<form action="{{ route('produk.index') }}" method="GET" class="mb-3"> 
    <div class="input-group"> 
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search nama produk"> 
        <button class="btn btn-outline-secondary" type="submit"> Search </button> 
    </div> 
</form> 

<div class="table-responsive"> 
    <table class="table align-middle"> 
        <thead> 
            <tr> 
                <th scope="col">#</th> 
                <th scope="col">User</th> 
                <th scope="col">Foto</th> 
                <th scope="col">Nama</th> 
                <th scope="col">Harga Beli</th> 
                <th scope="col">Harga Jual</th> 
                <th scope="col">Stok</th> 
                <th scope="col" class="text-center" style="width: 160px;">Aksi</th> 
            </tr> 
        </thead> 
        <tbody> 
            @forelse ($products as $product) 
            <tr> 
                <th scope="row">{{ $products->firstItem() + $loop->index }}</th> 
                <td>{{ $product->user->name }}</td> 
                
                <!-- PERBAIKAN: Memanggil foto dari storage agar tidak pecah lagi -->
                <td> 
                    @if ($product->foto)
                        <img src="{{ asset('storage/' . $product->foto) }}" width="40" height="40" class="img-thumbnail" alt="Foto">
                    @else
                        <span class="text-muted">No Photo</span>
                    @endif
                </td> 
                
                <td>{{ $product->nama }}</td> 
                <td>{{ $product->harga_beli }}</td> 
                <td>{{ $product->harga_jual }}</td> 
                <td>{{ $product->stok }}</td> 
                <td class="align-middle"> 
                    <div class="d-flex align-items-center gap-1 py-1"> 
                        @can('view', $product) 
                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-sm btn-primary text-white">Detail</a> 
                        @endcan 
                        
                        @can('update', $product) 
                        <span class="text-muted mx-1">||</span> 
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a> 
                        @endcan 
                        
                        @can('delete', $product) 
                        <span class="text-muted mx-1">||</span> 
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline m-0"> 
                            @csrf 
                            @method('DELETE') 
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')"> 
                                Hapus 
                            </button> 
                        </form> 
                        @endcan 
                    </div> 
                </td> 
            </tr> 
            @empty 
            <tr> 
                <td colspan="8"><h1 class="text-center">Data tidak tersedia.</h1></td> 
            </tr> 
            @endforelse 
        </tbody> 
    </table> 
</div> 

{{ $products->links() }} 

@endsection
