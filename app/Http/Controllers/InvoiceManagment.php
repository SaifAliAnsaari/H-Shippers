<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

class InvoiceManagment extends ParentController
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

    public function current_month_consignments(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $data = [ 'total_booked' => DB::table('consignment_client')->selectRaw('count(*) as total_booked')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_booked, 'total_delivered' => DB::table('consignment_client')->selectRaw('count(*) as total_delivered')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 2')->first()->total_delivered, 'in_transit' => DB::table('consignment_client')->selectRaw('count(*) as in_transit')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 1')->first()->in_transit, 'total_amount' => DB::table('consignment_client')->selectRaw('SUM(sub_total) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_amount, 'consignments' => DB::table('consignment_client as cc')->selectRaw('(SELECT company_name from clients where id = cc.customer_id) as client_name, (SELECT count(*) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_consignments, (SELECT SUM(sub_total) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->groupBy('customer_id')->get() ];
        return view('invoices.current_month_consignments', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $data]);
    }
}
