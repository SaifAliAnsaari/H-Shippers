<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile as CP;
use Illuminate\Support\Facades\Storage;
use DB;
use URL;

class OrganizationManagement extends ParentController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function manage_company(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view("organization_management.company_profile", ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function add_company(Request $request){

        $profile = new CP;
        $profile->company_name = $request->company_name;
        $profile->address = $request->address;
        $profile->contact_number = $request->contact_num;
        $profile->company_website = $request->company_website;
        $profile->ceo = $request->ceo;
        
        if($request->hasFile('compPicture')){
            $completeFileName = $request->file('compPicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('compPicture')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
            $path = $request->file('compPicture')->storeAs('public/company', $compPic);
            $profile->company_logo = $compPic;
        }

        if($profile->save()){
            echo json_encode('success');
        }

    }

    public function companies_list(){
        echo json_encode( CP::get());
    }

    public function get_company_data($id){
        echo json_encode(array('info' => DB::table('company_profile')->where('id', $id)->first(), "base_url" =>  URL::to('/storage/company').'/'));
    }

    public function update_company(Request $request){
        $company = CP::find($request->company_id);
        $company->company_name = $request->company_name;
        $company->address = $request->address;
        $company->contact_number = $request->contact_num;
        $company->company_website = $request->company_website;
        $company->ceo = $request->ceo;

        if($request->hasFile('compPicture')){
            $completeFileName = $request->file('compPicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('compPicture')->getClientOriginalExtension();
            $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
            $path = $request->file('compPicture')->storeAs('public/company', $empPicture);
            if(Storage::exists('public/company/'.$company->company_logo)){
                Storage::delete('public/company/'.$company->company_logo);
            }
            $company->company_logo = $empPicture;
        }

        if($company->save()){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }

    }

    public function delete_company_entry(Request $request){
        $delete_one_entry = DB::table('company_profile')
            ->where('id', $request->id)
            ->delete();
        if($delete_one_entry){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }



    public function manage_pickUp_delivery(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('organization_management.pick_up_and_delivery', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function add_pickUp(Request $request){
        
        $insert_pickup_delivery = DB::table('pickup_delivery')->insertGetId([
            'city_name' => $request->city_name,
            'province' => $request->province,
            'city_short' => $request->city_short_code
            ]);
        if($insert_pickup_delivery){
            $services =  explode(',', $request->location_service);

            foreach ($services as $service) {
                $insert_location_service = DB::table('locationservice_pickupdelivery')->insert([
                    'location_service' => $service,
                    'pick_up_table_id' => $insert_pickup_delivery
                    ]);
            }
            echo json_encode("success");
        }else{
            echo json_encode("failed");
        }
        
    }

    public function pickUp_list(){
        echo json_encode(DB::table('pickup_delivery')->get());
    }

    public function get_pickUp_data($id){
        $select_delivery = DB::table('pickup_delivery')->where('id', $id)->first();
        $select_location = DB::table('locationservice_pickupdelivery')->where('pick_up_table_id', $id)->get();
        echo json_encode(array('info' => $select_delivery, 'locations' => $select_location));
    }

    public function update_pickUp(Request $request){
        
        $update_pickup_delivery = DB::table('pickup_delivery')->where('id', $request->delivery_id)->update([
            'city_name' => $request->city_name,
            'province' => $request->province,
            'city_short' => $request->city_short_code
            ]);
            try{

            $delete_services = DB::table('LocationService_pickUpDelivery')
            ->where('pick_up_table_id', $request->delivery_id)
            ->delete();

            $services =  explode(',', $request->location_service);
            foreach ($services as $service) {
                $insert_location_service = DB::table('LocationService_pickUpDelivery')
                    ->insert([
                    'location_service' => $service,
                    'pick_up_table_id' => $request->delivery_id
                    ]);
            }
            echo json_encode("success");
        } catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }

    }

    public function delete_pickUp_entry(Request $request){
        $delete_one_entry = DB::table('pickup_delivery')
            ->where('id', $request->id)
            ->delete();
        
        $delete_services = DB::table('locationservice_pickupdelivery')
        ->where('pick_up_table_id', $request->id)
        ->delete();

        if($delete_one_entry && $delete_services){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }

}
