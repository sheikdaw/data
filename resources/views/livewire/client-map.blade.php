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
            var clickedStyle = new ol.style.Style({
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
            var pngFilePath = "{{ asset('public/kovai/test2png_ProjectRaster21.png') }}";

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
                    var overlays;

                    // var minX = 80.0; // Example minimum X coordinate
                    // var minY = 13.0; // Example minimum Y coordinate
                    // var maxX = 81.0; // Example maximum X coordinate
                    // var maxY = 14.0; // Example maximum Y coordinate

                    var minX =  -0.5; // Example minimum X coordinate
var minY = -25485.5; // Example minimum Y coordinate
var maxX =19040.5; // Example maximum X coordinate
var maxY =  0.5; // Example maximum Y coordinate


                    var imageExtent = [minX, minY, maxX, maxY];

                    overlays = new ol.layer.Group({
                        'title': 'Overlays',
                        layers: [
                            new ol.layer.Image({
                                title: 'Converted Image',
                                source: new ol.source.ImageStatic({
                                    url: pngFilePath, // URL of the converted image
                                    projection: 'EPSG:4326',
                                    imageExtent: imageExtent
                                })
                            })
                        ]
                    });

                    var map = new ol.Map({
                        target: 'map',
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.OSM()
                            }), overlays, vectorBuildingLayer,
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
                        element: document.getElementById('popup'),
                        autoPan: true,
                        autoPanAnimation: {
                            duration: 250
                        }
                    });
                    map.addOverlay(popup);

                    var surveyed = @json($surveyed);

                    var gisIdSet = new Set();

                    surveyed.forEach(function(survey) {
                        gisIdSet.add(survey.gisid);
                    });

                    features.forEach(function(feature) {
                        var properties = feature.getProperties();
                        if (gisIdSet.has(properties['GIS_ID'])) {
                            feature.setStyle(completeStyle);
                        } else {
                            feature.setStyle(clickedStyle);
                        }
                    });

                    map.on('click', function(event) {
                        if (document.getElementById('type').value == 'None') {
                            var feature = map.forEachFeatureAtPixel(event.pixel, function(feature) {
                                return feature;
                            });

                            if (feature) {
                                var properties = feature.getProperties();
                                var geometryType = feature.getGeometry().getType();
                                alert("Geometry type: " + geometryType);
                                if (geometryType == 'Point') {
                                    var content = '';
                                for (var key in properties) {
                                    if (key !== 'geometry') {
                                        content += '<li><strong>' + key + ':</strong> ' + properties[key] + '</li>';
                                    }
                                }
                                document.getElementById('featurePropertiesList').innerHTML = content;
                                document.getElementById('gisIdInput').value = properties['GIS_ID'];
                                $('#featureModal').modal('show');
                                var newStyle = new ol.style.Style({
                                    image: new ol.style.Circle({
                                        radius: 6,
                                        fill: new ol.style.Fill({
                                            color: 'blue' // Change color as desired
                                        }),
                                        stroke: new ol.style.Stroke({
                                            color: 'white'

                                        })
                                    })
                                });
                                feature.setStyle(newStyle);
                                }
                            } else {
                                $('#featureModal').modal('hide');
                            }
                        }
                    });
                    const typeSelect = document.getElementById('type');

                    let draw; // global so we can remove it later

                    function addInteraction() {
                        const value = typeSelect.value;
                        if (value !== 'None') {
                            draw = new ol.interaction.Draw({
                                source: vectorSource,
                                type: typeSelect.value,
                            });
                            map.addInteraction(draw);
                            draw.on('drawend', function(event) {
                                const feature = event.feature;
                                const geometry = feature.getGeometry();
                                const coordinates = geometry.getCoordinates();

                                // Send an Ajax request to Laravel route to add the feature to JSON
                                $.ajax({
                                    url: '/add-feature',
                                    type: 'POST', // Use POST method
                                    data: JSON.stringify({
                                        '_token': '{{ csrf_token() }}',
                                        'longitude': coordinates[0],
                                        'latitude': coordinates[1],
                                        'gis_id': feature
                                            .getId() // Assuming you're setting an ID for the feature
                                    }),
                                    contentType: 'application/json', // Set content type to JSON
                                    success: function(response) {
                                        console.log(response.message);
                                        // Handle success response
                                        // Refresh the map and update JSON data after point addition
                                        refreshMapAndData();
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                        // Handle error response
                                    }
                                });
                            });
                        }
                    }

                    function refreshMapAndData() {
                        // Clear the vector source to remove existing features from the map
                        vectorSource.clear();

                        // Fetch new GeoJSON data
                        fetch(pointpath)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to load GeoJSON file');
                                }
                                return response.json();
                            })
                            .then(pointJsonData => {
                                var features = (new ol.format.GeoJSON()).readFeatures(pointJsonData);

                                // Add new features to the vector source
                                vectorSource.addFeatures(features);

                                // Iterate over features to set style
                                features.forEach(function(feature) {
                                    var properties = feature.getProperties();
                                    if (gisIdSet.has(properties['GIS_ID'])) {
                                        feature.setStyle(completeStyle);
                                    } else {
                                        feature.setStyle(clickedStyle);
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error refreshing map and data:', error);
                                // Handle error
                            });
                    }
                    /**
                     * Handle change event.
                     */
                    typeSelect.onchange = function() {
                        map.removeInteraction(draw);
                        addInteraction();
                    };
                    document.getElementById('undo').addEventListener('click', function() {
                        // When the element with the ID 'undo' is clicked, execute the following function
                        $.ajax({
                            url: '/delete-feature', // URL to send the AJAX request
                            success: function(response) {
                                console.log(response
                                    .message);
                                refreshMapAndData();
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });


                    addInteraction();


                    $("#filterBtn").click(function(e) {
                        e.preventDefault();
                        var gisidvalue = $("#gisidval").val();

                        // Clear existing features
                        vectorSource.clear();

                        var features = (new ol.format.GeoJSON()).readFeatures(pointJsonData);
                        features.forEach(function(feature) {
                            var properties = feature.getProperties();
                            var newStyle;
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




                })
                .catch(error => {
                    console.error('Error loading files:', error);
                });
        </script>
    @endpush
</div>
