<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use URL;

class Clients extends Controller
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
    public function clients(){
        return view("clients/clients");
    }

    //get clients
    public function ClientsList(){
        echo json_encode( DB::table('clients')->get());
    }

    //add client
    public function save_client(Request $request){
        //echo json_encode($request->client_name);
        
        // if(DB::table('clients')->select('id')->where("email", $request->email)->first()){
        //     echo json_encode('already exist');
        // }else{
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
                        'city' => $request->city,
                        'address' => $request->address,
                        'ntn' => $request->ntn,
                        'strn' => $request->strn,
                        'customer_type' => $request->customer_type,
                        'pick_up_city' => $request->pick_up_city,
                        'pick_up_province' => $request->pick_up_province,
                        'company_pic' => $compPic
                        ]);
                    if($insert_client_data){
                        if($request->hasFile('documents')){
                            foreach($request->file('documents') as $file) :
                                $completeFileName = $file->getClientOriginalName();
                                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                                $extension = $file->getClientOriginalExtension();
                                $randomized = rand();
                                $documents = str_replace(' ', '', $fileNameOnly).'-'.$randomized.''.time().'.'.$extension;
                                $path = $file->storeAs('public/documents', $documents);
                                $insert_doc = DB::table('client_documents')->insert([
                                    'client_document' => $documents,
                                    'client_id' => $insert_client_data
                                ]);
                            endforeach;
                            if($insert_doc){
                                echo json_encode("success");
                            }else{
                                echo json_encode("failed");
                            }
                        }else{
                            echo json_encode("success");
                        }
                    }else{
                        echo json_encode("failed");
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
                        'pick_up_province' => $request->pick_up_province
                        ]);
                    if($insert_client_data){
                        if($request->hasFile('documents')){
                            foreach($request->file('documents') as $file) :
                                $completeFileName = $file->getClientOriginalName();
                                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                                $extension = $file->getClientOriginalExtension();
                                $randomized = rand();
                                $documents = str_replace(' ', '', $fileNameOnly).'-'.$randomized.''.time().'.'.$extension;
                                $path = $file->storeAs('public/documents', $documents);
                                $insert_doc = DB::table('client_documents')->insert([
                                    'client_document' => $documents,
                                    'client_id' => $insert_client_data
                                ]);
                            endforeach;
                            if($insert_doc){
                                echo json_encode("success");
                            }else{
                                echo json_encode("failed");
                            }
                            
                        }else{
                            echo json_encode("success");
                        }
                    }else{
                        echo json_encode("failed");
                    }
                }
        //}
    }

    //Get client data
    public function get_client_data($id){
        $select_client_data = DB::table('clients')->where('id', $id)->first();
        $select_documents = DB::table('client_documents')->where('client_id', $id)->get();
        echo json_encode(array('info' => $select_client_data, 'documents' => $select_documents, 'base_url' => URL::to('/storage/clients').'/'));
    }

    //Update
    public function update_client(Request $request){
        
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
                // if($request->hasFile('documents')){
                //     foreach($request->file('documents') as $file) :
                //         $completeFileName = $file->getClientOriginalName();
                //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                //         $extension = $file->getClientOriginalExtension();
                //         $randomized = rand();
                //         $documents = str_replace(' ', '', $fileNameOnly).'-'.$randomized.''.time().'.'.$extension;
                //         $path = $file->storeAs('public/documents', $documents);
                //         $insert_doc = DB::table('client_documents')->insert([
                //             'client_document' => $documents,
                //             'client_id' => $insert_client_data
                //         ]);
                //     endforeach;
                //     if($insert_doc){
                //         echo json_encode("success");
                //     }else{
                //         echo json_encode("failed");
                //     }
                // }
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
                // if($request->hasFile('documents')){
                //     foreach($request->file('documents') as $file) :
                //         $completeFileName = $file->getClientOriginalName();
                //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                //         $extension = $file->getClientOriginalExtension();
                //         $randomized = rand();
                //         $documents = str_replace(' ', '', $fileNameOnly).'-'.$randomized.''.time().'.'.$extension;
                //         $path = $file->storeAs('public/documents', $documents);
                //         $insert_doc = DB::table('client_documents')->insert([
                //             'client_document' => $documents,
                //             'client_id' => $insert_client_data
                //         ]);
                //     endforeach;
                //     if($insert_doc){
                //         echo json_encode("success");
                //     }else{
                //         echo json_encode("failed");
                //     }
                // }
                echo json_encode("success");
            }else{
                echo json_encode("failed");
            }
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
}
