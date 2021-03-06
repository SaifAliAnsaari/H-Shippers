<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;
//use Excel;
use DateTime;
use App\Http\Controllers\Import_excel\Consignments;

class ConsignmentManagement extends ParentController
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Admin
    public function consignment_booking(){
        parent::get_notif_data();
        parent::VerifyRights(); if($this->redirectUrl){return redirect($this->redirectUrl);}

        return view('consignment_booking.client_for_admin_consignment', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function book_admin_consignment(){
        parent::get_notif_data();
        parent::VerifyRights(); if($this->redirectUrl){return redirect($this->redirectUrl);}
        $get_city_from_pickup = DB::table('pickup_delivery')->get();
       // $cnno = "313".$this->generateRandomNumber();
        $city_name = DB::table('pickup_delivery')->select('city_name', 'province')->orderBy('city_name','province')->get();
       $last_consignment = DB::table('consignment_client')->orderBy('id', 'Desc')->first();
       $newConsignmentId = $last_consignment ? $last_consignment->id+1 : 1;
       $cnno = '3131'.sprintf("%05s", $newConsignmentId);
       $clients = DB::table('clients')->whereRaw('is_active = 1 AND billing_added = 1')->get();

       return view('consignment_booking.consignment_booking', ['check_rights' => $this->check_employee_rights, 'pickup_city' => $get_city_from_pickup, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'cnno' => $cnno, 'city' => $city_name, 'clients' => $clients]);
    }

    public function SaveConsignmentAdmin(Request $request){

        $service_type = $request->service_type;
        $chargesCriteria = "";
        $service_criteria = "";
        //$test = Cookie::get('client_session');
        $client_city = $request->select_city_shipper;

        if($request->Fragile_Criteria == "For Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_fragile')->whereRaw('customer_id = '.$request->select_customer)->first();
        }else if($request->Fragile_Criteria == "For Non Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_non_fragile')->whereRaw('customer_id = '.$request->select_customer)->first();
        }else if($request->Fragile_Criteria == "For Electronics"){
            $insurance = DB::table('billing')->select('insurance_for_electronics')->whereRaw('customer_id = '.$request->select_customer)->first();
        }

       

        //yani service type (Second Day) aur (Over Land) nae hai
        if($request->service_type != 3 || $request->service_type != 4){
            if(strtolower($client_city) == strtolower($request->consignment_dest_city)){
                //within city
                $service_criteria = "within city";
            }else{
                $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = "'.$request->select_city_shipper.'"')->first();
                $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city)->first();

                // echo json_encode(['client'=> $clientProvince, 'dest' => $destinationProvince]);
                // die;
                if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                    //within province
                    $service_criteria = "within province";
                }else{
                    //province to province
                    $service_criteria = "province to province";
                }
            }
        }else{
            $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw("city_name = $client_city")->first();
            $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city)->first();

            if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                //within province
                $service_criteria = "within province";
            }else{
                //province to province
                $service_criteria = "province to province";
            }
        }


        $price = 0;
        $totalPrice = 0;
        if($request->service_type == 1){

            if($request->consignment_weight <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }  
            }else if($request->consignment_weight > 0.25 && $request->consignment_weight <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight > 0.50 && $request->consignment_weight <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                   // $test = Cookie::get('client_session');
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $abc = "" ;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                   
                }
                
                
            }

        }else if($request->service_type == 2){
            if($request->consignment_weight <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight > 0.25 && $request->consignment_weight <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight > 0.50 && $request->consignment_weight <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
                
            }
        }else if($request->service_type == 3){
            if($request->consignment_weight <= 3){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight > 3){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }else{
            if($request->consignment_weight <= 10){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight > 10){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight-10) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight-10) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = '.$request->select_customer.') AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }

        if($request->product_price != ""){
            if($request->Fragile_Criteria == "For Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Non Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_non_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Electronics"){
                $totalPrice = $totalPrice + (($insurance->insurance_for_electronics / 100) * $request->product_price);
            }
        }
       

        if($request->hidden_supplementary_services != ""){
            $suplementary_services =  explode(',', $request->hidden_supplementary_services);
            foreach ($suplementary_services as $services) {
                if($services == "Holiday"){
                    $supplementary_values = DB::table('billing')->select('holiday')->whereRaw('customer_id = '.$request->select_customer.'')->first();
                    $totalPrice += $supplementary_values->holiday;
                }else if($services == "Special Handling"){
                    $supplementary_values = DB::table('billing')->select('special_handling')->whereRaw('customer_id = '.$request->select_customer.'')->first();
                    $totalPrice += $supplementary_values->special_handling;
                }else if($services == "Time Specified"){
                    $supplementary_values = DB::table('billing')->select('time_specified')->whereRaw('customer_id = '.$request->select_customer.'')->first();
                    $totalPrice += $supplementary_values->time_specified;
                }else{
                    $supplementary_values = DB::table('billing')->select('passport')->whereRaw('customer_id = '.$request->select_customer.'')->first();
                    $totalPrice += $supplementary_values->passport;
                }
                
            }

        }

        $gst_fuel = DB::table('billing')->select('tax', 'fuel_charges')->whereRaw('customer_id = '.$request->select_customer.'')->first();
        $sub_total = $totalPrice;

        if($gst_fuel->tax != "" || $gst_fuel->fuel_charges != ""){
            $totalPrice = $totalPrice + (($gst_fuel->tax / 100) * $sub_total);

            $price_for_fuel = ($gst_fuel->fuel_charges / 100) * $sub_total;
            $price_for_tax = ($gst_fuel->tax / 100) * ($sub_total + $price_for_fuel);

            $totalPrice = $totalPrice + (($gst_fuel->fuel_charges / 100) * $totalPrice);

            
        }
        
        $last_consignment = DB::table('consignment_client')->orderBy('id', 'Desc')->first();
        
        $newConsignmentId = $last_consignment ? $last_consignment->id+1 : 1;
       
        $cnno = '3131'.sprintf("%05s", $newConsignmentId);

        $insert = DB::table('consignment_client')->insertGetId(
            ['booking_date' => $request->booking_date, 
            'cnic' => $cnno,
            'customer_id' => $request->select_customer,
            'origin_city' => $request->select_city_shipper, 
            'consignee_name' => $request->consignee_name,
            'consignee_ref' => $request->consignee_ref_num,
            'consignee_cell' => $request->consignee_cell_num,
            'consignee_email' => $request->consignee_email,
            'consignee_address' => $request->consignee_address,
            'consignment_type' => $request->consignment_type,
            'fragile_cost' => $request->fragile_cost_hidden,
            'consignment_service_type' => $request->service_type,
            'consignment_pieces' => $request->consignment_pieces,
            'consignment_weight' => $request->consignment_weight,
            'consignment_description' => $request->consignment_description,
            'fragile_criteria' => $request->Fragile_Criteria,
            //'add_insurance' => $request->inlineRadioOptions,
            'status' => 1,
            'product_price' => $request->product_price,
            'consignment_dest_city' => $request->consignment_dest_city,
            'remarks' => $request->description,
            'supplementary_services' => $request->hidden_supplementary_services,
            'sub_total' => ROUND($sub_total, 2),
            'fuel_charge' => ROUND($price_for_fuel, 2),
            'gst_charge' => ROUND($price_for_tax, 2),
            'total_price' => ROUND($totalPrice, 2),
            'created_at' => date('Y-m-d H:i:s')
        ]);

       

       
        if($insert){
            //echo json_encode(round($totalPrice));
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 101,
                'message' => 'New consignment added',
                'consignment_id' => $insert,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if($insert_notification){
                echo json_encode($cnno);
            }else{
                echo json_encode('failed');
            }
        }else{
            echo json_encode('failed');
        }

    }


    //Client
    public function consignment_booking_client(){
        parent::get_client_nofif_data();
        $check_session = DB::table('clients')->select('username', 'company_pic', 'pick_up_city')->where('client_login_session', Cookie::get('client_session'))->first();
        if(!$check_session){
            return redirect('/cout');
        }else{
            //$cnno = "313".$this->generateRandomNumber();
            $test = Cookie::get('client_session');
            $client_id = DB::table('clients')->select('id')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
            $check = DB::table('billing')->select('id')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
            $get_city_from_pickup = DB::table('pickup_delivery')->get();
            $city_name = DB::table('pickup_delivery')->select('city_name', 'province')->orderBy('city_name','province')->get();
            $last_consignment = DB::table('consignment_client')->orderBy('id', 'Desc')->first();
            $newConsignmentId = $last_consignment ? $last_consignment->id+1 : 1;
            $cnno = '3131'.sprintf("%05s", $newConsignmentId);
            //$check_cnno = DB::table('consignment_client')->selectRaw('id, (Select id from consignment_admin where cnic = "'.$cnno.'")')->where('cnic', $cnno)->first();
            // if($check_cnno){
            //     return redirect('/consignment_booking_client');
            // }else{
                if($check){
                    return view('consignment_booking.consignment_booking_client', ['client_id' => $client_id->id, 'check_rights' => $this->check_employee_rights, 'pickup_city' => $get_city_from_pickup, 'name' => $check_session, 'cnno' => $cnno, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications, 'city' => $city_name]);
                }else{
                    return redirect('/');
                }
           // }
            
        }  
    }

    public function get_price_if_consignmentTypeFragile(Request $request){
        if(Cookie::get('client_session')){
            $cost_fragile = DB::table('billing')->select('fragile_cost')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
            echo json_encode($cost_fragile->fragile_cost);
        }else{
            $cost_fragile = DB::table('billing')->select('fragile_cost')->whereRaw('customer_id = (Select id from clients where id = "'.$request->id.'")')->first();
            echo json_encode($cost_fragile->fragile_cost);
        }
        
    }

    public function SaveConsignmentClient(Request $request){
      
        $service_type = $request->consignment_service_type_client;
        $chargesCriteria = "";
        $service_criteria = "";
        $test = Cookie::get('client_session');
        $client_city = $request->region_client;
        if($request->Fragile_Criteria == "For Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($request->Fragile_Criteria == "For Non Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_non_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($request->Fragile_Criteria == "For Electronics"){
            $insurance = DB::table('billing')->select('insurance_for_electronics')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }

       

        //yani service type (Second Day) aur (Over Land) nae hai
        if($request->consignment_service_type_client != 3 || $request->consignment_service_type_client != 4){
            if(strtolower($client_city) == strtolower($request->consignment_dest_city_client)){
                //within city
                $service_criteria = "within city";
            }else{
                $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = "'.$request->region_client.'"')->first();
                $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city_client)->first();

                // echo json_encode(['client'=> $clientProvince, 'dest' => $destinationProvince]);
                // die;
                if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                    //within province
                    $service_criteria = "within province";
                }else{
                    //province to province
                    $service_criteria = "province to province";
                }
            }
        }else{
            $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = (Select city from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
            $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city_client)->first();

            if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                //within province
                $service_criteria = "within province";
            }else{
                //province to province
                $service_criteria = "province to province";
            }
        }


        $price = 0;
        $totalPrice = 0;
        if($request->consignment_service_type_client == 1){

            if($request->consignment_weight_client <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight_client > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $test = Cookie::get('client_session');
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $abc = "" ;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                   
                }
                
                
            }

        }else if($request->consignment_service_type_client == 2){
            if($request->consignment_weight_client <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight_client > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
                
            }
        }else if($request->consignment_service_type_client == 3){
            if($request->consignment_weight_client <= 3){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 3){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight_client-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight_client-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }else{
            if($request->consignment_weight_client <= 10){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 10){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight_client-10) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight_client-10) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }

        if($request->product_price != ""){
            if($request->Fragile_Criteria == "For Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Non Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_non_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Electronics"){
                $totalPrice = $totalPrice + (($insurance->insurance_for_electronics / 100) * $request->product_price);
            }
        }
       

        if($request->hidden_supplementary_services != ""){
            $suplementary_services =  explode(',', $request->hidden_supplementary_services);
            foreach ($suplementary_services as $services) {
                if($services == "Holiday"){
                    $supplementary_values = DB::table('billing')->select('holiday')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                    $totalPrice += $supplementary_values->holiday;
                }else if($services == "Special Handling"){
                    $supplementary_values = DB::table('billing')->select('special_handling')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                    $totalPrice += $supplementary_values->special_handling;
                }else if($services == "Time Specified"){
                    $supplementary_values = DB::table('billing')->select('time_specified')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                    $totalPrice += $supplementary_values->time_specified;
                }else{
                    $supplementary_values = DB::table('billing')->select('passport')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                    $totalPrice += $supplementary_values->passport;
                }
                
            }

        }

        $gst_fuel = DB::table('billing')->select('tax', 'fuel_charges')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        $sub_total = $totalPrice;

        if($gst_fuel->tax != "" || $gst_fuel->fuel_charges != ""){
            $totalPrice = $totalPrice + (($gst_fuel->tax / 100) * $sub_total);

            $price_for_fuel = ($gst_fuel->fuel_charges / 100) * $sub_total;
            $price_for_tax = ($gst_fuel->tax / 100) * ($sub_total + $price_for_fuel);

            $totalPrice = $totalPrice + (($gst_fuel->fuel_charges / 100) * $totalPrice);

            
        }
        // echo json_encode(round($totalPrice));
        
        $last_consignment = DB::table('consignment_client')->orderBy('id', 'Desc')->first();
       
        $newConsignmentId = $last_consignment ? $last_consignment->id+1 : 1;
        $cnno = '3131'.sprintf("%05s", $newConsignmentId);

        // die;
        $save_consignment_client = DB::table('consignment_client')->insertGetId(
            ['booking_date' => $request->datepicker, 
           // 'cnic' => $request->cnic_client, 
            'cnic' => $cnno,
            'customer_id' => $request->customer_id_client,
            'origin_city' => $request->region_client, 
            'consignee_name' => $request->consignee_name_client,
            'consignee_ref' => $request->consignee_ref_client,
            'consignee_cell' => $request->consignee_cell_client,
            'consignee_email' => $request->consignee_email_client,
            'consignee_address' => $request->consignee_address_client,
            'consignment_type' => $request->consignment_type,
            'fragile_cost' => $request->fragile_cost_hidden,
            'consignment_service_type' => $request->consignment_service_type_client,
            'consignment_pieces' => $request->consignment_pieces_client,
            'consignment_weight' => $request->consignment_weight_client,
            'consignment_description' => $request->consignment_description_client,
            'fragile_criteria' => $request->Fragile_Criteria,
            'add_insurance' => $request->inlineRadioOptions,
            'product_price' => $request->product_price,
            'consignment_dest_city' => $request->consignment_dest_city_client,
            'remarks' => $request->remarks_client,
            'supplementary_services' => $request->hidden_supplementary_services,
            'sub_total' => ROUND($sub_total, 2),
            'fuel_charge' => ROUND($price_for_fuel, 2),
            'gst_charge' => ROUND($price_for_tax, 2),
            'total_price' => ROUND($totalPrice, 2),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($save_consignment_client){
            //echo json_encode(round($totalPrice));
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 101,
                'message' => 'New consignment added',
                'consignment_id' => $save_consignment_client,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // $get_email_addresses = DB::table('users')->select('email')->whereRaw('id IN (Select emp_id from subscribed_notifications WHERE email = 1 AND notification_code_id = 101)')->get();
            
            // if(!$get_email_addresses->isEmpty()){
            //     foreach($get_email_addresses as $email){
            //         $name = 'Krunal';
            //          Mail::to($email->email)->send(new SendMailable($name));
            //     }
            // }

            if($insert_notification){
                echo json_encode($request->cnic_client);

                ///echo json_encode(array('total_price'=> ROUND($totalPrice, 2), 'sub_price' => ROUND($sub_total, 2), 'fuel_price' => Round($price_for_fuel,2), 'tax_price' => ROUND($price_for_tax, 2)));
                //return redirect('/invoice/"'.$request->cnic_client.'"');
            }else{
                echo json_encode('failed');
            }
        }else{
            echo json_encode('failed');
        }
    }

    public function invoice($id){
        //echo Cookie::get('client_session'); die;
        $test = '';
        if(!Cookie::get('client_session')){
            $consignment = DB::table('consignment_client as cc')->selectRaw('id, origin_city, booking_date, cnic, consignee_ref, consignee_cell, consignee_address, consignee_name, remarks, customer_id, consignment_description, consignment_weight, fragile_cost, consignment_dest_city, consignment_service_type, consignment_pieces, supplementary_services, TIME(created_at) as time, (Select company_name from clients where id = cc.customer_id) as shipper_name, (Select address from clients where id = cc.customer_id) as shipper_address')->where('cnic', $id)->first();
            if($consignment){
               if($consignment->supplementary_services == null || $consignment->supplementary_services == ''){
                    $supplementary_charges = 0;
               }else{
                    $suplementary_services = explode(',', $consignment->supplementary_services);
                    $supplementary_charges = 0;
                    $billing = DB::table('billing')->where('customer_id', $consignment->customer_id)->first();
                    foreach($suplementary_services as $services){
                        if($services == 'Special Handling'){
                            $supplementary_charges += $billing->special_handling;
                        }else if($services == 'Holiday'){
                            $supplementary_charges += $billing->holiday;
                        }else if($services == 'Time Specified'){
                            $supplementary_charges += $billing->time_specified;
                        }else{
                            $supplementary_charges += $billing->passport;
                        }
                    }
               }
                return view('invoices.invoice', ['data' => $consignment, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'supplementary_charges' => $supplementary_charges]);
            }else{
                return redirect('/consignment_booking_client');
            }
        }else{
            parent::get_client_nofif_data();
            $check_session = DB::table('clients')->select('id', 'username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();

            $client_consignment = DB::table('consignment_client as cc')->selectRaw('id, origin_city, booking_date, cnic, consignee_ref, consignee_cell, consignee_address, consignee_name, remarks, customer_id, consignment_description, consignment_weight, fragile_cost, consignment_dest_city, consignment_service_type, consignment_pieces, supplementary_services, TIME(created_at) as time, (Select company_name from clients where id = cc.customer_id) as shipper_name, (Select address from clients where id = cc.customer_id) as shipper_address')->where('cnic', $id)->first();
            if($client_consignment){
               // $suplementary_services = $client_consignment->supplementary_services;
               if($client_consignment->supplementary_services == null || $client_consignment->supplementary_services == ''){
                    $supplementary_charges = 0;
               }else{
                    $suplementary_services = explode(',', $client_consignment->supplementary_services);
                    $supplementary_charges = 0;
                    $billing = DB::table('billing')->where('customer_id', $check_session->id)->first();
                    foreach($suplementary_services as $services){
                        if($services == 'Special Handling'){
                            $supplementary_charges += $billing->special_handling;
                        }else if($services == 'Holiday'){
                            $supplementary_charges += $billing->holiday;
                        }else if($services == 'Time Specified'){
                            $supplementary_charges += $billing->time_specified;
                        }else{
                            $supplementary_charges += $billing->passport;
                        }
                    }
               }
               //echo "<pre>"; print_r($client_consignment); die;
                return view('invoices.invoice', ['data' => $client_consignment, 'name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications, 'supplementary_charges' => $supplementary_charges]);
            }else{
                return redirect('/consignment_booking_client');
            } 
        } 
    }

    public function UpdateConsignmentClient(Request $request){
       
        $service_type = $request->consignment_service_type_client;
        $chargesCriteria = "";
        $service_criteria = "";

        $client_city = $request->update_region_client;

        if($request->Fragile_Criteria == "For Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_fragile')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
        }else if($request->Fragile_Criteria == "For Non Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_non_fragile')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
        }else if($request->Fragile_Criteria == "For Electronics"){
            $insurance = DB::table('billing')->select('insurance_for_electronics')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
        }

        //yani service type (Second Day) aur (Over Land) nae hai
        if($request->consignment_service_type_client != 3 || $request->consignment_service_type_client != 4){
            if(strtolower($client_city) == strtolower($request->consignment_dest_city_client)){
                //within city
                $service_criteria = "within city";
            }else{
                $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = "'.$request->update_region_client.'"')->first();
                $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city_client)->first();

                // echo json_encode(['client'=> $clientProvince, 'dest' => $destinationProvince]);
                // die;
                if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                    //within province
                    $service_criteria = "within province";
                }else{
                    //province to province
                    $service_criteria = "province to province";
                }
            }
        }else{
            $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = (Select city from clients where id = "'.$request->customer_id_client.'")')->first();
            $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $request->consignment_dest_city_client)->first();

            if(strtolower($clientProvince->province) == strtolower($destinationProvince->province)){
                //within province
                $service_criteria = "within province";
            }else{
                //province to province
                $service_criteria = "province to province";
            }
        }


        $price = 0;
        $totalPrice = 0;
        if($request->consignment_service_type_client == 1){

            if($request->consignment_weight_client <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight_client > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $abc = "" ;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
                
            }

        }else if($request->consignment_service_type_client == 2){
            if($request->consignment_weight_client <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
            }else if($request->consignment_weight_client > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
                
                
            }
        }else if($request->consignment_service_type_client == 3){
            if($request->consignment_weight_client <= 3){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 3){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight_client-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight_client-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }else{
            if($request->consignment_weight_client <= 10){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 10){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight_client-10) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight_client-10) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }
        }

        if($request->product_price != ""){
            if($request->Fragile_Criteria == "For Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Non Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_non_fragile / 100) * $request->product_price);
            }else if($request->Fragile_Criteria == "For Electronics"){
                $totalPrice = $totalPrice + (($insurance->insurance_for_electronics / 100) * $request->product_price);
            }
        }

        $abc = $request->hidden_supplementary_services;

        if($request->hidden_supplementary_services != ""){
            $suplementary_services =  explode(',', $request->hidden_supplementary_services);
            foreach ($suplementary_services as $services) {
                if($services == "Holiday"){
                    $supplementary_values = DB::table('billing')->select('holiday')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
                    $totalPrice += $supplementary_values->holiday;
                }else if($services == "Special Handling"){
                    $supplementary_values = DB::table('billing')->select('special_handling')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
                    $totalPrice += $supplementary_values->special_handling;
                }else if($services == "Time Specified"){
                    $supplementary_values = DB::table('billing')->select('time_specified')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
                    $totalPrice += $supplementary_values->time_specified;
                }else{
                    $supplementary_values = DB::table('billing')->select('passport')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();
                    $totalPrice += $supplementary_values->passport;
                }
                
            }

        }

        $gst_fuel = DB::table('billing')->select('tax', 'fuel_charges')->whereRaw('customer_id = (Select id from clients where id = "'.$request->customer_id_client.'")')->first();

        $sub_total = $totalPrice;

        if($gst_fuel->tax != "" || $gst_fuel->fuel_charges != ""){
            $totalPrice = $totalPrice + (($gst_fuel->tax / 100) * $totalPrice);

            $price_for_fuel = ($gst_fuel->fuel_charges / 100) * $sub_total;
            $price_for_tax = ($gst_fuel->tax / 100) * ($sub_total + $price_for_fuel);


            $totalPrice = $totalPrice + (($gst_fuel->fuel_charges / 100) * $totalPrice);
        }
        // echo json_encode(round($totalPrice));
        

        // die;
        $save_consignment_client = DB::table('consignment_client')->where('cnic', $request->cnic_client)->update(
            ['booking_date' => $request->datepicker, 
            'cnic' => $request->cnic_client, 
            'customer_id' => $request->customer_id_client,
            'origin_city' => $request->update_region_client, 
            'consignee_name' => $request->consignee_name_client,
            'consignee_ref' => $request->consignee_ref_client,
            'consignee_cell' => $request->consignee_cell_client,
            'consignee_email' => $request->consignee_email_client,
            'consignee_address' => $request->consignee_address_client,
            'consignment_type' => $request->consignment_type,
            'fragile_cost' => $request->fragile_cost_hidden,
            'consignment_service_type' => $request->consignment_service_type_client,
            'consignment_pieces' => $request->consignment_pieces_client,
            'consignment_weight' => $request->consignment_weight_client,
            'consignment_description' => $request->consignment_description_client,
            'fragile_criteria' => $request->Fragile_Criteria,
            'add_insurance' => $request->inlineRadioOptions,
            'product_price' => $request->product_price,
            'consignment_dest_city' => $request->consignment_dest_city_client,
            'remarks' => $request->remarks_client,
            'supplementary_services' => $request->hidden_supplementary_services,
            'sub_total' => ROUND($sub_total, 2),
            'fuel_charge' => ROUND($price_for_fuel, 2),
            'gst_charge' => ROUND($price_for_tax, 2),
            'total_price' => ROUND($totalPrice, 2),
            'updated_at' => date('Y-m-d H:i:s')
            ]);
            if($save_consignment_client){
                //echo json_encode(round($totalPrice));
                $insert_notification = DB::table('notifications_list')->insert([
                    'code' => 101,
                    'message' => 'consignment updated',
                    'consignment_id' => $request->hiddenconsignment_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                // $get_email_addresses = DB::table('users')->select('email')->whereRaw('id IN (Select emp_id from subscribed_notifications WHERE email = 1 AND notification_code_id = 101)')->get();
               
                // if(!$get_email_addresses->isEmpty()){
                //     foreach($get_email_addresses as $email){
                //         $name = 'Krunal';
                //          Mail::to($email->email)->send(new SendMailable($name));
                //     }
                // }

                if($insert_notification){
                    //echo json_encode('success');
                    //echo json_encode(ROUND($totalPrice, 2));
                    echo json_encode(array('total_price'=> ROUND($totalPrice, 2), 'sub_price' => ROUND($sub_total, 2), 'fuel_price' => Round($price_for_fuel,2), 'tax_price' => ROUND($price_for_tax, 2)));
                }else{
                    echo json_encode('failed');
                }
            }else{
                echo json_encode('failed');
            }
    }

    //Download Invoice
    public function download_invoice_client(){
        if(Cookie::get('client_session')){
            $client_id = DB::table('clients')->where('client_login_session', Cookie::get('client_session'))->first();
            if($client_id){
                $invoice_num = $this->generateRandomNumber();
                if(DB::table('invoice_data')->where('invoice_num', $invoice_num)->first()){
                    return redirect('/download_invoice_c');
                }else{
                    // $save_invoice_num = DB::table('invoice_data')->insert([
                    //     'invoice_num' => $invoice_num, 
                    //     'client_id' => $client_id->id,
                    //     'created_at' => date('Y-m-d H:i:s')
                    //     ]);
                    $month = date('m')-1;
                    $check_invoice = DB::table('invoices_generated')->whereRaw('client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'") AND month = "'.$month.'" AND paid = 0')->first();

                    if($check_invoice){
                        //$reports = DB::table('clients')->selectRaw('ntn, strn, username, company_name, poc_name, address, (Select Count(*) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 1) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 1) as price_same_day, (Select Count(*) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 2) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'" AND consignment_service_type = 4) as price_over_land, (Select SUM(fuel_charge) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'") as fuel_charges, (Select SUM(gst_charge) from consignment_client where customer_id = "'.$check_invoice->client_id.'" AND Month(booking_date) = "'.$check_invoice->month.'") as total_tax, (Select tax from billing where customer_id = "'.$check_invoice->client_id.'") as gst, (Select id from billing where customer_id = "'.$check_invoice->client_id.'") as account_id, (SELECT Date(created_at) FROM `clients` WHERE id = "'.$check_invoice->id.'") as date, (Select invoice_num from invoices_generated where client_id = "'.$client_id->id.'" AND month = "'.$month.'") as invoice_num')->whereRaw('id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                        return redirect('/fpdf/index.php?month='.$month.'&client='.Cookie::get('client_session').'&hit_from=client');
                        
                        // if($reports){
                        //     $url = '/fpdf?'.http_build_query(json_decode(json_encode($reports), true));
                        //     if($url){
                        //         return redirect($url);
                        //     }
                        // }else{
                        //     return redirect('/home');
                        // }

                    }else{
                        echo 'No new Invoice generated.'; die;
                    }

                    

                    // Monthly
                    // $reports = DB::table('clients')->selectRaw('ntn, strn, username, company_name, poc_name, address, (Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 1) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 1) as price_same_day, (Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 2) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'" AND consignment_service_type = 4) as price_over_land, (Select SUM(fuel_charge) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'") as fuel_charges, (Select SUM(gst_charge) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$client_id->id.'") as total_tax, (Select tax from billing where customer_id = "'.$client_id->id.'") as gst, (Select id from billing where customer_id = "'.$client_id->id.'") as account_id, (SELECT Date(created_at) FROM `clients` WHERE id = "'.$client_id->id.'") as date, (Select invoice_num from invoice_data where client_id = "'.$client_id->id.'" AND invoice_num = "'.$invoice_num.'") as invoice_num')->where('id', $client_id->id)->first();

                }
            }else{
                return redirect('/home');
            }
        } else{
            return redirect('/home');
        }
    }




    public function consignment_booked(){
        if(Cookie::get('client_session')){
            parent::get_client_nofif_data();
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                return view('consignment_booking.consignment_booked', ['check_rights' => $this->check_employee_rights, 'name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
            }
        }else{
            parent::get_notif_data();
            parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
            return view('consignment_booking.consignment_booked', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        }

        
        
    }

    public function GetConsignmentsList(){
        if(Cookie::get('client_session')){
            echo json_encode(DB::table('consignment_client')->selectRaw('id, booking_date, consignee_name, consignee_cell, region, (Select username from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_name, (Select city from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_city, (Select phone from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_cell')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get());
        }else{
            $booked_by_client = DB::table('consignment_client as cons')->selectRaw('id, booking_date, consignee_name, consignee_cell, (Select username from clients where id = cons.customer_id) as shipper_name, (Select city from clients where client_login_session = "'.Cookie::get('client_session').'") as shipper_city, (Select city from clients where id = cons.customer_id) as shipper_city, (Select phone from clients where id = cons.customer_id) as shipper_cell')->get();

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



    //Pending/Booked Consignments
    public function pending_consignments(){
        parent::get_notif_data();
        parent::VerifyRights(); if($this->redirectUrl){return redirect($this->redirectUrl);}
        $final_consignments = array();
        $counter = 0;
        //Designation 5 = Riders
        $riders = DB::table('users')->where('designation', '5')->get();
        $consignments_client = DB::table('consignment_client as cc')->selectRaw('id, cnic, booking_date, consignment_weight, status, total_price, consignment_pieces, consignee_name, (Select username from clients where id = cc.customer_id) as sender_name')->where('status', 0)->get();
     
        $consignments_admin = DB::table('consignment_admin')->where('status', 0)->get();
      
        foreach($consignments_client as $client){
            $final_consignments[$counter]['id'] = $counter+1;
            $final_consignments[$counter]['consignment_id'] = $client->id;
            $final_consignments[$counter]['date'] = $client->booking_date;
            $final_consignments[$counter]['weight'] = $client->consignment_weight;
            $final_consignments[$counter]['consignment_pieces'] = $client->consignment_pieces;
            $final_consignments[$counter]['sender_name'] = $client->sender_name;
            $final_consignments[$counter]['reciver_name'] = $client->consignee_name;
            $final_consignments[$counter]['cnno'] = $client->cnic;
            $final_consignments[$counter]['total_price'] = $client->total_price;
            $final_consignments[$counter]['opp'] = 'client';
            $counter++;
        }
        foreach($consignments_admin as $admin){
            $final_consignments[$counter]['id'] = $counter+1;
            $final_consignments[$counter]['consignment_id'] = $admin->id;
            $final_consignments[$counter]['date'] = $admin->booking_date;
            $final_consignments[$counter]['weight'] = $admin->consignment_weight;
            $final_consignments[$counter]['consignment_pieces'] = $admin->consignment_pieces;
            $final_consignments[$counter]['sender_name'] = $admin->shipper_name;
            $final_consignments[$counter]['cnno'] = $admin->cnic;
            $final_consignments[$counter]['reciver_name'] = $admin->consignee_name;
            $final_consignments[$counter]['total_price'] = $admin->total_price;
            $final_consignments[$counter]['opp'] = 'admin';
            $counter++;
        }

        $total_consignments = DB::table('consignment_client')->selectRaw('Count(*) as client_count, (Select Count(*) from consignment_admin) as admin_count, (Select Count(*) from consignment_client where status = 2) as completed_client, (Select Count(*) from consignment_admin where status = 2) as completed_admin')->first();
        $total_completed = $total_consignments->completed_client + $total_consignments->completed_admin;
        $total_consignments = $total_consignments->client_count + $total_consignments->admin_count;

        //echo '<pre>'; print_r($total_consignments); die;

        return view('consignment_booking.consignments_pending', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'consignments' => $final_consignments, 'total_consignments' => $total_consignments, 'pending_consignments' => $counter, 'all_notif' => $this->all_notification, 'completed' => $total_completed, 'riders' => $riders]);
    }

    public function process_this_consignment(Request $request){
        if($request->consignment_type == "admin"){
            $update = DB::table('consignment_admin')->where('id', $request->id)->update([
                'status' => 1,
                'rider' => $request->rider]);
            if($update){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            $update = DB::table('consignment_client')->where('id', $request->id)->update([
                'status' => 1,
                'rider' => $request->rider]);
            if($update){
                //For Client Notification
                DB::table('notifications_list')->insert([
                    'code' => "202", 
                    'message' => 'Consignment is proceed.', 
                    'consignment_id' => $request->id, 
                    'created_at' => date('Y-m-d H:i:s')
                    ]);
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }

    public function delete_pending_consignment(Request $request){
        // echo json_encode($request->consignment_type);
        // $abc;
        if($request->consignment_type == "admin"){
            $delete = DB::table('consignment_admin')->where('id', $request->id)->delete();
            if($delete){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            $delete = DB::table('consignment_client')->where('id', $request->id)->delete();
            if($delete){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }
    
    
    

    //Shipment Tracking
    public function shipment_tracking($id){
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                parent::get_client_nofif_data();
                $cnno_data = DB::table('consignment_client as cc')->selectRaw('id, cnic, consignee_name, booking_date, status, customer_id, consignment_dest_city, (Select company_name from clients where id = cc.customer_id) as company_name, (Select username from clients where id = cc.customer_id) as username, origin_city as city, (Select status from status_log where cnno = "'.$id.'" ORDER BY id DESC LIMIT 1) as current_status, (Select Date(created_at) from status_log where cnno = "'.$id.'" ORDER BY id DESC LIMIT 1) as status_date')->where('cnic', $id)->first();
        
            // echo "<pre>"; print_r($cnno_data); die;
                
                $statuses = DB::table('status_log as sl')->selectRaw('DATE(created_at) as date, status, remarks, created_by, (Select name from users where id = sl.created_by) as created_by')->where('cnno', $id)->get();
        
                if(!$cnno_data){
                    $check = 1;
                    echo 'here'; die;
                    return view('consignment_booking.shippment_tracking', ['data'=> $check, 'consignment' => null, 'statuses' => $statuses, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications, 'name' => $check_session]);
                }else{
                    $check = 2;
                    return view('consignment_booking.shippment_tracking', ['data'=> $check, 'consignment' => $cnno_data, 'statuses' => $statuses, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications, 'name' => $check_session]);
                }
            }
        }else{
            parent::get_notif_data();
            parent::VerifyRights(); 
            if($this->redirectUrl){
                return redirect($this->redirectUrl);
            }
            $cnno_data = DB::table('consignment_client as cc')->selectRaw('id, cnic, consignee_name, booking_date, status, customer_id, consignment_dest_city, (Select company_name from clients where id = cc.customer_id) as company_name, (Select username from clients where id = cc.customer_id) as username, origin_city as city, (Select status from status_log where cnno = "'.$id.'" ORDER BY id DESC LIMIT 1) as current_status, (Select Date(created_at) from status_log where cnno = "'.$id.'" ORDER BY id DESC LIMIT 1) as status_date')->where('cnic', $id)->first();
    
           // echo "<pre>"; print_r($cnno_data); die;
            
            $statuses = DB::table('status_log as sl')->selectRaw('DATE(created_at) as date, status, remarks, created_by, (Select name from users where id = sl.created_by) as created_by')->where('cnno', $id)->get();
    
            if(!$cnno_data){
                $check = 1;
                return view('consignment_booking.shippment_tracking', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'data'=> $check, 'consignment' => null, 'all_notif' => $this->all_notification, 'statuses' => $statuses]);
            }else{
                $check = 2;
                return view('consignment_booking.shippment_tracking', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'data'=> $check, 'consignment' => $cnno_data, 'all_notif' => $this->all_notification, 'statuses' => $statuses]);
            }
        }  
    }

    public function GetCNNOData(Request $request){
        if(Cookie::get('client_session')){

            if(DB::table('consignment_client')->whereRaw('cnic = "'.$request->id.'" AND customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first()){

                $core_data = DB::table('consignment_client as cc')->selectRaw('id, cnic, consignee_name, booking_date, status, customer_id, consignment_dest_city, (Select company_name from clients where id = cc.customer_id) as company_name, (Select username from clients where id = cc.customer_id) as username, (Select city from clients where id = cc.customer_id) as city, (Select status from status_log where cnno = "'.$request->id.'" ORDER BY id DESC LIMIT 1) as current_status, (Select Date(created_at) from status_log where cnno = "'.$request->id.'" ORDER BY id DESC LIMIT 1) as status_date')->where('cnic', $request->id)->first();
        
                $statuses = DB::table('status_log as sl')->selectRaw('DATE(created_at) as date, status, remarks, created_by, (Select name from users where id = sl.created_by) as created_by')->where('cnno', $request->id)->get();

                if($core_data){
                    echo json_encode(array(['core' => $core_data, 'statuses' => $statuses]));
                }else{
                    echo json_encode('error');
                }

            }else{
                echo json_encode('error');
            }
            
        }else{
            $core_data = DB::table('consignment_client as cc')->selectRaw('id, cnic, consignee_name, booking_date, status, customer_id, consignment_dest_city, (Select company_name from clients where id = cc.customer_id) as company_name, (Select username from clients where id = cc.customer_id) as username, (Select city from clients where id = cc.customer_id) as city, (Select status from status_log where cnno = "'.$request->id.'" ORDER BY id DESC LIMIT 1) as current_status, (Select Date(created_at) from status_log where cnno = "'.$request->id.'" ORDER BY id DESC LIMIT 1) as status_date')->where('cnic', $request->id)->first();
           
        
            $statuses = DB::table('status_log as sl')->selectRaw('DATE(created_at) as date, status, remarks, created_by, (Select name from users where id = sl.created_by) as created_by')->where('cnno', $request->id)->get();
            
            if($core_data){
                echo json_encode(array(['core' => $core_data, 'statuses' => $statuses]));
            }else{
                echo json_encode('error');
            }
        } 
    }



    //Confirmed Consignments
    public function confirmed_consignments(){
        parent::get_notif_data();
        parent::VerifyRights(); 
        if($this->redirectUrl){
            return redirect($this->redirectUrl);
        }

        $final_consignments = array();
        $counter = 0;
        $consignments_client = DB::table('consignment_client as cc')->selectRaw('id, booking_date, rider, total_price, cnic, consignment_weight, status, total_price, consignee_name, (Select username from clients where id = cc.customer_id) as shipper_name, (Select status from status_log where cnno = cc.cnic order by id desc LIMIT 1) as status_log, (Select remarks from status_log where cnno = cc.cnic order by id desc LIMIT 1) as status_remark, (Select name from users where id = cc.rider) as rider_name')->where('status', 1)->get();
        //echo '<pre>'; print_r($consignments_client); die;
        $consignments_admin = DB::table('consignment_admin as ca')->SelectRaw('id, booking_date, total_price, rider, cnic, consignment_weight, status, total_price, consignee_name, shipper_name, (Select status from status_log where cnno = ca.cnic order by id desc LIMIT 1) as status_log, (Select remarks from status_log where cnno = ca.cnic order by id desc LIMIT 1) as status_remark, (Select name from users where id = ca.rider) as rider_name')->where('status', 1)->get();
        //echo '<pre>'; print_r($consignments_admin); die;
        foreach($consignments_client as $client){
            $final_consignments[$counter]['id'] = $counter+1;
            $final_consignments[$counter]['consignment_id'] = $client->id;
            $final_consignments[$counter]['date'] = $client->booking_date;
            $final_consignments[$counter]['weight'] = $client->consignment_weight;
            $final_consignments[$counter]['price'] = $client->total_price;
            $final_consignments[$counter]['sender_name'] = $client->shipper_name;
            $final_consignments[$counter]['reciver_name'] = $client->consignee_name;
            $final_consignments[$counter]['cnno'] = $client->cnic;
            $final_consignments[$counter]['status_log'] = $client->status_log;
            $final_consignments[$counter]['status_remark'] = $client->status_remark;
            $final_consignments[$counter]['rider_name'] = $client->rider_name;
            $final_consignments[$counter]['total_price'] = $client->total_price;
            $final_consignments[$counter]['opp'] = 'client';
            $counter++;
        }
        foreach($consignments_admin as $admin){
            $final_consignments[$counter]['id'] = $counter+1;
            $final_consignments[$counter]['consignment_id'] = $admin->id;
            $final_consignments[$counter]['date'] = $admin->booking_date;
            $final_consignments[$counter]['weight'] = $admin->consignment_weight;
            $final_consignments[$counter]['price'] = $admin->total_price;
            $final_consignments[$counter]['sender_name'] = $admin->shipper_name;
            $final_consignments[$counter]['cnno'] = $admin->cnic;
            $final_consignments[$counter]['status_log'] = $admin->status_log;
            $final_consignments[$counter]['status_remark'] = $admin->status_remark;
            $final_consignments[$counter]['reciver_name'] = $admin->consignee_name;
            $final_consignments[$counter]['total_price'] = $admin->total_price;
            $final_consignments[$counter]['rider_name'] = $admin->rider_name;
            $final_consignments[$counter]['opp'] = 'admin';
            $counter++;
        }

        $total_consignments = DB::table('consignment_client')->selectRaw('Count(*) as client_count, (Select Count(*) from consignment_admin) as admin_count, (Select Count(*) from consignment_client where status = 2) as completed_client, (Select Count(*) from consignment_admin where status = 2) as completed_admin')->first();
        $total_completed = $total_consignments->completed_client + $total_consignments->completed_admin;
        $total_consignments = $total_consignments->client_count + $total_consignments->admin_count;
        

        $statuses = DB::table('custom_status')->get();
        return view('consignment_booking.confirmed_consignments', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'consignments' => $final_consignments, 'total_consignments' => $total_consignments, 'pending_consignments' => $counter, 'status' => $statuses, 'all_notif' => $this->all_notification, 'completed' => $total_completed]);
    }

    public function GetStatusLogForModal(){
        echo json_encode(DB::table('custom_status')->get());
    }

    public function update_status_log(Request $request){   
        $insert = DB::table('status_log')->insert([
            'cnno' => $request->cnno,
            'status' => $request->status_code,
            'remarks' => $request->remarks,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($insert){
            //For Client Notification
            if(DB::table('consignment_client')->where("cnic", $request->cnno)->first()){
                DB::table('notifications_list')->insert([
                    'code' => "202", 
                    'message' => 'Consignment Status Changed to "'.$request->status_code.'" with remarks "'.$request->remarks.'"', 
                    'consignment_id' => DB::raw('(Select id from consignment_client where cnic = "'.$request->cnno.'")'),
                    'created_at' => date('Y-m-d H:i:s')
                    ]);
            }
           
            echo json_encode(DB::table('status_log')->select('status', 'remarks')->where('cnno', $request->cnno)->orderBy('id','DESC')->first());
        }else{
            echo json_encode('failed');
        }
    }

    public function GetStatusList(Request $requessaveCont){
        echo json_encode(DB::table('custom_status')->get());
    }



    //Mark Consignment as Complete
    public function mark_consignment_complete(Request $request){
        if($request->opp == 'admin'){
            $complete = DB::table('consignment_admin')->where('id', $request->id)->update([
                'status' => 2
            ]);
            if($complete){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            $complete = DB::table('consignment_client')->where('id', $request->id)->update([
                'status' => 2
            ]);
            if($complete){
                
                if(DB::table('consignment_client')->where("cnic", $request->cnno)->first()){
                    DB::table('notifications_list')->insert([
                        'code' => "202", 
                        'message' => 'Consignmnet Completed', 
                        'consignment_id' => $request->id,
                        'created_at' => date('Y-m-d H:i:s')
                        ]);

                    $insert_status = DB::table('status_log')->insert([
                        'cnno' => $request->cnno,
                        'status' => $request->status_code,
                        'remarks' => $request->remarks,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                //$get_start_time = DB::table('consignment_client')->select('created_at')->where('cnic', $request->cnno)->first();
                // $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                // $datetime2 = new DateTime($get_start_time->created_at);
                // //$interval = $datetime1- $datetime2;
                // $interval = date_diff($datetime1, $datetime2);
                // $interval = $interval->format('%R%a days');
                // DB::table('consignment_client')->where('cnic', $request->cnno)->update(['avg_delivery_time' => $interval->format('%s')]);
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }



    //Add Consignment Statuses
    public function consignment_statuses(){
        parent::get_notif_data();
        parent::VerifyRights(); 
        if($this->redirectUrl){
            return redirect($this->redirectUrl);
        }

        return view('consignment_booking.consignment_statuses', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function save_consignment_statuses(Request $request){
        if(DB::table('custom_status')->where('status', $request->status)->first()){
            echo json_encode('already_exist');
        }else{
            $insert = DB::table('custom_status')->insert([
                'status' => $request->status,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        } 
    }

    public function get_custom_status_data(Request $request){
        echo json_encode(DB::table('custom_status')->where('id', $request->id)->first());
    }

    public function update_custom_status(Request $request){
        try{
            $update = DB::table('custom_status')->where('id', $request->id)->update([
                'status' => $request->status
            ]);
            echo json_encode('success');
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }
    }

    public function delete_custom_status(Request $request){
        $delete = DB::table('custom_status')->where('id', $request->id)->delete();
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }



    //Update Consignments Admin View
    public function update_consignment_ad($id){
        parent::get_notif_data();
        parent::VerifyRights(); 
        if($this->redirectUrl){
            return redirect($this->redirectUrl);
        }

        return view('consignment_booking.update_ac', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    //Update Consignments Client View
    public function update_consignment_cc($id){
        parent::get_notif_data();
        parent::VerifyRights(); 
        if($this->redirectUrl){
            return redirect($this->redirectUrl);
        }

        $get_city_from_pickup = DB::table('pickup_delivery')->get();
        return view('consignment_booking.update_cc', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, "cnno"=> $id, 'pickup_city' => $get_city_from_pickup, 'all_notif' => $this->all_notification]);
    }

    //Get Client Consignment Data
    public function GetCCData(Request $request){
        echo json_encode(DB::table('consignment_client')->where('cnic', $request->id)->first());
    }

    public function GetClientsListForConsignment(){
        echo json_encode(DB::table('clients')->whereRaw('is_active = 1 AND billing_added = 1')->get());
    }

    function generateRandomNumber($length = 8) {
        $number = '1234567890';
        $numberLength = strlen($number);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $number[rand(0, $numberLength - 1)];
        }
        return $randomNumber;
    }

    // public function bulkAction(Request $request){
    //     Excel::import(new Consignments(["test" => 123]), request()->file('excel_data'));
    //     echo "success";
    // }
    
}
