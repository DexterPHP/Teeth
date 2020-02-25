<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PatientResource;
use App\Models;
use App\Http\Controllers\Controller;
use App\User;
//use App\user\Patients;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp;

class PatientsController extends Controller
{


    ////// API ///////
    public function API_Get_All()
    {
        $user = Patients::all();

        // return response()->json(\App\user\Patients::all(),200);
        return response()->json(PatientResource::collection($user));
    }

}
