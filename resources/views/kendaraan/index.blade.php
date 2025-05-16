@extends('layouts.app')

@section('content')
<h2>Data Kendaraan</h2>

<a href="{{ route('kendaraan.create') }}" class="btn btn-primary mb-3">Tambah Kendaraan</a>

{{-- Form Filter --}}
<form method="GET" action="{{ route('kendaraan.index') }}" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="nama" value="{{ request('nama') }}" class="form-control" placeholder="Cari nama kendaraan...">
    </div>
    <div class="col-md-4">
        <select name="jenis" class="form-control">
            <option value="">-- Semua Jenis --</option>
            <option value="Truk Food Grade" {{ request('jenis') == 'Truk Food Grade' ? 'selected' : '' }}>Truk Food Grade</option>
            <option value="Truk Kecil" {{ request('jenis') == 'Truk Kecil' ? 'selected' : '' }}>Truk Kecil</option>
            <option value="Truk Sedang" {{ request('jenis') == 'Truk Sedang' ? 'selected' : '' }}>Truk Sedang</option>
            <option value="Truk Besar" {{ request('jenis') == 'Truk Besar' ? 'selected' : '' }}>Truk Besar</option>
        </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="{{ route('kendaraan.index') }}" class="btn btn-light">Reset</a>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Plat Nomor</th>
            <th>Jenis</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kendaraans as $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->nama_kendaraan }}</td>
            <td>{{ $k->plat_nomor }}</td>
            <td>{{ $k->jenis }}</td>
            <td>
                <a href="{{ route('kendaraan.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('kendaraan.destroy', $k->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Belum ada data kendaraan.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
