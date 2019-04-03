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

     //View
    public function current_month_consignments(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $data = [ 'total_booked' => DB::table('consignment_client')->selectRaw('count(*) as total_booked')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_booked, 'total_delivered' => DB::table('consignment_client')->selectRaw('count(*) as total_delivered')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 2')->first()->total_delivered, 'in_transit' => DB::table('consignment_client')->selectRaw('count(*) as in_transit')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 1')->first()->in_transit, 'total_amount' => DB::table('consignment_client')->selectRaw('SUM(sub_total) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_amount, 'consignments' => DB::table('consignment_client as cc')->selectRaw('customer_id, (SELECT company_name from clients where id = cc.customer_id) as client_name, (SELECT count(*) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_consignments, (SELECT SUM(sub_total) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->groupBy('customer_id')->get() ];
        //dd($data);
        return view('invoices.current_month_consignments', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $data]);
    }


    //Get Current Month Data 
    public function get_current_month_data_for_invoice(Request $request){
        $reports = DB::table('clients')->selectRaw('ntn, strn, username, company_name, poc_name, address, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as price_same_day, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as price_over_land, (Select SUM(fuel_charge) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'") as fuel_charges, (Select SUM(gst_charge) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'") as total_tax, (Select tax from billing where customer_id = "'.$request->id.'") as gst, (Select id from billing where customer_id = "'.$request->id.'") as account_id')->where('id', $request->id)->first();

        //echo "<pre>"; print_r($data);
        echo json_encode($reports);
    }
}
