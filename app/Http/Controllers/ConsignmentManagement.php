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

    public function SaveConsignmentAdmin(Request $request){
        $insert = DB::table('consignment_admin')->insert([
            'booking_date' => $request->booking_date,
            'cnic' => $request->cnic,
            'shipper_name' => $request->shipper_name,
            'shipper_city' => $request->select_city_shipper,
            'shipper_area' => $request->shipper_area,
            'shipper_cell' => $request->shipper_cell_num,
            'shipper_land_line' => $request->shipper_land_line,
            'shipper_email' => $request->shipper_email,
            'shipper_address' => $request->shipper_address,
            'consignee_name' => $request->consignee_name,
            'consignee_ref_num' => $request->consignee_ref_num,
            'consignee_cell' => $request->consignee_cell_num,
            'consignee_email' => $request->consignee_email,
            'consignee_address' => $request->consignee_address,
            'consignment_city' => $request->consignment_regin_city,
            'consignment_service_type' => $request->service_type,
            'consignment_pieces' => $request->consignment_pieces,
            'consignment_weight' => $request->consignment_weight,
            'consignment_description' => $request->consignment_description,
            'consignment_price' => $request->consignment_price,
            'consignment_destination' => $request->inlineRadioOptions,
            'consignment_dest_city' => $request->consignment_dest_city,
            'consignment_remarks' => $request->description,
            'supplementary_services' => $request->hidden_supplementary_services
        ]);
        if($insert){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
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
            echo json_encode(DB::table('consignment_client')->selectRaw('id, booking_date, consignee_name, consignee_cell, region, (Select username from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_name, (Select phone from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_cell')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get());
        }else{
            $booked_by_client = DB::table('consignment_client as cons')->selectRaw('id, booking_date, consignee_name, consignee_cell, (Select username from clients where id = cons.customer_id) as shipper_name, (Select city from clients where id = cons.customer_id) as shipper_city, (Select phone from clients where id = cons.customer_id) as shipper_cell')->get();

            $booked_by_admin = DB::table('consignment_admin as cons_adm')->selectRaw('id, booking_date, consignee_name, consignee_cell, consignment_city, shipper_name, shipper_city, shipper_cell')->get();

            $consignments = array();
            $counter = 0;

            if(!$booked_by_client->isEmpty()){
                foreach($booked_by_client as $client){
                    $consignments[$counter]['id'] = $client->id;
                    $consignments[$counter]['booking_date'] = $client->booking_date;
                    $consignments[$counter]['consignee_name'] = $client->consignee_name;
                    $consignments[$counter]['consignee_cell'] = $client->consignee_cell;
                    $consignments[$counter]['shipper_city'] = $client->shipper_city;
                    $consignments[$counter]['shipper_name'] = $client->shipper_name;
                    $consignments[$counter]['shipper_cell'] = $client->shipper_cell;
                    $consignments[$counter]['type'] = "client";
                    $counter++;
                }
            }

            if(!$booked_by_admin->isEmpty()){
                foreach($booked_by_admin as $admin){
                    $consignments[$counter]['id'] = $admin->id;
                    $consignments[$counter]['booking_date'] = $admin->booking_date;
                    $consignments[$counter]['consignee_name'] = $admin->consignee_name;
                    $consignments[$counter]['consignee_cell'] = $admin->consignee_cell;
                    $consignments[$counter]['shipper_city'] = $admin->shipper_city;
                    $consignments[$counter]['shipper_name'] = $admin->shipper_name;
                    $consignments[$counter]['shipper_cell'] = $admin->shipper_cell;
                    $consignments[$counter]['type'] = "admin";
                    $counter++;
                }
            }

            
            echo json_encode($consignments); die;
            
            echo json_encode(DB::table('consignment_client as cons')->selectRaw('id, booking_date, consignee_name, consignee_cell, region, (Select username from clients where id = cons.customer_id) as sender_name, (Select phone from clients where id = cons.customer_id) as sender_phone')->get());
        }
    }
}
