<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Cookie;

class ClientLogin extends ParentController
{

    public function client_login(){
         //parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('clients.client_login');
    }

    public function client_login_form(Request $request){
        //echo "here";
        $check = DB::table('clients')->select('id', 'password')->where('username', $request->username)->first();
        
        if($check){
            if (Hash::check($request->password, $check->password)){
                $token = $this->random_string(50);
                Cookie::queue('client_session', $token, 525600);
                DB::table('clients')->where('id', $check->id)->update(["client_login_session" => $token]);
                return redirect('/');
            }else{
                return redirect()->back()->with('message', 'Invalid credientials!');
                //echo 'Invalid credientials!';
            }
        }else{
            return redirect()->back()->with('message', 'Invalid client username!');
            //echo 'Invalid client username!';
        }
    }


function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

}
