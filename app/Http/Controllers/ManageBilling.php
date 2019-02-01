<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageBilling extends Controller
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

    public function billing(){
        return view("manage_billing.billing");
    }
}
