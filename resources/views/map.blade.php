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
        var pngFilePath = "{{ asset('public/kovai/building.json') }}";
        var xmlData = `<TreeList><Extent><Top>1235527.17763</Top><Left>8566150.76848</Left><Right>8568107.06848</Right><Bottom>1232901.87763</Bottom></Extent></TreeList>`;

        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(xmlData, "text/xml");

        var top = parseFloat(xmlDoc.getElementsByTagName("Top")[0].textContent);
        var left = parseFloat(xmlDoc.getElementsByTagName("Left")[0].textContent);
        var right = parseFloat(xmlDoc.getElementsByTagName("Right")[0].textContent);
        var bottom = parseFloat(xmlDoc.getElementsByTagName("Bottom")[0].textContent);

        console.log("Top:", top);
        console.log("Left:", left);
        console.log("Right:", right);
        console.log("Bottom:", bottom);

        var extent = [left, bottom, right, top];
        var projection = 'EPSG:3857'; // Assuming your coordinates are in Web Mercator projection

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
    </script>
</body>
</html>
