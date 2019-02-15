<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

class HomeController extends ParentController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/client_login');
            }
        }else{
            $this->middleware('auth');
            //echo $this->get_employee_id; die;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Cookie::get('client_session')){
            parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
            return view('home', ['check_rights' => $this->check_employee_rights]);
        }else{
            return view('home');
        }
         
    }
}
