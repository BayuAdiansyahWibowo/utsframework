<!-- resources/views/kendaraan/create.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Tambah Kendaraan</h2>

<form action="{{ route('kendaraan.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Kendaraan</label>
        <input type="text" name="nama_kendaraan" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Plat Nomor</label>
        <input type="text" name="plat_nomor" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis</label>
        <select name="jenis" class="form-control" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="Truk Food Grade">Truk Food Grade</option>
            <option value="Truk Kecil">Truk Kecil</option>
            <option value="Truk Sedang">Truk Sedang</option>
            <option value="Truk Besar">Truk Besar</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection

