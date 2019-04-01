<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;
use Mail;
use App\Mail\SendMailable;

class ComplaintsAndSuggestions extends ParentController
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

    public function complaints_suggestions(){
        parent::get_client_nofif_data();
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('username', 'id', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if($check_session){
                return view('complaints_suggestions.complaints_suggestion', ["client_id" => $check_session->id, 'name' => $check_session, 'all_notif' => $this->all_notification, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
            } 
        }else{
            return redirect('/');
        }  
    }

    public function complaints_list(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.complaints-list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function suggestions_list(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.suggestions-list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function complaints_list_client(){
        //
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        if(!Auth::user()){
            if(Cookie::get('client_session')){
                parent::get_client_nofif_data();
                $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
                if($check_session){
                   return view('complaints_suggestions.complaints-list-clients', ['name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
                } 
            }else{
                return redirect('/');
            } 
        }else{
            parent::get_notif_data();
            return view('complaints_suggestions.complaints-list-clients', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        } 
    }

    public function suggestions_list_client(){
        
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
         if(!Auth::user()){
            if(Cookie::get('client_session')){
                parent::get_client_nofif_data();
                $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
                if($check_session){
                    return view('complaints_suggestions.suggestions_list_client', ['name' => $check_session, 'notifications_counts' => $this->notif_counts_client, 'notif_data' => $this->notif_data_client, 'all_notif' => $this->clients_all_notifications]);
                } 
            }else{
                return redirect('/');
            } 
        }else{
            parent::get_notif_data();
            return view('complaints_suggestions.suggestions_list_client', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        } 
        
    }

    public function saveComplaints(Request $request){
    
        $insert_complaint = DB::table('complaints_suggestions')->insertGetId([
            "operation" => "Complaint",
            "name" => $request->name_complaint,
            "cell" => $request->cell_complaint,
            "email" => $request->email_complaint,
            "subject" => $request->subject_complaint,
            "tracking_num" => $request->tracking_no_complaint,
            "description" => $request->description,
            "status" => "pending",
            "client_id" => $request->client_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($insert_complaint){
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 102,
                'message' => 'New complain added',
                'complain_id' => $insert_complaint,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // $get_email_addresses = DB::table('users')->select('email')->whereRaw('id IN (Select emp_id from subscribed_notifications WHERE email = 1 AND notification_code_id = 102)')->get();
               
            // if(!$get_email_addresses->isEmpty()){
            //     foreach($get_email_addresses as $email){
            //         $name = 'Krunal';
            //          Mail::to($email->email)->send(new SendMailable($name));
            //     }
            // }
            
            
            if($insert_notification){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            echo json_encode('failed');
        }
    }

    public function saveSuggestions(Request $request){
        $insert_suggestion = DB::table('complaints_suggestions')->insertGetId([
            "operation" => "Suggestion",
            "name" => $request->name_suggestions,
            "cell" => $request->cell_suggestions,
            "email" => $request->email_suggestions,
            "subject" => $request->subject_suggestions,
            "city" => $request->city_suggestions,
            "description" => $request->description,
            "status" => "pending",
            "client_id" => $request->client_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($insert_suggestion){
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 103,
                'message' => 'New suggestion added',
                'suggestion_id' => $insert_suggestion,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // $get_email_addresses = DB::table('users')->select('email')->whereRaw('id IN (Select emp_id from subscribed_notifications WHERE email = 1 AND notification_code_id = 103)')->get();
               
            // if(!$get_email_addresses->isEmpty()){
            //     foreach($get_email_addresses as $email){
            //         $name = 'Krunal';
            //          Mail::to($email->email)->send(new SendMailable($name));
            //     }
            // }
            
            if($insert_notification){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            echo json_encode('failed');
        }
    }

    public function GetCompliantsListClient(){
        if(Auth::check()){
            echo json_encode(['status' => 'admin', 'data' => DB::table('complaints_suggestions')->whereRaw('operation = "Complaint"')->get()]); 
        }else{
            echo json_encode(['status' => 'client', 'data' => DB::table('complaints_suggestions')->whereRaw('operation = "Complaint" AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get()]); 
        }
    }

    public function GetSuggestionsListClient(){
        if(Auth::check()){
            echo json_encode(['status' => 'admin', 'data' => DB::table('complaints_suggestions')->whereRaw('operation = "Suggestion"')->get()]); 
        }else{
            echo json_encode(['status' => 'client', 'data' => DB::table('complaints_suggestions')->whereRaw('operation = "Suggestion" AND client_id = (Select id from clients where client_login_session = "'.Cookie::get('client_session').'")')->get()]); 
        }
    }


    //Delete
    public function delete_complainOrSuggestion(Request $request){
        $delete = DB::table('complaints_suggestions')->where('id', $request->id)->delete();
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }

}
