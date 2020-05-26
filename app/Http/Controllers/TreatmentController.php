<?php

namespace App\Http\Controllers;

use App\Models\Center;
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
                    return view('treatment.add.Treatment',['Admin'=>false,'center'=>$center]);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}
