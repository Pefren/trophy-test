<?
require("map-stuff.php");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>A super cool map</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
          integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
          crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
            integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
            crossorigin=""></script>

    <link rel="stylesheet" href="styles.css">
</head>
<body class="full-width">
<div id="map-container">
    <div id="map"></div>
</div>

<script>

    var map = L.map('map').setView([<?=$lat1;?>, <?=$lon1;?>], 18);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Show polygon at the Trophy Office
    var geojson = L.geoJson(<?=geoJson($str);?>).addTo(map);

</script>
</body>
</html>
