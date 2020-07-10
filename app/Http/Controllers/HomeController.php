<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Doctor;
use App\User;
use App\user\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-patients']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                return view('Home.Admin_index');
            }else if($user_is == 2){// Doctor
                $get_all = Doctor::where('user_id',$user_id)->first();
                $All = Patients::where('doctors_id',$get_all->id)->get();
                return view('Home.Doctor_index',['d'=>$get_all]);
            }else if($user_is == 3){// Reception
                return view('Home.Reception_index');
            }else if($user_is == 4){ //Accounter
                $center_Doctor = $User_data->center_id;
                $doctors = Doctor::where('center_id',$center_Doctor)->get();
                $Patiens =0;
                foreach ($doctors as $doc){
                    $count = count($doc->Patiens);
                    $Patiens = $count;
                    break;

                }
                $Center = Center::find($center_Doctor);
                return view('Home.Accounter_index',['doctors'=>$doctors,'center'=>$Center,'Patiens'=>$Patiens]);
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

}
