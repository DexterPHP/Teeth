<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function API_Login(Request $request) {
        $data = $request->only('email','password');
        if (Auth::attempt($data)) {

            $client = DB::table('oauth_clients')->where('id', 2)->first();
            $id = ($client->id);
            $secret = ($client->secret);
            $http = new Client;
            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $id,
                    'client_secret' => $secret,
                    'username'=>$data['email'],
                    'password'=>$data['password'],
                    'scope'=>''
                ],
            ]);
            $access_token = json_decode($response->getBody())->access_token;

            return json_decode((string) $response->getBody(), true);

        }

         else {
          return  response()->json('user not found',404);
        }
    }
}
