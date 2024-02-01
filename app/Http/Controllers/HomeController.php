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


class HomeController extends Controller
{
    public function show($id){
        $surveys = DB::table('surveyeds')->where('gisid',$id)->get();
        return view('back.page.admin.showqr',compact('surveys'));
    }

}
