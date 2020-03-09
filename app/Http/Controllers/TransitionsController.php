<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Transitions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransitionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');// should Have an Account
    }

    public function choose(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                return view('transite.Main_index');
            }else if($user_is == 2){// Doctor
                return view('transite.Main_index');
            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                return view('transite.Main_index');
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    ##### Center #####
    // expense
    public function expenseCenter (){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.center_expanse',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_expanse',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_expanse',['center'=>$Center,'CenterData'=>$all_docs]);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }
    // income
    public function incomeCenter(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.center_income',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }


    ##### Doctor ##### Not Ready
    // expense
    public function expenseDoctor (){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.center_expanse',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_expanse',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_expanse',['center'=>$Center,'CenterData'=>$all_docs]);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }
    // income
    public function incomeDoctor(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.center_income',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.center_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

}
