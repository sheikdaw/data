<div>
    @push('style')
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
@endpush

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
@push('script')


<script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    var geoJsonFilePath = "{{ asset('public/kovai/test.json') }}";

    $.ajax({
        url: geoJsonFilePath,
        dataType: 'json',
        success: function(geoJsonData) {
            var features = (new ol.format.GeoJSON()).readFeatures(geoJsonData);

            var vectorSource = new ol.source.Vector({
                features: features
            });
            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });

            var pngLayer = new ol.layer.Image({
                source: new ol.source.ImageStatic({
                    url: pngFilePath,
                    imageExtent: [left, bottom, right, top],
                    projection: 'EPSG:32643',
                })
            });

            var map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    }),
                    pngLayer,
                    vectorLayer
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([80.241610, 13.098640]),
                    zoom: 15
                })
            });

            var markerLayer = new ol.layer.Vector({
                source: new ol.source.Vector(),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 1],
                        src: 'https://openlayers.org/en/latest/examples/data/icon.png' // Marker icon image
                    })
                })
            });
            map.addLayer(markerLayer);

            if ('geolocation' in navigator) {
                navigator.geolocation.watchPosition(function(position) {
                    var lonLat = [position.coords.longitude, position.coords.latitude];
                    var pos = ol.proj.fromLonLat(lonLat);
                    markerLayer.getSource().clear();
                    var marker = new ol.Feature({
                        geometry: new ol.geom.Point(pos)
                    });
                    markerLayer.getSource().addFeature(marker);
                    map.getView().setCenter(pos);
                }, function(error) {
                    console.error('Error getting geolocation:', error);
                });
            } else {
                console.error('Geolocation is not supported by this browser.');
            }

            var popup = new ol.Overlay({
                element: $('#popup'),
                autoPan: true,
                autoPanAnimation: {
                    duration: 250
                }
            });
            map.addOverlay(popup);

            var surveyed = @json($surveyed);

            var gisIdSet = new Set();

            $.each(surveyed, function(index, survey) {
                gisIdSet.add(survey.gisid);
            });

            $.each(features, function(index, feature) {
                var properties = feature.getProperties();
                if (gisIdSet.has(properties['GIS_ID'])) {
                    feature.setStyle(completeStyle);
                } else {
                    feature.setStyle(clickedStyle);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load GeoJSON file:', error);
        }
    });
});
</script>
    @endpush
</div>
