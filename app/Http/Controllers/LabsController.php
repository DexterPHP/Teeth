<?php

namespace App\Http\Controllers;

use App\Models\Labs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LabsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $lab_name = $request->only('lab_name');
            $lab_phon = $request->only('lab_phone');
            $hh = Labs::where([['lab_name',$lab_name],['lab_phone',$lab_phon]])->get();
            $valid =  $request->validate([
                'lab_name' => 'required|unique:labs|max:191'
            ]);
            if(count($hh) > 0){
                return redirect()->back()->with('error',' ');
            }else{
                $uuid = Str::uuid()->toString();
                $request['uuid'] = $uuid;
                Labs::create($request->all());
            }
            return redirect()->back()->with('message',' ');
        }else{

            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-lab']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    return view('labs.add_lab');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Labs  $labs
     * @return \Illuminate\Http\Response
     */
    public function show(Labs $labs)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-lab']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $all = Labs::all();
                $arr['data']=$all;
                return view('labs.labs_search',$arr);
            }else if($user_is == 2){// Doctor
                $all = Labs::all();
                $arr['data']=$all;
                return view('labs.labs_search',$arr);
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
     * @param  \App\Models\Labs  $labs
     * @return \Illuminate\Http\Response
     */
    public function edit(Labs $labs)
    {

        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-lab']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $all = Labs::all();
                $arr['data']=$all;
                return view('labs.edit_labs',$arr);
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
     * @param  \App\Models\Labs  $labs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('post')){
            $find = Labs::where('uuid',$id)->first();
            $find->update($request->all());
            return redirect()->back()->with('message',' ');

        }else{

            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['edit-lab']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $lab_data = Labs::where('uuid',$id)->first();
                    $arr['lab'] = $lab_data;
                    return view('labs.update_lab',$arr);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Labs  $labs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Labs $labs)
    {
        //
    }
}
