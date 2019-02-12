<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ClientsForBilling extends Controller
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

    public function select_customer(){
        return view('manage_billing.customers_list');
    }

    public function GetCustomersListForBilling(){
        echo json_encode(DB::table('clients')->where('billing_added', '0')->get());
    }
}
