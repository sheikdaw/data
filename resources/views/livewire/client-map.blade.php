<div>
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
        <style>
            .map {
                width: 100%;
                height: 1000px;
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
    @if (session('status'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('status') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <form class="form-inline">
        <label for="type">Geometry type: &nbsp;</label>
        <select class="form-control mr-2 mb-2 mt-2" id="type">
            <option value="None">None</option>
            @if (Route::is('client.*'))
                <option value="Point">Point</option>
                <option value="LineString">LineString</option>
                <option value="Polygon">Polygon</option>
                <option value="Circle">Circle</option>
            @endif
        </select>
        @if (Route::is('client.*'))
            <input class="form-control mr-2 mb-2 mt-2" type="button" value="Undo" id="undo">
        @endif
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

    <div class="modal fade" id="buildingModal" tabindex="-1" aria-labelledby="buildingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buildingModalLabel">Feature Properties</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('public/images/2.jpg') }}" id="building_img" alt="" width="300px">
                    <h4>Feature Properties</h4>
                    <ul id="featurePropertiesList">
                        <!-- Feature properties will be displayed here -->
                    </ul>
                    <hr>
                    <h4>Feature Form</h4>

                    <form id="buildingForm" enctype="multipart/form-data"> <form wire:submit.prevent="submitForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div id="alertBox" class="alert alert-danger" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="gis">Gis</label>
                                <input type="text" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="gisIdInput" name="gisid"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="number_bill">Number_of_Bill</label>
                                <input type="text" name="number_bill" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="number_bill">
                                <div id="number_bill_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="number_floor">Number_of_Floor</label>
                                <input type="text" name="number_floor" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="number_floor">
                                <div id="number_floor_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="Percentage">Percentage</label>
                                <select name="percentage" id="percentage" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value=""></option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="70">70</option>
                                    <option value="80">80</option>
                                    <option value="90">90</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="watet_tax">Watet_tax</label>
                                <input type="text" name="watet_tax" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="watet_tax">
                                <div id="watet_tax_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="eb">Eb_number</label>
                                <input type="text" name="eb" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="eb">
                                <div id="eb_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="building_name">Building_name</label>
                                <input type="text" name="building_name" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="building_name">
                                <div id="building_name_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="Building_usage">Building_usage</label>
                                <select name="building_usage" id="building_usage" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value=""></option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Mixed">Mixed</option>
                                </select>
                                <div id="building_usage_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="construction_type">Construction_type</label>
                                <select name="construction_type" id="construction_type" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value=""></option>
                                    <option value="PERMANENT">PERMANENT</option>
                                    <option value="SEMI-PERMANENT">SEMI-PERMANENT</option>
                                </select>
                                <div id="construction_type_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="road_name " >Road_name</label>


                                    <select  class="form-control" name="road_name"
                                    id="road_name"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value=""></option>
                                    @foreach ($road_name as $road)
                                        <option value="{{ $road->road_name }}">{{ $road->road_name }}</option>
                                    @endforeach
                                </select>
                                <div id="road_name_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="new_address_select">New Address</label>
                                <input type="text" name="new_address" id="new_address"  class="form-control"
                                @if (Route::is('seller.*')) readonly @endif >

                                <div id="new_address_div"></div>
                            </div>

                            <div class="form-group">
                                <label for="ugd">UGD</label>
                                <input type="text" name="ugd" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="ugd">
                                <div id="ugd_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="rainwater_harvesting">Rainwater_harvesting</label>
                                <select name="rainwater_harvesting" id="rainwater_harvesting" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="rainwater_harvesting_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="parking">Parking</label>
                                <select name="parking" id="parking" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value=""></option>
                                    <option value="NO">NO</option>
                                    <option value="Basement">Basement</option>
                                    <option value="Ground-Parking">Ground-Parking</option>
                                </select>
                                <div id="parking_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="ramp">Ramp</label>
                                <select name="ramp" id="ramp" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="ramp_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="hoarding">Hoarding</label>
                                <select name="hoarding" id="hoarding" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="hoarding_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="cell_tower">Cell_tower</label>
                                <select name="cell_tower" id="cell_tower" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="cell_tower_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="overhead_tank">OverHead Tank</label>
                                <select name="overhead_tank" id="overhead_tank" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="overhead_tank_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="liftroom">LiftRoom</label>
                                <select name="liftroom" id="liftroom" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="liftroom_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="headroom">Head Room</label>
                                <select name="headroom" id="headroom" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="headroom_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="solar_panel">Solar_panel</label>
                                <select name="solar_panel" id="solar_panel" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                                <div id="solar_panel_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="water_connection">Water_connection</label>
                                <select name="water_connection" id="water_connection" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="NO">NO</option>
                                    <option value="Bore">Bore</option>
                                    <option value="OPEN-WELL">OPEN-WELL</option>
                                    <option value="METRO">METRO</option>
                                </select>
                                <div id="water_connection_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="phone">phone_numnber</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                @if (Route::is('seller.*')) readonly @endif>

                                <div id="phone_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="value">Picture</label>
                                <input type="file" name="image" id="image" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                <div id="image_error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @if (Route::is('client.*'))
                                <button type="submit" id="pointSubmit" class="btn btn-primary">Save</button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pointModal" tabindex="-1" aria-labelledby="pointModalLabel" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pointModalLabel">Feature Properties</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Feature Properties</h4>
                    <ul id="featurepoint">
                        <!-- Feature properties will be displayed here -->
                    </ul>
                    <hr>
                    <button class="btn" id="addEstablishment">ADD</button>
                    <h4>Feature Form</h4>
                    <form method="POST" enctype="multipart/form-data" id="pointForm">

                        <div class="modal-body">
                            <div id="alertBox" class="alert alert-danger" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="gis">Gis</label>
                                <input type="text" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="pointgis"
                                    name="point_gisid" readonly>
                                <div id="pointgis_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="assessment">Assessment_no</label>
                                <input type="text" name="assessment" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="assessment">
                                <div id="assessment_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="old_assessment">Old Assessment</label>
                                <input type="text" name="old_assessment" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="old_assessment">
                                <div id="old_assessment_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="floor"> Floor</label>
                                <input type="text" name="floor" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="floor">
                                <div id="floor_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="old_door_no"> Old_door_no</label>
                                <input type="text" name="old_door_no" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="old_door_no">
                                <div id="old_door_no_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="new_door_no"> New_door_no</label>
                                <input type="text" name="new_door_no" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="new_door_no">
                                <div id="new_door_no_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="bill_usage">Bill_usage</label>
                                <select name="bill_usage" id="bill_usage" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Mixed">Mixed</option>
                                </select>
                                <div id="bill_usage_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="aadhar_no">Aadhar_no</label>
                                <input type="text" name="aadhar_no" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="aadhar_no">
                                <div id="aadhar_no_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="ration_no">Ration_no</label>
                                <input type="text" name="ration_no" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="ration_no">
                                <div id="ration_no_error"></div>
                            </div>

                            <div class="form-group">
                                <label for="phone">phone_numnber</label>
                                <input type="text" name="phone_number" class="form-control"
                                    @if (Route::is('seller.*')) readonly @endif id="phone">
                                <div id="phone_number_error"></div>
                            </div>
                            <div id="append"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @if (Route::is('client.*'))
                                <button type="submit" id="pointSubmit" class="btn btn-primary">Save image</button>
                            @endif

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/ol@v9.0.0/dist/ol.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {
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
                var pngFilePath = "D:\\cloned github\\gis\\png1.png"; // Note the double backslashes to escape correctly

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
                        // Define the extent of the image
                        var extent = [8566150.76848, 1232901.87763, 8568107.06848, 1235527.17763];

                        // Create the static image layer
                        var imageLayer = new ol.layer.Image({
                            source: new ol.source.ImageStatic({
                                url: "{{ asset('public/kovai/new/png2.png') }}", // Path to your static image
                                imageExtent: extent
                            })
                        });

                        var map = new ol.Map({
                            target: 'map',
                            layers: [
                                new ol.layer.Tile({
                                    source: new ol.source.OSM()
                                }), imageLayer, vectorBuildingLayer,
                                vectorLayer
                            ],
                            view: new ol.View({
                                center: ol.proj.fromLonLat([76.955393, 11.020899]),
                                projection: 'EPSG:3857',
                                zoom: 20
                            })
                        });
                        var createLabelStyleFunction = function(text) {
                            text = text || ''; // Set a default value if text is undefined or null
                            return new ol.style.Style({
                                text: new ol.style.Text({
                                    text: text.toString(), // Convert to string
                                    font: '20px Calibri,sans-serif',
                                    fill: new ol.style.Fill({
                                        color: '#ffff00' // Yellow color
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
                                    width: 1
                                }),
                                fill: new ol.style.Fill({
                                    color: 'rgba(255, 0, 0, 0)'
                                })
                            });
                        };

                        var completeLabelStyleFunction = function(text) {
                            text = text || ''; // Set a default value if text is undefined or null
                            return new ol.style.Style({
                                text: new ol.style.Text({
                                    text: text.toString(), // Convert to string
                                    font: '20px Calibri,sans-serif',
                                    fill: new ol.style.Fill({
                                        color: 'blue'
                                    }),
                                    stroke: new ol.style.Stroke({
                                        color: 'blue',
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
                                    color: 'blue',
                                    width: 3
                                }),
                                fill: new ol.style.Fill({
                                    color: 'rgba(255, 0, 0, 0)'
                                })
                            });
                        };

                        var building_data

                        function buildingStyle(building_data) {
                            var building_data =  building_data; // Assuming this part is correctly handled server-side

                        var buildingGisIdSet = new Set();

                        building_data.forEach(function(building) {
                            buildingGisIdSet.add(building.gisid);
                        });
                            vectorBuildingLayer.setStyle(function(feature) {
                                var id = feature.get('GIS_ID'); // Extract Id from feature properties
                                if (buildingGisIdSet.has(id)) {
                                    console.log(id);

                                    return completeLabelStyleFunction(id);
                                } else {
                                    return createLabelStyleFunction(id);
                                }
                            });
                        }
                        buildingStyle(@json($building_data));


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
                            gisIdSet.add(survey.point_gisid);
                        });
                        features.forEach(function(pointfeature) {
                            var properties = pointfeature.getProperties();

                            if (gisIdSet.has(properties['GIS_ID'])) {
                                console.log(properties['GIS_ID']);
                                pointfeature.setStyle(completeStyle);
                            } else {
                                pointfeature.setStyle(clickedStyle);
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
                                    //alert("Geometry type: " + geometryType);
                                    if (geometryType == 'Point') {
                                        var content = '';
                                        for (var key in properties) {
                                            // alert( key + ':</strong> ' + properties[key]);
                                            if (key !== 'geometry') {
                                                content += '<li><strong>' + key + ':</strong> ' +
                                                    properties[key] +
                                                    '</li>';
                                            }
                                        }
                                        document.getElementById('featurepoint').innerHTML = content;
                                        document.getElementById('pointgis').value = properties['GIS_ID'];
                                        $('#pointModal').modal('show');
                                    } else if (geometryType == 'Polygon') {
                                        var content = '';
                                        for (var key in properties) {
                                            if (key !== 'geometry') {
                                                content += '<li><strong>' + key + ':</strong> ' +
                                                    properties[key] +
                                                    '</li>';
                                            }
                                        }
                                        document.getElementById('featurePropertiesList').innerHTML =
                                            content;

                                        var gisId = properties[
                                            'GIS_ID']; // Get the GIS ID from the clicked feature
                                        document.getElementById('gisIdInput').value =
                                            gisId; // Set the GIS ID value in the form
                                        document.getElementById('number_bill').value = "";
                                        document.getElementById('number_floor').value = "";
                                        document.getElementById('watet_tax').value = "";
                                        document.getElementById('eb').value = "";
                                        document.getElementById('building_name').value = "";
                                        document.getElementById('building_usage').value = "";
                                        document.getElementById('construction_type').value = "";
                                        document.getElementById('road_name').value = "";
                                        document.getElementById('ugd').value = "";
                                        document.getElementById('rainwater_harvesting').value = "";
                                        document.getElementById('parking').value = "";
                                        document.getElementById('ramp').value = "";
                                        document.getElementById('hoarding').value = "";
                                        document.getElementById('liftroom').value = "";
                                        document.getElementById('overhead_tank').value = "";
                                        document.getElementById('headroom').value = "";
                                        document.getElementById('cell_tower').value = "";
                                        document.getElementById('percentage').value = "";
                                        document.getElementById('new_address').value = "";
                                        document.getElementById('solar_panel').value = "";
                                        document.getElementById('water_connection').value = "";
                                        document.getElementById('phone').value = "";
                                        document.getElementById('image').value = "";

                                        var building_data =
                                            @json($building_data); // Get building data from server-side
                                        building_data.forEach(function(selectedBuilding) {
                                            if (selectedBuilding.gisid == gisId) {
                                                alert(selectedBuilding.gisid);
                                                document.getElementById('number_bill').value =
                                                    selectedBuilding
                                                    .number_bill;
                                                document.getElementById('number_floor').value =
                                                    selectedBuilding
                                                    .number_floor;
                                                document.getElementById('watet_tax').value =
                                                    selectedBuilding
                                                    .watet_tax;
                                                document.getElementById('eb').value =
                                                    selectedBuilding.eb;
                                                document.getElementById('building_name').value =
                                                    selectedBuilding
                                                    .building_name;
                                                document.getElementById('building_usage').value =
                                                    selectedBuilding
                                                    .building_usage;
                                                document.getElementById('construction_type').value =
                                                    selectedBuilding
                                                    .construction_type;
                                                document.getElementById('road_name').value =
                                                    selectedBuilding
                                                    .road_name;
                                                document.getElementById('ugd').value =
                                                    selectedBuilding.ugd;
                                                document.getElementById('rainwater_harvesting')
                                                    .value =
                                                    selectedBuilding.rainwater_harvesting;
                                                document.getElementById('parking').value =
                                                    selectedBuilding
                                                    .parking;
                                                document.getElementById('ramp').value =
                                                    selectedBuilding.ramp;
                                                document.getElementById('hoarding').value =
                                                    selectedBuilding
                                                    .hoarding;
                                                document.getElementById('cell_tower').value =
                                                    selectedBuilding
                                                    .cell_tower;
                                                document.getElementById('percentage').value =
                                                    selectedBuilding
                                                    .percentage;
                                                document.getElementById('new_address').value =
                                                    selectedBuilding
                                                    .new_address;
                                                document.getElementById('solar_panel').value =
                                                    selectedBuilding
                                                    .solar_panel;
                                                document.getElementById('water_connection').value =
                                                    selectedBuilding
                                                    .water_connection;
                                                document.getElementById('phone').value =
                                                    selectedBuilding.phone;
                                                document.getElementById('building_img')
                                                    .setAttribute('src',
                                                        `/public${selectedBuilding.image}`);

                                                document.getElementById('image')
                                                    .setAttribute('src',
                                                        `/public${selectedBuilding.image}`);
                                            }
                                        });




                                        $('#buildingModal').modal('show');
                                    }
                                } else {
                                    $('#pointModal').hide();
                                    $('#buildingModal').modal('hide');
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
                                    if (value == "Polygon") {
                                        alert(coordinates);
                                        $.ajax({
                                            url: '/add-feature',
                                            type: 'POST', // Use POST method
                                            data: JSON.stringify({
                                                '_token': '{{ csrf_token() }}',
                                                'type': 'Polygon',
                                                'coordinates': coordinates,
                                                'gis_id': feature
                                                    .getId() // Assuming you're setting an ID for the feature
                                            }),
                                            contentType: 'application/json', // Set content type to JSON
                                            success: function(response) {
                                                console.log(response.message);
                                                // Handle success response
                                                // Refresh the map and update JSON data after point addition
                                                refreshMapAndData("Polygon");
                                                refreshMapAndData("Point");
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(error);
                                                // Handle error response
                                            }
                                        });
                                    }
                                    if (value == 'Point') {
                                        alert(coordinates);
                                        $.ajax({
                                            url: '/add-feature',
                                            type: 'POST', // Use POST method
                                            data: JSON.stringify({
                                                '_token': '{{ csrf_token() }}',
                                                'type': 'Point',
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
                                                refreshMapAndData("Point");
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(error);
                                                // Handle error response
                                            }
                                        });
                                    }
                                });
                            }
                        }
                        $('#buildingForm').submit(function(e) {
                    e.preventDefault();
                    $('.error-message').text('');
                    $('input').removeClass('is-invalid');

                    var formData = new FormData(this);
                    alert(formData);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('client.buildingdata-upload') }}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                    alert('Data saved successfully!');
                                    console.log(response.building_data); // Log the entire building_data object
                                    // Assuming building_data is an array, you can loop through it and log each item
                                    response.building_data.forEach(function(item) {
                                        console.log(item);
                                    });
                                    buildingStyle(response.building_data); // Call buildingStyle function with building_data
                                    // You can close the modal or do any other action upon success
                                }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert(
                                'An error occurred while processing your request. Please try again.'
                            );
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '_error').text(value[0]);
                                });
                            }
                        }
                    });
                });

                        var type;

                        function refreshMapAndData(type) {
                            alert(type);
                            if (type == "Point") {
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
                            } else if (type == "Polygon") {
                                // Clear the vector source to remove existing features from the map
                                vectorBuildingSource.clear();
                                // Fetch new GeoJSON data
                                fetch(buildingpath)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to load GeoJSON file');
                                        }
                                        return response.json();
                                    })
                                    .then(buildingJsonData => {
                                        var features = (new ol.format.GeoJSON()).readFeatures(buildingJsonData);
                                        // Add new features to the vector sourc e
                                        vectorBuildingSource.addFeatures(features);
                                        buildingStyle(@json($building_data));


                                    })
                                    .catch(error => {
                                        console.error('Error refreshing map and data:', error);
                                        // Handle error
                                    });
                            }
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
                            const value = typeSelect.value;
                            if (value == 'Point' || value == 'Polygon') {
                                $.ajax({
                                    url: '/delete-feature/' +
                                        value, // URL to send the AJAX request with parameter
                                    method: 'GET', // Request method
                                    success: function(response) {
                                        console.log(response.message);
                                        refreshMapAndData(value);
                                        // Display success message

                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                        // Display error message
                                    }
                                });
                            } else {
                                console.error("Invalid feature type.");
                                // Display error message
                                showToast('error', 'Invalid feature type.');
                            }
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
                                vectorSource.addFeature(
                                    feature); // Add the feature back to the source
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error loading files:', error);
                    });






                var establishmentadd = -1;

                // Event handler for the ADD button
                $(document).on('click', '#addEstablishment', function(e) {
                    e.preventDefault();
                    var use = $('#bill_usage').val();
                    if (use != 'Residential') {
                        establishmentadd++;
                        var newRow = `
                        <div class="added bordered">

                                <button class="btn btn-sm btn-dark removeEstablishment">Remove Floor</button>
                                        <div class="form-group">
                                            <label for="shop_floor" >Shop Floor</label>
                                            <input type="text" name="shop_floor[${establishmentadd}]" id="shop_floor" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Shop Floor">
                                            <div class="text-danger" id="shop_floor.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shop_name" >Shop Name</label>
                                            <input type="text" name="shop_name[${establishmentadd}]" id="shop_name" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Shop Name">
                                            <div class="text-danger" id="shop_name.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shop_owner_name" >Shop Owner Name</label>
                                            <input type="text" name="shop_owner_name[${establishmentadd}]" id="shop_owner_name" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Shop Owner Name">
                                            <div class="text-danger" id="shop_owner_name.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shop_category" >Shop Category</label>
                                            <select name="shop_category[${establishmentadd}]" id="shop_category" class="form-control"  @if (Route::is('seller.*')) readonly @endif>
                                                <option value="1">1</option>
                                            </select>
                                            <div class="text-danger" id="shop_category.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shop_mobile" >Shop Mobile</label>
                                            <input type="text" name="shop_mobile[${establishmentadd}]" id="shop_mobile" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Shop Mobile">
                                            <div class="text-danger" id="shop_mobile.${establishmentadd}_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="license" >License</label>
                                            <select name="license[${establishmentadd}]" id="license" class="form-control"  @if (Route::is('seller.*')) readonly @endif>
                                                <option value="1">1</option>
                                            </select>
                                            <div class="text-danger" id="license.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="professional_tax" >Professional Tax</label>
                                            <select name="professional_tax[${establishmentadd}]" id="professional_tax" class="form-control"  @if (Route::is('seller.*')) readonly @endif>
                                                <option value="1">1</option>
                                            </select>
                                            <div class="text-danger" id="professional_tax.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="gst" >GST Number</label>
                                            <input type="text" name="gst[${establishmentadd}]" id="gst" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="GST">
                                            <div class="text-danger" id="gst.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="number_of_emplyee" >Number of Employee</label>
                                            <input type="text" name="number_of_employee[${establishmentadd}]" id="number_of_employee" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Number of Employee">
                                            <div class="text-danger" id="number_of_employee.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="trade_income" >Trade Income</label>
                                            <input type="text" name="trade_income[${establishmentadd}]" id="trade_income" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Trade Income">
                                            <div class="text-danger" id="trade_income.${establishmentadd}_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="establishment_remarks" >Establishment Remarks</label>
                                            <input type="text" name="establishment_remarks[${establishmentadd}]" id="establishment_remarks" class="form-control"  @if (Route::is('seller.*')) readonly @endif placeholder="Establishment Remarks">
                                            <div class="text-danger" id="establishment_remarks.${establishmentadd}_error"></div>
                                        </div>

                                    </div>
                        </div>`;
                        alert("establishment_remarks.${establishmentadd}_error");
                        $("#append").append(newRow);
                    }
                });

                // Event handler for the Remove button (inside the dynamic row)
                $(document).on('click', '.removeEstablishment', function(e) {
                    e.preventDefault();
                    $(this).closest(".added").remove();
                });



                $('#pointForm').submit(function(e) {
                    e.preventDefault();
                    $('.error-message').text('');
                    $('input').removeClass('is-invalid');
                    var pointData = $(this).serialize(); // Using $(this) to refer to the current form
                    alert(pointData);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('client.pointdata-upload') }}',
                        data: pointData,
                        success: function(response) {
                            if (response.success) {
                                alert('Data saved successfully!');

                                // You can close the modal or do any other action upon success
                                alert(response.data);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert(xhr.responseJSON.message);
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                alert(xhr.responseJSON.message);
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    $('#' + key).addClass(
                                        'is-invalid'); // Add invalid class to input field
                                    $('#' + key + '_error').text(value[
                                        0]); // Display the error message next to the field
                                    console.log('#' + key + '_error');
                                });
                            }
                        }
                    });
                });



                $("#image").change(function() {
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#building_img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
        </script>
    @endpush
</div>
