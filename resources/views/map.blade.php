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
        var extent = [-20037508.34, -20037508.34, 20037508.34, 20037508.34]; // WGS 1984 Web Mercator Auxiliary Sphere extent
        var projection = 'EPSG:3857'; // WGS 1984 Web Mercator Auxiliary Sphere projection
        var pngFilePath = "{{ asset('public/kovai/testpng.png') }}";
        var imageLayer = new ol.layer.Image({
            source: new ol.source.ImageStatic({
                url: pngFilePath, // Update with the path to your PNG file
                projection: projection,
                imageExtent: extent // Set the extent of your image
            })
        });

        var map = new ol.Map({
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                imageLayer
            ],
            target: 'map',
            view: new ol.View({
                center: [0, 0],
                zoom: 2
            })
        });
    </script>
</body>
</html>
