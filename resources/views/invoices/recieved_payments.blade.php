@extends('layouts.master')
@section('data-sidebar')

<div class="row mb-30 HS_CO">

    <div class="col-md-3">

        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($top_data, "total_consignments")) }} </h3>
            <h5 class="text-muted">Total Booked Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">
        <div class="card cp-stats  lb_border">
            <div class="cp-stats-icon"><img src="images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($top_data, "total_complete")) }}</h3>
            <h5 class="text-muted">Total Delivered Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats yr_border">
            <div class="cp-stats-icon"><img src="images/_t-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($top_data, "totaltransit")) }}</h3>
            <h5 class="text-muted">In-Transit Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="images/_am-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($top_data, "total_amount")) }}</h3>
            <h5 class="text-muted">Total Amount</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Payment <span> Receive List </span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Client Name</th>
                            <th>Invoice No</th>
                            <th>Consignments</th>
                            <th>Total Amount Due</th>
                            <th>Receive Amount</th>
                            <th>Remaining Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $outerItem)
                        @foreach($outerItem["consignments"] as $item)
                        @if($item->invoice_num)
                            @if(number_format($item->total-$item->amount_received) > 0)
                            <tr>
                                <td>{{ $outerItem["month_name"] }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->invoice_num }}</td>
                                <td>{{ $item->consignments }}</td>
                                <td>{{ $item->invoice_total_price }}</td>
                                <td>{{ $item->amount_received }} </td>
                                <td> {{ number_format($item->invoice_total_price - $item->amount_received) }} </td>
                                <td>
                                    <a href='/client_invoice/{{$item->customer_id}}/{{$outerItem["month"]}}' class="btn btn-default">Add Payment</a>
                                </td>
                            </tr>
                            @endif
                            @endif
                        @endforeach
                        @endforeach

                    </tbody>
                </table>

            </div>



        </div>

    </div>


</div>

@endsection
