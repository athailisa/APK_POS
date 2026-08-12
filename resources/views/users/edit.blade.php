@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0">Edit User</h4>
    <a href="{{ route('admin.users') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar user
    </a>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <!-- Pastikan method adalah POST dan HAPUS baris @method('PUT') jika sebelumnya ada -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @include('users._form')
        </form>
    </div>
</div>
@endsection