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
    public $notif_counts = 0;
    public $notif_data;
    public $all_notification;

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

    public function get_notif_data(){
        

        $check = DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = '. Auth::user()->id)->first();
        //echo $check; die;
        if($check->notifications_codes){

            //Counts
            $this->notif_counts = DB::table('notifications_list as nl')->selectRaw('Count(*) as counts')->whereRaw('code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = '. Auth::user()->id)->first()->notifications_codes.') AND id NOT IN (Select notif_id from notification_read_status where emp_id = "'.Auth::user()->id.'")')->first();

            //Show only four notifications
            $this->notif_data = DB::table('notifications_list as nl')->selectRaw('id, code, message, complain_id, suggestion_id, consignment_id, created_at, (Select username from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as notif_by, (Select company_pic from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as picture ')->whereRaw('code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = '. Auth::user()->id)->first()->notifications_codes.') AND id NOT IN (Select notif_id from notification_read_status where emp_id = "'.Auth::user()->id.'")')->orderBy('id','DESC')->take(4)->get();

             //Show all notifications
            $this->all_notification = DB::table('notifications_list as nl')->selectRaw('id, code, message, complain_id, suggestion_id, consignment_id, created_at, (Select username from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as notif_by, (Select company_pic from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as picture')->whereRaw('code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = '. Auth::user()->id)->first()->notifications_codes.')')->orderBy('id','DESC')->get();

        }else{
            $this->notif_counts = "";
            $this->notif_data = [];
            $this->all_notification = [];
        }

        

       

    }

    // public function verifySession(){
    //     $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
    //     if(!$check_session){
    //         // $this->invalidSess = true;
    //         return redirect('/cout');
    //     }
    // }
}
