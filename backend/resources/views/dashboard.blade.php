<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Electronics Service</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            Electronics Service
        </a>

        <div class="d-flex align-items-center gap-3 text-white">
            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-muted">
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    @if(auth()->user()->role?->name === 'Owner')
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            Manajemen Pengguna
        </a>
    @endif
    <div class="card border-0 shadow-sm rounded-3 mt-4">
        <div class="card-body">
            <h5>Informasi Akun</h5>
            <p class="mb-1">
                <strong>Nama:</strong> {{ auth()->user()->name }}
            </p>
            <p class="mb-1">
                <strong>Email:</strong> {{ auth()->user()->email }}
            </p>
            <p class="mb-0">
                <strong>Role:</strong>
                {{ auth()->user()->role?->name ?? 'Belum ditentukan' }}
            </p>
        </div>
    </div>
</div>

</body>
</html>
