<?php
require("queries.php");
?>

<!DOCTYPE html>
<html lang="en" style="width: 100%; height: 100%;margin: 0;padding: 0;">
<head>
    <meta charset="UTF-8">
    <title>Tomato runner</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" />
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div id="log-window">
    <p>Distance to winning point: <span id="distance-log"></span> meters</p>
    <p>Time passed: <span id="time-log"></span></p>
    <p id="results"></p>
    <a href="./"
       id="restart-button">
        Restart
    </a>

    <h4>Best scores:</h4>
    <ul>
        <?php foreach ($mySessionRecords as $sessionTimeRecord): ?>
            <li><?=$sessionTimeRecord;?></li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"></script>
<script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous"></script>
<script>

    // Main settings

    var isGameOver = false;
    var isTestMode = <?=$allSettings[SETTINGS_TEST_MODE]?>;

    // Map initializing

    var map = L.map('map').setView([55.683182, 12.571517], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Tomato player marker

    var tomatoIcon = L.icon({
        iconUrl: 'assets/images/tomato.png',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    var marker = L.marker([55.683182, 12.571517], { icon: tomatoIcon }).addTo(map);

    // Pineapple obstacle markers

    var obstacleMarkers = [
        [55.683471, 12.569538], // obstacle coordinate
        [55.682225, 12.573701], // obstacle coordinate
        // ...may be more
    ];

    var pineappleIcon = L.icon({
        iconUrl: 'assets/images/pineapple.png',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    obstacleMarkers.forEach(function (coordinates) {
        L.marker([coordinates[0], coordinates[1]], { icon: pineappleIcon }).addTo(map);
    });

    // Winning point

    var winningPointIcon = L.icon({
        iconUrl: 'assets/images/prize.png',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    var winningPointCoordinates = [55.232816, 11.767130]; // task winning point in Næstved but it's so far
    var distanceToWinningPoint = 1000; // task winning distance but it's so close for test mode
    if(isTestMode) {
        winningPointCoordinates = [55.681801, 12.567736];
        distanceToWinningPoint = 10;
    }

    var winningPoint = L.marker(winningPointCoordinates, { icon: winningPointIcon }).addTo(map);

    // Player speed initializing

    var speedOfUpdateInMilliseconds = 10;
    var normalSpeedInKPH = <?=$allSettings[SETTINGS_NORMAL_SPEED]?>;
    var turboSpeedInKPH = <?=$allSettings[SETTINGS_TURBO_SPEED]?>;

    var normalSpeed = normalSpeedInKPH / (60 * 60 * 1000 * speedOfUpdateInMilliseconds);
    var normalDiagonalSpeed = normalSpeed * (1 / Math.sqrt(2)); // cos 45 = sin 45 = 1/sqrt(2)

    var speed = normalSpeed;
    var diagonalSpeed = normalDiagonalSpeed;

    var turboSpeed = turboSpeedInKPH / (60 * 60 * 1000 * speedOfUpdateInMilliseconds);
    var turboDiagonal = turboSpeed * (1 / Math.sqrt(2));

    var isTurboSpeed = false;

    // Keys clicked handling

    var activeKeys = {};

    var KEY_UP = 38;
    var KEY_DOWN = 40;
    var KEY_LEFT = 37;
    var KEY_RIGHT = 39;
    var KEY_KEYSPACE = 32;

    function handleKeyDown(e) {
        activeKeys[e.keyCode] = true;

        if (e.keyCode === KEY_KEYSPACE) {
            isTurboSpeed = true;
        }
    }

    function handleKeyUp(e) {
        activeKeys[e.keyCode] = false;

        if (e.keyCode === KEY_KEYSPACE) {
            isTurboSpeed = false;
        }
    }

    // Move marker handler

    function moveMarker() {
        if(isGameOver) {
            // Show the restart button
            $('#restart-button').css('display', 'block');

            // Stop marker moving
            return;
        }

        // Current player's marker coordinates

        var latLng = marker.getLatLng();
        var lat = latLng.lat;
        var lng = latLng.lng;

        if (isTurboSpeed) {
            diagonalSpeed = turboDiagonal;
            speed = turboSpeed;
        } else {
            diagonalSpeed = normalDiagonalSpeed;
            speed = normalSpeed;
        }

        // Choose step direction

        if (activeKeys[KEY_LEFT] && activeKeys[KEY_UP]) {
            lng -= diagonalSpeed;
            lat += diagonalSpeed;
        } else if (activeKeys[KEY_LEFT] && activeKeys[KEY_DOWN]) {
            lng -= diagonalSpeed;
            lat -= diagonalSpeed;
        } else if (activeKeys[KEY_RIGHT] && activeKeys[KEY_UP]) {
            lng += diagonalSpeed;
            lat += diagonalSpeed;
        } else if (activeKeys[KEY_RIGHT] && activeKeys[KEY_DOWN]) {
            lng += diagonalSpeed;
            lat -= diagonalSpeed;
        } else if (activeKeys[KEY_LEFT]) {
            lng -= speed;
        } else if (activeKeys[KEY_RIGHT]) {
            lng += speed;
        } else if (activeKeys[KEY_UP]) {
            lat += speed;
        } else if (activeKeys[KEY_DOWN]) {
            lat -= speed;
        }

        // Set new coordinates
        marker.setLatLng([lat, lng]);

        // new map center
        map.panTo([lat, lng]);

        // Winning point handling

        var targetPoint = L.latLng(winningPointCoordinates); // Change the coordinates to your winning point
        var distance = Math.round(marker.getLatLng().distanceTo(targetPoint));

        // Set info window
        $('#distance-log').html(distance);
        $('#time-log').html(getElapsedTime());

        if (distance <= distanceToWinningPoint) {

            // Distance is achieved! Save the session record

            var data = {
                time: getElapsedTime()
            };

            $.ajax({
                url: 'saveSession.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#results').html('Congratulations! You have reached the winning point!');
                },
                error: function(xhr, status, error) {
                    $('#results').html('Error appeared when the record time was saving');
                }
            });

            // The game is over
            isGameOver = true;
        }

        // Obstacle points handling

        var markerLatLng = marker.getLatLng();

        if (checkCollision(markerLatLng, obstacleMarkers, 10)) {
            $('#results').html('Game Over! You collided with an obstacle.');
            isGameOver = true;
        }
    }

    function checkCollision(markerLatLng, otherMarkersLatLngs, distanceLimit) {
        for (var i = 0; i < otherMarkersLatLngs.length; i++) {
            var distance = markerLatLng.distanceTo(otherMarkersLatLngs[i]);
            if (distance < distanceLimit) {
                return true;
            }
        }
        return false;
    }

    // Timer handling

    var startTime = Date.now();
    var elapsedTime = "00:00:00";

    function updateTimer() {
        var currentTime = Date.now();
        var rawElapsedTime = Math.floor((currentTime - startTime) / 1000);
        var hours = Math.floor(rawElapsedTime / 3600);
        var minutes = Math.floor((rawElapsedTime % 3600) / 60);
        var seconds = rawElapsedTime % 60;
        elapsedTime = formatTime(hours) + ":" + formatTime(minutes) + ":" + formatTime(seconds);
    }

    function formatTime(time) {
        return time < 10 ? "0" + time : time;
    }

    function getElapsedTime() {
        return elapsedTime;
    }

    setInterval(updateTimer, 1000);

    // Keydown / keyup events handling

    document.addEventListener('keydown', handleKeyDown);
    document.addEventListener('keyup', handleKeyUp);

    setInterval(moveMarker, speedOfUpdateInMilliseconds);
</script>
</body>
</html>