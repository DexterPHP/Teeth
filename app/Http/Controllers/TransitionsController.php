<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Doctor;
use App\Models\Transitions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use PhpParser\Comment\Doc;
use function GuzzleHttp\Promise\all;

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
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    ='income';
                $request['Type']    ='income';
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
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    ='expense';
                $request['Type']    ='expense';
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
             }else{
                 $user_id = Auth::user()->id; // user login id
                 $center_are = Auth::user()->center_id; // Center id
                 $center_id= Center::where('id',$center_are)->get();
             }
            if(count($center_id) > 0){
                $request['center_id']    = $center_id[0]->id;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    = 'income';
                $request['Type']         = 'income';
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
                            $all = abs($request['Amount']); // 1000
                            $c_p = $Doctor_Box->cash_percent; // 15
                            $for_Center = ($all*$c_p)/100; // (1000*15)/100
                            $for_Doctor = $all - $for_Center; // 1000-150
                            $add_to_doctor = $Doctor_Box->moneybox+$for_Doctor; // 0+850 = 850
                            $add_to_center = $moneybox+$for_Center; // 0+150
                            //dd($Doctor_Box->cash_percent,$all,$c_p,$for_Center,$for_Doctor,$add_to_center,$add_to_doctor,$Doctor_Box->moneybox,$moneybox);
                            $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $add_to_center]);
                            $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $add_to_doctor]);
                        }else{
                            // Cash

                            $all = $Doctor_Box->moneybox+abs($request['Amount']);
                            $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $all]);
                        }
                    }else{
                        // Rollback Transaction
                        DB::rollback();
                        return redirect()->back()->with('WithError'.' ');
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
            }
            if(count($center_id) > 0){
                $request['center_id']    = $center_id[0]->id;
                $request['Amount']       = abs($request->howchange) ;
                $request['user_id']      = $user_id;
                $request['Opeartion']    = 'expense';
                $request['Type']         = 'expense';
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
                        if($request->howchange > $Doctor_Box->moneybox){ // Take from Center and Doctor
                             $total = $request->howchange;
                             $remove_from_center= $total-$Doctor_Box->moneybox;
                             $remove_from_doctor = $Doctor_Box->moneybox;
                             $newdoctor = ($Doctor_Box->moneybox - $remove_from_doctor) - $remove_from_center ;
                             $newcenter = $moneybox - $remove_from_center;
                            $update_moneyBoxC = Center::where('id',$Doctor_Box->center_id)->update(['moneybox' => $newcenter]);
                            $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $newdoctor]);
                            $take = $remove_from_center;

                        }else{ // Take from Doctor Only
                            $total = $request->howchange;
                            $remove_from_doctor = $total - $Doctor_Box->moneybox;
                            $newdoctor = $Doctor_Box->moneybox - $remove_from_doctor ;
                            $update_moneyBoxD = Doctor::where('id',$Doctor_Box->id)->update(['moneybox' => $newdoctor]);
                            $take = null;
                        }
                    }else{
                        // Rollback Transaction
                        DB::rollback();
                        return redirect()->back()->with(['WithError'=>' ','data'=>$take]);
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
                }
                else if($user_is == 3){// Reception
                    // Not Allowed
                }
                else if($user_is == 4){ //Accounter
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


######### Doctor #########
}
