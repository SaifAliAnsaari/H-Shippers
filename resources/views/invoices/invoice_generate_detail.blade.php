@extends('layouts.master')
@section('data-sidebar')

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-borderRed">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete <span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <p>Are you sure you want to delete?</p>
                </div>

            </div>
            <div class="modal-footer border-0">
                <a id="link_delete_consignment_modal"><button type="button" data-dismiss="modal"
                        class="btn btn-primary">Yes</button></a>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>



<div class="row mb-30 HS_CO">
    <div class="col-md-3">
        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="images/_t-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ sizeof($data) }}</h3>
            <h5 class="text-muted">Total Consignment</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card cp-stats yr_border">
            <div class="cp-stats-icon"><img src="images/_ca-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">Na</h3>
            <h5 class="text-muted">Cancel Consignment</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card cp-stats lb_border">
            <div class="cp-stats-icon"><img src="images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $top_data->total_transit }}</h3>
            <h5 class="text-muted">Pending Consignment</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $top_data->total_delivered }}</h3>
            <h5 class="text-muted">Complete Consignment</h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                {{-- <a href="" class="btn add_button"><i class="fa fa-plus"></i> <span>New
                        Consignments</span></a> --}}
                <h2>Consignments <span> List</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>CNNo.</th>
                            <th>Date</th>
                            <th>Sender’s</th>
                            <th>Receiver's</th>
                            <th>Piece</th>
                            <th>Weight</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->cnic }}</td>
                                <td>{{ $item->booking_date }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->consignee_name }}</td>
                                <td>{{ $item->consignment_pieces }}</td>
                                <td>{{ $item->consignment_weight }}</td>
                                <td>{{ $item->total_price }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="/update_consignment_cc/{{ $item->cnic }}" class="btn btn-default" name="client" title="Edit"><i
                                            class="fa fa-pencil-alt"></i></a>
                                    <button class="btn btn-default red-bg delete_cn_modal" name="client" data-toggle="modal" id="{{ $item->id }}" data-target="#exampleModal" title="Delete">Delete</button>
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
