<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Seller;
use App\Models\Surveyed;
use App\Models\mis;
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
use Illuminate\Pagination\Paginator;




class SellerController extends Controller
{
    public function home()
{
    $totalMisCount = DB::table('mis')->count();
    $totalSurveyCount = DB::table('surveyeds')->count();
    $line = DB::table('mis')
        ->select('road_name', DB::raw('COUNT(*) as count'))
        ->groupBy('road_name')
        ->orderByDesc('count')
        ->get()
        ->toArray();

    $labels = array_column($line, 'road_name');
    $values = array_column($line, 'count');
    $complete = DB::table('surveyeds')
        ->select('road_name', DB::raw('COUNT(*) as count'))
        ->groupBy('road_name')
        ->orderByDesc('count')
        ->get()
        ->toArray();

    $comLabels = array_column($complete, 'road_name');
    $comValues = array_column($complete, 'count');

    // Variation
    // Fetch variations count from table1
    $table1Variations = DB::table('mis')
        ->groupBy('assessment')
        ->get();

    // Fetch variations count from table2
    $table2Variations = DB::table('point_data')
        ->groupBy('assessment')
        ->get();

    // Comparing counts
    $comparisonResults = [];

    foreach ($table1Variations as $table1Variation) {
        foreach ($table2Variations as $table2Variation) {
            if ($table1Variation->assessment == $table2Variation->assessment) {
                $comparisonResults[] = $table2Variation->assessment;
            }
        }
    }

    return view('back.page.seller.home', compact('labels', 'values', 'comLabels', 'comValues', 'totalMisCount', 'totalSurveyCount', 'comparisonResults', 'table1Variations', 'table2Variations'));
}







    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $validationRules = [
            'email' => [
                'required',
                'email',
                'exists:clients,email',
            ],
            'username' => [
                'required',
                'exists:clients,username',
            ],
            'password' => [
                'required',
                'min:5',
                'max:45',
            ],
        ];

        $customMessages = [
            'login_id.required' => "Email or Username required",
            'login_id.email' => "Invalid Email address",
            'login_id.exists' => $fieldType === 'email' ? "Email not found" : "Username not found",
            'password.required' => "Password required",
        ];

        $request->validate(
            array_merge(['login_id' => $validationRules[$fieldType]], ['password' => $validationRules['password']]),
            $customMessages
        );

        $creds = [
            $fieldType => $request->login_id,
            'password' => $request->password,
        ];

        if (auth('seller')->attempt($creds)) {
            return redirect()->route('seller.home');
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('seller.login');
        }
    }
    //log out
    public function logoutHandler(Request $request)
    {
        Auth::guard('seller')->logout();
        Session()->flash('fail', "You are Logged outs");
        return redirect()->route('seller.login');
    }
    public function profileView(Request $request)
    {
        $seller=null;
        if (Auth::guard('seller')->check()) {
            $seller = Seller::findOrFail(auth()->id());
        }
        return view('back.page.seller.profile',compact('seller'));
    }
    public function changeProfilePicture(Request $request)
    {
        try {
            $path = '/images/seller/';

            $file = $request->file('sellerProfilePictureFile');
            $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
            $file->move(public_path($path), $new_image_name);

            // Retrieve old profile picture path
            $sellerId = Auth::guard('seller')->id();
            $seller = Seller::find($sellerId);
            $oldpicture = $seller->getAttribute('picture');

            if ($oldpicture != '') {
                $oldPicturePath = public_path($oldpicture);

                // Example condition: Delete the old picture if its file size is greater than 1 MB
                if (file_exists($oldPicturePath) && filesize($oldPicturePath) > 1024 * 1024) {
                    unlink($oldPicturePath); // Delete the old picture
                }
            }

            // Update the client's picture attribute with the new image path
            $seller->picture = $new_image_name;
            $seller->save();

            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } catch (\Exception $e) {
            Log::error('Error in changeProfilePicture: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'An error occurred. Please check the server logs for more information.', 'name' => $new_image_name]);
        }
    }
    public function getProfilePicture()
    {
        if (Auth::guard('seller')->check()) {
            $seller = Seller::findOrFail(auth()->id());

            return response()->json(['status' => 1, 'picture' => $seller->picture ?? null]);
        }

        return response()->json(['status' => 0, 'msg' => 'User not authenticated']);
    }
    public function showAllSurveyData()
    {     Paginator::useBootstrap();
        $data = mis::paginate(10); // Fetch 10 items per page (adjust as needed)

        return view('back.page.seller.view-all-survey-data', ['data' => $data]);
    }
    public function showParticularSurveyData()
    {

        $data = mis::paginate(10); // Fetch 10 items per page (adjust as needed)

        return view('back.page.seller.view-particular-survey-data', ['data' => $data]);
    }



}
