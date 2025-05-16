@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tugas Pengiriman</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('tugas.store') }}">
        @csrf

        <div class="mb-3">
            <label for="barang_id" class="form-label">Nama Barang</label>
            <select name="barang_id" id="barang_id" class="form-select">
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}">{{ $barang->nama }} ({{ $barang->jenis }}) - stok: {{ $barang->jumlah }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah yang dikirim</label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" value="1">
        </div>

        <div class="mb-3">
            <label for="kendaraan_id" class="form-label">Jenis Kendaraan & Plat Nomor</label>
            <select name="kendaraan_id" id="kendaraan_id" class="form-select">
                @foreach($kendaraans as $kendaraan)
                    <option value="{{ $kendaraan->id }}">{{ $kendaraan->jenis }} - {{ $kendaraan->plat_nomor }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="driver_id" class="form-label">Pilih Driver</label>
            <select name="driver_id" id="driver_id" class="form-select">
                <option value="">-- Pilih driver --</option>
                {{-- Diisi oleh JavaScript --}}
            </select>
        </div>

        <div class="mb-3">
            <label for="sim_image" class="form-label">Preview SIM</label>
            <div id="sim-preview">
                <img src="" id="sim_image" style="max-width:200px; display:none;" />
            </div>
        </div>

        <hr>
        <h5>Rute Pengiriman</h5>

        <div class="mb-3">
            <label class="form-label">Pilih Titik Awal dan Tujuan di Peta</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        {{-- Hidden coordinate input --}}
        <input type="hidden" name="latitude_awal" id="latitude_awal">
        <input type="hidden" name="longitude_awal" id="longitude_awal">
        <input type="hidden" name="latitude_tujuan" id="latitude_tujuan">
        <input type="hidden" name="longitude_tujuan" id="longitude_tujuan">

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>

{{-- === Leaflet & JS Driver Selector === --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const kendaraans = @json($kendaraans);
    const drivers = @json($drivers);

    const kendaraanSelect = document.getElementById('kendaraan_id');
    const driverSelect = document.getElementById('driver_id');
    const simImage = document.getElementById('sim_image');

    function updateDriverOptions(kendaraanId) {
        driverSelect.innerHTML = '<option value="">-- Pilih driver --</option>';
        const selectedKendaraan = kendaraans.find(k => k.id == kendaraanId);
        if (!selectedKendaraan) return;
        const matchingDrivers = drivers.filter(d => d.kendaraan?.jenis === selectedKendaraan.jenis);
        matchingDrivers.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = `${driver.nama} (${driver.kendaraan?.jenis})`;
            option.dataset.sim = driver.sim_path;
            driverSelect.appendChild(option);
        });
    }

    kendaraanSelect.addEventListener('change', function () {
        updateDriverOptions(this.value);
        simImage.style.display = 'none';
    });

    driverSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const simPath = selectedOption.dataset.sim;
        if (simPath) {
            simImage.src = `/${simPath}`;
            simImage.style.display = 'block';
        } else {
            simImage.style.display = 'none';
        }
    });

    window.addEventListener('DOMContentLoaded', () => {
        if (kendaraanSelect.value) {
            updateDriverOptions(kendaraanSelect.value);
        }
    });
</script>

<script>
    const map = L.map('map').setView([-6.2, 106.816666], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

    let markerAwal = null, markerTujuan = null, polyline = null;
    let step = 0; // 0 = awal, 1 = tujuan

    function updateCoordsInput(type, lat, lng) {
        document.getElementById(`latitude_${type}`).value = lat;
        document.getElementById(`longitude_${type}`).value = lng;
    }

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        if (step === 0) {
            if (markerAwal) map.removeLayer(markerAwal);
            markerAwal = L.marker([lat, lng], { draggable: true }).addTo(map).bindPopup("Titik Awal").openPopup();
            updateCoordsInput('awal', lat, lng);
            step = 1;

            markerAwal.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                updateCoordsInput('awal', pos.lat, pos.lng);
                if (markerTujuan) drawRoute();
            });
        } else {
            if (markerTujuan) map.removeLayer(markerTujuan);
            markerTujuan = L.marker([lat, lng], { draggable: true }).addTo(map).bindPopup("Titik Tujuan").openPopup();
            updateCoordsInput('tujuan', lat, lng);
            step = 0;

            markerTujuan.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                updateCoordsInput('tujuan', pos.lat, pos.lng);
                if (markerAwal) drawRoute();
            });

            if (markerAwal) drawRoute();
        }
    });

    function drawRoute() {
        if (polyline) map.removeLayer(polyline);
        polyline = L.polyline([
            [markerAwal.getLatLng().lat, markerAwal.getLatLng().lng],
            [markerTujuan.getLatLng().lat, markerTujuan.getLatLng().lng]
        ], { color: 'blue' }).addTo(map);
    }
</script>
@endsection
