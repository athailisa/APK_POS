@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0">Edit Jenis</h3>
    <a href="{{ route('jenis.index') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar jenis
    </a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body p-4">
        <form action="{{ route('jenis.update', $jenis) }}" method="POST">
            @csrf
            @method('PUT')
            @include('jenis._form')
        </form>
    </div>
</div>

@endsection