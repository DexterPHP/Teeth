<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Diseases;
use App\Models\Treatment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'title' => 'required|string|min:2',
                'price' => 'required|string|min:2',
                'center_id' => 'required',
            ]);
            $request['uuid'] = Str::uuid()->toString();
            $search = Treatment::where([ ['title',$request->title],['center_id',$request->center_id] ]) ->get();
            if(count($search) > 0){
                return redirect()->back()->with('exsist',' ');
            }else{
                $done = Treatment::create($request->all());
                return redirect()->back()->with('Greate',' ');
            }
        }else{
            $user_id =  Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-treatments']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $center = Center::all();
                    return view('treatment.add',['Admin'=>true,'center'=>$center]);

                }else if($user_is == 2){// Doctor
                    $center = $User_data->center_id;
                    return view('treatment.add',['Admin'=>false,'center'=>$center]);

                }else if($user_is == 3){// Reception
                    abort(401, 'Access denied - وصول غير مسموح ');
                }else if($user_is == 4){ //Accounter
                    $center = $User_data->center_id;
                    return view('treatment.add',['Admin'=>false,'center'=>$center]);

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }


    public function search()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-treatments']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
               $Treatment =  Treatment::all();
               return view('treatment.search',['Treatment'=>$Treatment]);

            }else if($user_is == 2){// Doctor
                $center_of_user = $User_data->center_id;
                $Center_disease = Treatment::where('center_id',$center_of_user)->get();
                return view('treatment.search',['disease'=>$Center_disease,'main'=>false]);

            }else if($user_is == 3){// Reception

            }else if($user_is == 4){ //Accounter
                $center_of_user = $User_data->center_id;
                $Center_disease = Treatment::where('center_id',$center_of_user)->get();
                return view('treatment.search',['disease'=>$Center_disease,'main'=>false]);
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    public function view()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-treatments']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Treatment =  Treatment::all();
                return view('treatment.search',['Treatment'=>$Treatment]);

            }else if($user_is == 2){// Doctor
                $center_of_user = $User_data->center_id;
                $Center_disease = Treatment::where('center_id',$center_of_user)->get();
                return view('treatment.view_for_edit',['disease'=>$Center_disease,'main'=>false]);

            }else if($user_is == 3){// Reception

            }else if($user_is == 4){ //Accounter
                $center_of_user = $User_data->center_id;
                $Center_disease = Treatment::where('center_id',$center_of_user)->get();
                return view('treatment.view_for_edit',['disease'=>$Center_disease,'main'=>false]);
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }


    public function update(Request $request,$id)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-treatments']);
        if($rols){
            // [POST] Update
            if($request->isMethod('post')){
                $Center_disease = Treatment::where('uuid',$id)->first();
                if(isset($Center_disease)){
                    $update = $Center_disease->update($request->all());
                    return redirect()->back()->with('Greate',' ');

                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }


            }else{
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $Treatment =  Treatment::all();
                    return view('treatment.search',['Treatment'=>$Treatment]);

                }else if($user_is == 2){// Doctor
                    $center_of_user = $User_data->center_id;
                    $Center_disease = Treatment::where('uuid',$id)->first();
                    if($Center_disease->center_id == $User_data->center_id){
                        return view('treatment.update_treatment',['disease'=>$Center_disease]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }else if($user_is == 3){// Reception

                }else if($user_is == 4){ //Accounter
                    $center_of_user = $User_data->center_id;
                    $Center_disease = Treatment::where('uuid',$id)->first();
                    if($Center_disease->center_id == $User_data->center_id){
                        return view('treatment.update_treatment',['disease'=>$Center_disease]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }

            }
            }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

}
