@extends('layouts.master')
@section('data-sidebar')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Shipment <span>List</span></h2>
            </div>
            <div class="body">

                <div class="row _client-info">

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3"><span class="_cname">Client: </span></div>
                            <div class="col-md-9"><span class="_cname">{{ $cust_data->company_name }}</span></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Address: </div>
                            <div class="col-md-9">{{ $cust_data->address }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">N.T.N</div>
                            <div class="col-md-9">{{ $cust_data->ntn }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">S.Tax No</div>
                            <div class="col-md-9">{{ $cust_data->strn }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Export To Excel</button>
                        <button type="submit" class="btn btn-primary">Export To PDF</button>
                    </div>

                </div>
                <div class="inv_cl-list">

                    <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">

                        <thead>
                            <tr>
                                <th>SN.</th>
                                <th>Booking Date</th>
                                <th>Origin</th>
                                <th>Tracking No</th>
                                <th>Dest</th>
                                <th>Services</th>
                                <th>Weight</th>
                                <th>Pieces</th>
                                <th>Rates</th>
                                <th>Fuel</th>
                                <th>Gst</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($shipments))
                                @foreach ($shipments as $data)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $data->booking_date }}</td>
                                        <td>{{ $data->origin_city }}</td>
                                        <td>NA</td>
                                        <td>{{ $data->consignment_dest_city }}</td>
                                        <td>{{ ($data->consignment_service_type == 1 ? "Same Day" : ($data->consignment_service_type == 2 ? "Over Night" : ($data->consignment_service_type == 3 ? "Second Day" : "Over Land"))) }}</td>
                                        <td>{{ $data->consignment_weight }}</td>
                                        <td>{{ $data->consignment_pieces }}</td>
                                        <td>{{ $data->sub_total }}</td>
                                        <td>{{ $data->fuel_charge }}</td>
                                        <td>{{ $data->gst_charge }}</td>
                                        <td>{{ $data->total_price }}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>



        </div>

    </div>


</div>


@endsection
