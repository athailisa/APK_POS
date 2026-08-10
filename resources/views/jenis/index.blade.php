@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')
@include('layouts.navbar')

<h1>Halaman Jenis Produk</h1>

@if (session('errors'))
    <div class="alert alert-danger">
        {{ session('errors') }}
    </div>
@endif

@can('create', App\Models\Jenis::class)
<div class="mb-3">
    <a href="{{ route('jenis.create') }}" class="btn btn-primary">Tambah Jenis</a>
</div>
@endcan

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
                    <div class="d-flex align-items-center justify-content-center gap-1 py-1">
                        @can('update', $jenis)
                        <a href="{{ route('jenis.edit', $jenis->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan

                        @can('delete', $jenis)
                        <form action="{{ route('jenis.destroy', $jenis->id) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus jenis ini?')">
                                Hapus
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3"><h1 class="text-center">Data tidak tersedia.</h1></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $jenisList->links() }}

@endsection