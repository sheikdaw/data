<div>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
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
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Filter
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filter">
                        <input type="type" value="gis" id="gisidval">
                        <input type="button" value="save" id="filterBtn">
                    </form>
                </div>
            </div>
        </div>
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
        <script src="https://cdn.jsdelivr.net/npm/ol@v9.0.0/dist/ol.js"></script>
        <script type="text/javascript">
            class GeoJSONStyle {
                constructor(fillColor, strokeColor, strokeWidth) {
                    this.fill = new ol.style.Fill({
                        color: fillColor
                    });
                    this.stroke = new ol.style.Stroke({
                        color: strokeColor,
                        width: strokeWidth
                    });
                    this.image = new ol.style.Circle({
                        radius: 6,
                        fill: new ol.style.Fill({
                            color: fillColor
                        })
                    });
                }
            }

            class GeoJSONLayer {
                constructor(sourceData) {
                    this.source = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(sourceData)
                    });
                    this.layer = new ol.layer.Vector({
                        source: this.source
                    });
                }
            }

            class MarkerLayer {
                constructor() {
                    this.source = new ol.source.Vector();
                    this.layer = new ol.layer.Vector({
                        source: this.source,
                        style: new ol.style.Style({
                            image: new ol.style.Icon({
                                anchor: [0.5, 1],
                                src: 'https://openlayers.org/en/latest/examples/data/icon.png'
                            })
                        })
                    });
                }

                addMarker(lonLat) {
                    const pos = ol.proj.fromLonLat(lonLat);
                    this.source.clear();
                    const marker = new ol.Feature({
                        geometry: new ol.geom.Point(pos)
                    });
                    this.source.addFeature(marker);
                }
            }

            class OverlayLayer {
                constructor(imageUrl, extent) {
                    this.layer = new ol.layer.Group({
                        'title': 'Overlays',
                        layers: [
                            new ol.layer.Image({
                                title: 'Converted Image',
                                source: new ol.source.ImageStatic({
                                    url: imageUrl,
                                    projection: 'EPSG:4326',
                                    imageExtent: extent
                                })
                            })
                        ]
                    });
                }
            }

            class Map {
                constructor(targetElement, baseLayer, overlaysLayer, layers) {
                    this.map = new ol.Map({
                        target: targetElement,
                        layers: [baseLayer, overlaysLayer, ...layers],
                        view: new ol.View({
                            center: ol.proj.fromLonLat([80.241610, 13.098640]),
                            zoom: 15
                        })
                    });
                }

                addLayer(layer) {
                    this.map.addLayer(layer);
                }

                addInteraction(interaction) {
                    this.map.addInteraction(interaction);
                }

                setOnClickHandler(handler) {
                    this.map.on('click', handler);
                }
            }class FeatureManager {
    constructor(features, vectorSource, clickedStyle, completeStyle, gisIdSet) {
        this.features = features;
        this.vectorSource = vectorSource;
        this.clickedStyle = clickedStyle;
        this.completeStyle = completeStyle;
        this.gisIdSet = gisIdSet;
    }

    applyStyles() {
        this.features.forEach(feature => {
            const properties = feature.getProperties();
            if (this.gisIdSet.has(properties['GIS_ID'])) {
                feature.setStyle(this.completeStyle);
            } else {
                feature.setStyle(this.clickedStyle);
            }
        });
    }
}

class DrawInteraction {
    constructor(map, vectorSource, typeSelect, pointpath, csrfToken) {
        this.map = map;
        this.vectorSource = vectorSource;
        this.typeSelect = typeSelect;
        this.pointpath = pointpath;
        this.csrfToken = csrfToken;
        this.draw = null;
    }

    addInteraction() {
        const value = this.typeSelect.value;
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

                // Send an Ajax request to Laravel route to add the feature to JSON
                $.ajax({
                    url: '/add-feature',
                    type: 'POST', // Use POST method
                    data: JSON.stringify({
                        '_token': this.csrfToken,
                        'longitude': coordinates[0],
                        'latitude': coordinates[1],
                        'gis_id': feature.getId() // Assuming you're setting an ID for the feature
                    }),
                    contentType: 'application/json', // Set content type to JSON
                    success: response => {
                        console.log(response.message);
                        // Handle success response
                        // Refresh the map and update JSON data after point addition
                        refreshMapAndData();
                    },
                    error: (xhr, status, error) => {
                        console.error(error);
                        // Handle error response
                    }
                });
            });
        }
    }
}


            // Usage
            const clickedStyle = new GeoJSONStyle('rgba(255, 0, 0, 0.6)', 'rgba(255, 0, 0, 1)', 2);
            const completeStyle = new GeoJSONStyle('rgba(0, 48, 143, 0.6)', 'rgba(0, 48, 143, 1)', 2);
            const filterStyle = new GeoJSONStyle('rgba(255, 215, 0, 0.6)', 'rgba(255, 215, 0, 1)', 2);

            const pointpath = "{{ $point }}";
            const buildingpath = "{{ asset('public/kovai/building.json') }}";
            const pngFilePath = "{{ asset('public/kovai/Ward.png') }}";

            const pointJsonPromise = fetch(pointpath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load GeoJSON file');
                    }
                    return response.json();
                });

            const buildingJsonPromise = fetch(buildingpath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load GeoJSON file');
                    }
                    return response.json();
                });

            Promise.all([pointJsonPromise, buildingJsonPromise])
                .then(responses => {
                    const pointJsonData = responses[0];
                    const buildingJsonData = responses[1];

                    const vectorLayer = new GeoJSONLayer(pointJsonData);
                    const vectorBuildingLayer = new GeoJSONLayer(buildingJsonData);
                    const overlaysLayer = new OverlayLayer(pngFilePath, [80.0, 13.0, 81.0, 14.0]).layer;
                    const baseLayer = new ol.layer.Tile({
                        source: new ol.source.OSM()
                    });

                    const map = new Map('map', baseLayer, overlaysLayer, [vectorBuildingLayer.layer, vectorLayer.layer]);

                    const markerLayer = new MarkerLayer();
                    map.addLayer(markerLayer.layer);

                    if ('geolocation' in navigator) {
                        navigator.geolocation.watchPosition(position => {
                            markerLayer.addMarker([position.coords.longitude, position.coords.latitude]);
                        }, error => {
                            console.error('Error getting geolocation:', error);
                        });
                    } else {
                        console.error('Geolocation is not supported by this browser.');
                    }

                    // Other parts of your code...
                })
                .catch(error => {
                    console.error('Error loading files:', error);
                });
                const surveyed = @json($surveyed);
const gisIdSet = new Set();

surveyed.forEach(survey => {
    gisIdSet.add(survey.gisid);
});

const featureManager = new FeatureManager(features, vectorSource, clickedStyle, completeStyle, gisIdSet);
featureManager.applyStyles();

const drawInteraction = new DrawInteraction(map, vectorSource, typeSelect, pointpath, '{{ csrf_token() }}');
drawInteraction.addInteraction();

$("#filterBtn").click(e => {
    e.preventDefault();
    const gisidvalue = $("#gisidval").val();

    // Clear existing features
    vectorSource.clear();

    const features = (new ol.format.GeoJSON()).readFeatures(pointJsonData);
    features.forEach(feature => {
        const properties = feature.getProperties();
        let newStyle;
        if (gisidvalue == properties['GIS_ID']) {
            newStyle = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({
                        color: 'green'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'white'
                    })
                })
            });
        } else {
            newStyle = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({
                        color: 'red'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'white'
                    })
                })
            });
        }

        feature.setStyle(newStyle);
        vectorSource.addFeature(feature); // Add the feature back to the source
    });
});
        </script>
    @endpush
</div>
