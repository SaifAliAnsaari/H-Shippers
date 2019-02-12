<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Cookie::get('client_session')){
            $test = 123;
            //Authenticate from client_session db table
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/client_login');
            }
            /*if(Cookie::get('client_session'))
            valid
            else
            invalid redirect to /login page
            */
        }else{
            $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
