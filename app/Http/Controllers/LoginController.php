<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $hasher = app()->make('hash');

        $email = $request->input('email');
        $password = $request->input('password');

        $login = User::where('email', $email)->first();
        if(!$login) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';
            
            return response($res);
        }else{
            if($hasher->check($password, $login->password)) {
                $api_token = sha1(time());
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                if($create_token) {
                    $res['success'] = true;
                    $res['api_token'] = $api_token;
                    $res['message'] = $login;

                    return response($res);
                }
            }else{
                $res['success'] = true;
                $res['message'] = 'Your email or password incorrect!';

                return response($res);
            }
        }
    }
}
