<?php
namespace App\Http\Controllers\Import_excel;

use Auth;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class Consignments implements ToModel
{
    
    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $test = $this->data;
        if(is_numeric($row[0])){
        }
    }

    public function SaveConsignmentClient($sType, $fCriteria, $destCity, $consignWeight, $fragCost, $prodPrice, $suppServices){
        
        $service_type = $sType;
        $chargesCriteria = "";
        $service_criteria = "";
        $test = Cookie::get('client_session');
        $client_city = DB::table('clients')->select('pick_up_city')->whereRaw('client_login_session = "'.Cookie::get('client_session').'"')->first();
        $insurance = '';
       
        if($fCriteria == "For Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($fCriteria == "For Non Fragile"){
            $insurance = DB::table('billing')->select('insurance_for_non_fragile')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }else if($fCriteria == "For Electronics"){
            $insurance = DB::table('billing')->select('insurance_for_electronics')->whereRaw('customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
        }

        //yani service type (Second Day) aur (Over Land) nae hai
        if($sType != 3 || $sType != 4){
            if(strtolower($client_city->pick_up_city) == strtolower($destCity)){
                //within city
                $service_criteria = "within city";
            }else{
                $clientProvince = DB::table('pickup_delivery')->select('province')->whereRaw('city_name = (Select pick_up_city from clients where client_login_session = "'.Cookie::get('client_session').'")')->first();
                $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $destCity)->first();

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
            $destinationProvince = DB::table('pickup_delivery')->select('province')->where('city_name', $destCity)->first();

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
        if($sType == 1){

            if($consignWeight <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 0.25 && $consignWeight <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                    
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 0.50 && $consignWeight <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
                
            }else if($consignWeight > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $test = Cookie::get('client_session');
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $abc = "" ;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 0')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                   
                }
                
                
            }

        }else if($sType == 2){
            if($consignWeight <= 0.25){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                    
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_025')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_025;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 0.25 && $consignWeight <= 0.50){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->upto_05;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 0.50 && $consignWeight <= 1){
                if($service_criteria == "within city"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $price->zero_five_1KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
                
            }else if($consignWeight > 1){
                if($service_criteria == "within city"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within city" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $chunks = ceil(($consignWeight-1) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('zero_five_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 1')->first();
                    $totalPrice = $maxKgPrice->zero_five_1KG + $price;
                    
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
                
                
            }
        }else if($sType == 3){
            if($consignWeight <= 3){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $price->upto_3KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 3){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $chunks = ceil(($consignWeight-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $chunks = ceil(($consignWeight-3) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 2')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }
        }else{
            if($consignWeight <= 10){
                if($service_criteria == "within province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $price = DB::table('biling_criteria')->select('upto_10KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $price->upto_10KG;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }else if($consignWeight > 10){
                if($service_criteria == "within province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additional_1KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $chunks = ceil(($consignWeight-10) / 1);
                    $price = $chunks * $eachAdditionalPrice->additional_1KG;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "within province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }else if($service_criteria == "province to province"){
                    $eachAdditionalPrice = DB::table('biling_criteria')->select('additionals_05')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $chunks = ceil(($consignWeight-10) / 0.5);
                    $price = $chunks * $eachAdditionalPrice->additionals_05;
                    $maxKgPrice = DB::table('biling_criteria')->select('upto_3KG')->whereRaw('biling_id = (Select id from billing where customer_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")) AND type = "province to province" AND criteria = 3')->first();
                    $totalPrice = $maxKgPrice->upto_3KG + $price;
                   
                    if($fragCost !== ""){
                        $totalPrice = $totalPrice + $fragCost;
                    }
                }
            }
        }

        if($prodPrice != ""){
            if($fCriteria == "For Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_fragile / 100) * $prodPrice);
            }else if($fCriteria == "For Non Fragile"){
                $totalPrice =$totalPrice + (($insurance->insurance_for_non_fragile / 100) * $prodPrice);
            }else if($fCriteria == "For Electronics"){
                $totalPrice = $totalPrice + (($insurance->insurance_for_electronics / 100) * $prodPrice);
            }
        }
       

        if($suppServices != ""){
            $suplementary_services =  explode(',', $suppServices);
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
        

        $save_consignment_client = DB::table('consignment_client')->insertGetId(
            ['booking_date' => $bookingDate, 
            'cnic' => "313".$this->generateRandomNumber(), 
            'customer_id' => $request->customer_id,
            'region' => $request->region_client, 
            'consignee_name' => $request->consignee_name_client,
            'consignee_ref' => $request->consignee_ref_client,
            'consignee_cell' => $request->consignee_cell_client,
            'consignee_email' => $request->consignee_email_client,
            'consignee_address' => $request->consignee_address_client,
            'consignment_type' => $request->consignment_type,
            'fragile_cost' => $fragCost,
            'consignment_service_type' => $sType,
            'consignment_pieces' => $request->consignment_pieces_client,
            'consignment_weight' => $consignWeight,
            'consignment_description' => $request->consignment_description_client,
            'fragile_criteria' => $fCriteria,
            'add_insurance' => $request->inlineRadioOptions,
            'product_price' => $prodPrice,
            'consignment_dest_city' => $destCity,
            'remarks' => $request->remarks_client,
            'supplementary_services' => $suppServices,
            'sub_total' => $sub_total,
            'fuel_charge' => $price_for_fuel,
            'gst_charge' => $price_for_tax,
            'total_price' => $totalPrice,
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

                if($insert_notification){
                    echo json_encode(array('total_price'=> ROUND($totalPrice, 2), 'sub_price' => ROUND($sub_total, 2), 'fuel_price' => $price_for_fuel, 'tax_price' => $price_for_tax));
                }else{
                    echo json_encode('failed');
                }
            }else{
                echo json_encode('failed');
            }
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

}
