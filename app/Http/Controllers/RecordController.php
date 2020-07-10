<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Doctor;
use App\Models\Labs;
use App\Models\Record;
use App\Models\Treatment;
use App\User;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;

class RecordController extends Controller
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
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-record']);
        if ($rols) {
            $user_is = Auth::user()->user_type;
            if ($user_is == 1) {// Super Admin
                $user = Patients::all(); // Get All users
                $arr['data'] = $user;
                return view('records.view_all_user', $arr);
            } else if ($user_is == 2) {// Doctor
                $doctor = Doctor::where('user_id', $user_id)->first();
                $user = $doctor->Patiens; // Get All users
                $arr['data'] = $user;

                return view('records.view_all_user', $arr);

            } else if ($user_is == 3) {// Reception
                // Not Allowed
            } else if ($user_is == 4) { //Accounter
                $doctor = Patients::all(); // Get All users;
                $pat = [];
                foreach ($doctor as $doctorx) {
                    $doctorz = $doctorx->doctors_id;
                    $dod = Doctor::find($doctorz);
                    if ($dod->center_id == Auth::user()->center_id) {
                        array_push($pat, $doctorx);
                    }
                }
                $user = $pat; // Get All users
                $arr['data'] = $user;
                return view('records.view_all_user', $arr);

            }

        } else {
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }


    public function add(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            if($request['record_time'] <= date('Y/m/d H:s:i')){
                $uuid = Str::uuid()->toString();
                $request['uuid'] = $uuid;
                $Pation_data = Patients::where('uuid', $id)->first();
                $patient_box = $Pation_data->patient_box;   // Box
                $total = $request['set_total']; // All
                $rest = $request['set_phppayment']; // Part
                /*  $difrn = $total - $rest;
                  if($total < $rest and $patient_box >= 0){
                      return redirect()->back()->with('totalError',' ');

                  }
                  $patient_box_new  = ($Pation_data->patient_box) + $difrn;

                  if(isset($cread)){
                      $update_pation = $Pation_data->update(['patient_box'=> $patient_box_new]);
                  }*/
                $doc_uuid = Doctor::find($request['doctor_id'])->uuid;
                $request['dotor_uuid'] = $doc_uuid;
                $request['Pation_uuid'] = $id;
                Session::put('Record', $request->all());
                //$cread = Record::create($request->all());
                //return redirect()->back()->with('message', ' ');
                return redirect()->route('add_money', $doc_uuid);
            }else{
                return redirect()->back()->with('dateError',' ');
            }



        } else {
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            ////// Treatment
            $Treatment = Center::find($User_data->center_id)->Treatment;
            ///// Treatment
            $rols = $User_data->hasAccess(['create-record']);
            if ($rols) {
                $user_is = Auth::user()->user_type;
                if ($user_is == 1) {// Super Admin
                    // Pation
                    $Pation_data = Patients::where('uuid', $id)->first();
                    // Doctors
                    $Doctor = Doctor::all();
                    // Labs
                    $Labs = Labs::all();
                    return view('records.add_record', ['user_data' => $Pation_data, 'doctor_data' => $Doctor, 'lab' => $Labs, 'Treatment' => $Treatment]);
                } else if ($user_is == 2) {// Doctor
                    // Pation
                    $Pation_data = Patients::where('uuid', $id)->first();
                    // Doctor Data
                    $doctor = Doctor::where('user_id', $user_id)->first();
                    if ($doctor->id == $Pation_data->doctors_id) {
                        // Doctors
                        $Doctor = Doctor::where('id', $doctor['id'])->get();
                        // Labs
                        $Labs = Labs::all();
                        return view('records.add_record', ['user_data' => $Pation_data, 'doctor_data' => $Doctor, 'lab' => $Labs, 'Treatment' => $Treatment]);

                    } else {

                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                } else if ($user_is == 3) {// Reception
                    // Not Allow
                } else if ($user_is == 4) { // Accounter
                    // Pation
                    $Pation_data = Patients::where('uuid', $id)->first();
                    $doctor_for_user = $Pation_data->doctors_id;
                    $getDoc = Doctor::find($doctor_for_user)->center_id;
                    if ($getDoc == Auth::user()->center_id) {
                        $docy = [];
                        // Doctors
                        $Doctor = Doctor::where('id', $Pation_data->doctors_id)->get();
                        // Labs
                        $Labs = Labs::all();
                        return view('records.add_record', ['user_data' => $Pation_data, 'doctor_data' => $Doctor, 'lab' => $Labs, 'Treatment' => $Treatment]);
                    }
                }

            } else {
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-record']);
        if ($rols) {
            $user_is = Auth::user()->user_type;
            if ($user_is == 1) {// Super Admin
                $user_id = $id;
                $ut = Patients::where('uuid', $id)->first();
                $record = Record::where('patient_id', $ut['id'])->get();
                $arr['datas'] = $record;
                $arr['user_id'] = $id;
                $arr['user'] = $ut;
                return view('records.view_user_records', $arr);

            } else if ($user_is == 2) {// Doctor
                $user_id = $id;
                $ut = Patients::where('uuid', $id)->first();
                $do_id = $ut->doctors_id;
                $du_from_doc = Doctor::find($do_id);
                if ($du_from_doc->user_id == Auth::user()->id) {
                    $record = Record::where('patient_id', $ut['id'])->get();
                    $arr['datas'] = $record;
                    $arr['user_id'] = $id;
                    $arr['user'] = $ut;
                    return view('records.view_user_records', $arr);
                } else {
                    abort(401, 'Access denied - وصول غير مسموح ');
                }


            } else if ($user_is == 3) {// Reception
                // Now Allow
            } else if ($user_is == 4) { //Accounter
                $user_id = $id;
                $ut = Patients::where('uuid', $id)->first();
                $do_id = $ut->doctors_id;
                $du_from_doc = Doctor::find($do_id);
                if ($du_from_doc->center_id == Auth::user()->center_id) {
                    $record = Record::where('patient_id', $ut['id'])->get();
                    $arr['datas'] = $record;
                    $arr['user_id'] = $id;
                    $arr['user'] = $ut;
                    return view('records.view_user_records', $arr);
                } else {
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        } else {
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-record']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                //$record = Record::all();
                //return view('records.serach_record', ['All' => $record]);


            }else if($user_is == 2){// Doctor
                $Find_doc = Doctor::where('user_id',$User_data->id)->first(); // Get Doctor
                $xXx = $Find_doc->with('Patiens')->first();
                $xXx = $xXx->Patiens; // Get Pations of This Doctor
                $pation =[];
                foreach ($xXx as $Pation){
                    $reco = Patients::find($Pation->id);
                    $ny = Record::where('patient_id',$reco->id)->get();
                    $The_Pation =[
                        'pation'=> $Pation,
                        'Records'=> $ny
                    ];
                    array_push($pation,$The_Pation);
                }
                return view('records.serach_record', ['All' => $pation]);

            }else if($user_is == 3){// Reception
                abort(401, 'Access denied - وصول غير مسموح ');
            }else if($user_is == 4){ //Accounter
                $Find_doc = Doctor::where('center_id',$User_data->center_id)->get(); // Get All Doctors

                return view('records.doctor_records', ['All' => $Find_doc]);


            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    public function showDoctorRecord(Request $request,$id){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-record']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                // Not needed
            }else if($user_is == 2){// Doctor
                // Not needed
            }else if($user_is == 3){// Reception
                // Not needed
            }else if($user_is == 4){ //Accounter
              $getDoctor = Doctor::where('uuid',$id)->first();
              if(isset($getDoctor) && $getDoctor->center_id ==  $User_data->center_id){
                  $xXx = Patients::where('doctors_id',$getDoctor->id)->get(); // Get Pations of This Doctor
                  $pation =[];
                  foreach ($xXx as $Pation){
                      $reco = Patients::find($Pation->id);
                      $ny = Record::where('patient_id',$reco->id)->get();
                      $The_Pation =[
                          'pation'=> $Pation,
                          'Records'=> $ny
                      ];
                      array_push($pation,$The_Pation);
                  }
                  return view('records.Pation_for_Doctor', ['All' => $pation]);
              }else{
                  abort(401, 'Access denied - وصول غير مسموح ');
              }
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    public function getuserrecord($id)
    {

        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['edit-record']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $user   = Patients::where('uuid', $id)->first();
                $Record = Record::where('patient_id', $user->id)->get();
                return view('records.user_record', ['data' => $Record, 'userdata' => $user]);

            }else if($user_is == 2){// Doctor
                $user   = Patients::where('uuid', $id)->first();
                $Record = Record::where('patient_id', $user->id)->get();
                return view('records.user_record', ['data' => $Record, 'userdata' => $user]);

            }else if($user_is == 3){// Reception
                // Not Allowed ....
            }else if($user_is == 4){ //Accounter
                $user   = Patients::where('uuid', $id)->first();
                $Record = Record::where('patient_id', $user->id)->get();
                return view('records.user_record', ['data' => $Record, 'userdata' => $user]);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }


    }

    public function updaterecord(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $the_record = Record::where('uuid', $id)->first();
            $the_record->update($request->all());
            return redirect()->back()->with('message', ' ');

        } else {
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['edit-record']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin

                }else if($user_is == 2){// Doctor

                }else if($user_is == 3){// Reception

                }else if($user_is == 4){ //Accounter

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
            $the_record = Record::where('uuid', $id)->first();
            $labs = Labs::all();
            $doctor = Doctor::find($the_record['doctor_id']);
            //$Treatment = Center::find($User_data->center_id)->Treatment;
            return view('records.update_Record', ['TheRecord' => $the_record, 'lab' => $labs,'doctor'=>$doctor]);

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
