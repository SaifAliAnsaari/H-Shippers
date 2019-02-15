<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

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
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if($check_session){
                return view('complaints_suggestions.complaints_suggestion', ["client_id" => $check_session->id, 'check_rights' => $this->check_employee_rights]);
            } 
        }else{
            return redirect('/');
        }  
    }

    public function complaints_list(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.complaints-list', ['check_rights' => $this->check_employee_rights]);
    }

    public function suggestions_list(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.suggestions-list', ['check_rights' => $this->check_employee_rights]);
    }

    public function complaints_list_client(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.complaints-list-clients', ['check_rights' => $this->check_employee_rights]);
    }

    public function suggestions_list_client(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('complaints_suggestions.suggestions_list_client', ['check_rights' => $this->check_employee_rights]);
    }

    public function saveComplaints(Request $request){
       
        $insert_complaint = DB::table('complaints_suggestions')->insert([
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
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }

    public function saveSuggestions(Request $request){
        $insert_complaint = DB::table('complaints_suggestions')->insert([
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
        if($insert_complaint){
            echo json_encode('success');
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
