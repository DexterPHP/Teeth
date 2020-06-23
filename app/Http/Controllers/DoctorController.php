<?php

namespace App\Http\Controllers;

use App\Models\Accounter;
use App\Models\Center;
use App\Models\Dates;
use App\Models\Doctor;
use App\Models\Patients;
use App\Models\Record;
use App\Models\Rols;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;
use Prophecy\Call\CallCenter;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    public function add(Request $request){
        if($request->isMethod('post')){
            $username = $request->only('doctor_username');
            $us = Doctor::all()->where('doctor_username',$username);
            if(count($us) < 1){
                $uuid = Str::uuid()->toString();
                $request['uuid'] = $uuid;
                Doctor::create($request->all());
                // Send Mail //
                $user_id = Auth::user()->id; // user login id
                $User_data = User::find($user_id);
                $to_email = 'fenixthelord@gmail.com';
                $c_name = $request['center_name'];
                $subject = "New Doctor Added ....";
                $message = 'New Doctor called  '.$c_name.'  Added To Center '.$request['center_id'].' by: '.$User_data->name.' At: '.date('d/m/Y').' ';
                $headers = 'From: support@adam-medical.com';
                mail($to_email,$subject,$message,$headers);
                // Send Mail //
            }else{
                return redirect()->back()->with('messageError',' xxx');
            }

             return redirect()->back()->with('message',' xxx');

        }else{
            $user_id = Auth::user()->id;
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-doctor']);
            if($rols){
                $cc = Center::where('id','!=',1)->get();
                $acount = Accounter::all();
                $users = User::where('id','!=',1)->get();
                $arr['doc']=$cc;
                $arr['acc']=$acount;
                $arr['users']=$users;

                return view('doctor.add_doctor',$arr);
            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-doctor']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){
                $all = Doctor::all();
                $arr['doctors']=$all;
                return view('doctor.All_doctors',$arr);
            }else{
                $user_id = Auth::user()->center_id;
                $all = Doctor::where('center_id',$user_id)->get();
                $arr['doctors']=$all;
                return view('doctor.All_doctors',$arr);
            }


        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }





    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-doctor']);
        if($rols){
            $all = Doctor::all();
            $arr['doctors']=$all;
            return view('doctor.edit_doctor',$arr);
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('post')){
           $item = Doctor::where('uuid',$id)->first();
            $username = $request->only('doctor_username');
            $us = Doctor::all()->where('doctor_username',$username);
            if(count($us) < 1){
                $item->update($request->all());
                return redirect()->back()->with('message',' ');
            }else{
                return redirect()->back()->with('messageError',' ');
            }

         }else{

                $search = Doctor::where('uuid',$id)->first();
                $arr['daoctor']=$search;
                $cc = Center::all();
                $acount = Accounter::all();
                $arr['doc']=$cc;
                $arr['acc']=$acount;
                return view('doctor.do_edit',$arr);


        }
    }
    public function moeny(Request $request,$id){
        $doctor = Doctor::where('uuid',$id)->get();
        $sum = $coll = 0;
        $getmoeny = Record::where([['doctor_id',$doctor['id']]])->get();
         // loop for All Peation in Doctor
        foreach ($getmoeny as $Pation){
            $sum = $sum + $Pation->set_total; // All
            $coll = $coll + $Pation->set_payment; // Pation Payment
        }
        return view('doctor.calender');
    }

    public function dates($id){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-date']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $doctor_id = Doctor::where('uuid',$id)->first();
                $dates = Dates::where('doctor_id',$doctor_id['id'])->get();
                return view('doctor.calender',['doctor'=>$id,'datar'=>$dates]);
            }else if($user_is == 2){// Doctor
                $doctor_id = Doctor::where('user_id',$user_id)->first();
                    if($doctor_id->uuid == $id){
                        $dates = Dates::where('doctor_id',$doctor_id['id'])->get();
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                return view('doctor.calender',['doctor'=>$id,'datar'=>$dates]);

            }else if($user_is == 3){// Reception
                // $doctor_center == user_center
                $user_center = Auth::user()->center_id;
                $doctor_c = Doctor::where('uuid',$id)->first();
                $doctor_center = $doctor_c->center_id;
                if($user_center == $doctor_center){
                    $doctor_id = Doctor::where('uuid',$id)->first();
                    $dates = Dates::where('doctor_id',$doctor_id['id'])->get();
                    return view('doctor.calender',['doctor'=>$id,'datar'=>$dates]);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
