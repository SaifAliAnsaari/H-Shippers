<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

class ComplaintsAndSuggestions extends Controller
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
        if(Cookie::get('client_session')){
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if($check_session){
                return view('complaints_suggestions.complaints_suggestion', ["client_id" => $check_session->id]);
            } 
        }else{
            return redirect('/');
        }  
    }

    public function complaints_list(){
        return view('complaints_suggestions.complaints-list');
    }

    public function suggestions_list(){
        return view('complaints_suggestions.suggestions-list');
    }

    public function complaints_list_client(){
        return view('complaints_suggestions.complaints-list-clients');
    }

    public function suggestions_list_client(){
        return view('complaints_suggestions.suggestions_list_client');
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
