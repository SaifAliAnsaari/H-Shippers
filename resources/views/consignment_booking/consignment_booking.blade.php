@extends('layouts.master')

@section('data-sidebar')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">New <span> Consignment Booking</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Consignment Booking</span></a></li>
            <li><span>New Booking</span></li>
        </ol>
    </div>
</div>

<form id="saveConsignmentForm">
    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
    @csrf
    <input hidden type="text" name="hidden_supplementary_services" />
    <input hidden type="text" value="" name="fragile_cost_hidden" id="fragile_cost_hidden" />
    <input hidden type="text" value="" name="select_customer" id="select_customer" />
    <div class="col-md-12 sm-pb-30">
        <div class="row">

            <div class="_new-consign-top">
                <label class="control-label label1">Booking Date:</label>
                <div class="form-group">
                    <div class="input-append date position-relative" id="dp3"
                        data-date-format="yyyy-mm-dd" >
                        <input type="text" class="required" value="{{date('Y-m-d')}}" name="booking_date" readonly
                            style="font-size: 13px">
                        <span class="add-on calendar-icon">
                            <img src="/images/calendar-icon.svg" alt="" /> </span>
                    </div>
                   
                </div>
            </div>

            <div class="_new-consign-top">
                <label class="control-label label2">CNNo:* </label>
                <input type="text" name="cnic" id="cnic" class="form-control required ml-1" disabled value="{{$cnno}}"
                    placeholder="" style="font-size: 13px">
            </div>
            {{-- <div class="_new-consign-top">
                <label class="control-label label2">Client:* </label>
                <div class="form-s2 ml-1">
                    <div>
                        <select class="form-control formselect required" placeholder="Services Type"
                            name="select_customer" id="select_customer">
                            <option value="0" selected disabled>Select Client*</option>
                            @foreach ($clients as $data)
                                <option value="{{$data->id}}">{{$data->company_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>


    <div class="row">

        <div class="col-md-12">
            <div id="floating-label" class="card p-20 top_border mb-3">

                <h2 class="_head03">Shipper</h2>
                <div class="form-wrap pt-0 PB-20">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Name</label>
                                <input type="text" id="shipper_name" name="shipper_name" class="form-control"
                                    placeholder="" style="font-size: 13px" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">City</label>
                                <input type="text" id="select_city_shipper" name="select_city_shipper" class="form-control" readonly
                                    placeholder="" style="font-size: 13px">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Area</label>
                                <input type="text" id="shipper_area" name="shipper_area" class="form-control" readonly
                                    placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Cell#</label>
                                <input type="number" id="shipper_cell_num" name="shipper_cell_num" readonly
                                    class="form-control" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Land Line#</label>
                                <input type="number" id="shipper_land_line" name="shipper_land_line" readonly
                                    class="form-control" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Email</label>
                                <input type="email" id="shipper_email" name="shipper_email" readonly
                                    class="form-control" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label mb-10">Address</label>
                                <input type="text" id="shipper_address" name="shipper_address" readonly
                                    class="form-control" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                    </div>

                </div>

                <h2 class="_head03">Consignee <span></span></h2>
                <div class="form-wrap pt-0 PB-20">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Name*</label>
                                <input type="text" id="consignee_name" name="consignee_name"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Ref#*</label>
                                <input type="text" id="consignee_ref_num" name="consignee_ref_num"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Consignee Cell#*</label>
                                <input type="number" id="consignee_cell_num" name="consignee_cell_num"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Email*</label>
                                <input type="email" id="consignee_email" name="consignee_email"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label mb-10">Address*</label>
                                <input type="text" id="consignee_address" name="consignee_address"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                    </div>

                </div>

                <h2 class="_head03">Consignment <span></span></h2>

                <div class="form-wrap pt-0 PB-20">
                    <div class="row">

                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Region City*</label>
                                <input type="text" id="consignment_regin_city" name="consignment_regin_city"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" placeholder="Consignment Type"
                                        name="consignment_type" id="consignment_type">
                                        <option value="0" selected disabled>Consignment Type*</option>
                                        <option value="Fragile">Fragile</option>
                                        <option value="Non Fragile" selected>Non Fragile</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" name="service_type"
                                        placeholder="Services Type" id="service_type">
                                        <option value="0" selected disabled>Select Services Type*</option>
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
                                <input type="number" id="consignment_pieces" name="consignment_pieces"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Weight(Kgs)*</label>
                                <input type="number" id="consignment_weight" name="consignment_weight"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Description (Product/Item)*</label>
                                <input type="text" id="consignment_description" name="consignment_description"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-s2 pt-19">
                                <div>
                                    <select class="form-control formselect required" placeholder="Services Type"
                                        name="consignment_dest_city" id="consignment_dest_city">
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

                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label mb-10">Price*</label>
                                <input type="number" id="consignment_price" name="consignment_price"
                                    class="form-control required" placeholder="" style="font-size: 13px">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="row radio_topPD">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input consignment_destination" type="radio"
                                            name="inlineRadioOptions" id="Domestic" value='valuable' data-id="Domestic">
                                        <label class="custom-control-label" for="Domestic">Domestic*</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input consignment_destination" type="radio"
                                            name="inlineRadioOptions" id="International" value='valuable'
                                            data-id="International">
                                        <label class="custom-control-label" for="International">International*</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
                                        <label class="custom-control-label" for="Non-Fragile">For Non
                                            Fragile</label>
                                    </div>
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="Electronics" value='For Electronics'
                                            data-id="Electronics">
                                        <label class="custom-control-label" for="Electronics">For
                                            Electronics</label>
                                    </div>
                                    <div class="custom-control custom-radio col-md-3 col-xs-3">
                                        <input class="custom-control-input insurance_selector" type="radio"
                                            name="Fragile_Criteria" id="none" value='none' data-id="none" checked>
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
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>

                <h2 class="_head03">Supplementary Services <span></span></h2>

                <div class="row _checkbox-padd">

                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_admin"
                                name="supplementary_services_admin" value="Holiday" id="id001">
                            <label class="custom-control-label" for="id001">Holiday</label>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_admin"
                                name="supplementary_services_admin" value="Special Handling" id="id002">
                            <label class="custom-control-label" for="id002">Special Handling</label>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_admin"
                                name="supplementary_services_admin" value="Time Specified" id="id003">
                            <label class="custom-control-label" for="id003">Time Specified</label>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input supplementary_services_admin"
                                name="supplementary_services_admin" value="Passport" id="id004">
                            <label class="custom-control-label" for="id004">Passport</label>
                        </div>
                    </div>

                </div>
                <h2 class="_head03 pt-30">Remarks <span></span></h2>
                <div class="form-wrap pt-0 PB-20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="description" class="required" id="consignment_remarks" rows="8"
                                    style="font-size: 13px"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bottom-btns">

                    <button type="button" class="btn btn-primary mr-2 save_consignment_admin">Save</button>
                    <button type="button" class="btn btn-cancel">Cancel</button>

                </div>



            </div>
        </div>
</form>

</div>


@endsection
