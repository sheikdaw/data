<!DOCTYPE html>
<html>
<head>
    <title>OpenLayers Image Overlay</title>
    <script src="https://cdn.jsdelivr.net/npm/ol@v6.5.0/dist/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v6.5.0/css/ol.css">
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
        var pngFilePath = "public/kovai/testpng.png"; // Adjust the file path as needed
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
                        url: pngFilePath,
                        imageExtent: imageExtent,
                        projection: 'EPSG:4326' // Adjust projection if needed
                    })
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([80.5, 13.5]), // Adjust the center to focus on the image area
                zoom: 8 // Adjust zoom level
            })
        });
    </script>
</body>
</html>
