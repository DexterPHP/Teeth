<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Center;
use App\Models\Messenger;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MessengerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');// should Have an Account
    }

    public function index()
    {
        return view('messanger.chat_app');
    }
    public function contacts()
    {
        $user = Auth::user();
        $center_user = User::with('CenterUser')->where('center_id',$user->center_id)->where('id','!=',$user->id)->get();
       return response()->json($center_user);
    }
    public function Conversation($id)
    {
        $user = Auth::user();
        $Messenger = Messenger::where('from_user',$id)->orWhere('to_user',$id)->get();
       return response()->json($Messenger);
    }
    public function Send(Request $request){
        $user = Auth::user();
        $newText = Messenger::create([
            'from_user' => $user->id,
            'to_user'=> $request->contact_id,
            'message_content' => $request->text,
        ]);
         event(new NewMessage($newText));

        return response()->json($newText);

    }

}
