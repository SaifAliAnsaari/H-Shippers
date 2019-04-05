@extends('layouts.master')
@section('data-sidebar')

{{-- Payment Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <span> Payment</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="floating-label" class="modal-body">
                <div class="col-md-12 PT-10">
                    <div class="form-s2">
                        <select class="form-control formselect" placeholder="Select Rider" id="select_payment_type">
                            <option value="0" disabled selected>Select Payment Type</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                </div>

                <hr class="mb-10">
                <div class="row m-0 cheque_div" style="display:none">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">Banks Name*</label>
                            <input type="text" class="form-control" id="bank_name" style="font-size: 13px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">Cheque No*</label>
                            <input type="text" class="form-control" id="cheque_num" style="font-size: 13px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="PT-10 font12">Cheque Date*</label>
                        <div class="form-group" style="height: auto">
                            <input type="text" id="datepicker" class="form-control" placeholder=""
                                style="font-size: 13px">
                        </div>
                    </div>
                    <hr class="m-0 mt-10">
                </div>
                

                <div class="col-md-12 PT-20 cash_div" style="display:none">
                    <div class="form-group">
                        <label class="control-label mb-10">Add Payment*</label>
                        <input type="number" class="form-control" id="cash_amount" style="font-size: 13px">
                    </div>
                </div>


            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary add_payment">Add</button>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>



<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Invoice <span> Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Invoice</span></a></li>
            <li><span>Payment</span></li>
        </ol>
    </div>
</div>

<div class="row">
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
                            <p class="mb-0">{{ $report->company_name }}</p>
                            <p class="mb-0">{{ $report->address }}</p>
                            <p class="mb-0">NTN # {{ $report->ntn }}</p>
                            <p class="mb-0">STRN # {{ $report->strn }}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="inv-title">
                                <h3>e-Invoice</h3>
                                <span class="inv-pr">Account # </span> {{ $report->account_id }}<br>
                                <span class="inv-pr">Invoice # </span> <span style="font-weight:normal; margin-left:0px; !important" id="client_invoice_num">{{ $report->invoice_num }}</span><br>
                                <span class="inv-pr">Invoice Date </span> {{ $report->invoice_month }}<br>
                                <span class="inv-pr">Time Period </span>{{ date('Y-m-01')." - ".$report->consignmnet_date }}<br>
                            </div>
                        </div>
                    </div>

                    <?php $counter = 1; ?>
                    <div class="table-responsive inv-con-list">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>SERVICE</th>
                                    <th>QUANTITY</th>
                                    <th>WEIGHT</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th class="bg-transparent border-0" colspan="3"></th>
                                    <th>GRAND TOTAL RS.</th>
                                    <th>{{ ($report->price_over_night + $report->price_same_day + $report->price_second_day + $report->price_over_land) }}</th>
                                </tr>
                            </tfoot>


                            <tbody>
                                @if($report->counts_over_night)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>Over Night Delivery</td>
                                    <td>{{ $report->counts_over_night }}</td>
                                    <td>{{ $report->weight_over_night }}</td>
                                    <td>RS.{{  ($report->sub_price_over_nigth) }}</td>
                                </tr>
                                @endif
                                @if($report->counts_same_day)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>Same Day Delivery</td>
                                    <td>{{ $report->counts_same_day }}</td>
                                    <td>{{ $report->weight_same_day }}</td>
                                    <td>RS.{{  ($report->sub_price_same_day) }}</td>
                                </tr>
                                @endif
                                
                                @if($report->counts_second_day)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>Second Day Delivery</td>
                                    <td>{{ $report->counts_second_day }}</td>
                                    <td>{{ $report->weight_second_day }}</td>
                                    <td>RS.{{  ($report->sub_price_second_day) }}</td>
                                </tr>
                                @endif
                                @if($report->counts_over_land != '')
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>Over Land Delivery</td>
                                    <td>{{ $report->counts_over_land }}</td>
                                    <td>{{ $report->weight_over_land }}</td>
                                    <td>RS.{{  ($report->sub_price_over_land) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" rowspan="2" style="border: 0px !important"></td>
                                    <td>Fuel Charges</td>
                                    <td>RS.{{  ($report->fuel_charges) }} </td>
                                </tr>
                                <tr>
                                    <td>GST ({{ $report->gst }}%)</td>
                                    <td>Rs.{{  ($report->total_tax) }} </td>
                                </tr>
                            </tbody>

                        </table>

                        <img src="/images/signature.jpg" alt="" />
                    </div>

                    <div class="inv-footer">
                        <p><strong>H Shippers</strong></p>
                        <p>CL-1/1 Saifee House Dr Zia Ud Din Ahmed Road, Opposite Shaheen Complex, Karachi</p>
                        <p>021-32212217 | 0300-2070848 | NTN# 8924782-4 | GST# 1200980575537 </p>
                        <p> www.hshippers.com</p>
                    </div>

                </div>

            </div>
        </div>

    </div>


    <div class="col-md-4 _ord-rightside">
        <h2 class="">Payment</h2>
        <div class="_sidBar">
            <?php 
            $total_pend_am = number_format(($report->price_over_night + $report->price_same_day + $report->price_second_day + $report->price_over_land) - $report->paid_amount);  
//echo $total_pend_am;
            ?>
            @if($total_pend_am <= 0)
                <div class="pay_detail">
                    <div class="row _totalAM">
                        <div class="col-6">Paid Amount</div>
                        <div class="col-6 text-right"><strong>Rs.<span>{{ Round ($report->price_over_night + $report->price_same_day + $report->price_second_day + $report->price_over_land, 2) }}</strong></div>
                    </div>
                </div>
            @endif()

            @if($total_pend_am > 0)
                <div class="pay_detail">
                    <div class="row _totalAM">
                        <div class="col-6">Invoice Amount</div>
                        <div class="col-6 text-right"><strong>Rs.<span>{{ Round ($report->price_over_night + $report->price_same_day + $report->price_second_day + $report->price_over_land, 2) }}</strong></div>
                    </div>
    
                    <div class="row">
                        <div class="col-6">Paid Amount</div>
                        <input hidden id="total_paid_amount" value="{{ ($report->paid_amount != '' || null ? $report->paid_amount : 0) }}"/>
                        <div class="col-6 text-right paid_amount_div">Rs.{{ ($report->paid_amount != '' || null ? $report->paid_amount : 0) }}</div>
                    </div>
                    <hr>
                    <div class="row red_t">
                        <div class="col-6">Pending Amount</div>
                        <?php $pend_amount = ($report->price_over_night + $report->price_same_day + $report->price_second_day + $report->price_over_land) - $report->paid_amount ?>
                        <div class="col-6 text-right">Rs.<span id="pending_amount" name="{{ ROUND($pend_amount, 2) }}">{{ ROUND($pend_amount, 2) }}</span></div>
                    </div>
                    <a href="#" class="btn add-product-line" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-plus"> </i> Add Payment</a>
                </div>
            @endif
            

            <h2 class="">Payment History</h2>

            <div class="payment_details">
                {{-- <div class="row">
                        <div class="col-3"><strong>Date</strong></div>
                        <div class="col"><strong>Paid Amount</strong></div>
                        <div class="col text-right"><strong>Pending Amount</strong></div>
                    </div>
                    <hr> --}}
                    {{-- <div class="row">
                        <div class="col-3">02-27-2019</div>
                        <div class="col">Rs.25,000 <span class="float-right green_t">Cash</span></div>
                        <div class="col text-right">Rs.5,405</div>
                    </div>
                    <hr> --}}
            </div>
            
        </div>

    </div>

</div>

@endsection
