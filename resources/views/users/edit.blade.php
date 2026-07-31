@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <h4>Edit User</h4>
    
    <!-- Pastikan method adalah POST dan HAPUS baris @method('PUT') jika sebelumnya ada -->
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @include('users._form')
    </form>
@endsection
