@extends('back.layout.page-layout')
@section('pagetitle', isset($pagetitle) ? $pagetitle : 'page title')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css"
type="text/css">
<style>
.map {
    width: 100%;
    height: 600px;
}

.ol-popup {
    position: absolute;
    background-color: white;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #cccccc;
    bottom: 12px;
    left: -50px;
    min-width: 280px;
}

.ol-popup:after,
.ol-popup:before {
    top: 100%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.ol-popup:after {
    border-top-color: white;
    border-width: 10px;
    left: 48px;
    margin-left: -10px;
}

.ol-popup:before {
    border-top-color: #cccccc;
    border-width: 11px;
    left: 48px;
    margin-left: -11px;
}

.ol-popup-closer {
    text-decoration: none;
    position: absolute;
    top: 2px;
    right: 8px;
}

.ol-popup-closer:after {
    content: "✖";
}
</style>
    <div class="card shadow p-3">
        <div class="row p-2 g-3">
            @foreach($streetsNotInSurveyed as $street)
                <div class="card col-md-3 mb-3 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">{{ $street->road_name }}</h5>
                        <p class="card-text">Balance Count: {{ $street->road_count }}</p>
                        @foreach($totalRoadCount as $totalRoad)
                            @if($totalRoad->road_name == $street->road_name)
                                <p class="card-text">Total Count: {{ $totalRoad->total_road_count }}</p>
                            @endif
                        @endforeach
                    </div>
                    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>
                </div>
                <script type="text/javascript"
                src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
                <script type="text/javascript">
                    // Path to your GeoJSON file
                    var geoJsonFilePath = "{{asset('public/kovai/test.json')}}";
                    // Path to your PNG file
                    var pngFilePath = "{{asset('public/kovai/final.png')}}";

                    // Load the GeoJSON file using fetch API
                    var geoJsonPromise = fetch(geoJsonFilePath)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to load GeoJSON file');
                            }
                            return response.json();
                        });

                    // Load the PNG file using fetch API
                    var pngPromise = fetch(pngFilePath)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to load PNG file');
                            }
                            return response.blob();
                        });

                    // Once both files are loaded, proceed with processing
                    Promise.all([geoJsonPromise, pngPromise])
                        .then(responses => {
                            var geoJsonData = responses[0];
                            var pngBlob = responses[1];

                            var pngDataUrl = URL.createObjectURL(pngBlob);

                            // Convert GeoJSON data to OpenLayers feature objects
                            var features = (new ol.format.GeoJSON()).readFeatures(geoJsonData);

                            // Create a vector source
                            var vectorSource = new ol.source.Vector({
                                features: features
                            });

                            // Create a vector layer
                            var vectorLayer = new ol.layer.Vector({
                                source: vectorSource
                            });

                            var imageLayer = new ol.layer.Image({
                    source: new ol.source.ImageStatic({
                        url: "{{asset('public/kovai/final.png')}}", // Adjust the path to the converted image
                        projection: 'EPSG:3857', // Assuming Web Mercator projection
                        imageExtent: ol.extent.createEmpty() // Specify the extent if needed
                    })
                });

                            // Create the map
                            var map = new ol.Map({
                                target: 'map',
                                layers: [
                                    new ol.layer.Tile({
                                        source: new ol.source.OSM()
                                    }),
                                    vectorLayer
                                ],
                                view: new ol.View({
                                    center: ol.proj.fromLonLat([77.039639, 20.245615]), // Center map at desired coordinates
                                    zoom: 6 // Set desired zoom level
                                })
                            });

                            // Popup
                            var popup = new ol.Overlay({
                                element: document.getElementById('popup'),
                                autoPan: true,
                                autoPanAnimation: {
                                    duration: 250
                                }
                            });
                            map.addOverlay(popup);
                            var properties_color_change = feature.getProperties();


                            // Display popup on click
                            map.on('click', function(event) {
                                var feature = map.forEachFeatureAtPixel(event.pixel, function(feature) {
                                    return feature;
                                });

                                if (feature) {
                                    var properties = feature.getProperties();
                                    var content = '<h4>Feature Properties</h4>';
                                    content += '<ul>';
                                    for (var key in properties) {
                                        if (key !== 'geometry') {
                                            content += '<li><strong>' + key + ':</strong> ' + properties[key] + '</li>';
                                        }
                                    }
                                    content += '</ul>';
                                    popup.setPosition(event.coordinate);
                                    document.getElementById('popup-content').innerHTML = content;
                                } else {
                                    popup.setPosition(undefined);
                                }
                            });

                            // Close popup
                            document.getElementById('popup-closer').onclick = function() {
                                popup.setPosition(undefined);
                                return false;
                            };


                        })
                        .catch(error => {
                            console.error('Error loading files:', error);
                        });
                </script>
            @endforeach
        </div>
    </div>
@endsection
