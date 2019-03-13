@extends('layouts.master')
@section('data-sidebar')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Shipment <span> Tracking</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Shipment</span></a></li>
            <li><span>Tracking</span></li>
        </ol>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card p-20 top_border mb-3">
                <img src="/images/loader.gif" width="30px" height="auto" id="loader" style="position: absolute; left: 50%; top: 50%; display:none;">
            <!--<h2 class="_head_trac border-0">Shipment Tracking Summary</h2>-->
            <div class="track-search">
                <div class="track-icon"><img src="/images/shipment-track.svg" alt="" /></div>
                <div class="row" id="error_layout" >
                    <div class="col-sm-6 col-5 ta-text error_heading" style="color:red; font-size:16px;"></div>
                    <div class="col-sm-6 col-7 error_text" style="color:red;"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-5 ta-text">CNNo:</div>
                    <div class="col-sm-6 col-7" id="shipment_cnno">{{ ($consignment != null ? $consignment->cnic : "----") }}</div>
                    <div class="col-sm-6 col-5 ta-text">Consignee:</div>
                    <div class="col-sm-6 col-7" id="shipment_consignee_name">{{ ($consignment != null ? $consignment->consignee_name : "----") }}</div>
                </div>
            </div>

            <input hidden type="text" id="check_cnno" value="{{ $data }}"/>
            <div class="col-md-12 track_detail" id="detail_div" style="display:none;">
                <div class="row">
                    <div class="col-md-7">
                        <div class="_tra-box">
                            <h2 class="_head03">Shipment Detail</h2>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>

                                    <tr>
                                        <td>Origin</td>
                                        <td id="shipment_origin">{{ (($consignment != null ? $consignment->city : "----")) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Destination</td>
                                        <td id="shipment_destination">{{ ($consignment != null ? $consignment->consignment_dest_city : "----") }}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking date</td>
                                        <td id="shipment_bookin_date">{{ ($consignment != null ? $consignment->booking_date : "----") }}</td>
                                    </tr>
                                    <tr>
                                        <td> Shipment booking Location</td>
                                        <td>PIA Socity, Wapda Town</td>
                                    </tr>
                                    <tr>
                                        <td>Shipper</td>
                                        <td id="shipment_shippername">{{ ($consignment != null ? ($consignment->company_name != null ? $consignment->company_name : $consignment->username) : "----") }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="_tra-box">
                            <h2 class="_head03">Shipment Tracking Summary</h2>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td>Current Status</td>
                                        <td id="shipment_consignment_status">{{ ($consignment != null ? ($consignment->status == 0 ? "Pending" : "Proceed") : "----") }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Date</td>
                                        <td>03-07-2019</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Received By</strong></td>
                                        <td><strong>Naeem Khan</strong></td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-md-12 _track_his">
                    <h2 class="_head03 mb-0 border-0">Tracking History</h2>
                    <table class="table table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Booked</td>
                                <td>Karachi</td>
                            </tr>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Arrived or Origin Branch</td>
                                <td>Lahore</td>
                            </tr>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Moved to DEST. Branch </td>
                                <td>Lahore</td>
                            </tr>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Booked</td>
                                <td>Karachi</td>
                            </tr>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Arrived or Origin Branch</td>
                                <td>Lahore</td>
                            </tr>
                            <tr>
                                <td>03-07-2019</td>
                                <td>Moved to DEST. Branch </td>
                                <td>Lahore</td>
                            </tr>


                        </tbody>
                    </table>

                </div>
            </div>    
            </div>
        </div>
    </div>
</div>

@endsection
