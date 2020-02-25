<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Labs;
use App\Models\Record;
use App\User;
use App\user\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $user = Patients::all(); // Get All users
                $arr['data'] = $user;
                return view('records.view_all_user',$arr);
            }else if($user_is == 2){// Doctor
                $doctor = Doctor::where('user_id',$user_id)->first();
                $user = $doctor->Patiens; // Get All users
                $arr['data'] = $user;

                return view('records.view_all_user',$arr);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $doctor = Patients::all(); // Get All users;
                $pat = [];
                foreach ($doctor as $doctorx){
                    $doctorz = $doctorx->doctors_id;
                    $dod = Doctor::find($doctorz);
                    if($dod->center_id == Auth::user()->center_id){
                        array_push($pat,$doctorx);
                    }
                }
                $user = $pat; // Get All users
                $arr['data'] = $user;
                return view('records.view_all_user',$arr);

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request,$id)
    {
        if($request->isMethod('post')){
            $uuid = Str::uuid()->toString();
            $request['uuid'] = $uuid;
            $cread = Record::create($request->all());
            return redirect()->back()->with('message', ' ');

        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-record']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    // Pation
                    $Pation_data = Patients::where('uuid',$id)->first();
                    // Doctors
                    $Doctor = Doctor::all();
                    // Labs
                    $Labs = Labs::all();
                    return view('records.add_record',['user_data'=>$Pation_data,'doctor_data'=>$Doctor,'lab'=>$Labs]);
                }else if($user_is == 2){// Doctor
                    // Pation
                    $Pation_data = Patients::where('uuid',$id)->first();
                    // Doctor Data
                    $doctor = Doctor::where('user_id',$user_id)->first();
                    if($doctor->id == $Pation_data->id){
                        // Doctors
                        $Doctor = Doctor::where('id',$doctor['id'])->get();
                        // Labs
                        $Labs = Labs::all();
                        return view('records.add_record',['user_data'=>$Pation_data,'doctor_data'=>$Doctor,'lab'=>$Labs]);

                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else if($user_is == 3){// Reception
                    // Not Allow
                }else if($user_is == 4){ // Accounter
                    // Pation
                    $Pation_data = Patients::where('uuid',$id)->first();
                    $doctor_for_user = $Pation_data->doctors_id;
                    $getDoc = Doctor::find($doctor_for_user)->center_id;
                    if($getDoc == Auth::user()->center_id){
                        $docy = [];
                        // Doctors
                        $Doctor = Doctor::where('id',$Pation_data->doctors_id)->get();
                        // Labs
                        $Labs = Labs::all();
                        return view('records.add_record',['user_data'=>$Pation_data,'doctor_data'=>$Doctor,'lab'=>$Labs]);
                    }
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
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-record']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $user_id = $id;
                $ut = Patients::where('uuid',$id)->first();
                $record = Record::where('patient_id',$ut['id'])->get();
                $arr['datas'] = $record;
                $arr['user_id'] = $id;
                $arr['user'] = $ut;
                return view('records.view_user_records',$arr);

            }else if($user_is == 2){// Doctor
                $user_id = $id;
                $ut = Patients::where('uuid',$id)->first();
                $do_id = $ut->doctors_id;
                $du_from_doc = Doctor::find($do_id);
                if($du_from_doc->user_id == Auth::user()->id ){
                    $record = Record::where('patient_id',$ut['id'])->get();
                    $arr['datas'] = $record;
                    $arr['user_id'] = $id;
                    $arr['user'] = $ut;
                    return view('records.view_user_records',$arr);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }


            }else if($user_is == 3){// Reception
                // Now Allow
            }else if($user_is == 4){ //Accounter
                $user_id = $id;
                $ut = Patients::where('uuid',$id)->first();
                $do_id = $ut->doctors_id;
                $du_from_doc = Doctor::find($do_id);
                if($du_from_doc->center_id == Auth::user()->center_id ){
                    $record = Record::where('patient_id',$ut['id'])->get();
                    $arr['datas'] = $record;
                    $arr['user_id'] = $id;
                    $arr['user'] = $ut;
                    return view('records.view_user_records',$arr);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $record = Record::all();
        return view('records.serach_record',['All'=>$record]);
    }
    public function getuserrecord($id){
        $user = Patients::where('uuid',$id)->first();
        $Record = Record::where('patient_id',$user->id)->get();
        return view('records.user_record',['data'=>$Record,'userdata'=>$user]);

    }
    public function updaterecord(Request $request,$id){
        if ($request->isMethod('post')){
            $the_record = Record::where('uuid',$id)->first();
            $the_record->update($request->all());
            return redirect()->back()->with('message',' ');

        }else{
            $the_record = Record::where('uuid',$id)->first();
            $labs = Labs::all();
            return view('records.update_Record',['TheRecord'=>$the_record,'lab'=>$labs]);

        }



}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
