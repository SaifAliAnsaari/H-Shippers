<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ClientsForBilling extends ParentController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
        // if($this->redirectUrl){
        //     return redirect($this->redirectUrl);
        // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function select_customer(){
        parent::get_notif_data();
          parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('manage_billing.customers_list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function GetCustomersListForBilling(){
        echo json_encode(DB::table('clients')->get());
    }
}
