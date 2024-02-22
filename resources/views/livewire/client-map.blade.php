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
            <option value="None">None</option>
            <option value="Point">Point</option>
            <option value="LineString">LineString</option>
            <option value="Polygon">Polygon</option>
            <option value="Circle">Circle</option>
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
                    {{-- <form id="featureForm" method="post" action="{{ route('client.Survey-Form-Point') }}">
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
                </form> --}}
                    <form action="{{ route('client.gis-images-upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div id="alertBox" class="alert alert-danger" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="gis">Gis</label>
                                <input type="text" class="form-control" id="gisIdInput" name="gisid" readonly>
                            </div>
                            <div class="form-group">
                                <label for="ward">Ward</label>
                                <input type="text" name="ward" class="form-control" id="ward">
                            </div>
                            <div class="form-group">
                                <label for="value">Picture</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- Moved submit button inside the form -->
                            <button type="submit" class="btn btn-primary">Save image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
        <script>
            class MapManager {
    constructor() {
        this.clickedStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 0, 0, 0.6)'
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 0, 0, 1)',
                width: 2
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: 'rgba(255, 0, 0, 1)'
                })
            })
        });

        this.completeStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(0, 48, 143, 0.6)'
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(0, 48, 143, 1)',
                width: 2
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: 'rgba(0, 48, 143, 1)'
                })
            })
        });

        this.pointpath = "{{ $point }}";
        this.pngFilePath = "{{ asset('public/kovai/Ward.png') }}";
        this.left = 8566697.42671;
        this.bottom = 1233036.89252;
        this.right = 8568056.82671;
        this.top = 1234055.69252;
        this.typeSelect = $('#type');
        this.undoButton = $('#undo');
    }

    initMap() {
        this.pointJsonPromise = fetch(this.pointpath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load GeoJSON file');
                }
                return response.json();
            });

        Promise.all([this.pointJsonPromise])
            .then(responses => {
                var pointJsonData = responses[0];
                var features = (new ol.format.GeoJSON()).readFeatures(pointJsonData);

                var vectorSource = new ol.source.Vector({
                    features: features
                });
                var vectorLayer = new ol.layer.Vector({
                    source: vectorSource,

                });
                features.forEach(function(feature) {
        var properties = feature.getProperties();
        if (gisIdSet.has(properties['GIS_ID'])) {
            feature.setStyle(this.completeStyle);
        } else {
            feature.setStyle(this.clickedStyle);
        }
    });

                var pngLayer = new ol.layer.Image({
                    source: new ol.source.ImageStatic({
                        url: this.pngFilePath,
                        imageExtent: [this.left, this.bottom, this.right, this.top],
                        projection: 'EPSG:32643',
                    })
                });

                this.map = new ol.Map({
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

                // Additional initialization...
            })
            .catch(error => {
                console.error('Error loading files:', error);
            });
            this.addInteraction();
        this.typeSelect.on('change', () => {
            this.map.removeInteraction(this.draw);
            this.addInteraction();
        });
        this.undoButton.on('click', () => {
            // Handle undo logic here
            $.ajax({
                url: '/delete-feature',
                success: function(response) {
                    console.log(response.message);
                    this.refreshMapAndData();
                }.bind(this),
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }

    addInteraction() {
        const value = this.typeSelect.val();
        if (value !== 'None') {
            this.draw = new ol.interaction.Draw({
                source: this.vectorSource,
                type: value,
            });
            this.map.addInteraction(this.draw);
            this.draw.on('drawend', event => {
                const feature = event.feature;
                const geometry = feature.getGeometry();
                const coordinates = geometry.getCoordinates();

                $.ajax({
                    url: '/add-feature',
                    type: 'POST',
                    data: JSON.stringify({
                        '_token': '{{ csrf_token() }}',
                        'longitude': coordinates[0],
                        'latitude': coordinates[1],
                        'gis_id': feature.getId()
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log(response.message);
                        this.refreshMapAndData();
                    }.bind(this),
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        }
    }
    refreshMapAndData(features) {
        const gisIdSet = new Set(); // Assuming gisIdSet is defined somewhere accessible
        this.surveyed.forEach(survey => {
            gisIdSet.add(survey.gisid);
        });

        features.forEach(feature => {
            const properties = feature.getProperties();
            if (gisIdSet.has(properties['GIS_ID'])) {
                feature.setStyle(this.completeStyle);
            } else {
                feature.setStyle(this.clickedStyle);
            }
        });

        const vectorLayer = new ol.layer.Vector({
            source: this.vectorSource
        });
        vectorLayer.set('name', 'pointLayer'); // Set a name to identify the layer
        this.map.addLayer(vectorLayer);
    }

}

$(document).ready(function() {
    const mapManager = new MapManager();
    mapManager.initMap();


});


        </script>
    @endpush
</div>
