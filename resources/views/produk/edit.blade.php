@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Edit Produk</h3>
</div>

<div class="card" style="max-width: 650px;">
    <div class="card-body p-4">
        <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('produk._form')
        </form>
    </div>
</div>

@endsection