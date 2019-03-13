@extends('layouts.master')
@section('data-sidebar')

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <a id="link_delete_consignment"><button type="button" data-dismiss="modal" class="btn btn-primary">Yes</button></a>
            <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
        </div>
        </div>
    </div>
</div>



<div class="row  mb-30 HS_CO">
    <div class="col-md-3">
        <div class="card cp-stats yb_border">
            <div class="cp-stats-icon"><img src="/images/_t-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $total_consignments }}</h3>
            <h5 class="text-muted">Total Consignment</h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card cp-stats yr_border">
            <div class="cp-stats-icon"><img src="/images/_ca-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">150</h3>
            <h5 class="text-muted">Cancel Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats lb_border">
            <div class="cp-stats-icon"><img src="/images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $pending_consignments }}</h3>
            <h5 class="text-muted">Pending Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="/images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">12540</h3>
            <h5 class="text-muted">Complete Consignment</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Consignments <span>& Booking (Booked)</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>CNNo.</th>
                            <th>Date</th>
                            <th>Sender’s</th>
                            <th>Area</th>
                            <th>Receiver's</th>
                            <th>Area</th>
                            <th>Rider Name</th>
                            <th>Piece</th>
                            <th>Weight</th>
                            <th>Status</th>
                            <th style="width: 153px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        
                        @if(!empty($consignments))
                            @foreach($consignments as $consignmnet)
                                <tr>
                                    <td>{{ $consignmnet['cnno'] }}</td>
                                    <td>{{ $consignmnet['date'] }}</td>
                                    <td>{{ $consignmnet['sender_name'] }}</td>
                                    <td>Town Ship Area</td>
                                    <td>{{ $consignmnet['reciver_name'] }}</td>
                                    <td>PIA Road Wapda town Lahore</td>
                                    <td>Jamshad Khan</td>
                                    <td>{{ $consignmnet['consignment_pieces'] }}</td>
                                    <td>{{ $consignmnet['weight'] }}</td>
                                    <td>Pending</td>
                                    <td>
                                        <button class="btn btn-default edit_consignment" name="{{ $consignmnet['opp'] }}" id="{{ $consignmnet['cnno'] }}" title="Edit"><i class="fa fa-pencil-alt"></i></button>
                                        <button class="btn btn-default" id="{{ $consignmnet['consignment_id'] }}" title="Invoice"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default process_consignment" name="{{ $consignmnet['opp'] }}" id="{{ $consignmnet['consignment_id'] }}">Process</button>
                                        <button class="btn btn-default red-bg delete_pend_consignment" name="{{ $consignmnet['opp'] }}" id="{{ $consignmnet['consignment_id'] }}" title="Delete">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        


                    </tbody>
                </table>

            </div>
            <button  class="btn btn-default red-bg" data-toggle="modal" data-target="#exampleModal" id="delete_customer_modal" hidden>Delete</button>
            {{-- <button type="submit" class="btn btn-primary mr-2" id="open_modal" data-toggle="modal" data-target=".bd-example-modal-lg" style="display:none">Open Modal</button> --}}
        

        </div>

    </div>


</div>

@endsection
