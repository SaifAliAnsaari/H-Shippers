<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AccessRights extends ParentController
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

    public function save_controllers(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('access_rights.save_controllers', ['check_rights' => $this->check_employee_rights]);
    }

    public function saveRoute(Request $request){
        $check = DB::table('controllers')->select('id')->where('route_name', $request->route_name)->first();
        if($check){
            echo json_encode('already_exist');
        }else{
            $insert = DB::table('controllers')->insert([
                "route_name" => $request->route_name,
                "show_up_name" => $request->show_up_name
                ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }


    public function select_employee(){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('access_rights.clients_list', ['check_rights' => $this->check_employee_rights]);
    }

    public function GetEmployeeListForRights(){
        echo json_encode(DB::table('users')->get());
    }

    public function access_rights($id){
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        $controllers = DB::table('controllers')->get();
        $check = DB::table('access_rights')->where('employee_id', $id)->get();

        if(!$check->isEmpty()){
            return view('access_rights.access_rights', ['employee_id' => $id, 'controllers' => $controllers, "rights" => $check, 'check_rights' => $this->check_employee_rights]);
        }else{
            return view('access_rights.access_rights', ['employee_id' => $id, 'controllers' => $controllers, "rights" => "", 'check_rights' => $this->check_employee_rights]);
        }
    }

    public function check_access_rights(Request $request){
        $check = DB::table('access_rights')->where('employee_id', $request->id)->get();
        if(!$check->isEmpty()){
            echo json_encode($check);
        }else{
            echo json_encode('no_user');
        }
    }

    public function saveAccessRights(Request $request){
        $check = DB::table('access_rights')->where('employee_id', $request->select_employee)->first();
        if($check){
            $delete_one_entry = DB::table('access_rights')->where('employee_id', $request->select_employee)->delete();
            if($delete_one_entry){
                foreach(explode(",", $request->access_route) as $routes){
                    $insert = DB::table('access_rights')->insert([
                        "employee_id" => $request->select_employee,
                        "access" => $routes
                    ]);
                }
                echo json_encode('success');
            }else{
                echo json_encode('failed'); 
            }
        }else{
            foreach(explode(",", $request->access_route) as $routes){
                $insert = DB::table('access_rights')->insert([
                    "employee_id" => $request->select_employee,
                    "access" => $routes
                ]);
            }
            echo json_encode('success');
        }
    }
}
