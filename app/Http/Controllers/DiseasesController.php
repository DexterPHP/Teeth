<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Diseases;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiseasesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post')){
            $des = Diseases::where([
                    ['title',$request["title"]],
                    ['center_id',$request["center_id"]]
                ])->get();
            if(count($des) > 0){
                return redirect()->back()->with('messageError',' ');
            }else{
                $tato = Diseases::create($request->all());
                return redirect()->back()->with('message',' ');
            }


        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-diseases']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $center = Center::orderBy('center_name','asc')->get();
                    return view('diseases.add_diseases',['centers'=>$center,'fetch'=>true]);

                }else if($user_is == 2){// Doctor
                    $center = Auth::user()->center_id;
                    return view('diseases.add_diseases',['centers'=>$center,'fetch'=>false]);

                }else if($user_is == 3){// Reception
                    $center = Auth::user()->center_id;
                    return view('diseases.add_diseases',['centers'=>$center,'fetch'=>false]);

                }else if($user_is == 4){ //Accounter
                    // Not Allowed
                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }




}
