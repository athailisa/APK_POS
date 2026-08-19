@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-plus"></i> Tambah User</h4>
</div>

<div class="card" style="max-width: 500px;">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @include('users._form')
        </form>
    </div>
</div>
@endsection