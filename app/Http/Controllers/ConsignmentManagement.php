<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsignmentManagement extends Controller
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

    public function consignment_booking(){
        return view('consignment_booking.consignment_booking');
    }

    public function consignment_booking_client(){
        return view('consignment_booking.consignment_booking_client');
    }

    public function consignment_booked(){
        return view('consignment_booking.consignment_booked');
    }
}
