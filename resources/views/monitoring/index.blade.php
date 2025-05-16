<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Driver</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 90vh; }
    </style>
</head>
<body>
    <h2>Monitoring Driver</h2>
    <div id="map"></div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        const map = L.map('map').setView([-6.200000, 106.816666], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        const markers = {};

        // Inisialisasi peta awal dari API
        fetch('/api/drivers/locations')
            .then(res => res.json())
            .then(data => {
                data.forEach(driver => {
                    const latlng = [driver.latitude, driver.longitude];
                    markers[driver.id] = L.marker(latlng).addTo(map)
                        .bindPopup(driver.name);
                });
            });

        // Real-time update dari WebSocket
        Echo.channel('drivers')
            .listen('.location.updated', (e) => {
                const driver = e.driver;
                const latlng = [driver.latitude, driver.longitude];

                if (markers[driver.id]) {
                    markers[driver.id].setLatLng(latlng);
                } else {
                    markers[driver.id] = L.marker(latlng).addTo(map)
                        .bindPopup(driver.name);
                }
            });
    </script>
</body>
</html>
