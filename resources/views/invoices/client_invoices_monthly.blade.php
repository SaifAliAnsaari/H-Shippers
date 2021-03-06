@extends('layouts.master')
@section('data-sidebar')

<div class="row mb-30 HS_CO">

    <div class="col-md-3">

        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($top_data, "total_consignments")) }}</h3>
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
            <h3 class="cp-stats-value">{{ number_format(array_sum(array_column($top_data, "total_amount"))) }}</h3>
            <h5 class="text-muted">Total Amount</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Paid <span>Invoices</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Client Name</th>
                            <th>Total Invoices</th>
                            <th>Total Charges</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(!empty($data))
                            @foreach ($data as $invoices)
                                <tr>
                                    <td>{{ date('F', mktime(0, 0, 0, $invoices->month, 10)) }}</td>
                                    <td>{{ $invoices->client_name }}</td>
                                    <td>{{ $invoices->count }}</td>
                                    <td>{{ $invoices->total_revnue }}</td>
                                    <td>
                                        <a href="/client_invoice/{{$invoices->client_id}}/{{$invoices->month}}" class="btn btn-default">View Detail</a>
                                    </td>
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
