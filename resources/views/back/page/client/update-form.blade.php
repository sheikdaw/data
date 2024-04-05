<div class="table table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Assessment</th>
                <th>Old Assessment</th>
                <th>Floor</th>
                <th>Bill Usage</th>
                <th>Aadhar No</th>
                <th>Ration No</th>
                <th>Phone Number</th>
                <th>Shop Floor</th>
                <th>Shop Name</th>
                <th>Old Door No</th>
                <th>New Door No</th>
                <th>Shop Owner Name</th>
                <th>Shop Category</th>
                <th>Shop Mobile</th>
                <th>License</th>
                <th>Professional Tax</th>
                <th>GST</th>
                <th>Number of Employee</th>
                <th>Trade Income</th>
                <th>Establishment Remarks</th>
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td><input type="text" name="id" id="id"
                        value="{{ $data->id }}"></td>
                    <td><input type="text" name="assessment" id="assessment_{{ $data->id }}"
                            value="{{ $data->assessment }}"></td>
                    <td><input type="text" name="old_assessment" id="old_assessment_{{ $data->id }}"
                            value="{{ $data->old_assessment }}"></td>
                    <td><input type="text" name="floor" id="floor_{{ $data->id }}" value="{{ $data->floor }}">
                    </td>
                    <td><input type="text" name="bill_usage" id="bill_usage_{{ $data->id }}"
                            value="{{ $data->bill_usage }}"></td>
                    <td><input type="text" name="aadhar_no" id="aadhar_no_{{ $data->id }}"
                            value="{{ $data->aadhar_no }}"></td>
                    <td><input type="text" name="ration_no" id="ration_no_{{ $data->id }}"
                            value="{{ $data->ration_no }}"></td>
                    <td><input type="text" name="phone_number" id="phone_number_{{ $data->id }}"
                            value="{{ $data->phone_number }}"></td>
                    <td><input type="text" name="shop_floor" id="shop_floor_{{ $data->id }}"
                            value="{{ $data->shop_floor }}"></td>
                    <td><input type="text" name="shop_name" id="shop_name_{{ $data->id }}"
                            value="{{ $data->shop_name }}"></td>
                    <td><input type="text" name="old_door_no" id="old_door_no_{{ $data->id }}"
                            value="{{ $data->old_door_no }}"></td>
                    <td><input type="text" name="new_door_no" id="new_door_no_{{ $data->id }}"
                            value="{{ $data->new_door_no }}"></td>
                    <td><input type="text" name="shop_owner_name" id="shop_owner_name_{{ $data->id }}"
                            value="{{ $data->shop_owner_name }}"></td>
                    <td><input type="text" name="shop_category" id="shop_category_{{ $data->id }}"
                            value="{{ $data->shop_category }}"></td>
                    <td><input type="text" name="shop_mobile" id="shop_mobile_{{ $data->id }}"
                            value="{{ $data->shop_mobile }}"></td>
                    <td><input type="text" name="license" id="license_{{ $data->id }}"
                            value="{{ $data->license }}"></td>
                    <td><input type="text" name="professional_tax" id="professional_tax_{{ $data->id }}"
                            value="{{ $data->professional_tax }}"></td>
                    <td><input type="text" name="gst" id="gst_{{ $data->id }}" value="{{ $data->gst }}">
                    </td>
                    <td><input type="text" name="number_of_employee" id="number_of_employee_{{ $data->id }}"
                            value="{{ $data->number_of_employee }}"></td>
                    <td><input type="text" name="trade_income" id="trade_income_{{ $data->id }}"
                            value="{{ $data->trade_income }}"></td>
                    <td><input type="text" name="establishment_remarks"
                            id="establishment_remarks_{{ $data->id }}" value="{{ $data->establishment_remarks }}">
                    </td>
                    <td><button class="updateBtn">Update</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.updateBtn').click(function() {
            var row = $(this).closest('tr');
            var inputs = row.find('input');
            var data = {};

            inputs.each(function() {
                var id = $(this).attr('id');
                var value = $(this).val();
                data[id] = value;
            });

            console.log(data); // You can serialize or send this data as needed
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('client.update-point') }}",
                data: data,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    alert('Row updated successfully.');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        });
    });
</script>

