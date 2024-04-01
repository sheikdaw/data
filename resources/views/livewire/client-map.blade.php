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
                            <button type="submit" id="pointSubmit" class="btn btn-primary">Save image</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/ol@v9.0.0/dist/ol.js"></script>
        <script type="text/javascript">var clickedStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 0, 0, 0.6)' // Red color with some opacity
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 0, 0, 1)', // Red color for outline
                width: 2 // Outline width
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: 'rgba(255, 0, 0, 1)' // Red color for point symbol
                })
            })
        });

        var completeStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(0, 48, 143, 0.6)' // Blue color with some opacity
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(0, 48, 143, 1)', // Green color for outline
                width: 2 // Outline width
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: 'rgba(0, 48, 143, 1)' // Green color for point symbol
                })
            })
        });

        var filterStyle = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 215, 0, 0.6)' // Dark yellow color with some opacity
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(255, 215, 0, 1)', // Dark yellow color for outline
                width: 2 // Outline width
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: 'rgba(255, 215, 0, 1)' // Dark yellow color for point symbol
                })
            })
        });

        var pointpath = "{{ $point }}";
        var buildingpath = "{{ asset('public/kovai/building.json') }}";
        var pngFilePath = "D:\cloned github\gis\png1.png";

        var pointJsonPromise = fetch(pointpath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load GeoJSON file');
                }
                return response.json();
            });
        var buildingJsonPromise = fetch(buildingpath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load GeoJSON file');
                }
                return response.json();
            });
        Promise.all([pointJsonPromise, buildingJsonPromise])
            .then(responses => {
                var pointJsonData = responses[0];
                var buildingJsonData = responses[1];
                var features = (new ol.format.GeoJSON()).readFeatures(pointJsonData);
                var buildingfeatures = (new ol.format.GeoJSON()).readFeatures(buildingJsonData);

                var vectorSource = new ol.source.Vector({
                    features: features
                });
                var vectorLayer = new ol.layer.Vector({
                    source: vectorSource
                });

                var vectorBuildingSource = new ol.source.Vector({
                    features: buildingfeatures
                });
                var vectorBuildingLayer = new ol.layer.Vector({
                    source: vectorBuildingSource
                });

                var extent = [8566150.76848, 1232901.87763, 8568107.06848, 1235527.17763];

                var imageLayer = new ol.layer.Image({
                    source: new ol.source.ImageStatic({
                        url: "{{ asset('public/kovai/new/png2.png') }}",
                        imageExtent: extent
                    })
                });

                var map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM()
                        }), imageLayer, vectorBuildingLayer, vectorLayer
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat([76.955393, 11.020899]),
                        projection: 'EPSG:3857',
                        zoom: 20
                    })
                });

                var createLabelStyleFunction = function(text) {
                    if (text !== undefined && text !== null) {
                        return new ol.style.Style({
                            text: new ol.style.Text({
                                text: text.toString(),
                                font: '25px Calibri,sans-serif',
                                fill: new ol.style.Fill({
                                    color: '#ffff00'
                                }),
                                stroke: new ol.style.Stroke({
                                    color: '#ffff00',
                                    width: 1
                                }),
                                offsetX: 0,
                                offsetY: -20,
                                textAlign: 'center',
                                textBaseline: 'bottom',
                                placement: 'point',
                                maxAngle: Math.PI / 4
                            }),
                            stroke: new ol.style.Stroke({
                                color: 'red',
                                width: 2
                            }),
                            fill: new ol.style.Fill({
                                color: 'rgba(255, 0, 0, 0)' // Red fill with opacity
                            })
                        });
                    } else {
                        return new ol.style.Style({});
                    }
                };

                vectorBuildingLayer.setStyle(function(buildingfeatures) {
                    var id = buildingfeatures.get('OBJECTID');
                    return createLabelStyleFunction(id);
                });

                var markerLayer = new ol.layer.Vector({
                    source: new ol.source.Vector(),
                    style: new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 1],
                            src: 'https://openlayers.org/en/latest/examples/data/icon.png'
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
                    element: document.getElementById('popup'),
                    autoPan: true,
                    autoPanAnimation: {
                        duration: 250
                    }
                });
                map.addOverlay(popup);

                // Rest of your code
            })
            .catch(error => {
                console.error('Error loading files:', error);
            });
        </script>
    @endpush
</div>
