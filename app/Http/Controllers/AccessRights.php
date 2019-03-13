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
         parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('access_rights.save_controllers', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
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
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('access_rights.clients_list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function GetEmployeeListForRights(){
        echo json_encode(DB::table('users')->get());
    }

    //View
    public function access_rights($id){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        $controllers = DB::table('controllers')->selectRaw('id, route_name, show_up_name, Heading')->get();
        $check = DB::table('access_rights')->where('employee_id', $id)->get();
        //$controllers = json_decode(json_encode($controllers), True);
        //$uniqueHeadings = $this->unique_multidim_array($controllers, "Heading");
        // $data = array();
         $counter = 0;
        
        // $data = array_map(function($item) use($counter, $controllers){
        //     $data[$counter]["heading"] = $item["Heading"];
        //     $data[$counter]["data"] = array_filter($controllers, function($cont) use($item){
        //         return ($cont["Heading"] == $item["Heading"] ? $cont : null);
        //     });
        //     $counter++;
        //     return array_values($data);
        // }, $uniqueHeadings);


        $array_heading = array();
        foreach($controllers as $headings){
            $array_heading[$counter] = $headings->Heading;
            $counter++;
        }

        $array_heading = array_unique($array_heading);

        $data = array();
        $counter_two = 0;
        
        //echo '<pre>'; print_r($array_heading); die;
        foreach($array_heading as $arr_heading){
            $data[$counter_two]['heading'] = $arr_heading;
            $counter_three = 0;
            $array_routes = array();
            foreach($controllers as $routes){
                if($routes->Heading == $arr_heading){
                    $array_routes[$counter_three] = array('id' => $routes->id, 'name' => $routes->show_up_name, 'route' => $routes->route_name);
                    $counter_three++;
                }
            }
            $data[$counter_two]["detail"] = $array_routes;
            $counter_three = 0;
            $counter_two ++;
        }
        
        //echo '<pre>'; print_r($data); die;

        if(!$check->isEmpty()){
            return view('access_rights.access_rights', ['employee_id' => $id, 'controllers' => $data, "rights" => $check, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
        }else{
            return view('access_rights.access_rights', ['employee_id' => $id, 'controllers' => $data, "rights" => "", 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
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

    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 

}
