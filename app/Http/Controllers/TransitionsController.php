<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Doctor;
use App\Models\Record;
use App\Models\Transitions;
use App\User;
use App\user\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

/*
use PhpParser\Comment\Doc;
use function GuzzleHttp\Promise\all;
*/
class TransitionsController extends Controller
{
    // Auth
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
                $User = Auth::user()->center_id;
                $u_id = Auth::user()->id;
                $center = Center::find($User);
                $doctor = Doctor::where('user_id',$u_id)->get()[0];
                return view('transite.Main_doctor',['center'=>$center,'doctor'=>$doctor]);
            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $User = Auth::user()->center_id;
                $center = Center::find($User);
                return view('transite.Main_accounter',['center'=>$center]);
            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

######### Center #########
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

    // Money in
    public function inCenter(Request $request,$uuid){
        if($request->isMethod('post')){
            $user_id = Auth::user()->id; // user login id
            $center_id= Center::where('uuid',$uuid)->get();
            if(count($center_id) > 0){
                $center_box = Center::where('uuid',$uuid)->get()[0];
                $request['center_id']    = $center_box->id;
                $request['doctor_id']    = Null;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    ='income';
                $request['Type']    ='center';
                $request['uuid']    = $uuid = Str::uuid()->toString();
                $request['created_date'] = date('Y-m-d');
                DB::beginTransaction();
                try
                {
                    $save_tran = Transitions::create($request->all());
                    if($save_tran){
                        $update_Box = Center::find($center_box->id);
                        $new = $update_Box->moneybox+$request['Amount'];
                        $update_moneyBox = Center::where('id',$center_box->id)->update(['moneybox' => $new]);
                    }else{
                        // Rollback Transaction
                        DB::rollback();
                    }
                    // Commit Transaction
                    DB::commit();
                    return redirect()->back()->with('Greate',' ');
                }catch (\Exception $e) {
                    // Rollback Transaction
                    DB::rollback();
                    return redirect()->back()->with('WithError'.' ');
                }
            }else{
                // Center Not Exist
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-transition']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        return view('transite.center_in',['center'=>$center_box]);

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else if($user_is == 2){// Doctor
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        if($User_data->center_id == $center_box->id){
                            return view('transite.center_in',['center'=>$center_box]);
                        }else{
                            // Center Not Exist
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }else if($user_is == 3){// Reception
                    // Not Allowed

                }else if($user_is == 4){ //Accounter
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        if($User_data->center_id == $center_box->id){
                            return view('transite.center_in',['center'=>$center_box]);
                        }else{
                            // Center Not Exist
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }

    }
    // Money Out
    public function outCenter(Request $request,$uuid){

        if($request->isMethod('post')){
            $user_id = Auth::user()->id; // user login id
            $center_id= Center::where('uuid',$uuid)->get();
            if(count($center_id) > 0){
                $center_box = Center::where('uuid',$uuid)->get()[0];
                $request['center_id']    = $center_box->id;
                $request['doctor_id']    = Null;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    ='expense';
                $request['Type']    ='center';
                $request['uuid']    = $uuid = Str::uuid()->toString();
                $request['created_date'] = date('Y-m-d');

                if($request['Amount'] < $center_box->moneybox){;
                    DB::beginTransaction();
                    try
                    {
                        $save_tran = Transitions::create($request->all());
                        if($save_tran){
                            $update_Box = Center::find($center_box->id);
                            $new = $update_Box->moneybox-$request['Amount'];
                            $update_moneyBox = Center::where('id',$center_box->id)->update(['moneybox' => $new]);
                        }else{
                            // Rollback Transaction
                            DB::rollback();
                        }
                        // Commit Transaction
                        DB::commit();
                        return redirect()->back()->with('Greate',' ');
                    }catch (\Exception $e) {
                        // Rollback Transaction
                        DB::rollback();
                        return redirect()->back()->with('WithError'.' ');
                    }
                }else{
                    return redirect()->back()->with('StopLessThan',' ');
                }
            }else{
                // Center Not Exist
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-transition']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        return view('transite.center_out',['center'=>$center_box]);

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else if($user_is == 2){// Doctor
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        if($User_data->center_id == $center_box->id){
                            return view('transite.center_out',['center'=>$center_box]);
                        }else{
                            // Center Not Exist
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }else if($user_is == 3){// Reception
                    // Not Allowed

                }else if($user_is == 4){ //Accounter
                    $center_box = Center::where('uuid',$uuid)->get();
                    if(count($center_box) > 0){
                        $center_box = Center::where('uuid',$uuid)->get()[0];
                        if($User_data->center_id == $center_box->id){
                            return view('transite.center_out',['center'=>$center_box]);
                        }else{
                            // Center Not Exist
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }

                    }else{
                        // Center Not Exist
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }
######### Center #########

######### Doctor #########
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
                return view('transite.doctor_expanse',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.doctor_expanse',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.doctor_expanse',['center'=>$Center,'CenterData'=>$all_docs]);
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
                return view('transite.doctor_income',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.doctor_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.doctor_income',['center'=>$Center,'CenterData'=>$all_docs]);
            }
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    // View Doctors in Center [ Expense ]
    public function ViewDoctoeCenterexpense($uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    $Doctors = $Center->Doctors;
                    return view('transite.doctors_in_center_expanse',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 2){// Doctor
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        foreach ($Center->Doctors as $doctor) {
                            if($Center->id == $doctor->center_id){
                                $Doctors = $doctor;
                                break;
                            }
                        }
                        return view('transite.doctors_in_center_expanse',['center'=>$Center,'DoctordsData'=>$Doctors]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        $Doctors = $Center->Doctors;
                        return view('transite.doctors_in_center_expanse',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }
    // View Doctors in Center [ InCome ]
    public function ViewDoctoeCenterincome($uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    $Doctors = $Center->Doctors;
                    return view('transite.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 2){// Doctor
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        foreach ($Center->Doctors as $doctor) {
                            if($Center->id == $doctor->center_id){
                                $Doctors = $doctor;
                                break;
                            }
                        }
                        return view('transite.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        $Doctors = $Center->Doctors;
                        return view('transite.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    // Doctor Money In
    public function DoctorMoneyIn(Request $request,$uuid){
        if($request->isMethod('post')){
            if(Auth::user()->user_type == 1){
                $doctor = Doctor::where('uuid',$uuid)->get()[0];
                $center_id = $doctor->center_id; // Center id
                $user_id = $doctor->user_id; // User id
                $center_id= Center::where('id',$center_id)->get();
                $doctor_id = $doctor->id;
            }else{
                $user_id = Auth::user()->id; // user login id
                $center_are = Auth::user()->center_id; // Center id
                $center_id= Center::where('id',$center_are)->get();
                $doctor = Doctor::where('uuid',$uuid)->get()[0];
                $doctor_id = $doctor->id;
            }
            if(count($center_id) > 0){
                $request['center_id']    = Null;
                $request['doctor_id']    = $doctor_id;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    = 'income';
                $request['Type']         = 'doctor';
                $request['patients_id']  = $request->Patieon_id;
                $request['uuid']         = Str::uuid()->toString();
                $request['created_date'] = date('Y-m-d');
                DB::beginTransaction();
                try
                {
                    $save_tran = Transitions::create($request->all());
                    if($save_tran){
                        $user = $user_id; // For this Doctor
                        $Doctor_Box = Doctor::where('uuid',$uuid)->get()[0];
                        $moneybox = $center_id[0]->moneybox;
                        if($Doctor_Box->Type == 'Percent'){ // Percent
                            $all = abs($request['Amount']); //
                            $c_pp = $Doctor_Box->moneybox; // -1000
                            $doctor = $c_pp;
                            $center = $moneybox;
                            $money = $all;
                            $c_p = ($all*$Doctor_Box->cash_percent)/100;
                            $d_p = $all - $c_p;
                            #######################
                            if($doctor < 0 && $d_p + $doctor < 0){ // - -
                                $doctor = $doctor +$d_p;
                                $center = $center + $money;
                                $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $center]);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $doctor]);
                            }else if($doctor < 0 && ($d_p + $doctor) > 0){ // - +
                                $belal = $d_p + $doctor;
                                $mohmd = $c_p + $center+ abs($doctor);
                                $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $mohmd]);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $belal]);
                            }elseif($doctor >= 0){ // + +
                                $for_Center = $c_p; //
                                $for_Doctor = $d_p; //
                                $add_to_doctor = $Doctor_Box->moneybox+$for_Doctor; //
                                $add_to_center = $moneybox+$for_Center; //
                                //dd($Doctor_Box->cash_percent,$all,$c_p,$for_Center,$for_Doctor,$add_to_center,$add_to_doctor,$Doctor_Box->moneybox,$moneybox);
                                $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $add_to_center]);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $add_to_doctor]);
                            }
                        }else{
                            // Cash
                            if($Doctor_Box->moneybox < 0){ // -1000
                                $tozero   = 0 - ($Doctor_Box->moneybox); // M شاد بدو المركز من الدكتور
                                $todoctor = ($request['Amount']) - $tozero; //  1000 - 1000 = 0
                                $add_to_center = $moneybox + $tozero; // 7000 + 1000
                                // End Collect To Center Box
                                $add_to_doctor = 0 + $todoctor; // -1000 + 0
                                $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $add_to_center]);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $add_to_doctor]);

                            }else{
                                $all = $Doctor_Box->moneybox+abs($request['Amount']);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $all]);
                            }
                        }
                    }else{
                        // Rollback Transaction
                        DB::rollback();
                        return redirect()->back()->with('WithError'.' ');
                    }
                    // Commit Transaction
                    DB::commit();
                    if(Session::has('Record')){
                        $record_session  = Session::get('Record');
                        $record_data = [
                            'patient_id' => $record_session['patient_id'],
                            'doctor_id' => $record_session['doctor_id'],
                            'set_total' => $record_session['set_total'],
                            'set_payment' => $record_session['set_payment'],
                            'teeth_lab' => $record_session['teeth_lab'],
                            'set_note' => $record_session['set_note'],
                            'teeth_work_name' => $record_session['teeth_work_name'],
                            'working_teeth' => $record_session['working_teeth'],
                            'uuid' => $record_session['uuid']
                        ];
                        $cread = Record::create($record_data);
                        Session::forget('Record');
                    }
                    return redirect()->back()->with('Greate',' ');
                }catch (\Exception $e) {
                    dd('1',$e);
                    // Rollback Transaction
                    DB::rollback();
                    return redirect()->back()->with('WithError',' ');
                }
            }else{

                // Center Not Exist
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }
        else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-transition']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $Doctor = Doctor::where('uuid',$uuid)->get();
                    if(count($Doctor) > 0){
                        $Doctor = Doctor::where('uuid',$uuid)->get()[0];
                        $Patiens = $Doctor->Patiens;
                        return view('transite.doctor_push_money',['DoctorData'=>$Doctor,'Patiens'=>$Patiens]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }else if($user_is == 2){// Doctor
                    $Find_doctor = Doctor::where('user_id',$user_id)->get();
                    if(count($Find_doctor) > 0){
                        if($Find_doctor[0]->uuid == $uuid){
                            $Doctor = Doctor::where('uuid',$uuid)->get();
                            if(count($Doctor) > 0){
                                $Doctor = $Doctor[0];
                                $Patiens = $Doctor->Patiens;
                                return view('transite.doctor_push_money',['DoctorData'=>$Doctor,'Patiens'=>$Patiens]);
                            }else{
                                abort(401, 'Access denied - وصول غير مسموح ');
                            }
                        }
                        else{
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else if($user_is == 3){// Reception
                    // Not Allowed
                }else if($user_is == 4){ //Accounter
                    $Doctor = Doctor::where('uuid',$uuid)->get();
                    if(count($Doctor) > 0){
                        $user_center = Auth::user()->center_id;
                        if($Doctor[0]->center_id == $user_center){
                            $Doctor = Doctor::where('uuid',$uuid)->get()[0];
                            $Patiens = $Doctor->Patiens;
                            return view('transite.doctor_push_money',['DoctorData'=>$Doctor,'Patiens'=>$Patiens]);

                        }else{
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }
    // Doctor Money Out
    public function DoctorMoneyOut(Request $request,$uuid){
        if($request->isMethod('post')){
            if(Auth::user()->user_type == 1){
                $doctor = Doctor::where('uuid',$uuid)->get()[0];
                $center_id = $doctor->center_id; // Center id
                $user_id = $doctor->user_id; // User id
                $center_id= Center::where('id',$center_id)->get();
                $doctor_id = $doctor->id;
                /////////////////////////////////////////////////////////
                $Full_Box = $center_id[0]->moneybox + $doctor->moneybox; // Full Box
                if($request->howchange > $Full_Box){
                    return redirect()->back()->with('MoreThanBox',' ');
                }
                /////////////////////////////////////////////////////////

            }else{
                $user_id = Auth::user()->id; // user login id
                $center_are = Auth::user()->center_id; // Center id
                $center_id= Center::where('id',$center_are)->get();
                $doctor = Doctor::where('uuid',$uuid)->get()[0];
                $doctor_id = $doctor->id;
            }
            if(count($center_id) > 0){
                $request['center_id']    = Null;
                $request['doctor_id']    = $doctor_id;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    = 'expense';
                $request['Type']         = 'doctor';
                $request['patients_id']  = $request->Patieon_id;
                $request['uuid']         = Str::uuid()->toString();
                $request['created_date'] = date('Y-m-d');
                DB::beginTransaction();
                try
                {
                    $save_tran = Transitions::create($request->all());
                    if($save_tran){
                        $user = $user_id; // For this Doctor
                        $Doctor_Box = Doctor::where('uuid',$uuid)->get()[0];
                        $moneybox = $center_id[0]->moneybox; // Center Cash
                        $Doctrbox = $Doctor_Box->moneybox; // Doctor Cash
                        if($request->howchange > $Doctrbox){

                            // Take from Center and Doctor
                            $total = abs($request->howchange); // 11050
                            $remove_from_center =  $moneybox - ( $total - $Doctrbox)   ;
                            if($remove_from_center >= 0){
                                $remove_from_doctor =  $Doctrbox + ( - $total  );
                                $newdoctor = $remove_from_doctor;
                                $newcenter = $remove_from_center;
                                $new_center = $moneybox - $remove_from_center;
                                $r_c = ($total - $Doctrbox) ;
                                //dd($moneybox,$remove_from_center,$total - $Doctrbox );
                                $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $remove_from_center]);
                                $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $remove_from_doctor]);
                                $take = $new_center;
                            }else{
                                DB::rollback();
                                return redirect()->back()->with(['MoreThanBox'=>' ','data'=>Null]);
                            }

                        }else{ // Take from Doctor Only

                            $total = abs($request->howchange);
                            $remove_from_doctor = ( $Doctor_Box->moneybox ) - ( $total)  ;
                            $newdoctor = $remove_from_doctor ;
                            $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $newdoctor]);
                            $take = null;
                        }
                    }else{
                        // Rollback Transaction
                        DB::rollback();
                        return redirect()->back()->with(['WithError'=>' ','data'=>Null]);
                    }
                    // Commit Transaction
                    DB::commit();
                    return redirect()->back()->with(['Greate'=>' ','data'=>$take]);
                }catch (\Exception $e) {
                    // Rollback Transaction
                    DB::rollback();
                    return redirect()->back()->with(['WithError'=>' ','data'=>$take]);
                }
            }else{

                // Center Not Exist
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }
        else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-transition']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $Doctor = Doctor::where('uuid',$uuid)->get();
                    if(count($Doctor) > 0){
                        $Doctor     = Doctor::where('uuid',$uuid)->get()[0];
                        $center     = Center::where('id',$Doctor->center_id)->get();
                        return view('transite.doctor_pull_money',['DoctorData'=>$Doctor,'Center'=>$center[0]]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }
                else if($user_is == 2){// Doctor
                    $Find_doctor = Doctor::where('user_id',$user_id)->get();
                    if(count($Find_doctor) > 0){
                        if($Find_doctor[0]->uuid == $uuid){
                            $Doctor = Doctor::where('uuid',$uuid)->get();
                            if(count($Doctor) > 0){
                                $Doctor     = Doctor::where('uuid',$uuid)->get()[0];
                                $center     = Center::where('id',$Doctor->center_id)->get();
                                return view('transite.doctor_pull_money',['DoctorData'=>$Doctor,'Center'=>$center[0]]);
                            }else{
                                abort(401, 'Access denied - وصول غير مسموح ');
                            }
                        }
                        else{
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }
                else if($user_is == 3){// Reception
                    // Not Allowed
                }
                else if($user_is == 4){ //Accounter
                    $Doctor = Doctor::where('uuid',$uuid)->get();
                    if(count($Doctor) > 0){
                        $user_center = Auth::user()->center_id;
                        if($Doctor[0]->center_id == $user_center){
                            $Doctor     = Doctor::where('uuid',$uuid)->get()[0];
                            $center     = Center::where('id',$Doctor->center_id)->get();
                            return view('transite.doctor_pull_money',['DoctorData'=>$Doctor,'Center'=>$center[0]]);
                        }else{
                            abort(401, 'Access denied - وصول غير مسموح ');
                        }
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }
        }
    }


######### Doctor #########


    // Browser
    public function Browser(){

        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                return view('transite.select_to_Search_Trans');

            }else if($user_is == 2){// Doctor
                $User = Auth::user()->center_id;
                $u_id = Auth::user()->id;
                $center = Center::find($User);
                $doctor = Doctor::where('user_id',$u_id)->get()[0];
                return view('transite.browser.Main_doctor',['center'=>$center,'doctor'=>$doctor]);
                //return view('transite.select_to_Search_Trans');

            }else if($user_is == 3){// Reception

            }else if($user_is == 4){ //Accounter
                $User = Auth::user()->center_id;
                $center = Center::find($User);
                return view('transite.browser.Main_accounter',['center'=>$center]);
                //return view('transite.select_to_Search_Trans');

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }


    }

    // Browser Doctor in [center view ]
    public function BrowserView(Request $request){
        if($request->isMethod('post')){
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['search-transition']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $dates = $request['dates'];
                    $ex = explode('||',$dates);
                    $start = trim($ex[0]);
                    $end = trim($ex[1]);
                    $trans = Transitions::whereBetween('created_date',array($start,$end))->get();
                    dd($start,$end,$trans);

                }else if($user_is == 2){// Doctor

                }else if($user_is == 3){// Reception

                }else if($user_is == 4){ //Accounter

                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }

    }

#################################################################################

    public function DoctorsIn(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.browser.doctor_income',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.doctor_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.doctor_income',['center'=>$Center,'CenterData'=>$all_docs]);
            }
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    // Browser Doctor in [select Doctor ]
    public function DoctorsInCenter($uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    $Doctors = $Center->Doctors;
                    return view('transite.browser.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 2){// Doctor
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        foreach ($Center->Doctors as $doctor) {
                            if($Center->id == $doctor->center_id){
                                $Doctors = $doctor;
                                break;
                            }
                        }
                        return view('transite.browser.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        $Doctors = $Center->Doctors;
                        return view('transite.browser.doctors_in_center_income',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    // select and view Doctor In
    public function DoctorsInCenteruuid(Request $request,$uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    if($request->isMethod('post')){
                        $dates = $request['dates'];
                        $ex = explode('||',$dates);
                        $start = trim($ex[0]);
                        $end = trim($ex[1]);
                        $trans = Transitions::where([
                            ['Type','doctor'],
                            ['Opeartion','income'],
                            ['doctor_id',$Doctor[0]->id]
                        ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                        if(count($trans) > 0){
                            $AllMount = $AllCenter = $AllDoctor =0;
                            foreach ($trans as $transdata){
                                $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                if($transdata->patients_id != Null){
                                    $pation = Patients::find($transdata->patients_id);
                                    $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                }else{
                                    $transdata->patients_id = ' لا يوجد ';
                                }
                                $user = User::find($transdata->user_id);
                                if($user->user_type == 2) {
                                    $ok = Doctor::where('user_id', $user->id)->get()[0];
                                    $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                }else if($user->user_type == 3){
                                    $transdata->user_id = ' الاستقبال ' .$user->name;
                                }else if($user->user_type == 4){
                                    $transdata->user_id = ' المحاسب ' .$user->name;
                                }else{
                                    $transdata->user_id = $user->name;
                                }
                                if($Doctor[0]->Type == 'Percent'){
                                    $all = $transdata->Amount;
                                    $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                    $ForDoctor = $all - $ForCenter ;
                                    $transdata->forDoctor = $ForDoctor;
                                    $transdata->forCenter = $ForCenter;
                                    $AllCenter = $AllCenter + $ForCenter;
                                    $AllDoctor = $AllDoctor + $ForDoctor;
                                }
                                $AllMount = $AllMount + $transdata->Amount;
                                $trans->All = $AllMount;
                                $trans->Center = $AllCenter ;
                                $trans->Doctor = $AllDoctor ;
                            }
                            return view('transite.browser.doctor_in_view',['data'=>$trans]);
                        }else{
                            return redirect()->back()->with('nowtrans',' ');
                        }
                    }else{
                        return view('transite.browser.doctor_in_view');
                    }


                }else{
                    abort(401,'Access Denied');
                }


            }else if($user_is == 2){// Doctor
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    $userare = $Doctor[0]->user_id;
                    if($userare == $user_id){

                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','doctor'],
                                ['Opeartion','income'],
                                ['doctor_id',$Doctor[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 4){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    if($Doctor[0]->Type == 'Percent'){
                                        $all = $transdata->Amount;
                                        $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                        $ForDoctor = $all - $ForCenter ;
                                        $transdata->forDoctor = $ForDoctor;
                                        $transdata->forCenter = $ForCenter;
                                        $AllCenter = $AllCenter + $ForCenter;
                                        $AllDoctor = $AllDoctor + $ForDoctor;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;
                                    $trans->Center = $AllCenter ;
                                    $trans->Doctor = $AllDoctor ;


                                }
                                return view('transite.browser.doctor_in_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.doctor_in_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }


                }else{
                    abort(401,'Access Denied');
                }



            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    $userare = $Doctor[0]->center_id;

                    if($User_data->center_id == $Doctor[0]->center_id){


                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','doctor'],
                                ['Opeartion','income'],
                                ['doctor_id',$Doctor[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    if($Doctor[0]->Type == 'Percent'){
                                        $all = $transdata->Amount;
                                        $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                        $ForDoctor = $all - $ForCenter ;
                                        $transdata->forDoctor = $ForDoctor;
                                        $transdata->forCenter = $ForCenter;
                                        $AllCenter = $AllCenter + $ForCenter;
                                        $AllDoctor = $AllDoctor + $ForDoctor;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;
                                    $trans->Center = $AllCenter ;
                                    $trans->Doctor = $AllDoctor ;


                                }
                                return view('transite.browser.doctor_in_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.doctor_in_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }

                }else{
                    abort(401,'Access Denied');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }



    /// Doctor Out
    public function DoctorsOut(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.browser.doctor_expance',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.doctor_expance',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.doctor_expance',['center'=>$Center,'CenterData'=>$all_docs]);
            }
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    // Browser Doctor Out [select Doctor ]
    public function DoctorsOutCenter($uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    $Doctors = $Center->Doctors;
                    return view('transite.browser.doctors_in_center_expance',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 2){// Doctor
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        foreach ($Center->Doctors as $doctor) {
                            if($Center->id == $doctor->center_id){
                                $Doctors = $doctor;
                                break;
                            }
                        }
                        return view('transite.browser.doctors_in_center_expance',['center'=>$Center,'DoctordsData'=>$Doctors]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center = Center::with('Doctors')->where('uuid',$uuid)->get();
                if(count($Center) > 0 ){
                    $Center = Center::with('Doctors')->where('uuid',$uuid)->get()[0];
                    if($User_data->center_id == $Center->id){
                        $Doctors = $Center->Doctors;
                        return view('transite.browser.doctors_in_center_expance',['center'=>$Center,'DoctordsData'=>$Doctors,'admin'=>true]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }
                }else{
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    public function DoctorsOutCenteruuid(Request $request,$uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    if($request->isMethod('post')){
                        $dates = $request['dates'];
                        $ex = explode('||',$dates);
                        $start = trim($ex[0]);
                        $end = trim($ex[1]);
                        $trans = Transitions::where([
                            ['Type','doctor'],
                            ['Opeartion','expense'],
                            ['doctor_id',$Doctor[0]->id]
                        ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                        if(count($trans) > 0){
                            $AllMount = $AllCenter = $AllDoctor =0;
                            foreach ($trans as $transdata){
                                $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                if($transdata->patients_id != Null){
                                    $pation = Patients::find($transdata->patients_id);
                                    $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                }else{
                                    $transdata->patients_id = ' لا يوجد ';
                                }
                                $user = User::find($transdata->user_id);
                                if($user->user_type == 2) {
                                    $ok = Doctor::where('user_id', $user->id)->get()[0];
                                    $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                }else if($user->user_type == 3){
                                    $transdata->user_id = ' الاستقبال ' .$user->name;
                                }else if($user->user_type == 4){
                                    $transdata->user_id = ' المحاسب ' .$user->name;
                                }else{
                                    $transdata->user_id = $user->name;
                                }
                                if($Doctor[0]->Type == 'Percent'){
                                    $all = $transdata->Amount;
                                    $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                    $ForDoctor = $all - $ForCenter ;
                                    $transdata->forDoctor = $ForDoctor;
                                    $transdata->forCenter = $ForCenter;
                                    $AllCenter = $AllCenter + $ForCenter;
                                    $AllDoctor = $AllDoctor + $ForDoctor;
                                }
                                $AllMount = $AllMount + $transdata->Amount;
                                $trans->All = $AllMount;
                                $trans->Center = $AllCenter ;
                                $trans->Doctor = $AllDoctor ;


                            }

                            return view('transite.browser.doctor_out_view',['data'=>$trans]);
                        }else{
                            return redirect()->back()->with('nowtrans',' ');
                        }
                    }else{
                        return view('transite.browser.doctor_out_view');
                    }


                }else{
                    abort(401,'Access Denied');
                }


            }else if($user_is == 2){// Doctor
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    $userare = $Doctor[0]->user_id;
                    if($userare == $user_id){

                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','doctor'],
                                ['Opeartion','expense'],
                                ['doctor_id',$Doctor[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 4){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    if($Doctor[0]->Type == 'Percent'){
                                        $all = $transdata->Amount;
                                        $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                        $ForDoctor = $all - $ForCenter ;
                                        $transdata->forDoctor = $ForDoctor;
                                        $transdata->forCenter = $ForCenter;
                                        $AllCenter = $AllCenter + $ForCenter;
                                        $AllDoctor = $AllDoctor + $ForDoctor;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;
                                    $trans->Center = $AllCenter ;
                                    $trans->Doctor = $AllDoctor ;


                                }
                                return view('transite.browser.doctor_out_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.doctor_out_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }


                }else{
                    abort(401,'Access Denied');
                }



            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Doctor = Doctor::where('uuid',$uuid)->get();
                if(count($Doctor) > 0){
                    $userare = $Doctor[0]->center_id;

                    if($User_data->center_id == $Doctor[0]->center_id){


                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','doctor'],
                                ['Opeartion','expense'],
                                ['doctor_id',$Doctor[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Doctor[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 4){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    if($Doctor[0]->Type == 'Percent'){
                                        $all = $transdata->Amount;
                                        $ForCenter= ($all * $Doctor[0]->cash_percent)/100;
                                        $ForDoctor = $all - $ForCenter ;
                                        $transdata->forDoctor = $ForDoctor;
                                        $transdata->forCenter = $ForCenter;
                                        $AllCenter = $AllCenter + $ForCenter;
                                        $AllDoctor = $AllDoctor + $ForDoctor;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;
                                    $trans->Center = $AllCenter ;
                                    $trans->Doctor = $AllDoctor ;


                                }
                                return view('transite.browser.doctor_out_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.doctor_out_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }

                }else{
                    abort(401,'Access Denied');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

#################################################################################

#################################################################################

    public function CenterIn(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.browser.center_income',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.center_income',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.center_income',['center'=>$Center,'CenterData'=>$all_docs]);
            }
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    public function CenterInCenteruuid(Request $request,$uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    if($request->isMethod('post')){
                        $dates = $request['dates'];
                        $ex = explode('||',$dates);
                        $start = trim($ex[0]);
                        $end = trim($ex[1]);
                        $trans = Transitions::where([
                            ['Type','center'],
                            ['Opeartion','income'],
                            ['center_id',$Center[0]->id]
                        ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                        if(count($trans) > 0){
                            $AllMount = 0;
                            foreach ($trans as $transdata){
                                $transdata->doctor_id = $Center[0]->doctor_fname;
                                if($transdata->patients_id != Null){
                                    $pation = Patients::find($transdata->patients_id);
                                    $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                }else{
                                    $transdata->patients_id = ' لا يوجد ';
                                }
                                $user = User::find($transdata->user_id);
                                if($user->user_type == 2) {
                                    $ok = Doctor::where('user_id', $user->id)->get()[0];
                                    $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                }else if($user->user_type == 3){
                                    $transdata->user_id = ' الاستقبال ' .$user->name;
                                }else if($user->user_type == 4){
                                    $transdata->user_id = ' المحاسب ' .$user->name;
                                }else{
                                    $transdata->user_id = $user->name;
                                }

                                $AllMount = $AllMount + $transdata->Amount;
                                $trans->All = $AllMount;
                            }
                            return view('transite.browser.center_in_view',['data'=>$trans]);
                        }else{
                            return redirect()->back()->with('nowtrans',' ');
                        }
                    }else{
                        return view('transite.browser.center_in_view');
                    }


                }else{
                    abort(401,'Access Denied');
                }


            }else if($user_is == 2){// Doctor
                $Center = Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    $userare = $Center[0]->id;
                    if($Center[0]->id == $User_data->center_id){
                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','center'],
                                ['Opeartion','income'],
                                ['center_id',$Center[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Center[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 4){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }

                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;

                                }
                                return view('transite.browser.doctor_in_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.center_in_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }


                }else{
                    abort(401,'Access Denied');
                }



            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center =  Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    $userare = $Center[0]->center_id;
                    if($User_data->center_id == $Center[0]->id){
                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','center'],
                                ['Opeartion','income'],
                                ['center_id',$Center[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Center[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;


                                }
                                return view('transite.browser.center_in_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.center_in_view');
                        }


                    }else{
                        abort(401,'Access Denied');
                    }

                }else{
                    abort(401,'Access Denied');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }


    public function CenterOut(){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            $center_is = Auth::user()->center_id;
            if($user_is == 1){// Super Admin
                $Center = Center::with('Doctors')->where('id','!=',1)->get();
                return view('transite.browser.center_expance',['center'=>$center_is,'CenterData'=>$Center,'admin'=>true]);

            }else if($user_is == 2){// Doctor
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.center_expance',['center'=>$Center,'CenterData'=>$all_docs]);

            }else if($user_is == 3){// Reception
                // Not Allowed
            }else if($user_is == 4){ //Accounter
                $Center = Center::find($center_is);
                $all_docs = ($Center->Doctors())->get();
                return view('transite.browser.center_expance',['center'=>$Center,'CenterData'=>$all_docs]);
            }
        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }

    public function CenterOutCenteruuid(Request $request,$uuid){
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-transition']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $Center = Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    if($request->isMethod('post')){
                        $dates = $request['dates'];
                        $ex = explode('||',$dates);
                        $start = trim($ex[0]);
                        $end = trim($ex[1]);
                        $trans = Transitions::where([
                            ['Type','center'],
                            ['Opeartion','expense'],
                            ['center_id',$Center[0]->id]
                        ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                        if(count($trans) > 0){
                            $AllMount = 0;
                            foreach ($trans as $transdata){
                                $transdata->doctor_id = $Center[0]->doctor_fname;
                                if($transdata->patients_id != Null){
                                    $pation = Patients::find($transdata->patients_id);
                                    $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                }else{
                                    $transdata->patients_id = ' لا يوجد ';
                                }
                                $user = User::find($transdata->user_id);
                                if($user->user_type == 2) {
                                    $ok = Doctor::where('user_id', $user->id)->get()[0];
                                    $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                }else if($user->user_type == 3){
                                    $transdata->user_id = ' الاستقبال ' .$user->name;
                                }else if($user->user_type == 4){
                                    $transdata->user_id = ' المحاسب ' .$user->name;
                                }else{
                                    $transdata->user_id = $user->name;
                                }

                                $AllMount = $AllMount + $transdata->Amount;
                                $trans->All = $AllMount;
                            }
                            return view('transite.browser.center_out_view',['data'=>$trans]);
                        }else{
                            return redirect()->back()->with('nowtrans',' ');
                        }
                    }else{

                        return view('transite.browser.center_in_view');
                    }


                }else{  dd('ll');
                    abort(401,'Access Denied');
                }


            }else if($user_is == 2){// Doctor

                $Center = Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    $userare = $Center[0]->user_id;
                    if($Center[0]->id == $User_data->center_id){
                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','center'],
                                ['Opeartion','expense'],
                                ['center_id',$Center[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Center[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 4){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }

                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;

                                }
                                return view('transite.browser.center_out_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.center_out_view');
                        }



                    }else{
                        abort(401,'Access Denied');
                    }


                }else{
                    abort(401,'Access Denied');
                }



            }else if($user_is == 3){// Reception
                // Not Allowed

            }else if($user_is == 4){ //Accounter
                $Center =  Center::where('uuid',$uuid)->get();
                if(count($Center) > 0){
                    $userare = $Center[0]->center_id;
                    if($User_data->center_id == $Center[0]->id){
                        if($request->isMethod('post')){
                            $dates = $request['dates'];
                            $ex = explode('||',$dates);
                            $start = trim($ex[0]);
                            $end = trim($ex[1]);
                            $trans = Transitions::where([
                                ['Type','center'],
                                ['Opeartion','expense'],
                                ['center_id',$Center[0]->id]
                            ])->whereBetween('created_date',[$start,$end])->orderBy('id', 'desc')->get();
                            if(count($trans) > 0){
                                $AllMount = $AllCenter = $AllDoctor =0;
                                foreach ($trans as $transdata){
                                    $transdata->doctor_id = $Center[0]->doctor_fname;
                                    if($transdata->patients_id != Null){
                                        $pation = Patients::find($transdata->patients_id);
                                        $transdata->patients_id = $pation->username.' '.$pation->user_middel.' '.$pation->lastname;
                                    }else{
                                        $transdata->patients_id = ' لا يوجد ';
                                    }
                                    $user = User::find($transdata->user_id);
                                    if($user->user_type == 2) {
                                        $ok = Doctor::where('user_id', $user->id)->get()[0];
                                        $transdata->user_id = 'د. ' . $ok->doctor_fname;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' الاستقبال ' .$user->name;
                                    }else if($user->user_type == 3){
                                        $transdata->user_id = ' المحاسب ' .$user->name;
                                    }else{
                                        $transdata->user_id = $user->name;
                                    }
                                    $AllMount = $AllMount + $transdata->Amount;
                                    $trans->All = $AllMount;


                                }
                                return view('transite.browser.center_out_view',['data'=>$trans]);
                            }else{
                                return redirect()->back()->with('nowtrans',' ');
                            }
                        }else{
                            return view('transite.browser.center_out_view');
                        }


                    }else{
                        abort(401,'Access Denied');
                    }

                }else{
                    abort(401,'Access Denied');
                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }


#################################################################################


}

