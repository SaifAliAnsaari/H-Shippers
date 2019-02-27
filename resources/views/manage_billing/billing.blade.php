@extends('layouts.master')


@section('data-sidebar')
{{-- Preview Documents SideBar --}}
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">Client <span>Documents</span></div>
    <div class="pc-cartlist">
      <div class="overflow-plist">
          <div class="plist-content">
              <div class="_left-filter">
                  <div class="container">
                      <div class="row test_images_modal">
                          
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>

{{-- Preview Billing Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 CB-view">
                            <div class="card p-20 top_border mb-30">
                                <h2 class="_head03">Client <span id="modal_client_name"> Name: Khan Traders</span></h2>
                                <div class="row">
                                    <div class="col-md-4" id="modal_poc_name">POC Name: Zia Khan</div>
                                    <div class="col-md-4" id="modal_start_date_div">Start Date: 5/22/2019</div>
                                    <div class="col-md-4" id="modal_address">Address: Donga Gali, House#450/F-II,
                                        Wapda/PIA Lahore.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2 class="_head03 border-0 mt-15">Same <span> Day Delivery Rate</span></h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered dt-responsive" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Weigh</th>
                                                            <th>Within City</th>
                                                            <th>Within Province</th>
                                                            <th>Province to Province</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Upto 0.25 KGs</td>
                                                            <td id="modal_withinCity_sameDay_025">50</td>
                                                            <td id="modal_withinProvince_sameDay_025">50</td>
                                                            <td id="modal_ProvToProv_sameDay_025">50</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Upto 0.50 KGs</td>
                                                            <td id="modal_withinCity_sameDay_50">60</td>
                                                            <td id="modal_withinProv_sameDay_50">60</td>
                                                            <td id="modal_ProvToProv_sameDay_50">60</td>
                                                        </tr>
                                                        <tr>
                                                            <td>0.51-1 KG</td>
                                                            <td id="modal_withinCity_sameDay_051">65</td>
                                                            <td id="modal_withinProv_sameDay_051">65</td>
                                                            <td id="modal_ProvToProv_sameDay_051">75</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinCity_sameDay_additional">80</td>
                                                            <td id="modal_withinProv_sameDay_additional">80</td>
                                                            <td id="modal_ProvToProv_sameDay_additional">80</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="_head03 border-0 mt-15">Over <span> Night Delivery Rate</span></h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered dt-responsive" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Weigh</th>
                                                            <th>Within City</th>
                                                            <th>Within Province</th>
                                                            <th>Province to Province</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Upto 0.25 KGs</td>
                                                            <td id="modal_withinCity_overNight_025">40</td>
                                                            <td id="modal_withinProv_overNight_025">43</td>
                                                            <td id="modal_ProvToProv_overNight_025">40</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Upto 0.50 KGs</td>
                                                            <td id="modal_withinCity_overNight_50">55</td>
                                                            <td id="modal_withinProv_overNight_50">55</td>
                                                            <td id="modal_ProvToProv_overNight_50">55</td>
                                                        </tr>
                                                        <tr>
                                                            <td>0.51-1 KG</td>
                                                            <td id="modal_withinCity_overNight_051">75</td>
                                                            <td id="modal_withinProv_overNight_051">75</td>
                                                            <td id="modal_ProvToProv_overNight_051">75</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinCity_overNight_additional">80</td>
                                                            <td id="modal_withinProv_overNight_additional">80</td>
                                                            <td id="modal_ProvToProv_overNight_additional">80</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="_head03 border-0 mt-15">Second <span> Day Delivery Rate</span></h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered dt-responsive" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Weigh</th>
                                                            <th>Within Province</th>
                                                            <th>Province to Province</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Upto 3 KGs</td>
                                                            <td id="modal_withinProv_secondDay_upto3Kg">70</td>
                                                            <td id="modal_ProvToProv_secondDay_upto3Kg">75</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 1 KGs</td>
                                                            <td id="modal_withinProv_secondDay_additional">85</td>
                                                            <td id="modal_ProvToProv_secondDay_additional">95</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="_head03 border-0 mt-15">Over <span> Land Service</span></h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered dt-responsive" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Weigh</th>
                                                            <th>Within Province</th>
                                                            <th>Province to Province</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Upto 10 KGs</td>
                                                            <td id="modal_withinProv_overLand_upto3Kg">70</td>
                                                            <td id="modal_ProvToProv_overLand_upto3Kg">75</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 1 KGs</td>
                                                            <td id="modal_withinProv_overLand_additional">85</td>
                                                            <td id="modal_ProvToProv_overLand_additional">95</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinProv_overLand_additional05">85</td>
                                                            <td id="modal_ProvToProv_overLand_additional05">95</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h2 class="_head03 mt-15 border-0">Fragile <span> Items Cost</span></h2>
                                        <div class="_boxgray">Items Cost:<span id="modal_fragile_cost">50</span> </div>
                                    </div>
                                    <div class="col-md-9">
                                        <h2 class="_head03 mt-15 border-0">Insurance <span> on Consignment</span></h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="_boxgray">For Fragile:<span id="modal_insurance_fragile">150</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="_boxgray">For none Fragile:<span id="modal_insurance_non_fragile">100</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="_boxgray">For Electronics:<span id="modal_insurance_electronics">120</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="_head03 mt-15 border-0">Supplementary <span> Services</span></h2>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="_boxgray">Holiday: <span id="modal_supplementary_holiday">100</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Special Handling: <span id="modal_supplementary_special_handling">120</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Time Specified: <span id="modal_supplementary_time_specified">120</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Passport: <span id="modal_supplementary_passport">240</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-3">
                                        <h2 class="_head03 mt-15 border-0">Fuel <span> Charges</span></h2>
                                        <div class="_boxgray">Charges: <span id="modal_fuel"> 20</span> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h2 class="_head03 mt-15 border-0">Government <span> Taxes</span></h2>
                                        <div class="_boxgray">GST: <span id="modal_tax"> 2.2%</span> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" class="btn btn-primary Doclink" >Documents
                                            Link</a>
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


<div id="content-wrapper">
    <div style="min-height: 400px" id="tblLoader">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="container" id='container_layout' style="display:none">
        <div class="row mt-2 mb-3">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2 class="_head01">Service <span> Charges For Domestic Courier</span></h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="#"><span>Service Charges</span></a></li>
                    <li><span>Domestic Courier</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Domestic <span> Service Charges</span></h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01"
                                    role="tab" aria-controls="v-pills-01" aria-selected="true">Start Date</a>
                                <a class="nav-link" id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab"
                                    aria-controls="v-pills-02" aria-selected="false">Same Day Delivery Rate</a>
                                <a class="nav-link" id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab"
                                    aria-controls="v-pills-03" aria-selected="false">Over Night Delivery</a>
                                <a class="nav-link" id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab"
                                    aria-controls="v-pills-04" aria-selected="false">Second Day Delivery</a>
                                <a class="nav-link" id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab"
                                    aria-controls="v-pills-05" aria-selected="false">Over Land Service</a>
                                <a class="nav-link" id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab"
                                    aria-controls="v-pills-06" aria-selected="false">Fragile Items Cost</a>
                                <a class="nav-link" id="v-pills-07-tab" data-toggle="pill" href="#v-pills-07" role="tab"
                                    aria-controls="v-pills-07" aria-selected="false">Insurance on Consignment </a>
                                <a class="nav-link" id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab"
                                    aria-controls="v-pills-08" aria-selected="false">Supplementary Services</a>
                                <a class="nav-link" id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab"
                                    aria-controls="v-pills-09" aria-selected="false">Fuel Charges</a>
                                <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab"
                                    aria-controls="v-pills-10" aria-selected="false">Government Taxes</a>
                                <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab"
                                    aria-controls="v-pills-11" aria-selected="false">Contract Copy</a>
                            </div>
                        </div>
                        <input hidden type="text" name="operation" id="operation" value="add" />
                        <input hidden type="text" name="billing_id_hidden" id="billing_id_hidden" value="" />
                        <div class="col-lg-6 col-md-8 col-sm-12 ml-800">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10">
                                                            <h2 class="_head04">Start <span>Date</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="PT-10 font12">Start Date*</label>
                                                            <div class="form-group" style="height: auto">
                                                                <input type="text" id="datepicker" name="datepicker"
                                                                    class="form-control required_date" placeholder=""
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-30">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-02" role="tabpanel" aria-labelledby="v-pills-02-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Same <span> Day Delivery Rate</span></h2>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Within <span> City</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                <input type="number" id="with_in_city_twentyfive" name="with_in_city_twentyfive"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                <input type="number" id="with_in_city_fifty" name="with_in_city_fifty"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">0.51-1 KG*</label>
                                                                <input type="number" id="with_in_city_six" name="with_in_city_six"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 0.5
                                                                    KGs*</label>
                                                                <input type="number" id="with_in_city_additional" name="with_in_city_additional"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Within <span> Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                <input type="number" id="with_in_province_twentyfive"
                                                                    name="with_in_province_twentyfive" class="form-control required_same_day"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                <input type="number" id="with_in_province_fifty" name="with_in_province_fifty"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">0.51-1 KG*</label>
                                                                <input type="number" id="with_in_province_six" name="with_in_province_six"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 0.5
                                                                    KGs*</label>
                                                                <input type="number" id="with_in_province_additional"
                                                                    name="with_in_province_additional" class="form-control required_same_day"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Province <span> to Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                <input type="number" id="prov_to_prov_twentyfive" name="prov_to_prov_twentyfive"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                <input type="number" id="prov_to_prov_fifty" name="prov_to_prov_fifty"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">0.51-1 KG*</label>
                                                                <input type="number" id="prov_to_prov_six" name="prov_to_prov_six"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 0.5
                                                                    KGs*</label>
                                                                <input type="number" id="prov_to_prov_additional" name="prov_to_prov_additional"
                                                                    class="form-control required_same_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-03" role="tabpanel" aria-labelledby="v-pills-03-tab">
                                    <div class="tab-pane fade show active" id="v-pills-01" role="tabpanel"
                                        aria-labelledby="v-pills-01-tab">
                                        <div class="CB_info">
                                            <div id="floating-label" class="card top_border mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-wrap PT-10 PB-20">
                                                        <div class="row">
                                                            <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Over <span> Night Delivery</span></h2>
                                                            </div>
                                                            <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Within <span> City</span></h2>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                    <input type="number" id="on_with_in_city_twentyfive"
                                                                        name="on_with_in_city_twentyfive" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                    <input type="number" id="on_with_in_city_fifty"
                                                                        name="on_with_in_city_fifty" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">0.51-1 KG*</label>
                                                                    <input type="number" id="on_with_in_city_six" name="on_with_in_city_six"
                                                                        class="form-control required_over_night" style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Each Additional
                                                                        0.5 KGs*</label>
                                                                    <input type="number" id="on_with_in_city_additional"
                                                                        name="on_with_in_city_additional" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Within <span> Province</span></h2>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                    <input type="number" id="on_with_in_prov_twentyfive"
                                                                        name="on_with_in_prov_twentyfive" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                    <input type="number" id="on_with_in_prov_fifty"
                                                                        name="on_with_in_prov_fifty" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">0.51-1 KG*</label>
                                                                    <input type="number" id="on_with_in_prov_six" name="on_with_in_prov_six"
                                                                        class="form-control required_over_night" style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Each Additional
                                                                        0.5 KGs*</label>
                                                                    <input type="number" id="on_with_in_prov_additional"
                                                                        name="on_with_in_prov_additional" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Province <span> to Province</span></h2>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.25 KGs*</label>
                                                                    <input type="number" id="on_provience_to_prov_twentyfive"
                                                                        name="on_provience_to_prov_twentyfive" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Upto 0.50 KGs*</label>
                                                                    <input type="number" id="on_provience_to_prov_fifty"
                                                                        name="on_provience_to_prov_fifty" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">0.51-1 KG*</label>
                                                                    <input type="number" id="on_provience_to_prov_six"
                                                                        name="on_provience_to_prov_six" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Each Additional
                                                                        0.5 KGs*</label>
                                                                    <input type="number" id="on_provience_to_prov_additional"
                                                                        name="on_provience_to_prov_additional" class="form-control required_over_night"
                                                                        style="font-size:13px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row m-0 PT-15">
                                                            <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                            <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-04" role="tabpanel" aria-labelledby="v-pills-04-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Second <span> Day Delivery</span></h2>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Within <span> Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 3 KGs*</label>
                                                                <input type="text" id="second_day_delivery_upto_3kg"
                                                                    name="second_day_delivery_upto_3kg" class="form-control required_second_day"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 1
                                                                    KGs*</label>
                                                                <input type="text" id="second_day_delivery_additional_1KG"
                                                                    name="second_day_delivery_additional_1KG" class="form-control required_second_day"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Province <span> to Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 3 KGs*</label>
                                                                <input type="text" id="second_day_delivery_prov_to_prov_upto3KG"
                                                                    name="second_day_delivery_prov_to_prov_upto3KG"
                                                                    class="form-control required_second_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 1
                                                                    KGs*</label>
                                                                <input type="text" id="second_day_delivery_prov_to_prov_additional1KG"
                                                                    name="second_day_delivery_prov_to_prov_additional1KG"
                                                                    class="form-control required_second_day" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">0.6-1 KG</label>
                                                                <input type="text" id="second_day_delivery_prov_to_prov_6to1KG"
                                                                    class="form-control" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 0.5
                                                                    KGs</label>
                                                                <input type="text" id="second_day_delivery_prov_to_prov_additionalpointFiveKg"
                                                                    class="form-control" style="font-size:13px">
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-05" role="tabpanel" aria-labelledby="v-pills-05-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Over <span> Land Service</span></h2>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Within <span> Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 10 KGs*</label>
                                                                <input type="text" id="over_land_upto10KG" name="over_land_upto10KG"
                                                                    class="form-control required_over_land" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 1
                                                                    KGs*</label>
                                                                <input type="text" id="over_land_additional1KG" name="over_land_additional1KG"
                                                                    class="form-control required_over_land" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Province <span> to Province</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Upto 10 KGs*</label>
                                                                <input type="text" id="over_land_prov_to_prov_upto10KG"
                                                                    name="over_land_prov_to_prov_upto10KG" class="form-control required_over_land"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Each Additional 0.5
                                                                    KGs*</label>
                                                                <input type="text" id="over_land_prov_to_prov_additionalpoint5KG"
                                                                    name="over_land_prov_to_prov_additionalpoint5KG"
                                                                    class="form-control required_over_land" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-06" role="tabpanel" aria-labelledby="v-pills-06-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Fragile <span> Items Cost</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Cost</label>
                                                                <input type="text" id="fragile_cost_price" name="fragile_cost_price"
                                                                    class="form-control required_cost" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-07" role="tabpanel" aria-labelledby="v-pills-07-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Insurance <span> on Consignment</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">For Fragile*</label>
                                                                <input type="number" id="insurance_for_fragile" name="insurance_for_fragile"
                                                                    class="form-control required_insurance" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">For Non Fragile*</label>
                                                                <input type="number" id="insurance_for_non_fragile"
                                                                    name="insurance_for_non_fragile" class="form-control required_insurance"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">For Electronics*</label>
                                                                <input type="number" id="insurance_for_electronics"
                                                                    name="insurance_for_electronics" class="form-control required_insurance"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-08" role="tabpanel" aria-labelledby="v-pills-08-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Supplementary <span> Services</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Holiday*</label>
                                                                <input type="number" id="supplementary_services_holiday"
                                                                    name="supplementary_services_holiday" class="form-control required_supplementary"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Special Handling*</label>
                                                                <input type="number" id="supplementary_services_special_holiday"
                                                                    name="supplementary_services_special_holiday" class="form-control required_supplementary"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Time Specified*</label>
                                                                <input type="number" id="supplementary_services_time_specified"
                                                                    name="supplementary_services_time_specified" class="form-control required_supplementary"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Passport*</label>
                                                                <input type="number" id="supplementary_services_passport"
                                                                    name="supplementary_services_passport" class="form-control required_supplementary"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-09" role="tabpanel" aria-labelledby="v-pills-09-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Fuel <span> Charges</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Fuel Charges*</label>
                                                                <input type="number" id="fuel_charges" name="fuel_charges"
                                                                    class="form-control required_fuel" style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Government <span> Taxes</span></h2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">GST</label>
                                                                <input type="number" id="gst_tax" name="gst_tax" class="form-control required_tax"
                                                                    style="font-size:13px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                    <form action="/test-upload" hidden class="dropzone" id="billing_form"
                                                        method="POST">
                                                        @csrf
                                                        <input name="customer_id" value="<?= $cust_id ?>" type="text"
                                                            hidden />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-11" role="tabpanel" aria-labelledby="v-pills-11-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Contract <span> Copy</span></h2>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="font12">Documents Attachment</label>
                                                            <div class="">
                                                                <form action="/test-upload" class="dropzone" id="dropzonewidget"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input hidden value="<?= $cust_id ?>" type="text"
                                                                        name="cust_id" />
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2 saveWholeForm">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2 cancel_btn">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="CBR_info">
                                <h2 class="_head04">Customer <span>Detail</span></h2>
                                <div class="CBR_value"><strong>Flagile Cost: </strong> <span id="cost_txt"> 00</span></div>
                                <div class="CBR_value"><strong>Flagile Insurance: </strong> <span id="f_insurance_txt">
                                        00</span></div>
                                <div class="CBR_value"><strong>Electronics Insurance: </strong> <span id="e_insurance_txt">
                                        00</span></div>
                                <div class="CBR_value"><strong>Fuel Charges: </strong> <span id="fuel_txt"> 00</span></div>
                                <div class="CBR_value"><strong>GST: </strong> <span id="gst_txt"> 00</span></div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <a href="" style="display:none" class="btn btn-primary preview_modal_btn" data-toggle="modal"
                                data-target="#exampleModal">Preview</a> <br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


