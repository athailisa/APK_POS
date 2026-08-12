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
                <i class="bi bi-cup-hot-fill" style="font-size: 2.5rem; color: var(--dbk-accent-dark);"></i>
            </div>
            <h5 class="mb-1 fw-bold" style="color:var(--dbk-accent-dark);">Selamat Datang</h5>
            <p class="text-muted small mb-4">Masuk ke akun POS kamu</p>

            <form action="{{ route('auth') }}" method="POST" class="text-start">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="exampleInputEmail1" placeholder="nama@email.com">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1"
                            placeholder="••••••••">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('exampleInputPassword1');
    const icon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});
</script>

<!-- batas Akhir isi konten -->
@endsection