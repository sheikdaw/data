<!DOCTYPE html>
<html>
<head>
    <title>OpenLayers Image Overlay</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        var pngFilePath = "{{ asset('public/kovai/testpng.png') }}";
        var minX = 80.0; // Example minimum X coordinate
        var minY = 13.0; // Example minimum Y coordinate
        var maxX = 81.0; // Example maximum X coordinate
        var maxY = 14.0; // Example maximum Y coordinate
        var imageExtent = [minX, minY, maxX, maxY];

        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                new ol.layer.Image({
                    source: new ol.source.ImageStatic({
                        url: pngFilePath, // Change this to your image path
                        projection: 'EPSG:3857',
                        imageExtent: imageExtent // Set the extent of your image
                    })
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([0, 0]),
                zoom: 2
            })
        });
    </script>
</body>
</html>
