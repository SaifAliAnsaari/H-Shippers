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

    //Billing Not Added
    public function select_customer(){
        parent::get_notif_data();
          parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('manage_billing.customers_list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function GetCustomersListForBilling(){
        echo json_encode(DB::table('clients')->whereRaw('billing_added = 0 AND is_active = 1')->get());
    }


    //Billing added clients list
    public function select_customer_BA(){
        parent::get_notif_data();
        parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('manage_billing.customers_list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function GetCustomersListOfAddedBilling(){
        echo json_encode(DB::table('clients')->whereRaw('billing_added = 1 and is_active = 1')->get());
    }
}
