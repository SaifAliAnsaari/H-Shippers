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
        parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('username', 'id', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
            if($check_session){
                return view('complaints_suggestions.complaints_suggestion', ["client_id" => $check_session->id, 'check_rights' => $this->check_employee_rights, 'name' => $check_session, ]);
            } 
        }else{
            return redirect('/');
        }  
    }

    public function complaints_list(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.complaints-list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function suggestions_list(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.suggestions-list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function complaints_list_client(){
        //
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        if(!Auth::user()){
            if(Cookie::get('client_session')){
                $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
                if($check_session){
                   return view('complaints_suggestions.complaints-list-clients', ['check_rights' => $this->check_employee_rights, 'name' => $check_session]);
                } 
            }else{
                return redirect('/');
            } 
        }else{
            parent::get_notif_data();
            return view('complaints_suggestions.complaints-list-clients', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
        } 
    }

    public function suggestions_list_client(){
        
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
         if(!Auth::user()){
            if(Cookie::get('client_session')){
                $check_session = DB::table('clients')->select('username', 'company_pic')->where('client_login_session', Cookie::get('client_session'))->first();
                if($check_session){
                    return view('complaints_suggestions.suggestions_list_client', ['check_rights' => $this->check_employee_rights, 'name' => $check_session]);
                } 
            }else{
                return redirect('/');
            } 
        }else{
            parent::get_notif_data();
            return view('complaints_suggestions.suggestions_list_client', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
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
            "client_id" => $request->client_id
        ]);
        if($insert_complaint){
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 102,
                'message' => 'New complain added',
                'complain_id' => $insert_complaint
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
            "client_id" => $request->client_id
        ]);
        if($insert_suggestion){
            $insert_notification = DB::table('notifications_list')->insert([
                'code' => 103,
                'message' => 'New suggestion added',
                'complain_id' => $insert_suggestion
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


}
