{{-- @extends('layouts.master')
@section('data-sidebar')
<div class="row mt-2 mb-3">        
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Save <span> Statuses</span></h2> 
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Dashboard</span></a></li>
            <li><span>Save Statuses</span></li>
        </ol>
    </div>
</div>

<div class="col-md-12">
    <form id="savestatuses">
    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
    @csrf
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label mb-10">Enter Status*</label>
                    <input type="text" id="status" name="" class="form-control" placeholder="" style="font-size: 13px">
                </div>
            </div>
            <div class="col-md-2"></div>
        </div> 
        <div class="row">
            <button style="position:relative; left:46%; top:15px;" type="button" class="btn btn-primary mr-2 save_status">Save</button>
        </div>
    </form>
</div>
@endsection --}}

@extends('layouts.master')

@section('data-sidebar')
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
            <a id="link_delete_custom_status"><button type="button" data-dismiss="modal" class="btn btn-primary">Yes</button></a>
            <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
        </div>
        </div>
    </div>
</div>


<div id="product-cl-sec" >
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Status</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist" id="sidebarLayout" style="display:none">
        <form id="savestatuses" style="width:100%;">
        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
        @csrf
            <input type="text" id="operation_status" hidden>
            <input hidden value="" type="text" class="status_id" name="status_id"/>
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Create <span>Status</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Status</label>
                                                        <input type="text" id="status" name="status" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- </form> --}}
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2 save_status" id="save_status">Save</button>
        <button type="submit" class="btn btn-primary mr-2 updatestatus" id="" style = "display:none;">Update</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelClient">Cancel</button>
        <button  class="btn" data-toggle="modal" data-target="#exampleModal" id="open_modal" hidden>Open Modal</button>
    </div>
</div>
@endsection


@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Statuses</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Statuses</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingstatus"><i class="fa fa-plus"></i> Add Status</a>
                <h2>Status List</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection