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
                    <div class="_left-filter">
                        <div class="se_cus-type p-20 mb-3">
                            <h2 class="_head04 border-0">Select <span> Customer Type</span></h2>
                            <div class="form-s2">
                                <select class="form-control formselect" name="type" placeholder="Select Customer Type">
                                    <option value="0" disabled selected>Select Customer Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                    @endforeach
						        </select>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Company <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="compName" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC*</label>
                                                        <input type="text" name="poc" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Job Title</label>
                                                        <input type="text" name="jobTitle" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="parentCompnay" placeholder="select Parent Company">
                                                            <option value="0">Select Parent Company</option>
                                                            @foreach ($customers as $comp)
                                                                <option value="{{ $comp->id }}">{{ $comp->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Contact <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Phone*</label>
                                                        <input type="text" name="businessPh" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Home Phone</label>
                                                        <input type="text" name="homePh" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Mobile Number</label>
                                                        <input type="text" name="mobPh" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">WhatsApp No</label>
                                                        <input type="text" name="whatsappPh" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Fax No</label>
                                                        <input type="text" name="faxPh" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address*</label>
                                                        <input type="text" name="address" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City*</label>
                                                        <input type="text" name="city" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">State/Province</label>
                                                        <input type="text" name="state" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="country" placeholder="select Country*">
                                                            <option value="0">Select Country*</option>
                                                            <option value="usa">USA</option>
                                                            <option value="uk">UK</option> 
                                                            <option value="china">Chaina</option>
                                                            <option value="india">India</option>  
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Region</label>
                                                        <input type="text" name="region" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email address</label>
                                                        <input type="text" name="email" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Web Page Address</label>
                                                        <input type="text" name="webpage" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Additional <span>Details</span></h2>
                                        <div class="form-s2">
                                            <label class="PT-10 font12">Document Types Required*</label>
                                            <select class="form-control sd-type" name="documentTypes" multiple="multiple">
                                                <option value="0">Select Document Types</option>
                                                <option value="1">Types 2</option> 
                                                <option value="2">Types 3</option>
                                                <option value="3">Types 4</option>
                                                <option value="4">Types 5</option>
                                                <option value="5">Types 6</option>
                                                <option value="6">Types 7</option>
                                                <option value="7">Types 8</option>  
                                            </select>
                                        </div>
                                        <div class="form-s2">
                                            <label class="PT-10 font12">Delivery Ports*</label>
                                            <select class="form-control sd-type" name="deliveryPorts" multiple="multiple">
                                                <option value="0">Delivery Ports</option>
                                                <option value="1">Port 1</option>
                                                <option value="2">Port 2</option> 
                                                <option value="3">Port 3</option>
                                                <option value="4">Port 4</option>
                                                <option value="5">Port 5</option>
                                                <option value="6">Port 6</option>
                                                <option value="7">Port 7</option>
                                                <option value="8">Port 8</option>  
                                            </select>
                                        </div>
                                        <div class="form-s2 pt-19">
                                            <select class="form-control formselect" name="acqSource" placeholder="Acquisition Source">
                                                <option value="0">Select Acquisition Source</option>
                                                <option value="Source 1">Acquisition Source 1</option>
                                                <option value="Source 2">UK</option> 
                                                <option value="Source 3">Chaina</option>
                                                <option value="Source 4">India</option>  
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-wrap pt-19" id="dropifyImgDiv">
                                                    {{-- <div class="upload-pic"></div>
                                                    <input type="file" name="compPicture" id="input-file-now" class="dropify" /> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="PT-10 font12">Remarks</label>
                                                    <div class="form-group">
                                                        <input type="text" name="document_types" hidden>
                                                        <input type="text" name="delivery_ports" hidden>
                                                        <textarea name="description" rows="8"></textarea>
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
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveCustomer">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelCustomer">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div style="min-height: 400px" id="tblLoader">
    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
</div>
<input type="text" id="companyIdForUpdate" value="{{ $update_customer->id }}" hidden>
<div id="contentDiv" style="display: none">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Customer <span>Profile</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Customer </span></a></li>
                <li><span>Profile</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-12 mb-30">
            <div class="card cp-mh">
                <div class="body">
                    <div class="_cut-img"><img src="" alt="" />
                        <div class="nam-title"></div>
                    </div>
                    <div class="con_info">
                        <p><i class="fa fa-user"></i></p>
                        <p><i class="fa fa-phone-square"></i></p>
                        <p><i class="fa fa-map-marked-alt"></i></p>
                        <p><i class="fa fa-globe"></i></p>
                        <a id="{{ $update_customer->id }}" class="btn-primary float-right openDataSidebarForUpdateCustomer" style="cursor: pointer; color: white !important">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12 mb-30">
            <div class="row">
                <div class="col-md-6 mb-30">
                    <div class="card cp-stats">
                        <div class="cp-stats-icon"> <i class="fa fa-chart-pie"></i> </div>
                        <h5 class="text-muted">Orders</h5>
                        <h3 class="cp-stats-value">36,254</h3>
                        <p class="mb-0"><span class="weight600 text-success"><i class="fa fa-arrow-up"> </i> 5.27%</span> <span class="bm_text"> Since last month</span> </p>
                    </div>
                </div>
                <div class="col-md-6 mb-30">
                    <div class="card cp-stats">
                        <div class="cp-stats-icon"> <i class="fa fa-chart-bar"></i> </div>
                        <h5 class="text-muted">Growth</h5>
                        <h3 class="cp-stats-value">36,254</h3>
                        <p class="mb-0"><span class="weight600 text-danger"><i class="fa fa-arrow-down"> </i> 5.27%</span> <span class="bm_text"> Since last month</span> </p>
                    </div>
                </div>
                <div class="col-md-6 mb-30">
                    <div class="card cp-stats">
                        <div class="cp-stats-icon"> <i class="fa fa-chart-area"></i> </div>
                        <h5 class="text-muted">Revenue</h5>
                        <h3 class="cp-stats-value">36,254</h3>
                        <p class="mb-0"><span class="weight600 text-danger"><i class="fa fa-arrow-down"> </i> 5.27%</span> <span class="bm_text"> Since last month</span> </p>
                    </div>
                </div>
                <div class="col-md-6 mb-30">
                    <div class="card cp-stats">
                        <div class="cp-stats-icon"> <i class="fa fa-chart-line"></i> </div>
                        <h5 class="text-muted">Customers</h5>
                        <h3 class="cp-stats-value">36,254</h3>
                        <p class="mb-0"><span class="weight600 text-success"><i class="fa fa-arrow-up"> </i> 5.27%</span> <span class="bm_text"> Since last month</span> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab01" role="tab" aria-controls="tab01" aria-selected="true">Order List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-toggle="tab" href="#tab02" role="tab" aria-controls="tab02" aria-selected="false">Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" data-toggle="tab" href="#tab03" role="tab" aria-controls="tab03" aria-selected="false">Contact</a>
                    </li>
                </ul>
                <div class="tab-content tab-style" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab1">
                        <table class="table table-hover dt-responsive nowrap" id="example" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Order#</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Deadline</th>
                                    <th>Order Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1566</td>
                                    <td>11/02/2018</td>
                                    <td>Saeed Khan</td>
                                    <td>Deadline here</td>
                                    <td>Rs: 17500</td>
                                    <td>Complete</td>
                                    <td>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-order-detail" title="Order Detail"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-cust-detail" title="Customer Detail"><i class="fa fa-user-check"></i></button>
                                        <button class="btn btn-default bg-success" title="Confirm Order"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-default bg-danger" title="Cancel"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1566</td>
                                    <td>11/02/2018</td>
                                    <td>Saeed Khan</td>
                                    <td>Deadline here</td>
                                    <td>Rs: 17500</td>
                                    <td><span class="text-danger">Pending</span></td>
                                    <td>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-order-detail" title="Order Detail"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-cust-detail" title="Customer Detail"><i class="fa fa-user-check"></i></button>
                                        <button class="btn btn-default bg-success" title="Confirm Order"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-default bg-danger" title="Cancel"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1566</td>
                                    <td>11/02/2018</td>
                                    <td>Saeed Khan</td>
                                    <td>Deadline here</td>
                                    <td>Rs: 17500</td>
                                    <td>Complete</td>
                                    <td>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-order-detail" title="Order Detail"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-cust-detail" title="Customer Detail"><i class="fa fa-user-check"></i></button>
                                        <button class="btn btn-default bg-success" title="Confirm Order"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-default bg-danger" title="Cancel"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1566</td>
                                    <td>11/02/2018</td>
                                    <td>Saeed Khan</td>
                                    <td>Deadline here</td>
                                    <td>Rs: 17500</td>
                                    <td><span class="text-danger">Pending</span></td>
                                    <td>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-order-detail" title="Order Detail"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-cust-detail" title="Customer Detail"><i class="fa fa-user-check"></i></button>
                                        <button class="btn btn-default bg-success" title="Confirm Order"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-default bg-danger" title="Cancel"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1566</td>
                                    <td>11/02/2018</td>
                                    <td>Saeed Khan</td>
                                    <td>Deadline here</td>
                                    <td>Rs: 17500</td>
                                    <td>Complete</td>
                                    <td>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-order-detail" title="Order Detail"><i class="fa fa-list"></i></button>
                                        <button class="btn btn-default" data-toggle="modal" data-target=".modal-cust-detail" title="Customer Detail"><i class="fa fa-user-check"></i></button>
                                        <button class="btn btn-default bg-success" title="Confirm Order"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-default bg-danger" title="Cancel"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="tab02" role="tabpanel" aria-labelledby="tab2">
                        2
                    </div>
                    <div class="tab-pane fade show" id="tab03" role="tabpanel" aria-labelledby="tab3">
                        3
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
