<?php

namespace App\Http\Controllers;

use App\Models\Accounter;
use App\Models\Center;
use App\Models\Dates;
use App\Models\Doctor;
use App\User;
use App\user\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;

class DatesController extends Controller
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
        $rols = $User_data->hasAccess(['create-date']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $getdoctors = Doctor::all();
                return view('dates.index',['doctors'=>$getdoctors]);
            }else if($user_is == 2){// Doctor
                $getdoctors = Doctor::where('user_id',$user_id)->get();
                return view('dates.index',['doctors'=>$getdoctors]);
            }else if($user_is == 3){// Reception
                $center = Auth::user()->center_id;
                $getdoctors = Doctor::where('center_id',$center)->get();
                return view('dates.index',['doctors'=>$getdoctors]);
            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }
    }


    public function addMetting(Request $request,$id){

        if($request->isMethod('post')){
            $data = $request->all();
            $start_time = date('H:i', strtotime($data['start_time']));
            $left_time = date('H:i', strtotime($data['left_time']));
            $data['start_time'] = $start_time;
            $data['left_time']  = $left_time;
            if($data['priority'] == 3){$data['priority'] ='#dc3545';}
            else if($data['priority'] == 1){$data['priority'] ='#007bff';}
            else if($data['priority'] == 2){$data['priority'] ='#ffc107';}
            else                           {$data['priority'] ='#17a2b8';}

            //if ( $data['what_date'] < date('Y-m-d')  ){return redirect()->back()->with('DateError',' ');}// Check Date
            //if ( $start_time < date('H:i')  ){return redirect()->back()->with('DateErrorTime',' ');}// Check time
            if($left_time < $start_time) { return redirect()->back()->with('timeoutare',' ');}
            else{

                $xx = Dates::where([['what_date','like','%'.$data['what_date'].'%'],['doctor_id',$data['doctor_id']]])->whereTime('start_time', '>=', $start_time)->whereTime('start_time', '<=' , $left_time)->get();
                $number_of_data = count($xx);
                if($number_of_data < 1){
                    $uuid = Str::uuid()->toString();
                    $data['uuid'] = $uuid;
                    Dates::create($data);
                    return redirect()->back()->with('message',' ');
                }else{

                    return redirect()->back()->with('messageError',' ');

                }
            }
        }else{
            //dd(Auth::user());
            $doctor_id  = Doctor::where('uuid',$id)->first();
            $doctordata = Doctor::find($doctor_id['id']);
            $pation     = Patients::where('doctors_id',$doctordata->id)->get();
            return view('dates.add_Event',['daoctor_data'=>$doctordata,'pations'=>$pation]);
        }

    }
    public function DatesData(Request $request,$id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $start_time = date('H:i', strtotime($data['start_time']));
            $left_time = date('H:i', strtotime($data['left_time']));
            $data['start_time'] = $start_time;
            $data['left_time']  = $left_time;
            if($data['priority'] == 3){$data['priority'] ='#dc3545';}
            else if($data['priority'] == 1){$data['priority'] ='#007bff';}
            else if($data['priority'] == 2){$data['priority'] ='#ffc107';}
            else                           {$data['priority'] ='#17a2b8';}
            if ( $data['what_date'] < date('Y-m-d')  ){return redirect()->back()->with('DateError',' ');}// Check Date
            //if ( $start_time < date('H:i')  ){dd($start_time , date('H:i'));return redirect()->back()->with('DateErrorTime',' ');}// Check time
            if($left_time < $start_time) {return redirect()->back()->with('timeoutare',' ');}
            $xx = Dates::where([['what_date','like','%'.$data['what_date'].'%'],['doctor_id',$data['doctor_id']]])
                ->whereTime('start_time', '>=', $start_time)
                ->whereTime('start_time', '<=' , $left_time)
                ->where('uuid', '!=' , $id)
                ->get();

            $number_of_data = count($xx);
            if($number_of_data < 1){
                $this_dates = Dates::where('uuid',$id)->first();

                $this_dates->update($data);
                return redirect()->back()->with('message',' ');
            }else{
                return redirect()->back()->with('messageError',' ');

            }
        }else{
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['edit-date']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Super Admin
                    $View = Dates::where('uuid',$id)->first(); // Get Dates Details
                    $doctordata = Doctor::find($View['doctor_id']);  // Doctor ID
                    $all_Patiens = $doctordata->Patiens;
                    return view('dates.Dates_data',['viewData'=>$View,'doctorid'=>$doctordata->id,'allPeation'=>$all_Patiens]);

                }else if($user_is == 2){// Doctor
                    $View = Dates::where('uuid',$id)->first(); // Get Dates Details
                    $doctor_id = $View->doctor_id; // Get Doctor ID form Dates                      [1]
                    $doctordata = Doctor::where('id',$doctor_id)->first();  // Doctor ID
                    if($doctordata->user_id == $user_id){
                        $all_Patiens = $doctordata->Patiens;
                        return view('dates.Dates_data',['viewData'=>$View,'doctorid'=>$doctordata->id,'allPeation'=>$all_Patiens]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }


                }else if($user_is == 3){// Reception

                    $View = Dates::where('uuid',$id)->first(); // Get Dates Details
                    $doctor_id = $View->doctor_id; // Get Doctor ID form Dates
                    $doctordata = Doctor::where('id',$doctor_id)->first();  // Doctor ID
                    $doctordata = Doctor::find($View['doctor_id']);  // Doctor ID
                    if($doctordata->center_id == Auth::user()->center_id){
                        $all_Patiens = $doctordata->Patiens;
                        return view('dates.Dates_data',['viewData'=>$View,'doctorid'=>$doctordata->id,'allPeation'=>$all_Patiens]);
                    }else{
                        abort(401, 'Access denied - وصول غير مسموح ');
                    }


                }else if($user_is == 4){ //Accounter
                    abort(401, 'Access denied - وصول غير مسموح ');
                }

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }

    }

    public function deleteDates(Request $request,$id){
        if($request->isMethod('post')){
            $theid = $request->only('theid');
            $d_d = Dates::find($theid)->first();
            $delete = $d_d->delete();
            return redirect()->route('home');

        }else{
            $Dateles = Dates::where('uuid',$id)->first();
            $doctor  = Doctor::find($Dateles['doctor_id']);
            return view('dates.delete_dates',['thidis'=>$Dateles,'Doctor'=>$doctor]);

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMetting()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-date']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){// Super Admin
                $yaya = Doctor::all();
                return view('dates.view_metting',['doctors'=>$yaya]);
            }else if($user_is == 2){// Doctor
                $getdoctors = Doctor::where('user_id',$user_id)->get();
                return view('dates.view_metting',['doctors'=>$getdoctors]);

            }else if($user_is == 3){// Reception
                $center = Auth::user()->center_id;
                $getdoctors = Doctor::where('center_id',$center)->get();
                return view('dates.view_metting',['doctors'=>$getdoctors]);

            }else if($user_is == 4){ //Accounter

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    public function SelectToEdit()
    {
        $yaya = Doctor::all();
        return view('dates.select_doctor',['doctors'=>$yaya]);
    }

    public  function DatesList($id)
    {
        $yaya = Doctor::where('uuid',$id);
        return view('dates.doctors_list',['doctors'=>$yaya]);
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
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function show(Dates $dates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function edit(Dates $dates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dates $dates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dates $dates)
    {
        //
    }
}
