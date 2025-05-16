@extends('layouts.app')

@section('content')
<h2>Data Driver</h2>

<a href="{{ route('drivers.create') }}" class="btn btn-success mb-3">Tambah Driver</a>

<!-- Filter -->
<form method="GET" action="{{ route('drivers.index') }}" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="nama" class="form-control" placeholder="Cari Nama" value="{{ request('nama') }}">
    </div>
    <div class="col-md-4">
        <select name="jenis_kendaraan" class="form-control">
            <option value="">-- Pilih Jenis Kendaraan --</option>
            @foreach ($jenisKendaraans as $jenis)
                <option value="{{ $jenis }}" {{ request('jenis_kendaraan') == $jenis ? 'selected' : '' }}>
                    {{ $jenis }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

<!-- Flash message -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Tabel driver -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>SIM</th>
            <th>Jenis Kendaraan</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($drivers as $driver)
            <tr>
                <td>{{ $driver->nama }}</td>
                <td>
                    @if($driver->sim_path)
                        <a href="{{ asset('storage/' . $driver->sim_path) }}" target="_blank">Lihat SIM</a>
                    @else
                        Tidak Ada SIM
                    @endif
                </td>
                <td>{{ $driver->kendaraan->jenis ?? '-' }}</td>
                <td>{{ $driver->alamat }}</td>
                <td>
                    <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection