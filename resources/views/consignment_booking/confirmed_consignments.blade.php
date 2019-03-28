@extends('layouts.master')
@section('data-sidebar')

{{-- Delete Modal --}}
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <a id="link_delete_consignment"><button type="button" data-dismiss="modal"
                        class="btn btn-primary">Yes</button></a>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div> --}}


{{-- Complete Consignment_modal --}}
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="completeModalLabel">Process <span> Complete</span></h5>
                <button type="button" class="close close_complete_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="check_mark">
                    <div class="sa-icon sa-success animate">
                        <span class="sa-line sa-tip animateSuccessTip"></span>
                        <span class="sa-line sa-long animateSuccessLong"></span>
                        <div class="sa-placeholder"></div>
                        <div class="sa-fix"></div>
                    </div>
                </div>

                <div class="form-wrap p-0">
                    <h1 class="_head05" align="center"><span>Do you want to </span> Complete Process?</h1>

                    <div class="PT-15 PB-10" align="center">
                        <button type="submit" class="btn btn-primary font13 m-0 mr-2 mb-2 complete_cn_modal">Yes</button>
                        <button type="submit"  data-dismiss="modal" class="btn btn-primary btn-outline font13 m-0 mb-2">No</button>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>


{{-- Change Status Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update <span> Status</span></h5>
                <button type="button" class="close close_status_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 PT-10">
                    <div class="form-s2">
                        <select class="form-control formselect" id="select_status_modal" placeholder="Select Status">
                            <option value="0" selected="" disabled="">Select Status</option>
                            
                        </select>
                    </div>
                </div>

                <div class="col-md-12 PT-10">
                    <label class="PT-10 font12">Remarks</label>
                    <textarea class="shadow-none _BgTextarea" id="remarks_modal" name="description" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary save_status_modal">Save</button>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>
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
            <h3 class="cp-stats-value">NA</h3>
            <h5 class="text-muted">Cancel Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats lb_border">
            <div class="cp-stats-icon"><img src="/images/_p-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $pending_consignments }}</h3>
            <h5 class="text-muted">Booked Consignment</h5>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card cp-stats bb_border">
            <div class="cp-stats-icon"><img src="/images/_c-consignment.svg" alt=""></div>
            <h3 class="cp-stats-value">{{ $completed }}</h3>
            <h5 class="text-muted">Complete Consignment</h5>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Consignments <span>& Booking (Confirmed)</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>CNNo.</th>
                            <th>Date</th>
                            <th>Sender’s</th>
                            <th>Receiver's</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Total Price</th>
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
                            <td>{{ $consignmnet['reciver_name'] }}</td>
                            <td>{{ ($consignmnet['rider_name'] != '' || null ? $consignmnet['rider_name'] : "NA") }}</td>
                            <td>{!! ($consignmnet['status_log'] != '' || null ? "<span id='test_status' style='color: #FBD536'>".$consignmnet['status_log']."</span>" : "<span style='color:darkgreen' >Processed</span>") !!}</td>
                            <td>{{ $consignmnet['total_price'] }}</td>
                            
                            <td>
                                <button class="btn btn-default update_cn_status" value="{{ $consignmnet['status_remark']."-".$consignmnet['status_log'] }}" name="{{ $consignmnet['opp'] }}"
                                    id="{{ $consignmnet['cnno'] }}" data-toggle="modal" data-target="#exampleModal">Update Status</button>
                                <button class="btn btn-default complete_consignment" name="{{ $consignmnet['opp'] }}"
                                    id="{{ $consignmnet['consignment_id'] }}" >Complete</button>
                                <button class="btn btn-default open_complete_modal" hidden data-toggle="modal" data-target="#completeModal">Open Complete Modal</button>
                            </td>
                        </tr>

                        @endforeach
                        @endif



                    </tbody>
                </table>

            </div>
            {{-- <button class="btn btn-default red-bg" data-toggle="modal" data-target="#exampleModal"
                id="delete_customer_modal" hidden>Delete</button> --}}
            {{-- <button type="submit" class="btn btn-primary mr-2" id="open_modal" data-toggle="modal" data-target=".bd-example-modal-lg"
                style="display:none">Open Modal</button> --}}


        </div>

    </div>


</div>

@endsection
