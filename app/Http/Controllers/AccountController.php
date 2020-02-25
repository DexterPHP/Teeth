<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Rols;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addaccount(Request $request){
        if($request->isMethod('post')){
            if($request->only('password') == $request->only('password2')){
                return redirect()->back()->with('errorPass',' ');
            }
            else{

                $validator = Validator::make($request->all(), [
                    'name'      => ['required', 'string', 'max:255'],
                    'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'  => ['required', 'string', 'min:8'],
                    'role_user' => ['required', 'string', 'min:1','exists:roles,id'],
                    'center_id' => ['required', 'string', 'min:1','exists:centers,id']
                ]);
                if ($validator->fails()) {
                    $error = $validator->errors()->first();
                    return redirect()->back()->with('TheError',$error);
                }else{
                    $request['uuid'] =  Str::uuid()->toString();
                    $request['password'] =   Hash::make($request['password']);
                    $request['user_type'] = $request['role_user'];

                    $make_user = User::create($request->all());
                    $make_user->roles()->attach($request['role_user']);

                   /* $make_user->roles()->attach([
                        'user_id' =>$make_user['id'],
                        'rols_id'=>$request['role_user'],
                        'created_at'=> date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ]);*/
                    return redirect()->back()->with('message',' ');



                }


            }

        }else{
            $user_id = Auth::user()->id;
            $User_data = User::find($user_id);
            $rols = $User_data->hasAccess(['create-user']);
            if($rols){
                $roles_list = Rols::where('id','!=',1)->get();
                $centers = Center::where('id','!=',1)->get();
                return view('account.add_account',['roles_list'=>$roles_list,'centers'=>$centers]);
            }else{
                abort(401, 'Access denied - وصول غير مسموح ');
            }


        }


    }
}
