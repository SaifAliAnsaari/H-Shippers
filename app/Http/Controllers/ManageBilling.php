<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Storage;
use File;

class ManageBilling extends Controller
{
    private $splitName;
    //private $cust = $splitName[4];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function billing($id){
        $splitName = explode('/', url()->current());
        $cust_id = $splitName[4];
        if(DB::table('customers')->whereRaw('id = "'.$id.'" AND billing_added = 1')->first()){
            return redirect('/select_customer');
        }else{
            if(DB::table('customers')->where('id', $id)->first()){
                return view('manage_billing.billing', ['cust_id' => $cust_id]);
            }else{
                return redirect('/select_customer');
            }
            
        }
        //return view("manage_billing.billing", ['cust_id' => $cust_id]);
    }

    public function save_billing(Request $request){

        // $splitName = explode('/', url()->current());
        // $customer_id = $splitName[4];

        $insert_billing = DB::table('billing')->insertGetId(
            ['start_date' => $request->datepicker,
            'fragile_cost' => $request->fragile_cost_price, 
            'insurance_for_fragile' => $request->insurance_for_fragile,
            'insurance_for_non_fragile' => $request->insurance_for_non_fragile, 
            'insurance_for_electronics' => $request->insurance_for_electronics,
            'holiday' => $request->supplementary_services_holiday,
            'special_handling' => $request->supplementary_services_special_holiday,
            'time_specified' => $request->supplementary_services_time_specified,
            'passport' => $request->supplementary_services_passport,
            'fuel_charges' => $request->fuel_charges,
            'tax' => $request->gst_tax,
            'customer_id' => $request->customer_id
            ]);

        if($insert_billing){
            $insert_same_day_data_within_city = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->with_in_city_twentyfive,
                'upto_05' => $request->with_in_city_fifty,
                '06-1KG' => $request->with_in_city_six,
                'additionals_05' => $request->with_in_city_additional,
                'type' => 'within city',
                'criteria' => "0",
                'biling_id' => $insert_billing
                ]);
            $insert_same_day_data_within_prov = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->with_in_province_twentyfive,
                'upto_05' => $request->with_in_province_fifty,
                '06-1KG' => $request->with_in_province_six,
                'additionals_05' => $request->with_in_province_additional,
                'type' => 'within province',
                'criteria' => "0",
                'biling_id' => $insert_billing
                ]);
            $insert_same_day_data_prov_to_prov = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->prov_to_prov_twentyfive,
                'upto_05' => $request->prov_to_prov_fifty,
                '06-1KG' => $request->prov_to_prov_six,
                'additionals_05' => $request->prov_to_prov_additional,
                'type' => 'province to province',
                'criteria' => "0",
                'biling_id' => $insert_billing
                ]);

            $insert_over_night_data_within_city = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->on_with_in_city_twentyfive,
                'upto_05' => $request->on_with_in_city_fifty,
                '06-1KG' => $request->on_with_in_city_six,
                'additionals_05' => $request->on_with_in_city_additional,
                'type' => 'within city',
                'criteria' => "1",
                'biling_id' => $insert_billing
                ]);
            $insert_over_night_data_within_prov = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->on_with_in_prov_twentyfive,
                'upto_05' => $request->on_with_in_prov_fifty,
                '06-1KG' => $request->on_with_in_prov_six,
                'additionals_05' => $request->on_with_in_prov_additional,
                'type' => 'within province',
                'criteria' => "1",
                'biling_id' => $insert_billing
                ]);
            $insert_over_night_data_prov_to_prov = DB::table('biling_criteria')->insert(
                ['upto_025' => $request->on_provience_to_prov_twentyfive,
                'upto_05' => $request->on_provience_to_prov_fifty,
                '06-1KG' => $request->on_provience_to_prov_six,
                'additionals_05' => $request->on_provience_to_prov_additional,
                'type' => 'province to province',
                'criteria' => "1",
                'biling_id' => $insert_billing
                ]);

            $insert_seond_day_data_within_prov = DB::table('biling_criteria')->insert(
                ['upto_3KG' => $request->second_day_delivery_upto_3kg,
                'additional_1KG' => $request->second_day_delivery_additional_1KG,
                'type' => 'within province',
                'criteria' => "2",
                'biling_id' => $insert_billing
                ]);
            $insert_seccond_dat_data_prov_to_prov = DB::table('biling_criteria')->insert(
                ['upto_3KG' => $request->second_day_delivery_prov_to_prov_upto3KG,
                'additional_1KG' => $request->second_day_delivery_prov_to_prov_additional1KG,
                '06-1KG' => $request->second_day_delivery_prov_to_prov_6to1KG,
                'additionals_05' => $request->second_day_delivery_prov_to_prov_additionalpointFiveKg,
                'type' => 'province to province',
                'criteria' => "2",
                'biling_id' => $insert_billing
                ]);

            $insert_over_land_data_within_prov = DB::table('biling_criteria')->insert(
                ['upto_10KG' => $request->over_land_upto10KG,
                'additional_1KG' => $request->over_land_additional1KG,
                'type' => 'within province',
                'criteria' => "3",
                'biling_id' => $insert_billing
                ]);
            $insert_over_land_data_prov_to_prov = DB::table('biling_criteria')->insert(
                ['upto_10KG' => $request->over_land_prov_to_prov_upto10KG,
                'additionals_05' => $request->over_land_prov_to_prov_additionalpoint5KG,
                'type' => 'province to province',
                'criteria' => "3",
                'biling_id' => $insert_billing
                ]);
            
            if($insert_same_day_data_within_city && $insert_same_day_data_within_prov && $insert_same_day_data_prov_to_prov && $insert_over_night_data_within_city && $insert_over_night_data_within_prov && $insert_over_night_data_prov_to_prov && $insert_seond_day_data_within_prov && $insert_seccond_dat_data_prov_to_prov && $insert_over_land_data_within_prov && $insert_over_land_data_prov_to_prov){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            echo json_encode('failed');
        }
        
    }

    // public function testUnlink($unlinkFile, Request $request){
    //     if(Storage::exists('public/uploads/'.$unlinkFile)){
    //         Storage::delete('public/uploads/'.$unlinkFile);
    //         DB::table('billing_documents')->where('customer_id', $request->cust_id)->delete();
    //     }
       
    // }

    public function testUnlink($unlinkFile, Request $request){
        if(Storage::exists('public/uploads/'.$unlinkFile)){
            Storage::delete('public/uploads/'.$unlinkFile);
            DB::table('billing_documents')->where('billing_docs', $unlinkFile)->delete();
        }
    }

    public function test(Request $request){
        // $image = $request->file('file');
        // $imageName = $image->getClientOriginalName();
        // $image->move(public_path('images'),$imageName);
        
        // $imageUpload = new ImageUpload();
        // $imageUpload->filename = $imageName;
        // $imageUpload->save();
        // return response()->json(['success'=>$imageName]);

        //$this->splitName;
        // $url = explode('/', $this->splitName);
        // $cust = $url[4];

        $input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}

        if($request->hasFile('file')){
            $file = $request->file('file');
            $completeFileName = $file->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $randomized = rand();
            $documents = str_replace(' ', '', $fileNameOnly).'-'.$randomized.''.time().'.'.$extension;
            $path = $file->storeAs('public/uploads', $documents);
            $test2 = $request->hasFile('file');
            $insert_doc = DB::table('billing_documents')->insert([
                    'billing_docs' => $documents,
                    'customer_id' => $request->cust_id
                ]);
        }
        
        echo $documents;
        die;
	
    }
}
