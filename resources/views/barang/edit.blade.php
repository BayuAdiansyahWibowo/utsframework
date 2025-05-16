<!-- resources/views/barang/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Edit Barang</h2>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="mb-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Barang</label>
            <select name="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pangan" {{ $barang->jenis == 'pangan' ? 'selected' : '' }}>Pangan</option>
                <option value="elektronik" {{ $barang->jenis == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $barang->jumlah }}" required>
        </div>

        <button type="submit" class="btn btn-warning">Update Barang</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>

</body>
</html>
