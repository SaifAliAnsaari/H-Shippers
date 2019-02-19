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
        //$this->verifySession();
        $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
        if(!$check_session){
            return redirect('/cout');
        }else{

            $test = Cookie::get('client_session');
            $client_id = DB::table('clients')->select('id')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
            $check = DB::table('billing')->select('id')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
            $get_city_from_pickup = DB::table('pickup_delivery')->get();

            if($check){
                return view('consignment_booking.consignment_booking_client', ['client_id' => $client_id->id, 'check_rights' => $this->check_employee_rights, 'pickup_city' => $get_city_from_pickup]);
            }else{
                return redirect('/');
            }
        }  
    }

    public function get_price_if_consignmentTypeFragile(){
        $cost_fragile = DB::table('billing')->select('fragile_cost')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        echo json_encode($cost_fragile->fragile_cost);
    }

    public function SaveConsignmentClient(Request $request){
        $service_type = $request->consignment_service_type_client;
        $chargesCriteria = "";
        $service_criteria = "";
        $test = Cookie::get('client_session');
        $client_city = DB::table('clients')->select('pick_up_city')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
       
        if($request->Fragile_Criteria == "For Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($request->Fragile_Criteria == "For Non Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_non_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($request->Fragile_Criteria == "For Electronics"){
            $insurance = DB::table('billing')->select('insurance_for_electronics')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }

        //Fragile Types Yeh Har return pa check hon gay yani echo json_encode($totalPrice) ki jagha ye checks lagain gay
        // if($request->product_price != ""){
        //     if($request->Fragile_Criteria == "For Fragile"){
        //         $totalPrice + (($insurance->insurance_for_fragile / 100) * $request->product_price);
        //     }else if($request->Fragile_Criteria == "For Non Fragile"){
        //         $totalPrice + (($insurance->insurance_for_non_fragile / 100) * $request->product_price);
        //     }else if($request->Fragile_Criteria == "For Electronics"){
        //         $totalPrice + (($insurance->insurance_for_electronics / 100) * $request->product_price);
        //     }
        // }

        //Supplementary Services 
        // if($request->hidden_supplementary_services != ""){
        //     $suplementary_services =  explode(',', $request->hidden_supplementary_services);
        //     foreach ($suplementary_services as $services) {
        //         if($services == "Holiday"){
        //             $supplementary_values = DB::table('billing')->select('holiday')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        //         }else if($services == "Special Handling"){
        //             $supplementary_values = DB::table('billing')->select('special_handling')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        //         }else if($services == "Time Specified"){
        //             $supplementary_values = DB::table('billing')->select('time_specified')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        //         }else{
        //             $supplementary_values = DB::table('billing')->select('passport')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        //         }
        //     }
        // }

        //yani service type (Second Day) aur (Over Land) nae hai
        if($request->consignment_service_type_client != 3 || $request->consignment_service_type_client != 4){
            if(strtolower($client_city->pick_up_city) == strtolower($request->consignment_dest_city_client)){
                //within city
                $service_criteria = "within city";
            }else{
                $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = (Select pick_up_city from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 0
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 0
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 0
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 0
                    // ]);
                }
                
                
            }

        }else if($request->consignment_service_type_client == 2){
            if($request->consignment_weight_client <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.25 && $request->consignment_weight_client <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }
            }else if($request->consignment_weight_client > 0.50 && $request->consignment_weight_client <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 1
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within city',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 1
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $chunks = ceil(($request->consignment_weight_client-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 1
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 2
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 2
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 2
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $chunks = ceil(($request->consignment_weight_client-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 2
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 3
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 3
                    // ]);
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
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'within province',
                    //     'criteria' => 3
                    // ]);
                    if($request->fragile_cost_hidden !== ""){
                        $totalPrice = $totalPrice + $request->fragile_cost_hidden;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $chunks = ceil(($request->consignment_weight_client-10) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                    // $insert = DB::table('consignment_test_table')->insert([
                    //     'total_price' => $totalPrice,
                    //     'type' => 'province to province',
                    //     'criteria' => 3
                    // ]);
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
        // else{
        //     echo json_encode($totalPrice);
        // }

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

        //echo json_encode($totalPrice);
        

       // die;
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
            'consignment_type' => $request->consignment_type,
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
            'total_price' => $totalPrice
            ]);
            if($save_consignment_client){
                echo json_encode(round($totalPrice));
            }else{
                echo json_encode('failed');
            }
    }



    public function consignment_booked(){
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/cout');
            }else{
                return view('consignment_booking.consignment_booked', ['check_rights' => $this->check_employee_rights]);
            }
        }else{
            parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
            return view('consignment_booking.consignment_booked', ['check_rights' => $this->check_employee_rights]);
        }

        
        
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
