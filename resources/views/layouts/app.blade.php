<!DOCTYPE html>
<html>
<head>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <title>Dashboard Tracking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white d-flex flex-column justify-content-between p-3" style="width: 250px; height: 100vh;">
        <div>
            <h4>Tracking</h4>
                <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('barang.index') }}" class="nav-link text-white">Manajemen Barang</a></li>
                <li class="nav-item"><a href="{{ route('drivers.index') }}" class="nav-link text-white">Data Driver</a></li>
                <li class="nav-item"><a href="{{ route('kendaraan.index') }}" class="nav-link text-white">Kendaraan</a></li>
                <li class="nav-item"><a href="{{ route('monitoring.index') }}" class="nav-link text-white">Monitoring</a></li>
                <li class="nav-item"><a href="{{ route('tugas.create') }}" class="nav-link text-white">Tugas Pengiriman</a></li>
            </ul>

        </div>

        <!-- Tombol Logout di bawah sidebar -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 mt-3">
                Logout
            </button>
        </form>
    </div>

    <!-- Konten Utama -->
    <div class="p-4" style="flex:1;">
        @yield('content')
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@yield('scripts')

</body>
</html>
