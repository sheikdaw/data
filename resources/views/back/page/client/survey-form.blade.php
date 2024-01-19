@extends('back.layout.page-layout')
@section('pagetitle',isset($pagetitle)?$pagetitle:'page title')
@section('content')
  
    <div class=" align-item-center justify-content-center d-flex-auto mt-5">
        <button class="btn btn-primary" id="assessment_btn">Assessment</button>
        <button class="btn btn-primary" id="address_btn">Address</button>
        <button class="btn btn-primary" id="floor_btn">Floor</button>
        <button class="btn btn-primary" id="establishment_btn">Establishment</button>
        <button class="btn btn-primary" id="facility_btn">Facility</button>
        <form id="myForm" class=" card bg-primary" >
            @csrf
            <div class="card-body">
                <div class="row" id="assessment_field">
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="Assessment" class="text-light">Assessment</label>
                            <input type="text" class="form-control" name="assessment" id="assessment"
                                value="{{ old('assessment') ? old('assessment') : $data->assessment }}"
                                placeholder="Assessment">

                            <div class="text-danger" id="assessment_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Ward" class="text-light">Ward</label>
                            <input type="text" class="form-control" name="ward" id="ward"
                                value="{{ old('ward') ? old('ward') : $data->ward }}" placeholder="Ward">
                            <div class="text-danger" id="ward_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Owner-Name" class="text-light">Owner Name</label>
                            <input type="text" class="form-control" name="owner_name" id="owner_name"
                                value="{{ old('owner_name') ? old('owner_name') : $data->owner_name }}"
                                placeholder="Owner_Name">
                            <div class="text-danger" id="owner_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Present-Owner" class="text-light">Present Owner Name</label>
                            <input type="text" class="form-control" name="present_owner" id="present_owner"
                                value="" placeholder="Present Owner">
                            <div class="text-danger" id="present_owner_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Water Tax" class="text-light">Water Tax</label>
                            <input type="text" class="form-control" name="water_tax" id="water_tax" value=""
                                placeholder="Water Tax">
                            <div class="text-danger" id="water_tax_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Building Location" class="text-light">Building Location</label>
                            <input type="text" class="form-control" name="building_location" id="building_location"
                                value="{{ old('building_location') ? old('building_location') : $data->building_location }}"
                                placeholder="Building Location">
                            <div class="text-danger" id="building_location_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Mobile" class="text-light">Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                value="{{ old('mobile') ? old('building_location') : $data->mobile }}" placeholder="Mobile">
                            <div class="text-danger" id="mobile_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Gis id" class="text-light">Gis id</label>
                            <input type="text" class="form-control" name="gisid" id="gisid" value=""
                                placeholder="Gis id">
                            <div class="text-danger" id="gisid_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Build uparea" class="text-light">Build uparea</label>
                            <input type="text" class="form-control" name="build_uparea" id="build_uparea"
                                value="" placeholder="Build uparea">
                            <div class="text-danger" id="build_uparea_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Building Name" class="text-light">Building Name</label>
                            <input type="text" class="form-control" name="building_name" id="building_name"
                                value="" placeholder="Building Name">
                            <div class="text-danger" id="building_name_error"></div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="Old Assessment" class="text-light">Old Assessment</label>
                            <input type="text" class="form-control" name="old_assessment" id="old_assessment"
                                value="" placeholder="Old Assessment">
                            <div class="text-danger" id="old_assessment_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="building_structure" class="text-light">Building Structure</label>
                            <select class="form-control" name="building_structure" id="building_structure">
                                <option></option>
                                <option value="Permenent">Permenent</option>
                                <option value="Semi-Permenent">Semi-Permenent</option>
                                <option value="Vacantland">Vacantland</option>
                            </select>
                            <div class="text-danger" id="building_structure_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Building Usage" class="text-light">Building Usage</label>
                            <select class="form-control" name="building_usage" id="building_usage">
                                <option></option>
                                <option value="Resitendial">Resitendial</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Mixed">Mixed</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Vacantland">Vacantland</option>
                            </select>
                            <div class="text-danger" id="building_usage_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Building Type" class="text-light">Building Type</label>
                            <select class="form-control" id="building_type" name="building_type">
                                <option></option>
                                <option value="Independent">Independent</option>
                                <option value="Temple">Temple</option>
                                <option value="Flats">Flats</option>
                                <option value="Apartment">Apartment</option>
                                <option value="State Government">State Government</option>
                                <option value="School">School</option>
                                <option value="College">College</option>
                                <option value="Hotel">Hotel</option>
                                <option value="Hostel">Hostel</option>
                                <option value="centr4al government">central government</option>
                                <option value="Vacantland">Vacantland</option>
                                <option value="Amma vunavagam">Amma vunavagam</option>
                                <option value="Kalyanamandabam">Kalyanamandabam</option>
                            </select>
                            <div class="text-danger" id="building_type_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Ration Card NO" class="text-light">Ration Card NO</label>
                            <input type="text" class="form-control" name="ration" id="ration" value=""
                                placeholder="Ration Card">
                        </div>
                        <div class="mb-3">
                            <label for="Aadhar Card NO" class="text-light">Aadhar Card NO</label>
                            <input type="text" class="form-control" name="aadhar" id="aadhar" value=""
                                placeholder="Aadhar Card">
                        </div>
                        <div class="mb-3">
                            <label for="Number of Shop" class="text-light">Number of Shop</label>
                            <input type="text" class="form-control" name="number_of_shop" id="number_of_shop"
                                value="" placeholder="Number of Shop">
                        </div>
                        <div class="mb-3">
                            <label for="Number of Bill" class="text-light">Number of Bill</label>
                            <input type="text" class="form-control" name="number_of_bill" id="number_of_bill"
                                value="" placeholder="Number of Bill">
                        </div>
                        <div class="mb-3">
                            <label for="Number of Floor" class="text-light">Number of Floor</label>
                            <input type="text" class="form-control" name="number_of_floor" id="number_of_floor"
                                value="" placeholder="Number of Floor">
                        </div>
                        <div class="mb-3">
                            <label for="Location" class="text-light">Location</label>
                            <input type="text" class="form-control" name="location" id="location" value=""
                                placeholder="Location">
                        </div>
                    </div>
                </div>
                <div class="row" id="address_field">
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="Road Name" class="text-light">Road Name</label>
                            <select name="road_name" id="road_name" value="" placeholder="Road Name"
                                class="form-control">
                                @foreach ($mis as $item)
                                    <option value="{{ $item->road_name}}">{{ $item->road_name}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="road_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Old Door Number" class="text-light">Old Door Number</label>
                            <input type="text" class="form-control" name="old_door_number" id="old_door_number"
                                placeholder="Old Door Number" value="">
                            <div class="text-danger" id="old_door_number_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="New Door Number" class="text-light">New Door Number</label>
                            <input type="text" class="form-control" name="new_door_number" id="new_door_number"
                                placeholder="New Door Number" value="">
                            <div class="text-danger" id="new_door_number_error"></div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="Old Address" class="text-light">Old Address</label>
                            <input type="text" class="form-control" name="old_address" id="old_address"
                                placeholder="Old Address" value="">
                            <div class="text-danger" id="old_address_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="New Address" class="text-light">New Address</label>
                            <input type="text" class="form-control" name="new_address" id="new_address"
                                placeholder="New Address" value="">
                            <div class="text-danger" id="new_address_error"></div>
                        </div>
                    </div>
                </div>
                <div id="floor_field">

                    <div class="row" id="floor_field">
                        <div id="errorAlert" class="alert alert-danger alert-dismissible" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error:</strong>
                            <span id="errorMessages"></span>
                        </div>
                        
                        <button class="btn btn-tight" id="addFloor">
                            <i class="fas fa-plus"></i> Add Floor
                        </button>
                        <!-- Rest of your form structure -->
                    </div>
                    <div class="row">
                        
                        
                        <div class="col-6 col-sm-6">
                            <div class="mb-3">
                                <label for="Floor" class="text-light">Floor</label>
                                <input type="text" class="form-control" name="floor[0]" id="floor[0]"
                                    placeholder="Floor" value="">
                                <div class="text-danger" id="floor.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Construction Type" class="text-light">Construction Type</label>
                                <select name="construction_type[0]" id="construction_type[0]" class="form-control"
                                    placeholder="Construction Type">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger" id="construction_type.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Percentage" class="text-light">Percentage</label>
                                <select name="percentage[0]" id="percentage[0]" class="form-control"
                                    placeholder="Percentage">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger " id="percentage.0"></div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6">
                            <div class="mb-3">
                                <label for="Occupied_by" class="text-light">Occupied_by</label>
                                <select name="occupied[0]" id="occupied[0]" class="form-control"
                                    placeholder="Occupied_by">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger" id="occupied.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Floor Usage" class="text-light">Floor Usage</label>
                                <select name="floor_usage[0]" id="floor_usage[0]" class="form-control floor-usage"
                                    placeholder="Floor Usage">
                                    <option value="COMMERCIAL">COMMERCIAL</option>
                                    <option value="RESIDENTIAL">RESIDENTIAL</option>
                                    <option value="MIXED">MIXED</option>
                                </select>
                                <div class="text-danger" id="floor_usage.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="Remarks" class="text-light">Remarks</label>
                                <input type="text" class="form-control" name="remarks[0]" id="remarks[0]"
                                    placeholder="Remarks" value="">
                                <div class="text-danger" id="remarks.0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="addedFloor"></div>

                </div>
                <!-- establishment field -->

                <div  id="establishment_field">
                    <button class="btn btn-dark" id="addEstablishment">Add Establishment</button>
                    <div class="row">
                        <div class="col-6 col-sm-6">
                            <div class="mb-3">
                                <label for="shop_floor" class="text-light">Shop Floor</label>
                                <input type="text" name="shop_floor[0]" id="shop_floor" class="form-control"
                                    placeholder="Shop Floor">
                                <div class="text-danger" id="shop_floor.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="shop_name[0]" class="text-light">Shop Name</label>
                                <input type="text" name="shop_name" id="shop_name" class="form-control"
                                    placeholder="Shop Name">
                                <div class="text-danger" id="shop_name.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="shop_owner_name" class="text-light">Shop Owner Name</label>
                                <input type="text" name="shop_owner_name[0]" id="shop_owner_name" class="form-control"
                                    placeholder="Shop Owner Name">
                                <div class="text-danger" id="shop_owner_name.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="shop_category" class="text-light">Shop Category</label>
                                <select name="shop_category[0]" id="shop_category" class="form-control">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger" id="shop_category.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="shop_mobile" class="text-light">Shop Mobile</label>
                                <input type="text" name="shop_mobile[0]" id="shop_mobile" class="form-control"
                                    placeholder="Shop Mobile">
                                <div class="text-danger" id="shop_mobile.0"></div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6">
                            <div class="mb-3">
                                <label for="license" class="text-light">License</label>
                                <select name="license[0]" id="license" class="form-control">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger" id="license.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="professional_tax" class="text-light">Professional Tax</label>
                                <select name="professional_tax[0]" id="professional_tax" class="form-control">
                                    <option value="1">1</option>
                                </select>
                                <div class="text-danger" id="professional_tax.0"></div>
                            </div>
                            <div class="mb-3">
                                <label for="establishment_remarks" class="text-light">Establishment Remarks</label>
                                <input type="text" name="establishment_remarks" id="establishment_remarks[0]"
                                    class="form-control" placeholder="Establishment Remarks">
                                <div class="text-danger" id="establishment_remarks.0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="addedEstablishment"></div>
                </div>
                <div class="row" id="facility_field">
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="CCTV" class="text-light">CCTV</label>
                            <select name="cctv" id="cctv" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="cctv_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Head Room" class="text-light">Head Room</label>
                            <select name="headroom" id="headroom" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="headroom_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Parking" class="text-light">Parking</label>
                            <select name="parking" id="parking" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="parking_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Basement" class="text-light">Basement</label>
                            <select name="basement" id="basement" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="basement_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Solar Panel" class="text-light">Solar Panel</label>
                            <select name="solar_panel" id="solar_panel" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="solar_panel_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Water Connection" class="text-light">Water Connection</label>
                            <select name="water_connection" id="water_connection" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="water_connection_error"></div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="mb-3">
                            <label for="Ramp" class="text-light">Ramp</label>
                            <select name="ranp" id="ranp" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="ranp_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Over Headtank" class="text-light">Over Headtank</label>
                            <select name="over_headtank" id="over_headtank" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="over_headtank_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Lift Room" class="text-light">Lift Room</label>
                            <select name="lift_room" id="lift_room" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="lift_room_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Cellphone Tower" class="text-light">Cellphone Tower</label>
                            <select name="collphone_tower" id="collphone_tower" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="collphone_tower_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="EB Connection" class="text-light">EB Connection</label>
                            <select name="eb_connection" id="eb_connection" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <div class="text-danger" id="eb_connection_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="UGD" class="text-light">UGD</label>
                            <input type="text" name="ugd" id="ugd" class="form-control">
                            <div class="text-danger" id="ugd_error"></div>
                        </div>
                    </div>
                    <button class="btn btn-dark" id="submit">Submit</button>
                </div>

            </div>
        </form>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                $("#establishment_btn,#facility_btn,#address_field,#floor_btn,#floor_field,#establishment_field,#facility_field")
                    .hide();
                $('#assessment_btn').click(function(e) {
                    e.preventDefault();
                    $("#establishment_btn,#facility_btn,#address_field,#floor_btn,#floor_field,#establishment_field,#facility_field")
                        .hide();
                    $("#assessment_field").show();

                });
                $('#address_btn').click(function(e) {
                    e.preventDefault();
                    $("#floor_field").hide();
                    var formData = $("#myForm").serialize();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('client.form-property')); ?>',
                        data: formData,
                        success: function(response) {
                            $('#myForm :input').removeClass('is-invalid');
                            $('#myForm .text-danger').html('');

                            if (response.success) {
                                // Validation and processing were successful.
                                $("#assessment_field").hide();
                                $("#address_field,#floor_btn").show();
                            } else {
                                if (response.msg == 'Fields mismatch') {
                                    $('#myForm :input').removeClass('is-invalid');
                                    $('#myForm .text-danger').html('');
                                    $.each(response.errors, function(key, value) {
                                        $('#' + key).addClass('is-invalid');
                                        // Display the error message
                                        $('#' + key + '_error').html(value);
                                    });
                                } else {
                                    $('#myForm :input').removeClass('is-invalid');
                                    $('#myForm .text-danger').html('');
                                    $.each(response.errors, function(key, value) {
                                        $('#' + key).addClass('is-invalid');
                                        // Display the error message
                                        $('#' + key + '_error').html(value);
                                    });
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors here
                            console.error('AJAX error:', error);
                        }
                    });
                });




                //click floor btn
                $('#floor_btn').click(function(e) {
                    e.preventDefault();
                    $("#assessment_field,#floor_field,#facility_field,#establishment_field").hide();

                    $("#establishment_field").hide();
                    var formData = $("#myForm").serialize();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('client.form-address')); ?>',
                        data: formData,
                        success: function(response) {
                            if (response.success) {

                                // Validation and processing were successful.
                                var building_usage = $("#building_usage").val();
                                $("#address_field").hide();
                                if (building_usage == "Resitendial") {
                                    $("#floor_field,#facility_btn").show();

                                } else {
                                    $("#floor_field,#establishment_btn").show();
                                }
                                $('#myForm :input').removeClass('is-invalid');
                            } else {
                                $('#myForm .text-danger').html('');
                                $('#myForm :input').removeClass('is-invalid');
                                $.each(response.errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    // Display the error message
                                    $('#' + key + '_error').html(value);
                                });
                            }
                        },
                    });
                });

                // Change event for Floor Usage select elements
                $(document).on('change', '.floor-usage', function(){
                    var building_usage = $("#building_usage").val();
                    var val = $(this).val();

                    if (building_usage === "Resitendial") {
                        var i=0;
                        $('.floor-usage').each(function() {
                            var currentValue = $(this).val();
                            var id = $(this).attr('id');

                            if (currentValue !== "RESIDENTIAL") {
                                $(this).addClass('is-invalid');
                                $('#' + id).text("Not Match");
                                i++;
                            } else {
                                $(this).removeClass('is-invalid');
                                $('#' + id).text(""); // Clear any previous invalid messages
                            }
                        });
                        if (i!=0) {
                            $('#facility_btn').prop('disabled', true);
                        } else {
                            $('#facility_btn').prop('disabled', false);
                        }
                    } else {
                        var i=0;
                        $('.floor-usage').each(function() {
                            var currentValue = $(this).val();
                            var id = $(this).attr('id');

                            if (currentValue === "RESIDENTIAL") {
                                $(this).addClass('is-invalid');
                                $('#' + id).text("Not Match");
                                i++;
                            } else {
                                $(this).removeClass('is-invalid');
                                $('#' + id).text(""); // Clear any previous invalid messages
                            }
                        });
                        if (i!=0) {
                            $('#establishment_btn').prop('disabled', true);
                        } else {
                            $('#establishment_btn').prop('disabled', false);
                        }
                    }

                    alert("Floor Usage Value: " + val);
                });







                //Estabishment btn click
                $('#establishment_btn').click(function(e) {
                    e.preventDefault();
                    $("#address_field, #assessment_field, #facility_field, #establishment_field").hide();
                    var formData = $("#myForm").serialize();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('client.form-floor')); ?>',
                        data: formData,
                        success: function(response) {
                            if (response.error) {
                                $('#myForm .text-danger').html('');
                                $('#myForm :input').removeClass('is-invalid');
                               // $('#myForm .text-danger').html('');
                               if (response.msg === 'Fields mismatch') {
                                var errorMessages = '';
                                $("#errorAlert").show();
                                $.each(response.errors, function(key, value) {
                                    errorMessages += 'Floor value is mismatch in ' + value + '\n';
                                    //$("#errorMessages").html(errorMessages);
                                      
                                });

                                // Show all error messages in a dismissible alert
                                alert(errorMessages); 
                                
                            } else {
                                    $.each(response.errors, function(key, value) {
                                        $('#' + key).addClass('is-invalid');
                                        $('#' + key.replace('.', '\\.')).html(value);
                                    });
                                }
                            } else {
                               // alert(response.msg);
                                $("#floor_field").hide();
                                $("#establishment_field").show();
                                $("#facility_btn").show();
                                $('#myForm :input').removeClass('is-invalid');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });


                var flooradd = 0;
                $("#addFloor").click(function(e) {
                    flooradd++;
                    e.preventDefault();
                    var newRow = `
    <div class="row">
        <div class="col-6 col-sm-6">
            <button class="btn btn-dark removeFloor">Remove Floor</button>
            <div class="mb-3">
                <label for="floor" class="text-light">Floor</label>
                <input type="text" class="form-control" name="floor[${flooradd}]" placeholder="Floor" value="">
                <div class="text-danger" id="floor.${flooradd}"></div>
            </div>
            <div class="mb-3">
                <label for="Construction Type" class="text-light">Construction Type</label>
                <select name="construction_type[${flooradd}]" class="form-control" placeholder="Construction Type">
                    <option value="1">1</option>
                </select>
                <div class="text-danger" id="construction_type.${flooradd}"></div>
            </div>
            <div class="mb-3">
                <label for="Percentage" class="text-light">Percentage</label>
                <select name="percentage[${flooradd}]" class="form-control" placeholder="Percentage">
                    <option value="1">1</option>
                </select>
                <div class="text-danger" id="percentage.${flooradd}"></div>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="mb-3">
                <label for="Occupied_by" class="text-light">Occupied_by</label>
                <select name="occupied[${flooradd}]" class="form-control" placeholder="Occupied_by">
                    <option value="1">1</option>
                </select>
                <div class="text-danger" id="occupied.${flooradd}"></div>
            </div>
            <div class="mb-3">
                <label for "Floor Usage" class="text-light">Floor Usage</label>
                <select name="floor_usage[${flooradd}]" class="form-control floor-usage" placeholder="Floor Usage">
                    <option value="COMMERCIAL">COMMERCIAL</option>
                    <option value="RESIDENTIAL">RESIDENTIAL</option>
                    <option value="MIXED">MIXED</option>
                </select>
                <div class="text-danger" id="floor_usage.${flooradd}"></div>
            </div>
            <div class="mb-3">
                <label for="Remarks" class="text-light">Remarks</label>
                <input type="text" class="form-control" name="remarks[${flooradd}]" placeholder="Remarks" value="">
                <div class="text-danger" id="remarks.${flooradd}"></div>
            </div>
        </div>
    </div>`;

                    $(".addedFloor").append(newRow);
                });

                // Remove Floor button click event
                $(".addedFloor").on('click', '.removeFloor', function(e) {
                    e.preventDefault();

                    // Remove the entire row when the remove button is clicked
                    $(this).closest(".row").remove();
                });


                //facility btn click
                $('#facility_btn').click(function(e) {
                    e.preventDefault();
                    $("#address_field,#assessment_field,#facility_fiel").hide();
                    var building_usage = $("#building_usage").val();

                    if (building_usage == "Resitendial") {
                        var formData = $("#myForm").serialize();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo e(route('client.form-floor')); ?>',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    // Validation and processing were successful.
                                    $("#floor_field").hide();
                                    $("#establishment_field").hide();
                                    $("#facility_field").show();
                                    $('#myForm :input').removeClass('is-invalid');
                                } else {
                                    $('#myForm .text-danger').html('');
                                    $('#myForm :input').removeClass('is-invalid');
                               // $('#myForm .text-danger').html('');
                               if (response.msg === 'Fields mismatch') {
                                var errorMessages = '';
                                $("#errorAlert").show();
                                $.each(response.errors, function(key, value) {
                                    errorMessages += 'Floor value is mismatch in ' + value + '\n';
                                    //$("#errorMessages").html(errorMessages);
                                      
                                });

                                // Show all error messages in a dismissible alert
                                alert(errorMessages); 
                                
                            } else {
                                    $.each(response.errors, function(key, value) {
                                        $('#' + key).addClass('is-invalid');
                                        $('#' + key.replace('.', '\\.')).html(value);
                                    });
                                }
                                }
                            },
                        });

                    } else {
                        var formData = $("#myForm").serialize();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo e(route('client.form-establishment')); ?>',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    // Validation and processing were successful.
                                    $("#establishment_field").hide();
                                    $("#facility_field").show();
                                    $('#myForm :input').removeClass('is-invalid');
                                } else {
                                    $('#myForm .text-danger').html('');
                                    $('#myForm :input').removeClass('is-invalid');
                               // $('#myForm .text-danger').html('');
                                    if (response.msg === 'Fields mismatch') {
                                        var errorMessages = '';
                                        $("#errorAlert").show();
                                        $.each(response.errors, function(key, value) {
                                            errorMessages += 'Floor value is mismatch in ' + value + '\n';
                                            //$("#errorMessages").html(errorMessages);
                                            
                                        });

                                        // Show all error messages in a dismissible alert
                                        alert(errorMessages); 
                                        
                                    }
                                    else if (response.flr === true) {
                                            alert("Floor values do not match in floor value and establishment value" );
                                        } 
                                     else {
                                            $.each(response.errors, function(key, value) {
                                                $('#' + key).addClass('is-invalid');
                                                $('#' + key.replace('.', '\\.')).html(value);
                                            });
                                        }
                                        }
                                    },
                                });
                            }
                        });

                // add ESTABLISHMENT
                var establishmentadd = 0;
                $("#addEstablishment").click(function(e) {
                    e.preventDefault();
                    establishmentadd++;
                    var newRow = `
    <div class="row">
        <div class="col-6 col-sm-6">
            <button class="btn btn-dark removeEstablishment">Remove Floor</button>
                    <div class="mb-3">
                        <label for="shop_floor" class="text-light">Shop Floor</label>
                        <input type="text" name="shop_floor[${establishmentadd}]" id="shop_floor" class="form-control" placeholder="Shop Floor">
                        <div class="text-danger" id="shop_floor.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shop_name[${establishmentadd}]" class="text-light">Shop Name</label>
                        <input type="text" name="shop_name" id="shop_name" class="form-control" placeholder="Shop Name">
                        <div class="text-danger" id="shop_name.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shop_owner_name" class="text-light">Shop Owner Name</label>
                        <input type="text" name="shop_owner_name[${establishmentadd}]" id="shop_owner_name" class="form-control" placeholder="Shop Owner Name">
                        <div class="text-danger" id="shop_owner_name.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shop_category" class="text-light">Shop Category</label>
                        <select name="shop_category[${establishmentadd}]" id="shop_category" class="form-control">
                            <option value="1">1</option>
                        </select>
                        <div class="text-danger" id="shop_category.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shop_mobile" class="text-light">Shop Mobile</label>
                        <input type="text" name="shop_mobile[${establishmentadd}]" id="shop_mobile" class="form-control" placeholder="Shop Mobile">
                        <div class="text-danger" id="shop_mobile.${establishmentadd}"></div>
                    </div>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="mb-3">
                        <label for="license" class="text-light">License</label>
                        <select name="license[${establishmentadd}]" id="license" class="form-control">
                            <option value="1">1</option>
                        </select>
                        <div class="text-danger" id="license.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="professional_tax" class="text-light">Professional Tax</label>
                        <select name="professional_tax[${establishmentadd}]" id="professional_tax" class="form-control">
                            <option value="1">1</option>
                        </select>
                        <div class="text-danger" id="professional_tax.${establishmentadd}"></div>
                    </div>
                    <div class="mb-3">
                        <label for="establishment_remarks" class="text-light">Establishment Remarks</label>
                        <input type="text" name="establishment_remarks" id="establishment_remarks[${establishmentadd}]" class="form-control" placeholder="Establishment Remarks">
                        <div class="text-danger" id="establishment_remarks.${establishmentadd}"></div>
                    </div>
                </div>
    </div>`;

                    $(".addedEstablishment").append(newRow);
                });

                // Remove Floor button click event
                $(".addedEstablishment").on('click', '.removeEstablishment', function(e) {
                    e.preventDefault();

                    // Remove the entire row when the remove button is clicked
                    $(this).closest(".row").remove();
                });



                //submit button on click
                $("#submit").click(function(e) {

                    e.preventDefault();
                    $("#floor_field").hide();
                    var formData = $("#myForm").serialize();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('client.form-submit')); ?>',
                        data: formData,
                        success: function(response) {

                            if (response.error) {
                                // Validation and processing were error.
                                $('#myForm .text-danger').html('');
                                $('#myForm :input').removeClass('is-invalid');
                                $.each(response.errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    // Display the error message
                                    $('#' + key + '_error').html(value);

                                });

                            } else {
                                alert(response.message);
                                window.location.href = "{{ route('client.Survey-Gis')}}";
                            }
                        },
                    });
                });


            });
        </script>
    @endpush
@endsection
