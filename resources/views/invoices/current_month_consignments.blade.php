@extends('layouts.master')
@section('data-sidebar')

{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-md-8">
                            <div class="card top_border">
                                <div class="body">
                                    <div class="invoice-section p-0">

                                        <div class="row">
                                            <div class="col-md-6 font13">
                                                <div class="invlist_logo">
                                                    <img class="float-L" src="/images/h-shippers.svg" alt="">
                                                </div>
                                                <span class="co-name pt-0">Billed To</span>
                                                <p class="mb-0" id="billed_to_modal"></p>
                                                <p class="mb-0" id="address_modal">
                                                </p>
                                                <p class="mb-0" id="ntn_modal">NTN # </p>
                                                <p class="mb-0" id="strn_modal">STRN # </p>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="inv-title">
                                                    <h3>e-Invoice</h3>
                                                    <span class="inv-pr">Account # </span><span
                                                        id="account_id_modal"></span> <br>
                                                    <span class="inv-pr">Invoice # </span><span
                                                        id="invoice_num_modal">NA</span> <br>
                                                    <span class="inv-pr">Invoice Date
                                                    </span><span>{{ date('d/m/y') }}</span> <br>
                                                    <span class="inv-pr">Time Period </span><span>{{ date('1/m/y') }} –
                                                        {{ date('d/m/y') }}</span><br>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive inv-con-list">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SN.</th>
                                                        <th>SERVICE</th>
                                                        <th>QUANTITY</th>
                                                        <th>WEIGHT</th>
                                                        <th>RATE</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>

                                                <tfoot>
                                                    <tr>
                                                        <th class="bg-transparent border-0" colspan="4"></th>
                                                        <th>GRAND TOTAL RS.</th>
                                                        <th id="grand_total_modal"></th>
                                                    </tr>
                                                </tfoot>


                                                <tbody>
                                                    <tr>
                                                        <td id="serial_no1">1</td>
                                                        <td id="service_typeone_modal">Same Day</td>
                                                        <td id="quantity_one"></td>
                                                        <td id="weight_one"></td>
                                                        <td id="rate_one"></td>
                                                        <td id="total_one"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="serial_no2">2</td>
                                                        <td id="service_typetwo_modal">Over Night</td>
                                                        <td id="quantity_two"></td>
                                                        <td id="weight_two"></td>
                                                        <td id="rate_two"></td>
                                                        <td id="total_two"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="serial_no3">3</td>
                                                        <td id="service_typethree_modal">Second Day</td>
                                                        <td id="quantity_three"></td>
                                                        <td id="weight_three"></td>
                                                        <td id="rate_three"></td>
                                                        <td id="total_three"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="serial_no4">4</td>
                                                        <td id="service_typefour_modal">Over Land</td>
                                                        <td id="quantity_four"></td>
                                                        <td id="weight_four"></td>
                                                        <td id="rate_four"></td>
                                                        <td id="total_four"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" rowspan="2" class="bg-transparent border-0"></td>
                                                        <td rowspan="2" class="bg-transparent border-0"></td>
                                                        <td rowspan="2" class="border-0"></td>
                                                        <td>Fuel Charges</td>
                                                        <td id="fuel_modal"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="gst_heading"></td>
                                                        <td id="gst_modal"> </td>
                                                    </tr>
                                                </tbody>

                                            </table>

                                            <img src="/images/signature.jpg" alt="" />
                                        </div>

                                        <div class="inv-footer">
                                            <p><strong>H Shippers</strong></p>
                                            <p>CL-1/1 Saifee House Dr Zia Ud Din Ahmed Road, Opposite Shaheen Complex,
                                                Karachi</p>
                                            <p>021-32212217 | 0300-2070848 | NTN# 8924782-4 | GST# 1200980575537 </p>
                                            <p> www.hshippers.com</p>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12 p-0 PT-20">
                                <button type="submit" class="btn btn-primary float-right  mb-20">Save as PDF</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row mb-30 HS_CO">

    <div class="col-md-3">

        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="/images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $data["total_booked"] }}</h3>
            <h5 class="text-muted">Total Booked Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">
        <div class="card cp-stats  lb_border">
            <div class="cp-stats-icon"><img src="/images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $data["total_delivered"] }}</h3>
            <h5 class="text-muted">Total Delivered Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats yr_border">
            <div class="cp-stats-icon"><img src="/images/_t-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $data["in_transit"] }}</h3>
            <h5 class="text-muted">In-Transit Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="/images/_am-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ ($data["total_amount"] ? $data["total_amount"] : "0") }}</h3>
            <h5 class="text-muted">Total Amount</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Invoice <span>Current Month</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Total Shipments</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data["consignments"] as $item)
                        <tr>
                            <td>{{ $item->client_name }}</td>
                            <td>{{ $item->total_consignments }}</td>
                            <td>{{ number_format($item->total_amount) }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#exampleModal" id="{{ $item->customer_id }}"
                                    class="btn btn-default view_detail_current_month">View
                                    Invoice</a>
                                <a href="/shipment_list/{{ $item->customer_id }}" class="btn btn-default">View
                                    Shipment</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>



        </div>

    </div>


</div>

@endsection
