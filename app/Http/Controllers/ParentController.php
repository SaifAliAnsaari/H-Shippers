<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Cookie;

class ParentController extends Controller
{
    public $check_employee_rights;
    public $redirectUrl = null;

    public function __construct(){
    }

    public function VerifyRights(){
        if(!Cookie::get('client_session')){
            $this->getAccRights();
            if(!DB::table('access_rights')->whereRaw('employee_id = '. Auth::user()->id . ' and access = "/'.explode('/', url()->current())[3].'"')->first()){
                
                DB::table('access_rights')->whereRaw('employee_id = '. Auth::user()->id . ' and access = "/home"')->first() ? $this->redirectUrl = "/home" : (DB::table('access_rights')->whereRaw('employee_id = '. Auth::user()->id)->first() ? $this->redirectUrl = DB::table('access_rights')->whereRaw('employee_id = '. Auth::user()->id)->first()->access : $this->redirectUrl = "/logout" );
            }
        }
    }

    public function getAccRights(){
        $this->check_employee_rights = DB::table('access_rights')->where('employee_id', Auth::user()->id)->get();
    }

    // public function verifySession(){
    //     $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
    //     if(!$check_session){
    //         // $this->invalidSess = true;
    //         return redirect('/cout');
    //     }
    // }
}
