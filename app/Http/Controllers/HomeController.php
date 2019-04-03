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

            // $current_month = date('m');
            // echo $current_month; die;
            return view('home', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        }else{
            parent::get_client_nofif_data();
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                return view('home', ['name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
            }
        }
         
    }

    //Prefrences View
    public function notification_prefrences(){
        if(Cookie::get('client_session')){
            parent::get_client_nofif_data();
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                $notification_codes = DB::table('notifications_code_client')->get();
                return view('notif_pref.notification_pref', ['name' => $check_session, 'notifications_codes' => $notification_codes, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
            }
        }else{
            parent::VerifyRights();
            parent::get_notif_data();
            if($this->redirectUrl){return redirect($this->redirectUrl);}
            $employees = DB::table('users')->get();
            $notifications_name = DB::table('notifications_code')->get();
            //print_r($employees); die;
            return view('notif_pref.notification_pref', ['check_rights' => $this->check_employee_rights, 'emp' => $employees, 'notifications_code' => $notifications_name, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        }
    }

    //Save Prefrences Employee
    public function save_pref_against_emp(Request $request){

        if(DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->first()){
            $delete_existing = DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->delete();
            if($delete_existing){
                foreach($request->notifications as $notifications){
                    $emailProp = 0;
                    $webProp = 0;
                    if(isset($notifications["properties"])){
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
                            'emp_id' => $request->emp_id,
                            'subscribed_at' => date('Y-m-d H:i:s')
                        ]);
                    }
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
                    'emp_id' => $request->emp_id,
                    'subscribed_at' => date('Y-m-d H:i:s')
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
        if(!Cookie::get('client_session')){
            parent::VerifyRights();
            parent::get_notif_data();
            if($this->redirectUrl){return redirect($this->redirectUrl);}
            return view('includes.notifications', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        }else{
            parent::get_client_nofif_data();
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                return view('includes.notifications', ['name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
            }
        }
        
       
    }

    public function read_notif_four(Request $request){
        if(Cookie::get('client_session')){
            if($request->notif_ids != ""){
                foreach($request->notif_ids as $notifications){
                    DB::table('notification_read_status')->whereRaw('notif_id = "'.$notifications.'" AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->delete();
                    DB::table('notification_read_status')->insert([
                        'notif_id' => $notifications,
                        'client_id' => DB::raw('(Select id from clients where client_login_session = "'.Cookie::get('client_session').'")'),
                        'read_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }else{
            if($request->notif_ids != ""){
                foreach($request->notif_ids as $notifications){
                    DB::table('notification_read_status')->whereRaw('notif_id = "'.$notifications.'" AND emp_id = '.Auth::user()->id)->delete();
                    DB::table('notification_read_status')->insert([
                        'notif_id' => $notifications,
                        'emp_id' => Auth::user()->id,
                        'read_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
       
    }



    //Client notification data
    public function get_client_notif_data(){
        if(Cookie::get('client_session')){
            echo json_encode(DB::table('subscribed_notifications')->whereRaw('client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get());
        }else{
            echo json_encode('employee');
        }
    }

    //Save Preferences Client
    public function save_pref_against_client(Request $request){
        $check = DB::table('clients')->select('id')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
        if($check){
            if(DB::table('subscribed_notifications')->whereRaw('client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()){
                $delete_existing = DB::table('subscribed_notifications')->whereRaw('client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->delete();
                if($delete_existing){
                    foreach($request->notifications as $notifications){
                        $emailProp = 0;
                        $webProp = 0;
                        if(isset($notifications["properties"])){
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
                                'client_id' => $check->id,
                                'subscribed_at' => date('Y-m-d H:i:s')
                            ]);
                        }
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
                        'client_id' => $check->id,
                        'subscribed_at' => date('Y-m-d H:i:s')
                    ]);
                }
                echo json_encode('success');
            }
                
        }else{
            echo json_encode('failed');
        }
    }





    //Admin Dashboard
    public function dashboard(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();
        $life_time_data = DB::table('consignment_client')->selectRaw('(Select booking_date order by id LIMIT 1 ) as first_order_date, (Select Count(*) from consignment_client) as life_time_consignments, (Select Sum(consignment_weight) from consignment_client) as total_weight')->first();
        $life_time_rev = DB::table('consignment_client')->selectRaw('SUM(sub_total) as life_time_revenus')->first();

        $consignments_by_days = DB::table('consignment_client')->selectRaw('DAYNAME(booking_date) as day, Count(*) as quantity, SUM(consignment_weight) as weight, SUM(sub_total) as rate')->groupBy(DB::raw('DAYNAME(booking_date)'))->orderby(DB::raw('Count(*)'), 'desc')->get();

        $consignments_by_destinations = DB::table('consignment_client')->selectRaw('consignment_dest_city, Count(*) as quantity, (Select Count(*) from consignment_client) as total_counts')->groupBy('consignment_dest_city')->orderby(DB::raw('Count(*)'), 'desc')->get();
       
        $reporting_this_month = DB::table('consignment_client')->selectRaw('(Select SUM(sub_total)) as total_revenue, (Select Count(*) from consignment_client) as total_bookings, (Select Count(*) from clients where is_active = 1) as active_custs, (Select SUM(amount) from payment) as amount_recieved ')->first();
        //echo "<pre>"; print_r($consignments_by_destinations); die;
        return view('dashboard.admin_dashboard', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $reporting_this_month, 'life_time_data' => $life_time_data, 'life_time_rev' => $life_time_rev, 'consignments_by_days' => $consignments_by_days, 'consignments_by_destinations' => $consignments_by_destinations]);
    }

    //Graph Reports
    public function get_graph_reports(){
        $graph_data = DB::table('consignment_client')->selectRaw('(SELECT Count(*) from consignment_client where Dayname(booking_date) = "Monday" AND consignment_service_type = 1) as type1Monday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Monday" AND consignment_service_type = 2) as type2Monday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Monday" AND consignment_service_type = 3) as type3Monday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Monday" AND consignment_service_type = 4) as type4Monday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Tuesday" AND consignment_service_type = 1) as type1Tuesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Tuesday" AND consignment_service_type = 2) as type2Tuesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Tuesday" AND consignment_service_type = 3) as type3Tuesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Tuesday" AND consignment_service_type = 4) as type4Tuesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Wednesday" AND consignment_service_type = 1) as type1Wednesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Wednesday" AND consignment_service_type = 2) as type2Wednesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Wednesday" AND consignment_service_type = 3) as type3Wednesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Wednesday" AND consignment_service_type = 4) as type4Wednesday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Thursday" AND consignment_service_type = 1) as type1Thursday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Thursday" AND consignment_service_type = 2) as type2Thursday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Thursday" AND consignment_service_type = 3) as type3Thursday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Thursday" AND consignment_service_type = 4) as type4Thursday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Friday" AND consignment_service_type = 1) as type1Friday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Friday" AND consignment_service_type = 2) as type2Friday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Friday" AND consignment_service_type = 3) as type3Friday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Friday" AND consignment_service_type = 4) as type4Friday,
        (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Saturday" AND consignment_service_type = 1) as type1Saturday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Saturday" AND consignment_service_type = 2) as type2Saturday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Saturday" AND consignment_service_type = 3) as type3Saturday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Saturday" AND consignment_service_type = 4) as type4Saturday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Sunday" AND consignment_service_type = 1) as type1Sunday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Sunday" AND consignment_service_type = 2) as type2Sunday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Sunday" AND consignment_service_type = 3) as type3Sunday, (SELECT Count(*) from consignment_client where Dayname(booking_date) = "Sunday" AND consignment_service_type = 4) as type4Sunday, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Monday" ) as Monday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Tuesday" ) as Tuesday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Wednesday") as Wednesday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Thursday") as Thursday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Friday") as Friday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Saturday" ) as Saturday_revenue, (Select SUM(sub_total) from consignment_client where Dayname(booking_date) = "Sunday" ) as Sunday_revenue')->first();

        echo json_encode($graph_data);
    }
}
