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
        // Define the extent of the image
        var extent = [8566150.76848, 1232901.87763, 8568107.06848, 1235527.17763];

        // Create the static image layer
        var imageLayer = new ol.layer.Image({
          source: new ol.source.ImageStatic({
            url: "{{ asset('public/kovai/new/png1.png') }}", // Path to your static image
            imageExtent: extent
          })
        });

        // Create the map
        var map = new ol.Map({
          target: 'map',
          layers: [new ol.layer.Tile({
                                source: new ol.source.OSM()
                            }),imageLayer],
          view: new ol.View({
            projection: 'EPSG:3857',
            center: ol.extent.getCenter(extent),
            zoom: 14
          })
        });
      </script>
</body>
</html>
