@extends('layouts.app')

@section('content')
<h2>Tambah Driver</h2>

{{-- Tampilkan pesan error jika ada --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
    </div>
    <div class="mb-3">
        <label>Upload SIM (jpg/png)</label>
        <input type="file" name="sim" class="form-control" accept="image/jpeg,image/png" required>
    </div>
    <div class="mb-3">
        <label>Jenis Kendaraan</label>
        <select name="kendaraan_id" class="form-control" required>
            <option value="">-- Pilih Jenis Kendaraan --</option>
            @foreach ($kendaraans as $kendaraan)
                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                    {{ $kendaraan->jenis }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
