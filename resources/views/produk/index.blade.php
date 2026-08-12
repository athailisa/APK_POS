@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<h1 class="mb-4"><i class="bi bi-box-seam"></i> Halaman Produk</h1>

@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            @can('create', App\Models\Produk::class)
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
            @endcan

            <form action="{{ route('produk.index') }}" method="GET" class="d-flex" style="min-width: 260px;">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nama produk...">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Stok</th>
                        <th scope="col">User</th>
                        <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <th scope="row">{{ $products->firstItem() + $loop->index }}</th>

                        <td>
                            @if ($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" width="40" height="40"
                                class="img-thumbnail" style="object-fit:cover;" alt="Foto">
                            @else
                            <span class="text-muted small">No Photo</span>
                            @endif
                        </td>

                        <td>{{ $product->nama }}</td>
                        <td>
                            @if ($product->jenis)
                            <span class="badge bg-secondary">{{ $product->jenis->nama }}</span>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($product->harga_beli) }}</td>
                        <td>Rp {{ number_format($product->harga_jual) }}</td>
                        <td>
                            <span
                                class="badge {{ $product->stok > 10 ? 'bg-success' : ($product->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $product->user->name }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-1 py-1">
                                @can('view', $product)
                                <a href="{{ route('produk.show', $product->id) }}"
                                    class="btn btn-sm btn-primary text-white"><i class="bi bi-eye"></i> Detail</a>
                                @endcan

                                @can('update', $product)
                                <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-sm btn-warning"><i
                                        class="bi bi-pencil"></i> Edit</a>
                                @endcan

                                @can('delete', $product)
                                <form action="{{ route('produk.destroy', $product->id) }}" method="POST"
                                    class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            Belum ada produk yang ditambahkan.
                        </div>
                    </td>                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
</div>

@endsection