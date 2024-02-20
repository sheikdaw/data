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

</div>
