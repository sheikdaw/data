@extends('back.layout.page-layout')

@section('pagetitle', isset($pagetitle) ? $pagetitle : 'Page Title')

@section('content')
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
    <form class="form-inline">
        <label for="type">Geometry type: &nbsp;</label>
        <select class="form-control mr-2 mb-2 mt-2" id="type">
            <option value="Point">Point</option>
            <option value="LineString">LineString</option>
            <option value="Polygon">Polygon</option>
            <option value="Circle">Circle</option>
            <option value="None">None</option>
        </select>
        <input class="form-control mr-2 mb-2 mt-2" type="button" value="Undo" id="undo">
    </form>
    <div class="card shadow p-3">
        <div class="row p-2 g-3">
            @foreach ($streetsNotInSurveyed as $street)
                <div class="card col-md-3 mb-3 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">{{ $street->road_name }}</h5>
                        <p class="card-text">Balance Count: {{ $street->road_count }}</p>
                        @foreach ($totalRoadCount as $totalRoad)
                            @if ($totalRoad->road_name == $street->road_name)
                                <p class="card-text">Total Count: {{ $totalRoad->total_road_count }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="map" class="map"></div>

    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>

    <div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalLabel">Feature Properties</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Feature Properties</h4>
                    <ul id="featurePropertiesList">
                        <!-- Feature properties will be displayed here -->
                    </ul>
                    <hr>
                    <h4>Feature Form</h4>
                    <form id="featureForm" method="post" action="{{ route('client.Survey-Form-Point') }}">
                        @csrf <!-- CSRF token for security -->
                        <div class="mb-3">
                            <label for="gisIdInput" class="form-label">Gis id</label>
                            <input type="text" class="form-control" id="gisIdInput" name="gisid" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="assessment" class="form-label">Assessment no</label>
                            <input type="text" class="form-control" id="assessment" name="assessment">
                        </div>
                        <!-- Add more form fields as needed -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
    <script type="text/javascript">
        var clickedStyle = new ol.style.Style({
    fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 0.6)' }),
    stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 0, 1)', width: 2 }),
    image: new ol.style.Circle({ radius: 6, fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 1)' }) })
});

var completeStyle = new ol.style.Style({
    fill: new ol.style.Fill({ color: 'rgba(0, 48, 143, 0.6)' }),
    stroke: new ol.style.Stroke({ color: 'rgba(0, 48, 143, 1)', width: 2 }),
    image: new ol.style.Circle({ radius: 6, fill: new ol.style.Fill({ color: 'rgba(0, 48, 143, 1)' }) })
});

var geoJsonFilePath = "{{ asset('public/kovai/test.json') }}";
var pngFilePath = "{{ asset('public/kovai/Ward.png') }}";
var left = 8566697.42671;
var bottom = 1233036.89252;
var right = 8568056.82671;
var top = 1234055.69252;

var vectorSource = new ol.source.Vector();
var vectorLayer = new ol.layer.Vector({ source: vectorSource });
var pngLayer = new ol.layer.Image({ source: new ol.source.ImageStatic({ url: pngFilePath, imageExtent: [left, bottom, right, top], projection: 'EPSG:32643' }) });

var map = new ol.Map({
    target: 'map',
    layers: [ new ol.layer.Tile({ source: new ol.source.OSM() }), pngLayer, vectorLayer ],
    view: new ol.View({ center: ol.proj.fromLonLat([80.241610, 13.098640]), zoom: 15 })
});

var markerLayer = new ol.layer.Vector({ source: new ol.source.Vector(), style: new ol.style.Style({ image: new ol.style.Icon({ anchor: [0.5, 1], src: 'https://openlayers.org/en/latest/examples/data/icon.png' }) }) });
map.addLayer(markerLayer);

var popup = new ol.Overlay({ element: document.getElementById('popup'), autoPan: true, autoPanAnimation: { duration: 250 } });
map.addOverlay(popup);

var gisIdSet = new Set(@json($surveyed.map(function(s) { return s.gisid; })));

map.on('click', function(event) {
    if (document.getElementById('type').value == 'None') {
        var feature = map.forEachFeatureAtPixel(event.pixel, function(feature) { return feature; });
        if (feature) {
            var properties = feature.getProperties();
            var content = '';
            for (var key in properties) { if (key !== 'geometry') { content += '<li><strong>' + key + ':</strong> ' + properties[key] + '</li>'; } }
            document.getElementById('featurePropertiesList').innerHTML = content;
            document.getElementById('gisIdInput').value = properties['GIS_ID'];
            $('#featureModal').modal('show');
        } else { $('#featureModal').modal('hide'); }
    }
});

const typeSelect = document.getElementById('type');

let draw;

function addInteraction() {
    const value = typeSelect.value;
    if (value !== 'None') {
        draw = new ol.interaction.Draw({ source: vectorSource, type: value });
        map.addInteraction(draw);
        draw.on('drawend', function(event) {
            const feature = event.feature;
            const coordinates = feature.getGeometry().getCoordinates();
            $.post('/add-feature', { '_token': '{{ csrf_token() }}', 'longitude': coordinates[0], 'latitude': coordinates[1], 'gis_id': feature.getId() })
                .done(function(response) { console.log(response.message); refreshMapAndData(); })
                .fail(function(xhr, status, error) { console.error(error); });
        });
    }
}

function refreshMapAndData() {
    vectorSource.clear();
    fetch(geoJsonFilePath)
        .then(response => response.ok ? response.json() : Promise.reject('Failed to load GeoJSON file'))
        .then(geoJsonData => {
            vectorSource.addFeatures(new ol.format.GeoJSON().readFeatures(geoJsonData));
            features.forEach(feature => feature.setStyle(gisIdSet.has(feature.getProperties()['GIS_ID']) ? completeStyle : clickedStyle));
        })
        .catch(error => console.error('Error loading files:', error));
}

typeSelect.onchange = function() {
    map.removeInteraction(draw);
    addInteraction();
};

document.getElementById('undo').addEventListener('click', function() { draw.removeLastPoint(); });

addInteraction();

    </script>
@endsection
