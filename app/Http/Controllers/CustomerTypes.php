<?php

namespace App\Http\Controllers;

use App\Customer as Cust;
use Illuminate\Http\Request;
use DB;
use URL;
use Illuminate\Support\Facades\Storage;

class CustomerTypes extends Controller
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
    public function index()
    {
        return view('customer.types');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required|max:200|unique:customer_types',
            'discount' => 'required|max:100|min:0|numeric'
        ]);

        $data = array('type_name' => $request->type_name, 'discount' => $request->discount);
        // echo json_encode(DB::table('customer_types')->insert($data));die;
        if(DB::table('customer_types')->insert($data)){
            echo json_encode('success');
        }else{
            echo json_encode('Unable to save customer type at the moment');
        }
    }

    public function customerTypesList()
    {
        echo json_encode(DB::table('customer_types')->get());
    }

    public function deleteCustomerType($id)
    {
        $status = DB::table('customer_types')->where('id', $id)->delete();
        echo $status ? json_encode('success') : json_encode('Unable to delete the customer type at this moment');
    }

    public function getCustomerTypeInfo($id){
        echo json_encode(DB::table('customer_types')->where('id', $id)->first());
    }

    public function update(Request $request, $id){
        echo DB::statement('UPDATE customer_types set `type_name` = "'.$request->type_name.'", `discount` = '.$request->discount.' where `id` = '.$id) ? json_encode('success') : json_encode('Unable to update customer type at this moment');
    }

}
