<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use URL;
use Cookie;
use Illuminate\Support\Facades\Input;
use Validator;
use File;

class Clients extends ParentController
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

    // Client View
    public function clients(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
         $city_name = DB::table('pickup_delivery')->select('city_name', 'province')->orderBy('city_name','province')->get();
        // echo '<pre>'; print_r($city_name); die;
        return view("clients/clients", ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'city' => $city_name]);
    }

    //get clients
    public function ClientsList(){
        echo json_encode( DB::table('clients')->get());
    }

    //add client
    public function save_client(Request $request){
       
                if($request->hasFile('compPicture')){
                    $completeFileName = $request->file('compPicture')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('compPicture')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
                    $path = $request->file('compPicture')->storeAs('public/clients', $compPic);
                    //$profile->company_logo = $compPic;
                    $insert_client_data = DB::table('clients')->insertGetId(
                        ['username' => $request->username, 
                        'password' => bcrypt($request->password), 
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        // 'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'company_pic' => $compPic,
                        'client_key' => $request->client_key,
                        'created_at' => date('Y-m-d H:i:s')
                        ]);
                    if($insert_client_data){
                        echo json_encode('success');
                    }else{
                        echo json_encode('failed');
                    }
                }else{
                    $insert_client_data = DB::table('clients')->insertGetId(
                        ['username' => $request->username, 
                        'password' => bcrypt($request->password), 
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'client_key' => $request->client_key,
                        'created_at' => date('Y-m-d H:i:s')
                        ]);
                        if($insert_client_data){
                            echo json_encode('success');
                        }else{
                            echo json_encode('failed');
                        }
                }
        //}
    }

    //Upload Client DOCS
    public function upload_docs(Request $request){

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
            $path = $file->storeAs('public/documents', $documents);
            $test2 = $request->hasFile('file');
            $insert_doc = DB::table('client_documents')->insert([
                    'client_document' => $documents,
                    'client_key' => $request->client_key_docs
                ]);
        }
        
        echo $documents;
        die;
    }

    //Remove client DOCS
    public function remove_docs($unlinkFile, Request $request){
        if(Storage::exists('public/documents/'.$unlinkFile)){
            Storage::delete('public/documents/'.$unlinkFile);
            DB::table('client_documents')->where('client_document', $unlinkFile)->delete();
        }
    }

    //Get client data
    public function get_client_data($id){
        $select_client_data = DB::table('clients')->where('id', $id)->first();
        $select_documents = DB::table('client_documents')->whereRaw('client_key = (Select client_key from clients where id = "'.$id.'")')->get();
        echo json_encode(array('info' => $select_client_data, 'documents' => $select_documents, 'base_url' => URL::to('/storage/clients').'/', 'doc_url' => URL::to('/storage/documents').'/'));
    }

    //Update
    public function update_client(Request $request){
        try{
            if($request->password == "*****"){
                if($request->hasFile('compPicture')){
                    $completeFileName = $request->file('compPicture')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('compPicture')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
                    $path = $request->file('compPicture')->storeAs('public/clients', $compPic);
        
                    if(Storage::exists('public/clients/'.str_replace('./storage/clients/', '', $request->logo_hidden))){
                        Storage::delete('public/clients/'.str_replace('./storage/clients/', '', $request->logo_hidden));
                    }
        
                    //$profile->company_logo = $compPic;
                    $update_client_data = DB::table('clients')->where('id', $request->client_id)->update(
                        ['username' => $request->username,  
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'company_pic' => $compPic,
                        'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    if($update_client_data){
                    
                        echo json_encode("success");
                    }else{
                        echo json_encode("failed");
                    }
                }else{
                    $update_client_data = DB::table('clients')->where('id', $request->client_id)->update(
                        ['username' => $request->username, 
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    if($update_client_data){
                    
                        echo json_encode("success");
                    }else{
                        echo json_encode("failed");
                    }
                }
            }else{
                if($request->hasFile('compPicture')){
                    $completeFileName = $request->file('compPicture')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('compPicture')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
                    $path = $request->file('compPicture')->storeAs('public/clients', $compPic);
        
                    if(Storage::exists('public/clients/'.str_replace('./storage/clients/', '', $request->logo_hidden))){
                        Storage::delete('public/clients/'.str_replace('./storage/clients/', '', $request->logo_hidden));
                    }
        
                    //$profile->company_logo = $compPic;
                    $update_client_data = DB::table('clients')->where('id', $request->client_id)->update(
                        ['username' => $request->username, 
                        'password' => bcrypt($request->password), 
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'company_pic' => $compPic
                        ]);
                    if($update_client_data){
                    
                        echo json_encode("success");
                    }else{
                        echo json_encode("failed");
                    }
                }else{
                    $update_client_data = DB::table('clients')->where('id', $request->client_id)->update(
                        ['username' => $request->username, 
                        'password' => bcrypt($request->password), 
                        'company_name' => $request->company_name,
                        'poc_name' => $request->poc, 
                        'phone' => $request->phone_number,
                        'office_num' => $request->office_number,
                        'website' => $request->website,
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province
                        ]);
                    if($update_client_data){
                    
                        echo json_encode("success");
                    }else{
                        echo json_encode("failed");
                    }
                }
            }
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }

    }

    //Delete
    public function delete_client_entry(Request $request){
        $delete_one_entry = DB::table('clients')
            ->where('id', $request->id)
            ->delete();
        if(DB::table('client_documents')->select('id')->where('client_id', $request->id)){
            try{
                $delete_document = DB::table('client_documents')
                ->where('client_id', $request->id)
                ->delete();
                echo json_encode('success');
            } catch(\Illuminate\Database\QueryException $ex){ 
                echo json_encode('failed'); 
            }
        }else{
            echo json_encode('success');
        }
    }

    //Client Logout
    public function cout(){
       // echo "here"; die;
        Cookie::queue(
            Cookie::forget('client_session')
        );
        return redirect('/client_login');
    }

    //Activate Client
    public function activate_client(Request $request){
        try{
            $add = DB::table('clients')
            ->where('id', $request->id)->update(
                ['is_active' => 1
                ]);
            echo json_encode('success');
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }
    }

    //Deactivate Client
    public function deactivate_client(Request $request){
        try{
            $add = DB::table('clients')
            ->where('id', $request->id)->update(
                ['is_active' => 0
                ]);
            echo json_encode('success');
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }
    }




    //Client profile from admin portal
    public function ClientProfile($id){
        parent::get_notif_data();
        parent::VerifyRights();
        if($this->redirectUrl){
            return redirect($this->redirectUrl);
        }
        $clients_data = DB::table('clients')->where('id', $id)->first();
        $reports_data = DB::table('consignment_client')->selectRaw('(Select booking_date from consignment_client where customer_id = "'.$id.'" order by id LIMIT 1 ) as first_order_date, (Select Count(*) from consignment_client where customer_id = "'.$id.'") as life_time_consignments, (Select Sum(consignment_weight) from consignment_client where customer_id = "'.$id.'") as total_weight, (Select SUM(sub_total) from consignment_client where customer_id = "'.$id.'") as life_time_revenue, (Select SUM(consignment_weight) from consignment_client where customer_id = "'.$id.'") as total_weight')->where('customer_id', $id)->first();

        $month_consignments = DB::table('consignment_client as cc')->selectRaw('count(*) as total_consignments, SUM(total_price) as amount, ROUND(SUM(consignment_weight), 2) as total_weight, Monthname(booking_date) as month_name')->where('customer_id', $id)->groupBy(DB::raw('Monthname(booking_date)'))->get();
        
        // echo '<pre>'; print_r($month_consignments); die;
       return view("clients.client_profile", ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'client_data' => $clients_data, "client_id" => $id, 'all_notif' => $this->all_notification, 'reports_data' => $reports_data, "month_consignments" => $month_consignments]);
    }

    public function updateClientProfile(Request $request){

        if($request->hasFile('client_pic')){
            $completeFileName = $request->file('client_pic')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('client_pic')->getClientOriginalExtension();
            $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
            $path = $request->file('client_pic')->storeAs('public/clients', $empPicture);
            if(Storage::exists('public/clients/'.str_replace('./storage/clients/', '', $request->hidden_img))){
                Storage::delete('public/clients/'.str_replace('./storage/clients/', '', $request->hidden_img));
            }
            DB::table('clients')->where('id', $request->id)->update([
                'company_pic' => $empPicture
            ]);
        }
        $update = DB::table('clients')->where('id', $request->id)->update([
            'company_name' => $request->profile_page_company_page,
            'poc_name' => $request->profile_page_poc,
            'phone' => $request->profile_page_phone,
            'address' => $request->profile_page_address
        ]);
        if($update){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }



    //Invoice Page
    public function client_invoice($id){
        parent::get_notif_data();
        parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}

        $reports = DB::table('clients')->selectRaw('ntn, strn, username, company_name, poc_name, address, IFNULL((Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 1), 0) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 1) as price_same_day, IFNULL((Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 2), 0) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'" AND consignment_service_type = 4) as price_over_land, (Select SUM(gst_charge) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'") as total_tax, (Select tax from billing where customer_id = "'.$id.'") as gst, (Select id from billing where customer_id = "'.$id.'") as account_id, (SELECT Date(created_at) FROM `clients` WHERE id = "'.$id.'") as date, (Select SUM(fuel_charge) from consignment_client where MONTH(created_at) = "'.date('m').'" and customer_id = "'.$id.'") as fuel_charges, (Select invoice_num from invoice_data where client_id = "'.$id.'" and MONTH(created_at) = "'.date('m').'" order by id desc limit 1) as invoice_num, (Select pending_amount from payment where client_id = "'.$id.'" order by id desc limit 1) as pending_amount, (Select SUM(amount) from payment where client_id = "'.$id.'" and MONTH(created_at) = "'.date('m').'") as paid_amount')->where('id', $id)->first();

         //echo '<pre>'; print_r($reports); die;

        if($reports->gst){
            return view('clients.client_invoice', ['notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'check_rights' => $this->check_employee_rights, "report" => $reports]);
        }else{
            return redirect('/clients');
        } 
    }



    //Save Payment
    public function save_payment(Request $request){
        if($request->bank_name){
            $insert = DB::table('payment')->insert([
                'payment_type' => 'Cheque',
                'bank_name' => $request->bank_name,
                'cheque_date' => $request->cheque_date,
                'cheque_no' => $request->cheque_num,
                'amount' => $request->cash_amount,
                'pending_amount' => $request->pending_amount,
                'client_id' => $request->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            $insert = DB::table('payment')->insert([
                'payment_type' => 'Cash',
                'amount' => $request->cash_amount,
                'client_id' => $request->id,
                'pending_amount' => $request->pending_amount,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }

    public function GetPaymentData(Request $request){
        echo json_encode(DB::table('payment')->selectRaw('id, Date(created_at) as date, amount, payment_type, pending_amount')->where('client_id', $request->id)->get());
    }

}
