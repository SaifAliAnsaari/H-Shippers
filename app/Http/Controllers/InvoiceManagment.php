<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use DB;
use Auth;

class InvoiceManagment extends ParentController
{
    protected $invalidSess = false;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Cookie::get('client_session')){
            $test = Cookie::get('client_session');
            $check_session = DB::table('clients')->select('id')->where('client_login_session', Cookie::get('client_session'))->first();
            if(!$check_session){
                return redirect('/client_login');
            }
        }else{
            $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     //View
    public function current_month_consignments(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $data = [ 'total_booked' => DB::table('consignment_client')->selectRaw('count(*) as total_booked')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_booked, 'total_delivered' => DB::table('consignment_client')->selectRaw('count(*) as total_delivered')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 2')->first()->total_delivered, 'in_transit' => DB::table('consignment_client')->selectRaw('count(*) as in_transit')->whereRaw('MONTH(booking_date) = '.date('m').' and status = 1')->first()->in_transit, 'total_amount' => DB::table('consignment_client')->selectRaw('SUM(total_price) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->first()->total_amount, 'consignments' => DB::table('consignment_client as cc')->selectRaw('customer_id, (SELECT company_name from clients where id = cc.customer_id) as client_name, (SELECT count(*) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_consignments, (SELECT SUM(total_price) from consignment_client where MONTH(booking_date) = '.date('m').' and customer_id = cc.customer_id) as total_amount')->whereRaw('MONTH(booking_date) = '.date('m'))->groupBy('customer_id')->get() ];
        //dd($data);
        return view('invoices.current_month_consignments', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $data]);
    }

    //Get Current Month Data 
    public function get_current_month_data_for_invoice(Request $request){
        $reports = DB::table('clients')->selectRaw('ntn, strn, username, company_name, poc_name, address, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 1) as price_same_day, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'" AND consignment_service_type = 4) as price_over_land, (Select SUM(fuel_charge) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'") as fuel_charges, (Select SUM(gst_charge) from consignment_client where MONTH(booking_date) = "'.date('m').'" and customer_id = "'.$request->id.'") as total_tax, (Select tax from billing where customer_id = "'.$request->id.'") as gst, (Select id from billing where customer_id = "'.$request->id.'") as account_id')->where('id', $request->id)->first();
        echo json_encode($reports);
    }

    //Shipment List of Current Month Against Customer
    public function shipment_list($id){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $data = DB::table('consignment_client')->whereRaw('customer_id = "'.$id.'" AND MONTH(booking_date) = '.date('m'))->get();
        $client_data = DB::table('clients')->where('id', $id)->first();
        //echo "<pre>"; print_r($data); die;

        return view('invoices.shipment_list', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'shipments' => $data, 'cust_data' => $client_data]);
    }




    public function invoices_generate(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $top_data = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where status = 2 AND customer_id NOT IN (Select client_id from invoices_generated) AND Month(booking_date) NOT IN (Select month from invoices_generated)) as total_delivered, (Select Count(*) from consignment_client where status = 1 AND customer_id NOT IN (Select client_id from invoices_generated) AND Month(booking_date) NOT IN (Select month from invoices_generated)) as total_transit')->first();

        $totalCustomers = json_decode(json_encode(DB::table('clients')->get()), true);

        $totalConsignments = json_decode(DB::table('consignment_client as cc')->selectRaw('id, MONTHNAME(booking_date) as month, MONTH(booking_date) as month_id, customer_id, booking_date, (SELECT company_name from clients where id = cc.customer_id) as name, (SELECT count(*) from consignment_client where customer_id = cc.customer_id and booking_date = cc.booking_date ) as total_consignments_on_date,total_price, (Select Count(*) from consignment_client where status = 2) as total_delivered')->get(), true);
        $alreadyGentdInvoices = json_decode(DB::table('invoices_generated')->get(), true);

        // dd(array_column($this->unique_multidim_array($totalConsignments, "booking_date"), "booking_date"));
        $totalDates = array_column($this->unique_multidim_array($totalConsignments, "booking_date"), "booking_date");
        $totalMonths = array_map(function($date){
            return date('m', strtotime($date));
        }, $totalDates);
        
        $totalUniqueMonths = array_unique($totalMonths);

        $data = [];
        $monthNames = [ "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
        $counter = 0;
        $consignmentsData = [];
        foreach ($totalUniqueMonths as $month) {
            $uniqueCust = array_unique(array_column(array_filter($totalConsignments, function($item) use($month){
                return date('m', strtotime($item["booking_date"])) == $month;
            }), "customer_id"));
            foreach ($uniqueCust as $cust) {
                $consignmentsData[] = ["customer_id" => $cust, 'customer_name' => $totalCustomers[array_search($cust, array_column($totalCustomers, "id"))]["company_name"], "month" => $month, "month_name" => $monthNames[ltrim($month, '0')], "total_price" => array_sum(array_column(array_filter($totalConsignments, function($item) use($month, $cust){
                    return date('m', strtotime($item["booking_date"])) == $month && $item["customer_id"] == $cust;
                }), "total_price")), 'total_consignments' => sizeof(array_filter($totalConsignments, function($item) use($month, $cust){
                    return date('m', strtotime($item["booking_date"])) == $month && $item["customer_id"] == $cust;
                }))];
            }
            $counter++;
        }

        $consignmentsDataNew = array_map(function($item) use(&$alreadyGentdInvoices){
            if(!DB::select('SELECT invoice_num from invoices_generated where month = '.$item["month"].' and client_id = '.$item["customer_id"])){
                return $item;
            }
            // $clientFoundInd = array_search($item["customer_id"], array_column($alreadyGentdInvoices, "client_id"));
            // if($clientFoundInd !== false && $clientFoundInd >= 0){
            //     $monthFound = ($alreadyGentdInvoices[$clientFoundInd]["month"] == $item["month"] ? true : false);
            //     if(!$monthFound){   
            //         return $item;
            //     }else{
            //         unset($alreadyGentdInvoices[$clientFoundInd]);
            //         $alreadyGentdInvoices = array_values($alreadyGentdInvoices);
            //     }
            // }else{
            //     return $item;
            // }
        }, $consignmentsData);
        //Junaid na call pa khatam kraya hai
        // $consignmentsDataNew = array_map(function($item) use(&$alreadyGentdInvoices){
        //     $clientFoundInd = array_search($item["customer_id"], array_column($alreadyGentdInvoices, "client_id"));
        //     if($clientFoundInd !== false && $clientFoundInd >= 0){
        //         $monthFound = ($alreadyGentdInvoices[$clientFoundInd]["month"] == $item["month"] ? true : false);
        //         if(!$monthFound){
        //             return $item;
        //         }else{
        //             unset($alreadyGentdInvoices[$clientFoundInd]);
        //             $alreadyGentdInvoices = array_values($alreadyGentdInvoices);
        //         }
        //     }else{
        //         return $item;
        //     }
        // }, $consignmentsData);

        // return $consignmentsDataNew;

        // $looped = [];
        // foreach($data as $item):
        //     foreach ($item as $innerItem):
        //         $invGentdMonth = array_search($innerItem["month_id"], array_column($alreadyGentdInvoices, 'month'));
        //         if($invGentdMonth !== false && $invGentdMonth >= 0){
        //             $invGentdClient = array_search($innerItem["customer_id"], array_column($alreadyGentdInvoices, 'client_id'));
        //             if($invGentdClient !== false && $invGentdClient >= 0){
        //                 continue;
        //             }
        //         }

        //         $monthFound = array_search($innerItem["month"], array_column($looped, 'month'));
        //         if($monthFound !== false && $monthFound >= 0){
        //             $custFound = array_search($innerItem["customer_id"], array_column($looped, 'customer_id'));
        //             if($custFound !== false && $custFound >= 0){
        //                 $test = 123;
        //             }else{
        //                 $looped[] = ['month' => $innerItem['month'], 'month_id' => $innerItem['month_id'], 'customer_id' => $innerItem['customer_id'], 'name' => $innerItem['name'], 'consignments' => $innerItem["total_consignments_on_date"], 'charges' => $innerItem["total_charges_on_date"]];
        //             }
        //         }else{
        //             $looped[] = ['month' => $innerItem['month'], 'month_id' => $innerItem['month_id'], 'customer_id' => $innerItem['customer_id'], 'name' => $innerItem['name'], 'consignments' => $innerItem["total_consignments_on_date"], 'charges' => $innerItem["total_charges_on_date"]];
        //         }
        //     endforeach;
        // endforeach;

        //dd($looped);
        return view('invoices.invoices_generate', ['data' => $consignmentsDataNew, 'top_data' => $top_data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    public function invoices_generate_detail($client_id, $month){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $top_data = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where status = 1 AND MONTH(booking_date) = '.$month.' and customer_id = "'.$client_id.'") as total_transit, (Select Count(*) from consignment_client where status = 2 AND MONTH(booking_date) = '.$month.' and customer_id = "'.$client_id.'") as total_delivered')->first();

        $data = DB::table('consignment_client as cc')->selectRaw('id, cnic, booking_date, consignee_name, (SELECT company_name from clients where id = cc.customer_id) as sender, consignment_weight, consignment_pieces, total_price, status')->whereRaw('MONTH(booking_date) = '.$month.' and customer_id = '.$client_id)->get();

        return view('invoices.invoice_generate_detail', ['top_data' => $top_data, 'data' => $data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }

    // public function GenerateInvoice(Request $req){
    //     $data = json_decode($req->postData);
    //     $status = DB::table('invoices_generated')->insert([ 'client_id' => $data->customer_id, 'month' => $data->month, 'invoice_num' => $this->generateRandomNumber(), 'created_at' => date('Y-m-d H:i:s') ]);
    //     if($status){
    //         echo "true";
    //         die;
    //     }
    //     echo $status;
    // }
    public function GenerateInvoice(Request $req){
        $data = json_decode($req->postData);
        $status = DB::table('invoices_generated')->insert([ 'client_id' => $data->customer_id, 'month' => $data->month, 'invoice_num' => $this->generateRandomNumber(), 'invoice_total' => CEIL(DB::table('consignment_client as cc')->selectRaw('SUM(total_price) as tp')->whereRaw('customer_id = '.$data->customer_id.' and MONTH(booking_date) = '.$data->month)->first()->tp), 'created_at' => date('Y-m-d H:i:s') ]);
        if($status){
            echo "true";
            die;
        }
        echo $status;
    }

    // public function received_payments(){
    //     parent::VerifyRights();
    //     if($this->redirectUrl){return redirect($this->redirectUrl);}
    //     parent::get_notif_data();

    //     $invoices_data = DB::table('invoices_generated')->where('paid', 0)->get();
    //     $top_data = [];
    //     $counter = 0;
    //     foreach($invoices_data as $data){
    //         $top_data[$counter] = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_consignments, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 1) as totaltransit, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 2) as total_complete, (Select SUM(total_price) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_amount')->first();
    //         $counter ++;
    //     }

    //     //echo "<pre>"; print_r($top_data); die;

    //     $totalMonths = DB::table('consignment_client')->selectRaw('MONTH(booking_date) as month')->groupBy('booking_date')->get();
    //     $totalMonths = json_decode(json_encode($totalMonths), true);
    //     $uniqMonths = array_unique(array_column($totalMonths, "month"));

    //     $data = [];
    //     $counter = 0;
    //     foreach ($uniqMonths as $key => $value) {
    //         $data[$counter]["month"] = $value; 
    //         $data[$counter]["month_name"] = date("F", mktime(null, null, null, $value, 1));
    //         $data[$counter]["consignments"] = DB::table('consignment_client as cc')->selectRaw('customer_id, ROUND(SUM(total_price), 2) as total, count(*) as consignments, (SELECT company_name from clients where id = cc.customer_id) as name, (SELECT invoice_num from invoices_generated where client_id = cc.customer_id and month = '.$value.') as invoice_num, (SELECT SUM(amount) from payment where invoice_num = (SELECT invoice_num from invoices_generated where client_id = cc.customer_id and month = '.$value.')) as amount_received, (SELECT ROUND(SUM(total_price)) from consignment_client where customer_id = cc.customer_id and MONTH(booking_date) = '.$value.' ) as total_price')->whereRaw('MONTH(booking_date) = '.$value)->groupBy('customer_id')->get();
    //         $counter++; 
    //     }

    //     //dd($data);

    //     return view('invoices.recieved_payments', ['data' => $data, 'top_data' => $top_data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    // }
    public function received_payments(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $invoices_data = DB::table('invoices_generated')->where('paid', 0)->get();
        $top_data = [];
        $counter = 0;
        foreach($invoices_data as $data){
            $top_data[$counter] = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_consignments, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 1) as totaltransit, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 2) as total_complete, (Select SUM(total_price) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_amount')->first();
            $counter ++;
        }

        //echo "<pre>"; print_r($top_data); die;

        $totalMonths = DB::table('consignment_client')->selectRaw('MONTH(booking_date) as month')->groupBy('booking_date')->get();
        $totalMonths = json_decode(json_encode($totalMonths), true);
        $uniqMonths = array_unique(array_column($totalMonths, "month"));

        $data = [];
        $counter = 0;
        foreach ($uniqMonths as $key => $value) {
            $data[$counter]["month"] = $value; 
            $data[$counter]["month_name"] = date("F", mktime(null, null, null, $value, 1));
            $data[$counter]["consignments"] = DB::table('consignment_client as cc')->selectRaw('customer_id, ROUND(SUM(total_price), 2) as total, count(*) as consignments, (SELECT company_name from clients where id = cc.customer_id) as name, (SELECT invoice_num from invoices_generated where client_id = cc.customer_id and month = '.$value.') as invoice_num, (SELECT SUM(amount) from payment where invoice_num = (SELECT invoice_num from invoices_generated where client_id = cc.customer_id and month = '.$value.')) as amount_received, (SELECT ROUND(SUM(total_price)) from consignment_client where customer_id = cc.customer_id and MONTH(booking_date) = '.$value.' ) as total_price, (SELECT invoice_total from invoices_generated where client_id = cc.customer_id and month = '.$value.') as invoice_total_price')->whereRaw('MONTH(booking_date) = '.$value)->groupBy('customer_id')->get();
            $counter++; 
        }

        // dd($data);

        return view('invoices.recieved_payments', ['data' => $data, 'top_data' => $top_data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification]);
    }


    public function paid_invoices(){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $invoices_data = DB::table('invoices_generated')->where('paid', 1)->get();
        $top_data = [];
        $counter = 0;
        foreach($invoices_data as $data){
            $top_data[$counter] = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_consignments, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 1) as totaltransit, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 2) as total_complete, (Select SUM(total_price) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_amount')->first();
            $counter ++;
        }


        $totalConsignments = json_decode(json_encode(DB::select('SELECT id, ROUND(total_price) as total_price, customer_id, booking_date, MONTH(booking_date) as month_id from consignment_client')), true);
        $totalPaidInv = json_decode(json_encode(DB::select('SELECT invoice_num, month, client_id, (SELECT company_name from clients where id = ig.client_id) as client_name from invoices_generated as ig where paid = 1')), true);

        $data = [];
        $counter = 0;
        foreach ($totalPaidInv as $inv) {
            $data[$counter]["client"] = $inv["client_id"];
            $data[$counter]["client_name"] = $inv["client_name"];
            $data[$counter]["invoice_num"] = $inv["invoice_num"];
            $data[$counter]["month"] = $inv["month"];
            $data[$counter]["revenue"] = array_sum(array_column(array_filter($totalConsignments, function($con) use($inv){
                return $con["customer_id"] == $inv["client_id"] && $inv["month"] == $con["month_id"];
            }), "total_price"));
            $counter++;
        }

        $newData = [];
        $counter = 0;
        $uniqClients = array_column($this->unique_multidim_array($data, "client"), "client");
        foreach ($uniqClients as $client) {
            $totalOfThisClient = array_values(array_filter($data, function($item) use($client){
                return $item["client"] == $client;
            }));
            $newData[$counter]["client"] = $client;
            $indF = array_search($client, array_column($totalOfThisClient, "client"));
            $newData[$counter]["client_name"] = array_values(array_filter($data, function($item) use($client){
                return $item["client"] == $client;
            }))[$indF]["client_name"];
            $newData[$counter]["revenue"] = array_sum(array_column($totalOfThisClient, "revenue"));
            $newData[$counter]["total_invoices"] = sizeof($totalOfThisClient);
            $counter++;
        }

        return view('invoices.paid_invoices', ['top_data' => $top_data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $newData]);
    }


    //Monthly Client Invoice
    public function MCI($id){
        parent::VerifyRights();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        parent::get_notif_data();

        $invoices_data = DB::table('invoices_generated')->where('paid', 1)->get();
        $top_data = [];
        $counter = 0;
        foreach($invoices_data as $data){
            $top_data[$counter] = DB::table('consignment_client')->selectRaw('(Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_consignments, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 1) as totaltransit, (Select Count(*) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'" AND status = 2) as total_complete, (Select SUM(total_price) from consignment_client where Month(booking_date) = "'.$data->month.'" AND customer_id = "'.$data->client_id.'") as total_amount')->first();
            $counter ++;
        }
        
        $total_invoices = DB::table('invoices_generated as ig')->selectRaw('month, invoice_num, client_id, (Select company_name from clients where id = "'.$id.'") as client_name, (Select Count(*) from consignment_client where customer_id = "'.$id.'" AND Month(booking_date) = ig.month) as count, (Select SUM(total_price) from consignment_client where customer_id = "'.$id.'" AND Month(booking_date) = ig.month) as total_revnue')->whereRaw('client_id = "'.$id.'" AND paid = 1')->get();
       // echo "<pre>"; print_r($total_invoices);

        return view('invoices.client_invoices_monthly', ['top_data' => $top_data, 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data, 'all_notif' => $this->all_notification, 'data' => $total_invoices]);
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

    function generateRandomNumber($length = 8) {
        $number = '1234567890';
        $numberLength = strlen($number);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $number[rand(0, $numberLength - 1)];
        }
        return $randomNumber;
    }
}
