<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;

class ConsignmentManagement extends ParentController
{
    public function __construct()
    {
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/client_login');
            }
        }else{
            $this->middleware('auth');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Admin
    public function consignment_booking(){
         parent::VerifyRights(); if($this->redirectUrl){return redirect($this->redirectUrl);}
         $get_city_from_pickup = DB::table('pickup_delivery')->get();
        return view('consignment_booking.consignment_booking', ['check_rights' => $this->check_employee_rights, 'pickup_city' => $get_city_from_pickup]);
    }



    //Client
    public function consignment_booking_client(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        $client_id = DB::table('clients')->select('id')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
        $check = DB::table('billing')->select('id')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        $get_city_from_pickup = DB::table('pickup_delivery')->get();
        if($check){
            return view('consignment_booking.consignment_booking_client', ['client_id' => $client_id->id, 'check_rights' => $this->check_employee_rights, 'pickup_city' => $get_city_from_pickup]);
        }else{
            return redirect('/');
        }  
    }

    public function SaveConsignmentClient(Request $request){
        //echo json_encode($request->hidden_supplementary_services);
        $save_consignment_client = DB::table('consignment_client')->insert(
            ['booking_date' => $request->datepicker, 
            'cnic' => $request->cnic_client, 
            'customer_id' => $request->customer_id_client,
            'region' => $request->region_client, 
            'consignee_name' => $request->consignee_name_client,
            'consignee_ref' => $request->consignee_ref_client,
            'consignee_cell' => $request->consignee_cell_client,
            'consignee_email' => $request->consignee_email_client,
            'consignee_address' => $request->consignee_address_client,
            'consignment_city' => $request->consignment_city_client,
            'consignment_service_type' => $request->consignment_service_type_client,
            'consignment_pieces' => $request->consignment_pieces_client,
            'consignment_weight' => $request->consignment_weight_client,
            'consignment_description' => $request->consignment_description_client,
            'consignment_price' => $request->consignment_price_client,
            'consignment_destination' => $request->inlineRadioOptions,
            'consignment_dest_city' => $request->consignment_dest_city_client,
            'remarks' => $request->remarks_client,
            'supplementary_services' => $request->hidden_supplementary_services
            ]);
            if($save_consignment_client){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
    }



    public function consignment_booked(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('consignment_booking.consignment_booked', ['check_rights' => $this->check_employee_rights]);
    }

    public function GetConsignmentsList(){
        if(Cookie::get('client_session')){
            echo json_encode(DB::table('consignment_client')->selectRaw('id, booking_date, consignee_name, consignee_cell, region, (Select username from clients where client_login_session = "'.Cookie::get('client_session').'") as sender_name, (Select phone from clients where client_login_session = "'.Cookie::get('client_session').'") as sender_phone')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get());
        }else{
            echo json_encode(DB::table('consignment_client as cons')->selectRaw('id, booking_date, consignee_name, consignee_cell, region, (Select username from clients where id = cons.customer_id) as sender_name, (Select phone from clients where id = cons.customer_id) as sender_phone')->get());
        }
    }
}
