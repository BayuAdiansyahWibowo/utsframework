<!-- resources/views/barang/index.blade.php -->
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


    <h2>Manajemen Barang</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Pencarian & Filter -->
    <form method="GET" action="{{ route('barang.index') }}" class="row row-cols-lg-auto g-3 align-items-center mb-4">
        <div class="col-12">
            <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ $search ?? '' }}">
        </div>
        <div class="col-12">
            <select name="jenis" class="form-select">
                <option value="">-- Semua Jenis --</option>
                <option value="pangan" {{ (isset($selectedJenis) && $selectedJenis == 'pangan') ? 'selected' : '' }}>Pangan</option>
                <option value="elektronik" {{ (isset($selectedJenis) && $selectedJenis == 'elektronik') ? 'selected' : '' }}>Elektronik</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">+ Tambah Barang</a>

    <h4>Daftar Barang</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Waktu Ditambahkan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
@endsection