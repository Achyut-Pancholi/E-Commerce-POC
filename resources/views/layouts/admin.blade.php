<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | E-Commerce POC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: #fff; }
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover { color: #fff; background-color: #495057; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="width: 250px;">
            <h4 class="text-center mb-4 text-light border-bottom pb-2">Admin Panel</h4>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="{{ route('admin.categories.index') }}"><i class="fas fa-list me-2"></i> Categories</a>
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-box me-2"></i> Products</a>
            <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
            <hr class="text-secondary">
            <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt me-2"></i> View Store</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-link text-secondary text-decoration-none p-2 w-100 text-start">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>

        <!-- Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
                <span class="navbar-brand mb-0 h1">Dashboard</span>
                <div class="ms-auto">
                    <span class="text-muted">Welcome, {{ Auth::user()->name }}</span>
                </div>
            </nav>

            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
