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
        // Sample XML data
var xmlData = `
<image>
    <boundingBox>
        <minX>-180</minX>
        <minY>-90</minY>
        <maxX>180</maxX>
        <maxY>90</maxY>
    </boundingBox>
</image>
`;
var pngFilePath = "{{ asset('public/kovai/new/png1.png.aux.xml.png') }}";
// Parse the XML data
var parser = new DOMParser();
var xmlDoc = parser.parseFromString(xmlData, "text/xml");

// Extract bounding box coordinates
var minX = parseFloat(xmlDoc.getElementsByTagName("minX")[0].textContent);
var minY = parseFloat(xmlDoc.getElementsByTagName("minY")[0].textContent);
var maxX = parseFloat(xmlDoc.getElementsByTagName("maxX")[0].textContent);
var maxY = parseFloat(xmlDoc.getElementsByTagName("maxY")[0].textContent);

// Log the coordinates
console.log("MinX:", minX);
console.log("MinY:", minY);
console.log("MaxX:", maxX);
console.log("MaxY:", maxY);

        // var extent = [-20037508.34, -20037508.34, 20037508.34, 20037508.34]; // WGS 1984 Web Mercator Auxiliary Sphere extent
        // var projection = 'EPSG:4326'; // WGS 1984 Web Mercator Auxiliary Sphere projection

        // var imageLayer = new ol.layer.Image({
        //     source: new ol.source.ImageStatic({
        //         url: pngFilePath, // Update with the path to your PNG file
        //         projection: projection,
        //         imageExtent: extent // Set the extent of your image
        //     })
        // });

        // var map = new ol.Map({
        //     layers: [
        //         new ol.layer.Tile({
        //             source: new ol.source.OSM()
        //         }),
        //         imageLayer
        //     ],
        //     target: 'map',
        //     view: new ol.View({
        //         center: [0, 0],
        //         zoom: 2
        //     })
        // });
    </script>
</body>
</html>
