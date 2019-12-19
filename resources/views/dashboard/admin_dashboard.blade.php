@extends('layouts.master')
@section('data-sidebar')


<div class="row mt-2 mb-3">
    <div class="col-lg-8 col-md-8 col-sm-12">
        <h2 class="_head01">Dashboard <span></span></h2>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="_dash-select">
            <select class="custom-select custom-select-sm select_report_time_period">
                <option selected disabled>Please Select Month</option>
            <option value="1">Current Month</option>
            <option value="2">Last Month</option>
            <option value="3" selected>Overall</option>
            </select>
        </div>
    </div>
</div>


<div class="row">


    <div class="col-lg-5 col-12">
        <div class="row">

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/totalreveneue.svg" alt="" /></div>
                    <h5 class="text-muted">Total Reveneue</h5>
                    <h3 class="cp-stats-value total_rev_dashboard" >Rs.{{ number_format(ROUND($data->total_revenue, 2)) }}</h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/totalbookings.svg" alt="" /></div>
                    <h5 class="text-muted">Total Bookings</h5>
                    <h3 class="cp-stats-value total_bookings_dashboard">{{ number_format(Round($data->total_bookings, 2)) }}</h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/active-cust.svg" alt="" /></div>
                    <h5 class="text-muted">Active Customers</h5>
                    <h3 class="cp-stats-value active_cust_dashboard">{{ number_format(Round($data->active_custs, 2)) }}</h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-rv-cust.svg" alt="" /></div>
                    <h5 class="text-muted">AVG. REV. / Cust</h5>
                    <h3 class="cp-stats-value avg_rev_cust_dashboard">Rs.{{ number_format(Round($data->total_revenue/$data->active_custs, 2)) }}
                    </h3>
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-7 col-12 mb-30">

        <div class="card _grap-bar pt-0">
            <div class="mt-3 chartjs-chart">
                <div id="e_chart_1" class="e_chart"></div>
            </div>
        </div>

    </div>

</div>

<div class="card _grayB">

    <div class="row m-0">
        <div class="col-md-4 _amState">
            <p>Total Outstanding Payment</p>
            <h3> <small class="fa fa-circle align-middle text-warning"></small>
                <span class="outstanding_dashboard"> Rs.{{number_format($life_time_rev->life_time_revenus) }}</span> </h3>
        </div>

        <div class="col-md-4 _amState BLight _borL B_border">
            <p>Amount Received </p>
            <h3><small class="fa fa-circle align-middle text-success"></small>
                <span class="amount_rec_dashboard"> Rs.{{ number_format(Round($data->amount_recieved, 2)) }}</span></h3>
        </div>

        <div class="col-md-4 _amState _borL">
            <p>Remaining Amount</p>
            <h3><small class="fa fa-circle align-middle text-danger"></small>
                <span class="remaining_amount_dashboard"> Rs.{{ number_format(Round($life_time_rev->life_time_revenus -  $data->amount_recieved, 2)) }}</span></h3>
        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-9 mb-30">
        <div class="card _grap-bar">
            <canvas id="line-chart-example" class="line-chart"></canvas>
        </div>
    </div>

    <div class="col-md-3 mb-30">
        <div class="row _RVperDay">

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-revenue.svg" alt="" /></div>
                    <h3 class="cp-stats-value avg_rev_day_dashboard">
                        Rs.{{ number_format($life_time_rev->life_time_revenus/$totalDays) }}
                    </h3>
                    <h5 class="text-muted">AVG Revenue Per Day</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-revenue-shipment.svg" alt="" /></div>
                    <h3 class="cp-stats-value avg_rev_shipment_dashboard"><?php
                    $avg_rev_shipment = $life_time_rev->life_time_revenus / $life_time_data->life_time_consignments;
                    echo "Rs.".number_format(Round($avg_rev_shipment, 2));
                    ?></h3>
                    <h5 class="text-muted">AVG Revenue Per Shipment</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-shipment-day.svg" alt="" /></div>
                    <h3 class="cp-stats-value avg_shipment_day_dashboard"> {{ number_format($life_time_data->life_time_consignments/$totalDays) }} </h3>
                    <h5 class="text-muted">AVG Shipments Per Day</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/weight-shipment.svg" alt="" /></div>
                    <h3 class="cp-stats-value avg_weight_shipment_dashboard"><?php
                        $avg_weight_shipment = $life_time_data->total_weight / $life_time_data->life_time_consignments;
                        echo number_format(Round($avg_weight_shipment, 2))."KG(s)";
                        ?></h3>
                    <h5 class="text-muted">AVG Weight Per Shipment</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats border-0">
                    <div class="cp-stats-icon"><img src="/images/avg-delivery-time.svg" alt="" /></div>
                    <h3 class="cp-stats-value avg_delivery_time_dashboard">NA</h3>
                    <h5 class="text-muted">AVG Delivery Time</h5>
                </div>
            </div>


        </div>
    </div>

</div>


<div class="row">

    <div class="col-md-4 mb-30">
        <div class="card p-20 top_border consignments_by_dest_dashboard">
            <h2 class="_head03 border-0">Consignments <span>By Destinations</span></h2>

            @if(!empty($consignments_by_destinations))
            @foreach ($consignments_by_destinations as $dest)
            <div class="_dash-prog ">
                <h5>{{ $dest->consignment_dest_city }}</h5>
                <div class="progress-w-percent">
                    <span class="progress-value">{{ Round(($dest->quantity / $dest->total_counts) * 100 , 0) }}% </span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                            style="width:{{ ($dest->quantity / $dest->total_counts) * 100 }}%;"
                            aria-valuenow="{{ ($dest->quantity / $dest->total_counts) * 100 }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif




        </div>
    </div>

    <div class="col-md-8 mb-30">
        <div class="card p-20 top_border">
            <h2 class="_head03 border-0 pb-0">Day <span>Wise Report</span></h2>

            <div class="table-responsive _dash-table day_wise_report_dashboard">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>SERVICE</th>
                            <th>QUANTITY</th>
                            <th>WEIGHT</th>
                            <th>RATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($consignments_by_days))
                        @foreach ($consignments_by_days as $data)
                        <tr>
                            <td> {{ $data->day }} </td>
                            <td> {{ number_format($data->quantity) }} </td>
                            <td> {{ number_format($data->weight) }} KG(s) </td>
                            <td> Rs.{{ number_format($data->rate) }} </td>
                        </tr>
                        @endforeach
                        @endif


                    </tbody>
                </table>

            </div>



        </div>
    </div>



</div>

@endsection
