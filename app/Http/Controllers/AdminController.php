<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport; // Import the UsersImport class;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use constGuards;
use constDefaults;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\surveyed;
use App\Models\mis;
use App\Models\Client;
use App\Models\image;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class AdminController extends Controller
{
    use ValidatesRequests;
    public function showqr($id)
{
    $surveys = Surveyed::with('images')
        ->where('gisid', $id)
        ->get();

    $data = [
        'surveys' => $surveys,
    ];

    return view('back.page.admin.showqr', $data);
}

    public function home()
    {
        $totalMisCount = DB::table('mis')->count();
        $totalSueveyCount = DB::table('surveyeds')->count();
        $line = DB::table('mis')
            ->select('road_name', DB::raw('COUNT(*) as count'))
            ->groupBy('road_name')
            ->orderByDesc('count')
            ->get()
            ->toArray();

        $labels = array_column($line, 'road_name');
        $values = array_column($line, 'count');
        $complete = DB::table('surveyeds')
            ->select('workername', DB::raw('COUNT(*) as count'))
            ->groupBy('workername') // Adjusted to include 'workername' in GROUP BY
            ->orderByDesc('count')
            ->get()
            ->toArray();

        $comlabels = array_column($complete, 'workername');
        $comvalues = array_column($complete, 'count');
        $totalRoadCount = mis::distinct('road_name')
            ->selectRaw('road_name, count(*) as total_road_count')->groupBy('road_name')
            ->get();

            $streetsNotInSurveyed = mis::whereNotIn('assessment', function ($query) {
                $query->select('assessment')->from('surveyeds');
            })
            ->selectRaw('road_name, COUNT(*) as road_count')
            ->groupBy('road_name')
            ->get();



        return view('back.page.admin.home', compact('labels', 'values', 'comlabels', 'comvalues', 'totalMisCount', 'totalSueveyCount', 'streetsNotInSurveyed', 'totalRoadCount'));
    }

    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email', // Corrected the usage of exists validation rule
                'password' => 'required|min:5|max:45',
            ], [
                'login_id.required' => "Email or Username required",
                'login_id.email' => "Invalid Email address",
                'login_id.exists' => "Email not exist in System",
                'password.required' => "Password required",
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:admins,username', // Corrected the usage of exists validation rule
                'password' => 'required|min:5|max:45',
            ], [
                'login_id.required' => "Email or Username required",
                'login_id.exists' => "Username not exist in System",
                'password.required' => "Password required",
            ]);
        }

        $creds = [
            $fieldType => $request->login_id,
            'password' => $request->password,
        ];

        if (auth('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request)
    {
        Auth::guard('admin')->logout();
        Session()->flash('fail', "You are Logged outs");
        return redirect()->route('admin.login');
    }
    public function sendpasswordresetlink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.required' => "Email required",
            'email.email' => "Invalid Email address",
            'email.exists' => "Email not exist in System",
        ]);
        $admin = Admin::where('email', $request->email)->first();
        $token = base64_encode(Str::random(64));
        $oldToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('guard', constGuards::ADMIN)
            ->first();


        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('guard', constGuards::ADMIN)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()

            ]);
        }
        $actionLink = route('admin.reset-password', ['token' => $token, 'email' => $request->email]);
        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin
        );
        $mail_body = view('email-templates.admin-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Reset password',
            'mail_body' => $mail_body
        );
        if (sendEmail($mailConfig)) {
            Session()->flash('success', "We have e-mailed your password");
            return redirect()->route('admin.forgot-password');
        } else {
            Session()->flash('fail', "Something went wrong");
            return redirect()->route('admin.forgot-password');
        }
    }

    public function profileView(Request $request)
    {
        $admin = null;
        if (Auth::guard('admin')->check()) {
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.page.admin.profile', compact('admin'));
    }

    public function changeProfilePicture(Request $request)
    {
        try {
            $path = '/images/admin/';

            $file = $request->file('adminProfilePictureFile');
            $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
            $file->move(public_path($path), $new_image_name);

            // Retrieve old profile picture path
            $adminId = Auth::guard('admin')->id();
            $admin = Admin::find($adminId);
            $oldpicture = $admin->getAttribute('picture');

            // if ($oldpicture != '') {
            //     $oldPicturePath = public_path($oldpicture);

            //     // Example condition: Delete the old picture if its file size is greater than 1 MB
            //     if (file_exists($oldPicturePath) && filesize($oldPicturePath) > 1024 * 1024) {
            //         unlink($oldPicturePath); // Delete the old picture
            //     }
            // }

            // Update the admin's picture attribute with the new image path
            $admin->picture = $new_image_name;
            $admin->save();

            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } catch (\Exception $e) {
            Log::error('Error in changeProfilePicture: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'An error occurred. Please check the server logs for more information.', 'name' => $new_image_name]);
        }
    }
    public function getProfilePicture()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Admin::findOrFail(auth()->id());

            return response()->json(['status' => 1, 'picture' => $admin->picture ]);
        }

        return response()->json(['status' => 0, 'msg' => 'User not authenticated']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file and import data
        Excel::import(new UsersImport, $file);

        // Success message if the import is successful
        Session::flash('success', 'Excel file imported successfully!');

        return redirect()->back();
    }


    public function uploadExel()
    {
        return view('back.page.upload-exel');
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'property' => 'required',
            'value' => 'required',
        ]);

        if ($request->property == "all") {
            $surveys = Surveyed::all();
        }else{
        $surveys = Surveyed::with('images')
            ->where($request->property, $request->value)
            ->get();
        }

        $data = [
            'surveys' => $surveys,
        ];
    //dd($surveys);
        $pdf = PDF::loadView('back.page.admin.exportpdf', $data);
        $pdf->setPaper('a3', 'landscape');
        return $pdf->download('report.pdf');
    }

    // Add Client details

    public function addClient(){
        return view('back.page.client.add-client');

    }

    public function register_handler(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:clients,username',
            'password' => 'required|max:7',
            'email' => 'required|email|unique:clients,email'
        ]);

        // Create a new Client instance
        $client = new Client();
        $client->name = $validatedData['name'];
        $client->username = $validatedData['user_name'];
        $client->password = bcrypt($validatedData['password']); // Assuming you want to hash the password
        $client->email = $validatedData['email'];

        // Save the client to the database
        $client->save();

        // Optionally, you may return a response indicating success
        return back()->with('success', 'Client registered successfully');
    }
    public function clientView(){
        $totalclient=Client::all();
        return view('back.page.admin.client-view',compact('totalclient'));

    }
    public function clientEdit($id){
        $client = Client::find($id);

        // Pass the client data to the view
        return view('back.page.admin.client-seller-profile', ['client' => $client]);
    }
    public function clientRemove($id){
        $client = Client::find($id);

        $client->delete();
        return back()->with('success', 'Client Removed successfully');
    }

    public function changeClientProfilePicture(Request $request)
    {
        try {
            $path = '/images/client/';

            $file = $request->file('clientProfilePictureFile');
            $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
            $file->move(public_path($path), $new_image_name);

            // Retrieve old profile picture path
            $clientId = Auth::guard('client')->id();
            $client = Client::find($clientId);
            $oldpicture = $client->getAttribute('picture');

            if ($oldpicture != '') {
                $oldPicturePath = public_path($oldpicture);

                // Example condition: Delete the old picture if its file size is greater than 1 MB
                if (file_exists($oldPicturePath) && filesize($oldPicturePath) > 1024 * 1024) {
                    unlink($oldPicturePath); // Delete the old picture
                }
            }

            // Update the client's picture attribute with the new image path
            $client->picture = $path . $new_image_name;
            $client->save();

            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } catch (\Exception $e) {
            Log::error('Error in changeProfilePicture: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'An error occurred. Please check the server logs for more information.', 'name' => $new_image_name]);
        }
    }
    public function getClientProfilePicture(Request $request)
    {
            $client = Client::find($request->x);

                return response()->json(['status' => 1, 'picture' => $client->picture ?? null]);

        return response()->json(['status' => 0, 'msg' => 'User not authenticated']);
    }



    public function addFeature(Request $request)
    {
        if ($request->type == "Polygon") {
            // Read the GeoJSON file and decode it
            $data = json_decode(file_get_contents(public_path('kovai/building.json')), true);

            // Assuming 'features' is an existing array in your JSON data
            $features = $data['features'];

            // Corrected coordinates structure for Polygon
            $coordinates = $request->input('coordinates');

            // Get the last feature ID and increment it by 1 for GIS_ID
            $lastFeatureId = count($features) > 0 ? $features[count($features) - 1]['properties']['GIS_ID'] : 0;
            $gisId = $lastFeatureId + 1;

            // Add all the fields from the provided JSON data
            $properties = [
                "OBJECTID" => $lastFeatureId + 1,
                "Corporatio" => "Coimbatore",
                "Region_Nam" => "Central",
                "Zone" => "Zone-B",
                "Ward_Numbe" => "68",
                "Road_ID" => $lastFeatureId + 1,
                "Road_Name" => "ANNA STREET",
                "GIS_ID" => $lastFeatureId + 1,
                "Building_T" => "Independent",
                "Building_U" => "Residential",
                "Door_Old_N" => "242 & 243",
                "Door_New_N" => "148",
                "MIS_Max_Fl" => "0",
                "Survey_Max" => "2",
                "MIS_Total_" => "0.00000000000e+000",
                "Drone_Area" => "7.84094889000e+002",
                "Variation_" => "0.00000000000e+000",
                "Shape_Leng" => "1.79893216299e-004",
                "Shape_Area" => "2.00812108491e-009",
                "MIS_Usage" => "New",
                "Variation1" => "New",
                "Variatio_1" => "NEW ASSESSMENT",
                "SGT_Remark" => "Integrated",
                "AREA_IN_SQ" => "2.61364963329e+002",
                "Plot_No" => ""
            ];

            // Prepare the new feature
            $newFeature = [
                "type" => "Feature",
                "id" => count($features) + 1, // Assigning an ID based on the current number of features
                "geometry" => [
                    "type" => "Polygon",
                    "coordinates" => $coordinates // Use the provided coordinates
                ],
                "properties" => $properties
            ];

            // Add the new feature to the existing features array
            $features[] = $newFeature;

            // Update the 'features' array in the JSON data
            $data['features'] = $features;

            // Write the updated JSON data back to the file
            file_put_contents(public_path('kovai/building.json'), json_encode($data, JSON_PRETTY_PRINT));


            ///


            return response()->json(['message' => 'Feature added successfully']);
        }



        //point
        if ($request->type == "Point") {
            $data = json_decode(file_get_contents(public_path('kovai/test.json')), true);

            // Assuming 'features' is an existing array in your JSON data
            $features = $data['features'];

            // // Primary GIS ID
            // $primaryGisId = $request->input('primary_gis_id');

            // Prepare the new feature
            $newFeature = [
                "type" => "Feature",
                "id" => count($features), // Assigning an ID based on the current number of features
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [
                        $request->input('longitude'),
                        $request->input('latitude')
                    ]
                ],
                "properties" => [
                    "FID" => count($features), // Using the same ID as 'id' for simplicity
                    "Id" => 0,
                    "GIS_ID" => count($features) + 1
                ]
            ];

            // Add the new feature to the existing features array
            $features[] = $newFeature;

            // Update the 'features' array in the JSON data
            $data['features'] = $features;

            // Write the updated JSON data back to the file
            file_put_contents(public_path('kovai/test.json'), json_encode($data, JSON_PRETTY_PRINT));

            return response()->json(['message' => 'Feature added successfully']);
        }
    }


    public function deleteLastFeature($value)
    {
        if ($value == 'Point') {
            // Read the JSON file
                $jsonFilePath = public_path('kovai/test.json');
                $jsonData = file_get_contents($jsonFilePath);

                // Decode JSON data to an associative array
                $data = json_decode($jsonData, true);

                // Check if the 'features' array exists in the JSON data
                if (isset($data['features'])) {
                    // Remove the last feature from the 'features' array
                    array_pop($data['features']);

                    // Encode the modified array back to JSON
                    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

                    // Write the updated JSON data back to the file
                    file_put_contents($jsonFilePath, $jsonData);

                    return response()->json(['message' => 'Last feature deleted successfully']);
                } else {
                    return response()->json(['message' => 'No features found in JSON data'], 404);
                }
        } else if($value == 'Polygon') {
            $jsonFilePath = public_path('kovai/building.json');
                $jsonData = file_get_contents($jsonFilePath);

                // Decode JSON data to an associative array
                $data = json_decode($jsonData, true);

                // Check if the 'features' array exists in the JSON data
                if (isset($data['features'])) {
                    // Remove the last feature from the 'features' array
                    array_pop($data['features']);

                    // Encode the modified array back to JSON
                    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

                    // Write the updated JSON data back to the file
                    file_put_contents($jsonFilePath, $jsonData);

                    return response()->json(['message' => 'Last feature deleted successfully']);
                } else {
                    return response()->json(['message' => 'No features found in JSON data'], 404);
                }
        }

    }

}
