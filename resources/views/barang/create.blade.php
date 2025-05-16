<!-- resources/views/barang/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Tambah Barang</h2>

    <form action="{{ route('barang.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Barang</label>
            <select name="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pangan">Pangan</option>
                <option value="elektronik">Elektronik</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Barang</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary ms-2">Kembali</a>
    </form>

</body>
</html>
