<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');// should Have an Account
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('center.add');
    }

    public  function add(Request $request){

        if($request->isMethod('post')){

           $valid =  $request->validate([
                'center_name' => 'bail|required|unique:centers|max:255'
            ]);
                $uuid = Str::uuid()->toString();
                $request['uuid'] = $uuid;
                $center = Center::create($request->all());
                return redirect()->back()->with('Greate','Exists');

        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-center']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    return view('center.add');
                }else if($user_is == 2){// Doctor

                }else if($user_is == 3){// Doctor

                }else if($user_is == 4){ //Accounter

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Center\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function show(Center $center)
    {
        $user_id = Auth::user()->id;
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-center']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $all_centers = Center::all();
                $arr['data']=$all_centers;
                return view('center.center_search',$arr);
            }else if($user_is == 2){// Doctor

            }else if($user_is == 3){// Doctor

            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Center\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function edit(Center $center)
    {
        $user_id = Auth::user()->id;
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-center']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::all();
                return view('center.All',['data'=>$Center]);
            }else if($user_is == 2){// Doctor

            }else if($user_is == 3){// Doctor

            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Center\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Center $center)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-date']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                ###### Type here the Code ####
            }else if($user_is == 2){// Doctor

            }else if($user_is == 3){// Doctor

            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Center\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function destroy(Center $center)
    {
        //
    }
}
