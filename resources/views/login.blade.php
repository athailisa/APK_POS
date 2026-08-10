<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Login')

<!-- batas awal isi konten -->
@section('content')

<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="card login-card text-center" style="width: 22rem;">
        <div class="card-body p-4">
            <div class="mb-3">
                <i class="bi bi-cup-hot-fill" style="font-size: 2.5rem; color: #8B5E3C;"></i>
            </div>
            <h5 class="mb-1 fw-bold" style="color:#8B5E3C;">Selamat Datang</h5>
            <p class="text-muted small mb-4">Masuk ke akun POS kamu</p>

            <form action="{{ route('auth') }}" method="POST" class="text-start">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
            </form>
        </div>
    </div>
</div>

<!-- batas Akhir isi konten -->
@endsection