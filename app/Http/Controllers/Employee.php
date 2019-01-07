<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use URL;

class Employee extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetEmployeeInfo($id)
    {
        echo json_encode(array('employee' => User::find($id), 'base_url' => URL::to('/').'/'));
    }

    public function UpdateEmployee(Request $request, $id)
    {
        //$employee->department_id = $request->department; die;
        
        $employee = User::find($id);

        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->cnic = $request->cnic;
        $employee->city = $request->city;
        $employee->address = $request->address;
        $employee->base_station = $request->base_station;
        $employee->home_num = $request->home_phone;
        $employee->ice_num = $request->ice_num;
        $employee->username = $request->username;
        if($request->password){
            //$employee->password = Hash::make($request->name);
            $password = bcrypt($request->password);
            $employee->password = $password;
        }
        $employee->hiring = $request->hiring;
        $employee->salary = $request->salary;
        $employee->designation = $request->designation;
        $employee->reporting_to = $request->reporting;
        
        if($request->hasFile('employeePicture')){
            $completeFileName = $request->file('employeePicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('employeePicture')->getClientOriginalExtension();
            $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
            $path = $request->file('employeePicture')->storeAs('public/employees', $empPicture);
            if(Storage::exists('public/employees/'.str_replace('./storage/employees/', '', $employee->picture))){
                Storage::delete('public/employees/'.str_replace('./storage/employees/', '', $employee->picture));
            }
            $employee->picture = './storage/employees/'.$empPicture;
        }
        //$employee->save();
        if($employee->save()){
            echo json_encode('updated');
        }else{
            echo json_encode('failed');
        }
        
        //echo json_encode($employee->save());
    }

}
