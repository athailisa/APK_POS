@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-gear"></i> Edit User</h4>
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