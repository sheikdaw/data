<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\mis;
use App\Models\surveyed;
use App\Models\image;
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


class ClientController extends Controller
{
    public function home()
    {
        $userName = Auth::guard('client')->user()->name;

        // Retrieve street-wise counts associated with the user
        $totalRoadCount = mis::distinct('road_name')
        ->selectRaw('road_name, count(*) as total_road_count')->groupBy('road_name')
        ->get();

        $streetsNotInSurveyed = mis::whereNotIn('assessment', function ($query) {
            $query->select('assessment')->from('surveyeds');
        })->where('workername', $userName)
            ->selectRaw('road_name, count(*) as road_count')
          ->groupBy('road_name')
          ->get();
          $surveyed = Surveyed::all();

          return view('back.page.client.home', compact('streetsNotInSurveyed', 'totalRoadCount','surveyed'));
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

        if (auth('client')->attempt($creds)) {
           return redirect()->route('client.home');
        }
         else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('back.page.client.login');
        }
    }
    //log out
    public function logoutHandler(Request $request)
    {
        Auth::guard('client')->logout();
        Session()->flash('fail', "You are Logged outs");
        return redirect()->route('client.login');
    }
    public function profileView(Request $request)
    {
        $client=null;
        if (Auth::guard('client')->check()) {
            $client = Client::findOrFail(auth()->id());
        }
        return view('back.page.client.profile',compact('client'));
    }
    public function changeProfilePicture(Request $request)
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
            $client->picture =  $new_image_name;
            $client->save();

            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } catch (\Exception $e) {
            Log::error('Error in changeProfilePicture: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'An error occurred. Please check the server logs for more information.', 'name' => $new_image_name]);
        }
    }
    public function getProfilePicture()
    {
        if (Auth::guard('client')->check()) {
            $client = Client::findOrFail(auth()->id());

            return response()->json(['status' => 1, 'picture' => $client->picture ?? null]);
        }

        return response()->json(['status' => 0, 'msg' => 'User not authenticated']);
    }
    public function surveyForm(Request $request)
    {
        if (Auth::guard('client')->check()) {
            $userName = Auth::guard('client')->user()->name;
            $data = mis::where('assessment', $request->input('assessment'))->where('workername',$userName)->first();
            $surveydata = surveyed::where('assessment', $request->input('assessment') )->first();
            $mis=mis::all();
            if ($data) {
            if ($surveydata) {

                return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'Bill Already Survey']);
            }
            else{
                return view('back.page.client.survey-form', compact('data','mis'));
            }
            } else {
                return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'No data found for the specified assessment']);
            }
        }
        return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'User not authenticated']);
    }
    //retrived
   public function surveyFormPoint(Request $request)
{
    if (Auth::guard('client')->check()) {
        $userName = Auth::guard('client')->user()->name;
        $data = mis::where('assessment', $request->input('assessment'))->where('workername', $userName)->first();
        $surveydata = surveyed::where('assessment', $request->input('assessment'))->first();
        $mis = mis::all();
        $id = $request->input('gisid');
        if ($data) {
            if ($surveydata) {
                return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'Bill Already Survey']);
            } else {
                // Assigning $id to $data['gisid']
                $data['gisid'] = $id;
                // Passing $data, $mis, and $id to the view
                return view('back.page.client.survey-form', compact('data', 'mis', 'id'));
               //dd($data);

            }
        } else {
            return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'No data found for the specified assessment']);
        }
    }
    return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'User not authenticated']);
}


    public function storeimg(Request $request)
    {

        $path = "/images/gis/{$request->ward}/";
        $image = $request->file('image');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $gisId = $request->input('gisid');

        // Check if the gisid already exists in the Image table
        $isGisIdExists = Image::where('gisid', $gisId)->exists();

        if (!$isGisIdExists) {
            $image->move(public_path($path), $new_image_name);
            $imageModel = new Image();
            $imageModel->image = $path . $new_image_name;
            $imageModel->gisid = $gisId;
            $imageModel->save();

            Session::flash('success', 'Image uploaded successfully!');
        } else {
            Session::flash('error', 'GIS ID already exists! Please use a different one.');
        }

        // Redirect back with the appropriate message
        return redirect()->back();

    }
    public function newAssessment(Request $request)
    {
        if (Auth::guard('client')->check()) {
            $mis=mis::all();
                return view('back.page.client.survey-form', compact('mis'));
        }
        return view('back.page.client.survey-gis')->with(['status' => 0, 'error' => 'User not authenticated']);
    }




}
