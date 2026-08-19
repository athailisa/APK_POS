@extends('layouts.app')

@section('title', 'Users')

@section('content')

<h3 class="fw-bold mb-4"><i class="bi bi-people"></i> Halaman Users</h3>

@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Tambah User
            </a>

            <form action="{{ route('admin.users') }}" method="GET" style="min-width: 260px;">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nama atau email...">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role->name === 'admin' ? 'bg-dark' : 'bg-secondary' }}">
                                {{ ucfirst($user->role->name) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon btn-icon-warning"
                                    title="Edit" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-icon btn-icon-danger" title="Hapus" data-bs-toggle="tooltip"
                                        onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                Tidak ada user ditemukan.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</div>

@endsection