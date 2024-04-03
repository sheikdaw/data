<?php

namespace App\Http\Controllers;

use App\Models\surveyed;
use App\Models\BuildingData;
use App\Models\PointData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function showForm()
    {
        return view('old_data_form');
    }

    // public function property(Request $request)
    // {
    //     try {
    //         // Define validation rules
    //         $rules = [
    //             'assessment' => 'required|regex:/^[0-9\/]+$/',
    //             'ward' => 'required|regex:/^[0-9]+$/',
    //             'owner_name' => 'required|regex:/^[A-Za-z.,]+$/',
    //             'present_owner' => 'required|regex:/^[A-Za-z.,]+$/|min:3',
    //             'water_tax' => 'required|regex:/^[0-9]+$/|min:4',
    //             'building_location' => 'required|regex:/^[A-Za-z0-9-]+$/',
    //             'mobile' => 'required|numeric',
    //             'gisid' => 'required',
    //             'number_of_shop' => 'required|numeric',
    //             'number_of_bill' => 'required|numeric',
    //             'number_of_floor' => 'required|numeric',
    //             // Add more rules for other fields
    //         ];

    //         // Additional rules based on condition
    //         if ($request->type == 'New Bill') {
    //             $rules += [
    //                 'build_uparea' => 'required',
    //                 'building_name' => 'required',
    //                 'old_assessment' => 'required',
    //                 'building_structure' => 'required',
    //                 'building_usage' => 'required',
    //                 'building_type' => 'required',
    //                 'ration' => 'required',
    //                 'aadhar' => 'required',
    //             ];
    //         }


    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json(['error' => true, 'errors' => $validator->errors()]);
    //         }

    //         // If validation passes, continue with your logic to store the data.
    //        $existingProperty = Surveyed::where('gisid', $request->gisid)->first();

    //         if ($existingProperty) {

    //             $errors = [];

    //             if ($existingProperty->number_of_floor != $request->number_of_floor) {
    //                 $errors['number_of_floor'] = 'value Mismatch';
    //             }

    //             if ($existingProperty->number_of_floor != $request->number_of_shop) {
    //                 $errors['number_of_shop'] = 'value Mismatch';
    //             }

    //             if ($existingProperty->number_of_bill != $request->number_of_bill) {
    //                 $errors['number_of_bill'] = 'value Mismatch';
    //             }

    //             if ($existingProperty->building_type != $request->building_type) {
    //                 $errors['building_type'] = 'value Mismatch';
    //             }

    //             if ($existingProperty->building_usage != $request->building_usage) {
    //                 $errors['building_usage'] = 'value Mismatch';
    //             }

    //             if (!empty($errors)) {
    //                 return response()->json(['error' => true, 'msg' => 'Fields mismatch', 'errors' => $errors]);
    //             }
    //             else{
    //                 return response()->json(['success' => true]);
    //             }

    //         } else {
    //             return response()->json(['success' => true]);
    //         }



    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    //     return response()->json(['success' => true]);
    // }

    // // address data valiadte
    // public function address(Request $request)
    // {
    //     // Define validation rules
    //     // $rules = [
    //     //     'road_name' => 'required',
    //     //     'old_door_number' => 'required',
    //     //     'new_door_number' => 'required',
    //     //     'old_address' => 'required',
    //     //     'new_address' => 'required',


    //     //     // Add more rules for other fields
    //     // ];

    //     // $validator = Validator::make($request->all(), $rules);

    //     // if ($validator->fails()) {
    //     //     return response()->json(['error' => true, 'errors' => $validator->errors()]);
    //     // }

    //     // // If validation passes, continue with your logic to store the data.

    //     return response()->json(['success' => true]);
    // }

    // //floor data validation
    // // address data valiadte
    // public function floor(Request $request)
    // {
    //     $rules = [
    //         'floor.*' => 'required',
    //         'construction_type.*' => 'required',
    //         'percentage.*' => 'required',
    //         'occupied.*' => 'required',
    //         'floor_usage.*' => 'required',
    //         'remarks.*' => 'required',
    //         // Add more rules for other fields
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => true, 'errors' => $validator->errors()]);
    //     }

    //     $floorCount = count($request->input('floor'));
    //     $existingProperty = Surveyed::where('gisid', $request->gisid)->first();

    //     if ($existingProperty) {
    //         $errors = [];
    //         for ($i = 0; $i < $floorCount; $i++) {
    //             // Check if the current floor exceeds the previous count
    //             if ($existingProperty->number_of_floor < $request->input('floor')[$i]) {
    //                 $errors['floor'] = $i;
    //             }
    //         }

    //         if (!empty($errors)) {
    //             return response()->json(['error' => true, 'msg' => 'Fields mismatch', 'errors' => $errors, 'errorsId' => $floorCount]);
    //         } else {
    //             return response()->json(['success' => true]);
    //         }
    //     } else {
    //         return response()->json(['success' => true]);
    //     }
    // }




    // //establishment data validate
    // public function establishment(Request $request)
    // {
    //     return response()->json(['success' => true]);
    //     // Define validation rules
    //     // $rules = [
    //     //     'shop_name.*' => 'required',
    //     //     'shop_owner_name.*' => 'required',
    //     //     'shop_mobile.*' => 'required',
    //     //     'shop_floor.*' => 'required',

    //     //     // Add more rules for other fields
    //     // ];

    //     // $validator = Validator::make($request->all(), $rules);

    //     // if ($validator->fails()) {
    //     //     return response()->json(['error' => true, 'errors' => $validator->errors()]);
    //     // }
    //     // $floorCount = count($request->input('floor'));
    //     // $shopfloorCount = count($request->input('shop_floor'));
    //     // // If validation passes, continue with your logic to store the data.
    //     // $existingProperty = Surveyed::where('gisid', $request->gisid)->first();

    //     // if ($existingProperty) {
    //     //     $errors = [];
    //     //     for ($i = 0; $i < $shopfloorCount; $i++) {
    //     //         // Check if the current floor exceeds the previous count
    //     //         if ($existingProperty->number_of_floor < $request->input('shop_floor')[$i]) {
    //     //             $errors['shop_floor'] = $i;
    //     //         }
    //     //     }

    //     //     if (!empty($errors)) {
    //     //         return response()->json(['error' => true, 'msg' => 'Fields mismatch', 'errors' => $errors, 'errorsId' => $shopfloorCount]);
    //     //     } else {
    //     //         $floorCount = count($request->input('floor'));
    //     //         $shopfloorCount = count($request->input('shop_floor'));
    //     //         $x=0;
    //     //         for ($i=0; $i < $floorCount; $i++) {
    //     //             for ($j=0; $j < $shopfloorCount ; $j++) {
    //     //                  if ($request->input('floor')[$i] == $request->input('shop_floor')[$j]) {
    //     //                      $x++;
    //     //                  }
    //     //             }
    //     //          }
    //     //          if ($x != $shopfloorCount ) {
    //     //              return response()->json(['error' => true,'flr'=> true]);
    //     //          }else{
    //     //              return response()->json(['success' => true]);
    //     //          }
    //     //     }
    //     // } else {
    //     //     $floorCount = count($request->input('floor'));
    //     // $shopfloorCount = count($request->input('shop_floor'));
    //     //  $x=0;
    //     //     for ($i=0; $i < $floorCount; $i++) {
    //     //        for ($j=0; $j < $shopfloorCount ; $j++) {
    //     //             if ($request->input('floor')[$i] == $request->input('shop_floor')[$j]) {
    //     //                 $x++;
    //     //             }
    //     //        }
    //     //     }
    //     //     if ($x != $shopfloorCount ) {
    //     //         return response()->json(['error' => true,'flr'=> true]);
    //     //     }else{
    //     //         return response()->json(['success' => true]);
    //     //     }
    //     // }
    // }
    // public function formSubmit(Request $request)
    // {
    //     // Validation rules
    //     $rules = [
    //         'ugd' => 'required',
    //         'cctv' => 'required',
    //             // 'head_room' => 'required',
    //             // 'parking' => 'required',
    //             // 'basement' => 'required',
    //             // 'solar_panel' => 'required',
    //             // 'water_connection' => 'required',
    //             // 'over_headtank' => 'required',
    //             // 'lift_room' => 'required',
    //             // 'cellphone_tower' => 'required',
    //             // 'eb_connection' => 'required',
    //         // Add more validation rules for other fields as needed
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => false, 'errors' => $validator->errors()]);
    //     }

    //     $floorCount = count($request->input('floor'));
    //     $establishmentCount = count($request->input('shop_floor'));

    //     for ($i = 0; $i < $floorCount; $i++) {
    //         $surveyedData = [
    //             'assessment' => $request->input('assessment'),
    //             'ward' => $request->input('ward'),
    //             'owner_name' => $request->input('owner_name'),
    //             'present_owner' => $request->input('present_owner'),
    //             'water_tax' => $request->input('water_tax'),
    //             'building_location' => $request->input('building_location'),
    //             'mobile' => $request->input('mobile'),
    //             'gisid' => $request->input('gisid'),
    //             'build_uparea' => $request->input('build_uparea'),
    //             'building_name' => $request->input('building_name'),
    //             'old_assessment' => $request->input('old_assessment'),
    //             'building_structure' => $request->input('building_structure'),
    //             'building_usage' => $request->input('building_usage'),
    //             'building_type' => $request->input('building_type'),
    //             'ration' => $request->input('ration'),
    //             'aadhar' => $request->input('aadhar'),
    //             'number_of_shop' => $request->input('number_of_shop'),
    //             'number_of_bill' => $request->input('number_of_bill'),
    //             'number_of_floor' => $request->input('number_of_floor'),
    //             'road_name' => $request->input('road_name'),
    //             'old_door_number' => $request->input('old_door_number'),
    //             'new_door_number' => $request->input('new_door_number'),
    //             'old_address' => $request->input('old_address'),
    //             'new_address' => $request->input('new_address'),
    //             'floor' => $request->input('floor')[$i],
    //             'construction_type' => $request->input('construction_type')[$i],
    //             'percentage' => $request->input('percentage')[$i],
    //             'occupied' => $request->input('occupied')[$i],
    //             'floor_usage' => $request->input('floor_usage')[$i],
    //             'remarks' => $request->input('remarks')[$i],
    //             'cctv' => $request->input('cctv'),
    //             'head_room' => $request->input('head_room'),
    //             'parking' => $request->input('parking'),
    //             'basement' => $request->input('basement'),
    //             'solar_panel' => $request->input('solar_panel'),
    //             'water_connection' => $request->input('water_connection'),
    //             'over_headtank' => $request->input('over_headtank'),
    //             'lift_room' => $request->input('lift_room'),
    //             'cellphone_tower' => $request->input('cellphone_tower'),
    //             'eb_connection' => $request->input('eb_connection'),
    //             'ugd' => $request->input('ugd'),
    //             'workername' => Auth::guard('client')->user()->name,
    //         ];Surveyed::create($surveyedData);
    //           return response()->json(['success' => true, 'message' => 'Data has been stored successfully.']);

    //         // if ($request->input('floor_usage')[$i] == "COMMERCIAL") {
    //         //     for ($j = 0; $j < $establishmentCount; $j++) {
    //         //         if ($request->input('floor')[$i] == $request->input('shop_floor')[$j]) {
    //         //             $mixedSurveyedData = $surveyedData; // Clone the common data
    //         //             $mixedSurveyedData['shop_floor'] = $request->input('shop_floor')[$j];
    //         //             $mixedSurveyedData['shop_name'] = $request->input('shop_name')[$j];
    //         //             $mixedSurveyedData['shop_owner_name'] = $request->input('shop_owner_name')[$j];
    //         //             $mixedSurveyedData['license'] = $request->input('license')[$j];
    //         //             $mixedSurveyedData['professional_tax'] = $request->input('professional_tax')[$j];
    //         //             $mixedSurveyedData['shop_category'] = $request->input('shop_category')[$j];
    //         //             $mixedSurveyedData['shop_mobile'] = $request->input('shop_mobile')[$j];
    //         //             $mixedSurveyedData['establishment_remarks'] = $request->input('establishment_remarks')[$j];
    //         //             Surveyed::create($mixedSurveyedData);
    //         //         }
    //         //     }
    //         // } else {
    //         //     Surveyed::create($surveyedData);
    //         //     return response()->json(['success' => true, 'message' => 'Data has been stored successfully.']);
    //         // }
    //     }

    //     return response()->json(['success' => true, 'message' => 'Data has been stored successfully.']);
    // }

    // public function gisUpdate(Request $request){
    //     $rules = [
    //         'gisid' => 'required',
    //         'property' => 'required',
    //         'value' => 'required',
    //         // Add more validation rules for other fields as needed
    //     ];

    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => true, 'errors' => $validator->errors()]);
    //     }
    //     $existingProperty = Surveyed::where('gisid', $request->gisid)->first();
    //     if ($existingProperty) {
    //         $existingProperty->{$request->property} = $request->value; // Update property value
    //         $existingProperty->save();
    //         return response()->json(['success' => true, 'message' => 'Property updated successfully']);
    //     } else {
    //         return response()->json(['error' => true,'msg'=>$request->property, 'errors' => $validator->errors()]);
    //     }

    // }



    //building data

    public function buildingdataUpload(Request $request)
    {
        $validatedData = $request->validate([
            'gisid' => 'required',
            'number_bill' => 'required',
            'number_floor' => 'required',
            'watet_tax' => 'required',
            'eb' => 'required',
            'building_name' => 'required',
            'building_usage' => 'required',
            'construction_type' => 'required',
            'road_name' => 'required',
            'ugd' => 'required',
            'rainwater_harvesting' => 'required',
            'parking' => 'required',
            'ramp' => 'required',
            'hoarding' => 'required',
            'cell_tower' => 'required',
            'solar_panel' => 'required',
            'water_connection' => 'required',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        $buildingData = BuildingData::where('gisid', $validatedData['gisid'])->first();

        // If the record exists, update it
        if ($buildingData) {
            $buildingData->update($validatedData);
        } else {
            // Otherwise, create a new record
            $buildingData = BuildingData::create($validatedData);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName); // Move image to public/images directory
            $buildingData->image = 'images/' . $imageName;
            $buildingData->save();
        }

        return response()->json(['success' => true]);
    }

    public function pointdataUpload(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'assessment' => 'required',
            'old_assessment' => 'required',
            'floor' => 'required',
            'bill_usage' => 'required',
            'aadhar_no' => 'required',
            'ration_no' => 'required',
            'phone' => 'required',
            // 'shop_floor' => 'required',
            // 'shop_name' => 'required',
            // 'shop_owner_name' => 'required',
            // 'shop_category' => 'required',
            // 'shop_mobile' => 'required',
            // 'license' => 'required',
            // 'professional_tax' => 'required',
            // 'gst' => 'required',
            // 'number_of_emplyee' => 'required',
            // 'trade_income' => 'required',
            // 'establishment_remarks' => 'required',
            'gisid' => 'required|exists:building_data,gisid',
        ]);

        // Create a new PointData model instance with the validated data
        $pointData = PointData::create($validatedData);

        // Optionally, you can return a response indicating success
        return response()->json(['success' => true,'message' => 'Point data created successfully', 'data' => $pointData], 201);
    }

}
