<!-- resources/views/kendaraan/edit.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Edit Kendaraan</h2>

<form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Kendaraan</label>
        <input type="text" name="nama_kendaraan" class="form-control" value="{{ $kendaraan->nama_kendaraan }}" required>
    </div>
    <div class="mb-3">
        <label>Plat Nomor</label>
        <input type="text" name="plat_nomor" class="form-control" value="{{ $kendaraan->plat_nomor }}" required>
    </div>
    <div class="mb-3">
        <label>Jenis</label>
        <select name="jenis" class="form-control" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="Truk Food Grade" {{ $kendaraan->jenis == 'Truk Food Grade' ? 'selected' : '' }}>Truk Food Grade</option>
            <option value="Truk Kecil" {{ $kendaraan->jenis == 'Truk Kecil' ? 'selected' : '' }}>Truk Kecil</option>
            <option value="Truk Sedang" {{ $kendaraan->jenis == 'Truk Sedang' ? 'selected' : '' }}>Truk Sedang</option>
            <option value="Truk Besar" {{ $kendaraan->jenis == 'Truk Besar' ? 'selected' : '' }}>Truk Besar</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
