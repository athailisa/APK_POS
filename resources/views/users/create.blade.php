@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0">Tambah User</h4>
    <a href="{{ route('admin.users') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar user
    </a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @include('users._form')
        </form>
    </div>
</div>
@endsection