@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0"><i class="bi bi-tags"></i> Tambah Jenis </h3>
    <a href="{{ route('jenis.index') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar jenis
    </a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body p-4">
        <form action="{{ route('jenis.store') }}" method="POST">
            @csrf
            @include('jenis._form')
        </form>
    </div>
</div>

@endsection