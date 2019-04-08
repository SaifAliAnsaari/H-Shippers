@extends('layouts.master')
@section('data-sidebar')

<div class="row mb-30 HS_CO">

    <div class="col-md-3">

        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ array_sum(array_column($data, "total_consignments")) }}</h3>
            <h5 class="text-muted">Total Booked Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">
        <div class="card cp-stats  lb_border">
            <div class="cp-stats-icon"><img src="images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $top_data->total_delivered }}</h3>
            <h5 class="text-muted">Total Delivered Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats yr_border">
            <div class="cp-stats-icon"><img src="images/_t-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $top_data->total_transit }}</h3>
            <h5 class="text-muted">In-Transit Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="images/_am-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ CEIL(array_sum(array_column($data, "total_price"))) }}</h3>
            <h5 class="text-muted">Total Amount</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Generate <span> Invoices</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Client Name</th>
                            <th>Consignments</th>
                            <th>Total Charges</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        @if($item)
                        <tr>
                            <td>{{ $item["month_name"] }}</td>
                            <td>{{ $item["customer_name"] }}</td>
                            <td>{{ $item["total_consignments"] }}</td>
                            <td>{{ CEIL($item["total_price"]) }}</td>
                            <td>
                                <input type="text" id="invStat" value=" {{ json_encode( ['customer_id' => $item['customer_id'], 'month' => $item['month'] ] ) }} " hidden>
                            <a href="/invoices_generate_detail/{{ $item['customer_id'] }}/{{ $item['month'] }}" class="btn btn-default">View Detail</a>
                                <a style="cursor: pointer; color: white !important" class="btn btn-default generateInvBtn">Generate Invoice</a>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>

            </div>



        </div>

    </div>


</div>

@endsection
