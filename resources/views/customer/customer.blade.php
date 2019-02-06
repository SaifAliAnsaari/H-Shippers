@extends('layouts.master')

@section('data-sidebar')

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content top_border">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Customer <span>has been successfully added</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body p-30">
            <div class="form-wrap p-0">	
    
            <h1 class="_head05">Add <span>Billing Account?</span></h1>		 
    
            <a id="add_billing_to_customer" href=""><button type="submit" class="btn btn-primary mr-2 mb-2">Yes</button></a>
            <button type="submit" class="btn btn-primary mr-2 mb-2" data-dismiss="modal">No</button>
    
                                
    
        <div class="modal-footer p-0 border-0">
        <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Add Another</button>
        </div>
    
    
            </div>
            </div>
        </div>
        </div>
    </div> 

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
        <button type="button" class="btn btn-primary mr-2" id="open_modal_billing" data-toggle="modal" data-target=".bd-example-modal-lg" style="display:none">Save</button>
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
