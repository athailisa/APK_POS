@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')

<h1><i class="bi bi-tags"></i> Halaman Jenis Produk</h1>

@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    @can('create', App\Models\Jenis::class)
    <a href="{{ route('jenis.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Jenis
    </a>
    @endcan

    <form method="GET" action="{{ route('jenis.index') }}" style="min-width: 260px;">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Cari nama jenis...">
        </div>
    </form>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Jenis</th>
                <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jenisList as $jenis)
            <tr>
                <th scope="row">{{ $jenisList->firstItem() + $loop->index }}</th>
                <td>{{ $jenis->nama }}</td>
                <td class="align-middle">
                    <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                        @can('update', $jenis)
                        <a href="{{ route('jenis.edit', $jenis->id) }}" class="btn-icon btn-icon-warning" title="Edit"
                            data-bs-toggle="tooltip">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan

                        @can('delete', $jenis)
                        <form action="{{ route('jenis.destroy', $jenis->id) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')
                            <button class="btn-icon btn-icon-danger" title="Hapus" data-bs-toggle="tooltip"
                                onclick="return confirm('Apakah anda yakin akan menghapus jenis ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        Belum ada jenis produk yang ditambahkan.
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $jenisList->links() }}

@endsection