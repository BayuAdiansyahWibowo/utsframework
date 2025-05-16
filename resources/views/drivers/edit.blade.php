@extends('layouts.app')

@section('content')
<h2>Edit Driver</h2>

<form action="{{ route('drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ $driver->nama }}" required>
    </div>
    <div class="mb-3">
        <label>Ganti SIM (optional)</label>
        <input type="file" name="sim" class="form-control">
        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti.</small>
    </div>
    <div class="mb-3">
        <label>Jenis Kendaraan</label>
        <select name="kendaraan_id" class="form-control" required>
            @foreach ($kendaraans as $kendaraan)
                <option value="{{ $kendaraan->id }}" {{ $driver->kendaraan_id == $kendaraan->id ? 'selected' : '' }}>
                    {{ $kendaraan->jenis }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required>{{ $driver->alamat }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
