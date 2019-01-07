@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Customer</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex;" id="saveCustomerForm">
            {!! Form::hidden('product_updating_id', '') !!}
            {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
            @csrf
            <input type="text" id="operation" hidden>
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter" style="padding-top:30px">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Prospect <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label mb-10">Country</label>
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" placeholder="Select Country">
                                                            <option>Select Country</option>
                                                            <option>USA</option>
                                                            <option>UK</option> 
                                                            <option>Chaina</option>
                                                            <option>India</option>  
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Region</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Client Name</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Mobile Number</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email ID</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Website</label>
                                                        <input type="text" id="" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                    <label class="PT-10 font12">Meeting Minutes</label>
                                                    <div class="form-group">
                                                        <textarea name="description" rows="5"></textarea>
                                                    </div>

                                                    <label class="PT-10 font12">Correspondence</label>
                                                    <div class="form-group">
                                                        <textarea name="description" rows="5"></textarea>
                                                    </div>

                                                    <label class="PT-10 font12">Remarks</label>
                                                    <div class="form-group">
                                                        <textarea name="description" rows="5"></textarea>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <h2 class="_head03 PT-20">Add<span> Business Card</span></h2>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-wrap p-0 pt-10">
                                                    <div class="upload-pic font12 pb-1">Front Photo</div>
                                                    <input type="file" id="input-file-now" class="dropify" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-wrap p-0 pt-10">
                                                    <div class="upload-pic font12 pb-1">Back Photo</div>
                                                    <input type="file" id="input-file-now" class="dropify" />
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
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveCustomer">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelCustomer">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Customers</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Customers</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingCustomer"><i class="fa fa-plus"></i> Add Customer</a>
                <h2>Customers List</h2>
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
