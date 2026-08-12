<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-cup-hot-fill me-1"></i> POS Cafe
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('jenis*') ? 'active' : '' }}" href="{{ route('jenis.index') }}">Jenis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('produk') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('penjualan') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
                </li>
            </ul>

            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center gap-2 user-menu-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="text-start d-none d-md-block">
                        <span class="d-block fw-semibold" style="font-size:0.9rem; line-height:1.1;">{{ auth()->user()->name }}</span>
                        <span class="d-block text-muted" style="font-size:0.75rem;">{{ ucfirst(auth()->user()->role->name) }}</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="px-2 py-1">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>