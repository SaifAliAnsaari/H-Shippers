@extends('layouts.master')
@section('data-sidebar')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Update <span> Consignment Booking</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Consignment Booking</span></a></li>
            <li><span>Update Booking</span></li>
        </ol>
    </div>
</div>
<div style="min-height: 400px" id="dataLoader" style="">
    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
</div>
<button type="button" hidden id="hidden_btn_client">Test</button>
<form id="updateConsignmentFormClient" style="display:none">
    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
    @csrf
    <input id="consignment_operation" hidden value="update" type="text" />
    <input hidden value="{{ $cnno }}" id="hidden_ccno" type="text" />
    <input hidden type="text" value="" name="hidden_supplementary_services" id="hidden_supplementary_services" />
    <input hidden type="text" value="" name="fragile_cost_hidden" id="fragile_cost_hidden" />
    <input hidden type="text" value="" name="hiddenconsignment_id" id="hiddenconsignment_id" />
    <div class="col-md-12 sm-pb-30">
        <div class="row">
            <div class="_new-consign-top">
                <label class="control-label label1">Booking Date:</label>
                <div class="form-group">
                    <div class="input-append date position-relative" id="dp3" TY data-date="{{ date('Y-m-d') }}"
                        data-date-format="yyyy-mm-dd">
                        <input type="text" value="{{ date('Y-m-d') }}" id="update_datepicker" name="datepicker" readonly
                            style="font-size: 13px">
                        <span class="add-on calendar-icon">
                            <img src="/images/calendar-icon.svg" alt="" /> </span>
                    </div>
                    <style>
                        .datepicker {
                            margin-left: -200px
                        }

                    </style>
                </div>
            </div>
            <div class="_new-consign-top">
                <label class="control-label label2">CNNo*:</label>
                <input type="text" id="update_cnic_client" readonly name="cnic_client" class="form-control required"
                    placeholder="" style="font-size: 13px">
            </div>
            <div class="_new-consign-top">
                <label class="control-label label3">Customer ID:</label>
                <input type="text" name="customer_id_client" value="00" readonly id="update_customer_id_client"
                    class="form-control" placeholder="Lhr02154" style="font-size: 13px">
            </div>
            <div class="_new-consign-top mr-0">
                <label class="control-label label4">Region:</label>
                <div class="form-s2 ">
                    <div>
                        <select class="form-control formselect required" placeholder="Consignment Type"
                            name="update_region_client" id="update_region_client">
                            <option value="0" selected disabled>Consignment Region*</option>
                            @if(!empty($pickup_city))
                                @foreach($pickup_city as $region)
                                    <option value="{{ $region->city_name }}">{{ $region->city_name }}</option>
                                    <option value="{{ $region->city_name }}" >{{ $region->city_name }}</option>
                                @endforeach
                            @endif
                        </select> 
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="floating-label" class="card p-20 top_border mb-3">
                <img src="/images/loader.gif" width="30px" height="auto" id="loader"
                    style="position: absolute; left: 50%; top: 45%; display:none;">
                <h2 class="_head03">Consignee <span></span></h2>
                <div class="form-wrap pt-0 PB-20">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Name*</label>
                                <input type="text" name="consignee_name_client" id="consignee_name_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Ref#</label>
                                <input type="text" name="consignee_ref_client" id="consignee_ref_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Cell#</label>
                                <input type="number" name="consignee_cell_client" id="consignee_cell_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Email</label>
                                <input type="email" name="consignee_email_client" id="consignee_email_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label mb-10">Address*</label>
                                <input type="text" name="consignee_address_client" id="consignee_address_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="_head03">Consignment <span></span></h2>
                <div class="form-wrap pt-0 PB-20">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" placeholder="Consignment Type"
                                        name="consignment_type" id="consignment_type">
                                        <option value="0" selected disabled>Consignment Type*</option>
                                        <option value="Fragile">Fragile</option>
                                        <option value="Non Fragile">Non Fragile</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" placeholder="Services Type"
                                        name="consignment_service_type_client" id="consignment_service_type_client">
                                        <option value="0" selected disabled>Services Type*</option>
                                        <option value="1">Same Day Delivery</option>
                                        <option value="2">Over Night Delivery</option>
                                        <option value="3">Second Day Delivery</option>
                                        <option value="4">Over Land</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Pieces*</label>
                                <input type="number" id="consignment_pieces_client" name="consignment_pieces_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Weight(Kgs)*</label>
                                <input type="number" name="consignment_weight_client" id="consignment_weight_client"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Description (Product/Item)</label>
                                <input type="text" name="consignment_description_client"
                                    id="consignment_description_client" class="form-control" placeholder=""
                                    style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" placeholder="Services Type"
                                        name="consignment_dest_city_client" id="consignment_dest_city_client">
                                        <option value="0" selected disabled>Select Destination City*</option>
                                        <?php
                                            if(!$pickup_city->isEmpty()){
                                            foreach($pickup_city as $city){ ?>
                                        <option value="<?= $city->city_name ?>"><?= $city->city_name ?></option>
                                        <?php }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="_head03">Insurance <span></span></h2>
                <div class="form-wrap pt-0 PB-20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="row mb-10">
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="Fragile" value='For Fragile' data-id="Fragile">
                                        <label class="custom-control-label" for="Fragile">For Fragile</label>
                                    </div>
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="Non-Fragile" value='For Non Fragile'
                                            data-id="Non-Fragile">
                                        <label class="custom-control-label" for="Non-Fragile">For Non Fragile</label>
                                    </div>
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="Electronics" value='For Electronics'
                                            data-id="Electronics">
                                        <label class="custom-control-label" for="Electronics">For Electronics</label>
                                    </div>
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="none" value='none' data-id="none">
                                        <label class="custom-control-label" for="none">None</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12" id="insurance_yes" style="display:none;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mb-10">Product Price*</label>
                                    <input type="number" id="product_price" name="product_price" class="form-control"
                                        placeholder="" style="font-size: 13px">
                                </div>
                            </div>
                            <hr class="mb-2">
                        </div>
                    </div>
                </div>
                <h2 class="_head03">Supplementary Services <span></span></h2>
                <div class="row _checkbox-padd">
                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_client"
                                value="Holiday" id="id001">
                            <label class="custom-control-label" for="id001">Holiday</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_client"
                                value="Special Handling" id="id002">
                            <label class="custom-control-label" for="id002">Special Handling</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_client"
                                value="Time Specified" id="id003">
                            <label class="custom-control-label" for="id003">Time Specified</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_client"
                                value="Passport" id="id004">
                            <label class="custom-control-label" for="id004">Passport</label>
                        </div>
                    </div>
                </div>
                <br>
                <h2 class="_head03">Remarks <span></span></h2>
                <div class="form-wrap pt-0 PB-20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="remarks_client" id="remarks_client" class="required" rows="8"
                                    style="font-size: 13px"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="_head03 update_total_price">Total Price<span></span></h2>
            </div>
        </div>
        
        <div class="bottom-btns">
            <button type="button" class="btn btn-primary mr-2 update_consignment_client">Update</button>
            <button type="button" class="btn btn-cancel" id="cancel_btn">Cancel</button>
        </div>
    </div>
    </div>
</form>
</div>
@endsection
