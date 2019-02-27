<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

class HomeController extends ParentController
{

    protected $invalidSess = false;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Cookie::get('client_session')){
            $test = Cookie::get('client_session');
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/client_login');
            }
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
        if(!Cookie::get('client_session')){
            parent::VerifyRights();
            if($this->redirectUrl){return redirect($this->redirectUrl);}
            parent::get_notif_data();
            //echo "<pre>"; print_r($this->notif_data); die;
            return view('home', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
        }else{
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                return view('home', ['name' => $check_session]);
            }
        }
         
    }

    //Prefrences View
    public function notification_prefrences(){
        parent::VerifyRights();
        parent::get_notif_data();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        $employees = DB::table('users')->get();
        $notifications_name = DB::table('notifications_code')->get();
        //print_r($employees); die;
        return view('notif_pref.notification_pref', ['check_rights' => $this->check_employee_rights, 'emp' => $employees, 'notifications_code' => $notifications_name, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    //Save Prefrences
    public function save_pref_against_emp(Request $request){

        if(DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->first()){
            $delete_existing = DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->delete();
            if($delete_existing){
                foreach($request->notifications as $notifications){
                    $emailProp = 0;
                    $webProp = 0;
                    foreach($notifications["properties"] as $props){
                        if($props == "email"){
                            $emailProp = 1;
                        }else{
                            $webProp = 1;
                        }
                    }
                    $insert = DB::table('subscribed_notifications')->insert([
                        'notification_code_id' => $notifications['code'],
                        'web' => $webProp,
                        'email' => $emailProp,
                        'emp_id' => $request->emp_id
                    ]);
                }
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            foreach($request->notifications as $notifications){
                $emailProp = 0;
                $webProp = 0;
                foreach($notifications["properties"] as $props){
                    if($props == "email"){
                        $emailProp = 1;
                    }else{
                        $webProp = 1;
                    }
                }
                $insert = DB::table('subscribed_notifications')->insert([
                    'notification_code_id' => $notifications['code'],
                    'web' => $webProp,
                    'email' => $emailProp,
                    'emp_id' => $request->emp_id
                ]);
            }
            echo json_encode('success');
        }
       
    }

    //Get Notifications against emp
    public function notif_pref_against_emp($id){
       echo json_encode(DB::table('subscribed_notifications')->where('emp_id', $id)->get());
    }


    public function notifications(){
        parent::VerifyRights();
        parent::get_notif_data();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('includes.notifications', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
       
    }

    public function read_notif_four(Request $request){
        if($request->notif_ids != ""){
            foreach($request->notif_ids as $notifications){
                DB::table('notification_read_status')->whereRaw('notif_id = "'.$notifications.'" AND emp_id = '.Auth::user()->id)->delete();
                DB::table('notification_read_status')->insert([
                    'notif_id' => $notifications,
                    'emp_id' => Auth::user()->id
                ]);
            }
        }
       
    }
}
