@extends('layouts.master')


@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Client</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex; width:100%" id="saveClientForm">
            {!! Form::hidden('product_updating_id', '') !!}
            {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
            @csrf
            <input type="text" id="operation" hidden>
            <input hidden value="" type="text" class="client_key_data" name="client_key"/>
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <input type = "text" value = "" name = "client_id" hidden/>
                                        <input type = "text" value = "" name = "logo_hidden" hidden/>
                                        <h2 class="_head03 PT-10">Create <span> User</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Username*</label>
                                                        <input type="text" name="username" class="form-control required" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Password*</label>
                                                        <input type="password" name="password" class="form-control required" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-wrap pt-19" id="dropifyImgDiv">
                                                        <div class="upload-pic"></div>
                                                        <input type="file" name="compPicture" id="input-file-now" class="dropify" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h2 class="_head03">Client <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="company_name" class="form-control required" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC Name</label>
                                                        <input type="text" name="poc" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC Contact#</label>
                                                        <input type="number" name="phone_number" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Office#</label>
                                                        <input type="number" name="office_number" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Website</label>
                                                        <input type="text" name="website" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City</label>
                                                        <input type="text" name="city" class="form-control" placeholder="">
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" name="address" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">NTN</label>
                                                        <input type="text" name="ntn" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">STRN</label>
                                                        <input type="text" name="strn" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="PT-10 font12">Customer Type</label>
                                                        <div>
                                                            <select class="form-control formselect required" name="customer_type" placeholder="Customer type">
                                                                <option value="0" disabled selected>Select Customer Type</option>
                                                                <option value="corporate">Corporate</option>
                                                                <option value="individual">Individual</option> 
                                                                <option value="brand">Brand</option> 
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="PT-10 font12">Pick Up City</label>
                                                        <div>
                                                            <select class="form-control sd-type required" name="pick_up_city">
                                                                <option value="0" selected disabled>Select City</option>
                                                                <option value="islamabad">Islamabad</option>
                                                                <option value="rawalpindi">Rawalpindi</option>
                                                                <option value="lahore">Lahore</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="PT-10 font12">Pick Up Province</label>
                                                        <div>
                                                            <select class="form-control sd-type required" name="pick_up_province">
                                                                <option value="0" selected disabled>Select Province</option>
                                                                <option value="sindh">Sindh</option>
                                                                <option value="kpk">KPK</option>
                                                                <option value="punjab">Punjab</option>
                                                                <option value="balochistan">Balochistan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                                <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Contract <span> Copy</span></h2>
                                                            </div> 
                                                            
                                                            <div class="col-md-12">
                                                            <label class="font12">Documents Attachment</label>
                                                                <div class="">
                                                                    <form action="/client_docs" class="dropzone" id="dropzonewidgetclient" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="text" hidden name="operation" class = "operation_docs"/>
                                                                    <input type="text" hidden class="client_key_docs" name="client_key_docs"/>
                                                                    </form>
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
                </div>
            </div>
        {{-- </form> --}}
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveClient">Save</button>
        <button type="submit" class="btn btn-primary mr-2" id="updateClient" style = "display:none;">Update</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelClient">Cancel</button>
    </div>
</div>
@endsection


@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Clients</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Clients</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingClient"><i class="fa fa-plus"></i> Add Client</a>
                <h2>Clients List</h2>
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