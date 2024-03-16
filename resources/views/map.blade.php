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
        var pngFilePath = "{{ asset('public/kovai/new/png1.png') }}";
        var xmlFilePath = "{{ asset('public/kovai/new/png1.png.aux.xml') }}";

        // Load the XML file
        fetch(xmlFilePath)
            .then(response => response.text())
            .then(xmlData => {
                var parser = new DOMParser();
                var xmlDoc = parser.parseFromString(xmlData, "text/xml");

                // Extract bounding box coordinates
                var minX = parseFloat(xmlDoc.getElementsByTagName("minx")[0].textContent);
                var minY = parseFloat(xmlDoc.getElementsByTagName("miny")[0].textContent);
                var maxX = parseFloat(xmlDoc.getElementsByTagName("maxx")[0].textContent);
                var maxY = parseFloat(xmlDoc.getElementsByTagName("maxy")[0].textContent);

                console.log("MinX:", minX);
                console.log("MinY:", minY);
                console.log("MaxX:", maxX);
                console.log("MaxY:", maxY);

                var extent = [minX, minY, maxX, maxY];
                var projection = 'EPSG:4326';

                var imageLayer = new ol.layer.Image({
                    source: new ol.source.ImageStatic({
                        url: pngFilePath,
                        projection: projection,
                        imageExtent: extent
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
                        center: ol.extent.getCenter(extent),
                        zoom: 2
                    })
                });
            })
            .catch(error => console.error('Error fetching XML:', error));
    </script>
</body>
</html>
