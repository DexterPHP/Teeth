<?php

namespace App\Http\Controllers;

use App\Models;
use App\Traits\UploadTrait;
use App\User;
use App\Models\Diseases;
use App\Models\Doctor;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatientsController extends Controller
{
    use UploadTrait;

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
        return view('user.add_user');
    }


    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $uuid = Str::uuid()->toString();
            $request['uuid'] = $uuid;
            $request['birthday'] = date('Y-m-d');
            $search = Patients::where([
                ['username',$request['username']],
                ['lastname',$request['lastname']],
                ['user_middel',$request['user_middel']],
                ['doctors_id',$request['doctors_id']],
            ])->get();
           if(isset($request['diseases']) and $request['diseases'] != null){
               $dises = count($request['diseases']);
               if($dises > 0){
                   $des = array();
                   for ($i=0;$i <= $dises-1; $i++ ){
                       $title = Diseases::where('id',
                           $request->diseases[$i])
                           ->first();
                       $val = [
                           'id'=> $request->diseases[$i],
                           'name' => $title->title
                       ];
                       $hi = array_push($des, $val );

                   }
                   $New_diseases= json_encode($des);
               }
           }else{
               $New_diseases = Null;
           }
            $count = count($search);
            if($count < 1 ){
                $request['diseases'] = $New_diseases;
                $request['user_mobile'] = $request['user_mobile'].' / '.$request['user_phone'];
                Patients::create($request->all());
                return redirect()->back()->with('message', ' ');
            }else{
                return redirect()->back()->with('userExists' , ' ')->withInput($request->all());
            }
        } else {
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-patients']);
            if($rols){
                $user_is = Auth::user()->user_type;
                if($user_is == 1){// Main Center
                    $cc =  Doctor::all();
                    $arr['doctors'] = $cc;
                    $disease = Diseases::all();
                    return view('user.add_user', ['doctors'=>$cc,'diseasei'=>$disease,'ViewDoctors'=>1]);
                }
                elseif($user_is == 2){   // Doctor
                    $cc = Doctor::where('user_id',$user_id)->first();
                    $arr['doctors'] = $cc;
                    //$disease = Diseases::with('Center')->get();
                    $disease = Diseases::where('center_id',Auth::user()->center_id)->get();
                    return view('user.add_user', ['doctors'=>$cc,'diseasei'=>$disease,'ViewDoctors'=>0]);
                }elseif($user_is == 3){// Reception
                    $center_id = Auth::user()->center_id;
                    $cc = Doctor::where('center_id',$center_id)->get();
                    $arr['doctors'] = $cc;
                    $disease = Diseases::where('center_id',Auth::user()->center_id)->get();
                    return view('user.add_user', ['doctors'=>$cc,'diseasei'=>$disease,'ViewDoctors'=>1]);
                    //return view('user.add_user', $arr);
                }elseif($user_is == 4){// Accounter
                    abort(401, 'Access denied - وصول غير مسموح ');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $user = Patients::where('uuid',$id)->first();
        $data['user'] = $user;
        return view('user.user_card', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Patients\Patients $patients
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['search-patients']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){
                $all = Patients::all();
                return view('user.show_all',['usersm'=>$all,'viewrecord'=>true,'viewcard'=>true,'deleteuser'=>true ]);
            }
            elseif ($user_is == 2){
                // he is a Doctor
                $all = Patients::all(); // All Patients
                $doctoe_id = Doctor::where('user_id',$user_id)->first();
                $patients_for_doc = Patients::where('doctors_id',$doctoe_id['id'])->orderBy('username', 'asc')->get();
                return view('user.show_all', ['usersm'=>$patients_for_doc,'viewrecord'=>true,'viewcard'=>true ,'deleteuser'=>true]);
            }else{
                $data = [];
                // Reception and Accounter
                //$all = Models\Patients::where('doctors_id',$user_id)->get();
                $this_center = Auth::user()->center_id;
                $all = Patients::all();

                foreach ($all as $patients) {
                    $get_dotors_in_center = Doctor::where('center_id',$this_center)->get();
                   foreach ($get_dotors_in_center as $dotorz){
                       if($patients->doctors_id == $dotorz->id){

                           array_push($data,$patients);
                       }
                   }

                }
                if($user_is == 3){return view('user.show_all', ['usersm'=>$data,'viewrecord'=>false,'viewcard'=>true,'deleteuser'=>true ]);}
                else             {return view('user.show_all', ['usersm'=>$data,'viewrecord'=>true,'viewcard'=>true,'deleteuser'=>false ]);}

            }

            }else{
        abort(401, 'Access denied - وصول غير مسموح ');
        }

    }

    public function download(Request $request, $id)
    {
        $all = Patients::where('uuid',$id)->get();
        $arr['num'] = $all;

        return view('user.user_download', $arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Patients\Patients $patients
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user_id = Auth::user()->id; // user login id
        $User_data = User::find($user_id);
        $rols = $User_data->hasAccess(['create-date']);
        if($rols){
            $user_is = Auth::user()->user_type;
            if($user_is == 1){
                $all = Patients::all();
                return view('user.edit', ['usersm'=>$all,'editable'=>true]);
            }else{
                if($user_is == 2){
                    // Doctor
                    // he is a Doctor
                    $all = Patients::all(); // All Patients
                    $doctoe_id = Doctor::where('user_id',$user_id)->first();
                    $patients_for_doc = Patients::where('doctors_id',$doctoe_id['id'])->orderBy('username', 'asc')->get();

                    return view('user.edit', ['usersm'=>$patients_for_doc,'editable'=>true]);

                }else{
                    $data = [];
                    $this_center = Auth::user()->center_id;
                    $all = Patients::all();
                    foreach ($all as $patients) {
                        $get_dotors_in_center = Doctor::where('center_id',$this_center)->get();
                        foreach ($get_dotors_in_center as $dotorz){
                            if($patients->id == $dotorz->id){
                                array_push($data,$patients);
                            }
                        }

                    }
                    $arr['usersm'] = $data;
                    if($user_is == 3){return view('user.edit', ['usersm'=>$all,'editable'=>true]);}
                    else{return view('user.edit', ['usersm'=>$all,'editable'=>false]);}


                }

            }

        }else{
            abort(401, 'Access denied - وصول غير مسموح ');
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Patients\Patients $patients
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(Request $request, PatientsController $patients)
    {
        dd($request);
    }*/
    public function update(Request $request, $id)
    {
        $item = Patients::where('uuid',$id)->first();
        if ($request->isMethod('post')) {

            // Check if a profile image has been uploaded
            if ($request->has('user_image')) {
                $imagex = $request->file('user_image')->store('/public');
                $nn = Storage::url($imagex);
                $ah =  asset($nn);
                $item->user_image = $ah;
                $request['user_image'] = $ah;
            }
            //$Find = Patients::where('uuid',$id)->first();
            //dd($request->all(),$item);
            $m = $item->update($request->all());
            return redirect()->back()->with('upDATE', ' ');


        } else {
            $user_id = Auth::user()->id; // user login id
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['edit-patients']);
            if($rols){
                $item = Patients::where('uuid',$id)->first();
                $disease = Diseases::where('center_id',Auth::user()->center_id)->get();
                $arr['user'] = $item;
                $arr['diseasei'] = $disease;
                return view('user.do_edit', $arr);

            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }

        }

    }


    public function delete(Request $request)
    {
        if($request->isMethod('post')){
            $theUser = Patients::where('uuid',$request->id)->first();
            if(isset($theUser)){
                $theUser->active = false;
                $Ya = $theUser->save();
                if($Ya){
                    echo 1;
                }
            }
        }
    }
}

