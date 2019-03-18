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

    public $clients_all_notifications;
    public $notif_counts_client = 0;
    public $notif_data_client;

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

    public function get_client_nofif_data(){
       
        $check = DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        if($check){
            //Counts
            if(DB::table('subscribed_notifications')->whereRaw('client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()){

                $this->notif_counts_client = DB::table('notifications_list as nl')->selectRaw('Count(*) as counts')->whereRaw('consignment_id IN ((Select id from consignment_client where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'"))) AND code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()->notifications_codes.') AND id NOT IN (Select notif_id from notification_read_status where client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'"))')->first();

                //Show only four notifications
                $this->notif_data_client = DB::table('notifications_list as nl')->selectRaw('id, code, message, complain_id, suggestion_id, consignment_id, created_at, (Select username from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as notif_by, (Select company_pic from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as picture ')->whereRaw('consignment_id IN ((Select id from consignment_client where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'"))) AND code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()->notifications_codes.') AND id NOT IN (Select notif_id from notification_read_status where client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'"))')->orderBy('id','DESC')->take(4)->get();

                //Show all notifications
                $this->clients_all_notifications = DB::table('notifications_list as nl')->selectRaw('id, code, message, complain_id, suggestion_id, consignment_id, created_at, (Select username from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as notif_by, (Select company_pic from clients where id = (Select client_id from complaints_suggestions where id = IFNull(nl.complain_id, IfNull(suggestion_id, consignment_id)))) as picture')->whereRaw('consignment_id IN ((Select id from consignment_client where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'"))) AND code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()->notifications_codes.')')->orderBy('id','DESC')->get();
            }else{
                $this->notif_counts_client = "";
                $this->notif_data_client = [];
                $this->clients_all_notifications = [];
            }
            
        }else{
            $this->notif_counts_client = "";
            $this->notif_data_client = [];
            $this->clients_all_notifications = [];
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
