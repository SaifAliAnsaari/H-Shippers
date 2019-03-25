@extends('layouts.master')


@section('content')

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
                                <h2 class="_head03">Client <span id="modal_client_name"> Name: --</span></h2>
                                <div class="row">
                                    <div class="col-md-4" id="modal_poc_name">POC Name: --</div>
                                    <div class="col-md-4" id="modal_start_date_div">Start Date: --</div>
                                    <div class="col-md-4" id="modal_address">Address: --</div>
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
                                                            <td id="modal_withinCity_sameDay_025">--</td>
                                                            <td id="modal_withinProvince_sameDay_025">--</td>
                                                            <td id="modal_ProvToProv_sameDay_025">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Upto 0.50 KGs</td>
                                                            <td id="modal_withinCity_sameDay_50">--</td>
                                                            <td id="modal_withinProv_sameDay_50">--</td>
                                                            <td id="modal_ProvToProv_sameDay_50">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>0.51-1 KG</td>
                                                            <td id="modal_withinCity_sameDay_051">--</td>
                                                            <td id="modal_withinProv_sameDay_051">--</td>
                                                            <td id="modal_ProvToProv_sameDay_051">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinCity_sameDay_additional">--</td>
                                                            <td id="modal_withinProv_sameDay_additional">--</td>
                                                            <td id="modal_ProvToProv_sameDay_additional">--</td>
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
                                                            <td id="modal_withinCity_overNight_025">--</td>
                                                            <td id="modal_withinProv_overNight_025">--</td>
                                                            <td id="modal_ProvToProv_overNight_025">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Upto 0.50 KGs</td>
                                                            <td id="modal_withinCity_overNight_50">--</td>
                                                            <td id="modal_withinProv_overNight_50">--</td>
                                                            <td id="modal_ProvToProv_overNight_50">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>0.51-1 KG</td>
                                                            <td id="modal_withinCity_overNight_051">--</td>
                                                            <td id="modal_withinProv_overNight_051">--</td>
                                                            <td id="modal_ProvToProv_overNight_051">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinCity_overNight_additional">--</td>
                                                            <td id="modal_withinProv_overNight_additional">--</td>
                                                            <td id="modal_ProvToProv_overNight_additional">--</td>
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
                                                            <td id="modal_withinProv_secondDay_upto3Kg">--</td>
                                                            <td id="modal_ProvToProv_secondDay_upto3Kg">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 1 KGs</td>
                                                            <td id="modal_withinProv_secondDay_additional">--</td>
                                                            <td id="modal_ProvToProv_secondDay_additional">--</td>
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
                                                            <td id="modal_withinProv_overLand_upto3Kg">--</td>
                                                            <td id="modal_ProvToProv_overLand_upto3Kg">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 1 KGs</td>
                                                            <td id="modal_withinProv_overLand_additional">--</td>
                                                            <td id="modal_ProvToProv_overLand_additional">--</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Each Additional 0.5 KGs</td>
                                                            <td id="modal_withinProv_overLand_additional05">--</td>
                                                            <td id="modal_ProvToProv_overLand_additional05">--</td>
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
                                        <div class="_boxgray">Items Cost:<span id="modal_fragile_cost">--</span> </div>
                                    </div>
                                    <div class="col-md-9">
                                        <h2 class="_head03 mt-15 border-0">Insurance <span> on Consignment</span></h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="_boxgray">For Fragile:<span id="modal_insurance_fragile">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="_boxgray">For none Fragile:<span id="modal_insurance_non_fragile">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="_boxgray">For Electronics:<span id="modal_insurance_electronics">--</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="_head03 mt-15 border-0">Supplementary <span> Services</span></h2>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="_boxgray">Holiday: <span id="modal_supplementary_holiday">--</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Special Handling: <span id="modal_supplementary_special_handling">--</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Time Specified: <span id="modal_supplementary_time_specified">--</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="_boxgray">Passport: <span id="modal_supplementary_passport">--</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-3">
                                        <h2 class="_head03 mt-15 border-0">Fuel <span> Charges</span></h2>
                                        <div class="_boxgray">Charges: <span id="modal_fuel"> --</span> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h2 class="_head03 mt-15 border-0">Government <span> Taxes</span></h2>
                                        <div class="_boxgray">GST: <span id="modal_tax"> --</span> </div>
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