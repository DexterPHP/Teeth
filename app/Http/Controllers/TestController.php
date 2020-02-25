<?php
namespace App\Http\Controllers;
use App\Models\Doctor;
use App\User;
use App\user\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');// should Have an Account
    }
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
                return view('Home.Accounter_index');
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }
}
