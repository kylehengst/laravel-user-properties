<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
        }
    </style>
</head>
<body>
<div id="map">Loading...</div>
<script src="https://code.jquery.com/jquery-3.0.0.min.js"
        integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPkWVdSTvm_uv3fb_Ic5G533Zrca6x9Yk&callback=initMap"
        async defer></script>
<script>

    var map;

    function initMap() {

        var myLatLng = {lat:51.6448554,lng:-0.3004618};

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: myLatLng
        });

        getProperties();

    }

    function getProperties() {
        $.get('/api/properties', function (data) {
            if(data) addPropertyMarkers(data);
        });
    }

    function addPropertyMarkers(properties) {

        var bounds = new google.maps.LatLngBounds();

        for (var i in properties) {

            var latlng = {lat: parseFloat(properties[i].latitude), lng: parseFloat(properties[i].longitude)};

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: properties[i].name
            });

            bounds.extend(marker.position);

        }

        map.fitBounds(bounds);

    }


</script>
</body>
</html>