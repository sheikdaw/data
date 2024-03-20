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
            class GeoJsonLayer {
                constructor(path, style) {
                    this.path = path;
                    this.style = style;
                    this.features = [];
                    this.source = new ol.source.Vector();
                    this.layer = new ol.layer.Vector({
                        source: this.source
                    });
                }

                async loadFeatures() {
                    try {
                        const response = await fetch(this.path);
                        if (!response.ok) {
                            throw new Error('Failed to load GeoJSON file');
                        }
                        const data = await response.json();
                        this.features = (new ol.format.GeoJSON()).readFeatures(data);
                        this.source.addFeatures(this.features);
                        this.features.forEach(feature => {
                            feature.setStyle(this.style);
                        });
                    } catch (error) {
                        console.error('Error loading GeoJSON file:', error);
                    }
                }
            }

            class MapHandler {
                constructor() {
                    this.map = null;
                }

                initMap(target, layers, view) {
                    this.map = new ol.Map({
                        target: target,
                        layers: layers,
                        view: view
                    });
                }

                addLayer(layer) {
                    this.map.addLayer(layer);
                }

                removeInteraction(interaction) {
                    this.map.removeInteraction(interaction);
                }

                addInteraction(interaction) {
                    this.map.addInteraction(interaction);
                }

                addOverlay(overlay) {
                    this.map.addOverlay(overlay);
                }

                on(event, callback) {
                    this.map.on(event, callback);
                }
            }

            class FeatureInteraction {
                constructor(source, type, drawendCallback) {
                    this.source = source;
                    this.type = type;
                    this.drawendCallback = drawendCallback;
                    this.interaction = null;
                }

                createInteraction() {
                    this.interaction = new ol.interaction.Draw({
                        source: this.source,
                        type: this.type
                    });
                    this.interaction.on('drawend', this.drawendCallback);
                    return this.interaction;
                }
            }

            // Example usage:

            const clickedStyle = new ol.style.Style({
                // Define style properties
            });

            const vectorSource = new GeoJsonLayer(pointpath, clickedStyle);
            const vectorBuildingSource = new GeoJsonLayer(buildingpath, completeStyle);

            const mapHandler = new MapHandler();
            mapHandler.initMap('map', [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                vectorBuildingSource.layer,
                vectorSource.layer
            ], new ol.View({
                center: ol.proj.fromLonLat([76.955393, 11.020899]),
                projection: 'EPSG:3857',
                zoom: 20
            }));

            vectorSource.loadFeatures();
            vectorBuildingSource.loadFeatures();

            const drawInteraction = new FeatureInteraction(vectorSource.source, 'Point', function(event) {
                // Handle drawend event
                // This function will be called when a point is drawn
                const feature = event.feature;
                const geometry = feature.getGeometry();
                const coordinates = geometry.getCoordinates();
                // Send an Ajax request to Laravel route to add the feature to JSON
                alert(coordinates);
                // Your AJAX logic here
            });

            mapHandler.addInteraction(drawInteraction.createInteraction());

            // Add more interactions, overlays, event listeners, etc. as needed

            // Remember to replace remaining code outside the provided snippet with appropriate class instances and method calls.
        </script>
    @endpush
</div>
