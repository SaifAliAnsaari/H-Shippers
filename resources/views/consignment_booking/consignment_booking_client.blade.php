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


<form id="saveConsignmentFormClient">
  {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
  @csrf

    <input hidden type="text" value="" name="hidden_supplementary_services"/>
    <input hidden type="text" value="" name="fragile_cost_hidden" id="fragile_cost_hidden"/>

         <div class="col-md-12 sm-pb-30">
          <div class="row">					
         
                 <div class="_new-consign-top">
                    <label class="control-label label1">Booking Date:</label>
                    <div class="form-group">
                      <div class="input-append date position-relative" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                    <input type="text" value="12-02-2012" readonly name="datepicker" id="datepicker" style="font-size: 13px">
                                    <span class="add-on calendar-icon">
                                    <img src="images/calendar-icon.svg" alt=""/> </span> 
                      </div>
                      <style>.datepicker{margin-left: -200px}</style>
                  </div>
                   </div>
     
                  <div class="_new-consign-top">
                    <label class="control-label label2">CNNo*:</label>
                    <input type="text" id="cnic_client" name="cnic_client" class="form-control required" placeholder="" style="font-size: 13px">				 
                </div>
                
                 <div class="_new-consign-top">
                    <label class="control-label label3">Customer ID:</label>
                    <input type="text" name="customer_id_client" value="<?= $client_id ?>" readonly id="customer_id_client" class="form-control" placeholder="Lhr02154" style="font-size: 13px">				 
                </div>
                
                 <div class="_new-consign-top mr-0">
                    <label class="control-label label4">Region*:</label>
                    <input type="text" name="region_client" id="region_client" class="form-control required" placeholder="Lahore" style="font-size: 13px">				 
                </div>
        </div>
        </div>
        

<div class="row">

<div class="col-md-12">
 <div id="floating-label" class="card p-20 top_border mb-3">
    <img src="/images/loader.gif" width="30px" height="auto" id="loader" style="position: absolute; left: 50%; top: 45%; display:none;">
          <h2 class="_head03">Consignee <span></span></h2>
          <div class="form-wrap pt-0 PB-20">	
                   
              <div class="row">
              
              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Consignee Name*</label>
                    <input type="text" name="consignee_name_client" id="consignee_name_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Consignee Ref#*</label>
                    <input type="text" name="consignee_ref_client" id="consignee_ref_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Consignee Cell#*</label>
                    <input type="number" name="consignee_cell_client" id="consignee_cell_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Email*</label>
                    <input type="email" name="consignee_email_client" id="consignee_email_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div> 

                <div class="col-md-8">
                  <div class="form-group">
                    <label class="control-label mb-10">Address*</label>
                    <input type="text" name="consignee_address_client" id="consignee_address_client" class="form-control required" placeholder="" style="font-size: 13px">
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
                    <input type="text" name="consignment_city_client" id="consignment_city_client" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div> --}}
                <div class="col-md-4">
                  <div class="form-s2 pt-19">
                    <div>
                      <select class="form-control formselect required" placeholder="Consignment Type" name="consignment_type" id="consignment_type">
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
                    <select class="form-control formselect required" placeholder="Services Type" name="consignment_service_type_client" id="consignment_service_type_client">
                      <option value = "0" selected disabled>Services Type*</option>
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
                    <input type="number" id="consignment_pieces_client" name="consignment_pieces_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Weight(Kgs)*</label>
                    <input type="number" name="consignment_weight_client" id="consignment_weight_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div> 

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Description (Product/Item)*</label>
                    <input type="text" name="consignment_description_client" id="consignment_description_client" class="form-control required" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Price*</label>
                    <input type="number" name="consignment_price_client" id="consignment_price_client" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div> --}}

                <div class="col-md-4">
                  <div class="form-s2 pt-19">
                    <div>
                      <select class="form-control formselect required" placeholder="Services Type" name="consignment_dest_city_client" id="consignment_dest_city_client">
                          <option value = "0" selected disabled>Select Destination City*</option>
                          <?php
                            if(!$pickup_city->isEmpty()){
                              foreach($pickup_city as $city){ ?>
                                <option value = "<?= $city->city_name ?>"><?= $city->city_name ?></option>
                              <?php }
                            }
                          ?>
                        </select>
                      </div>
                  </div>
                </div>

                
                <div class="col-md-12">

                      <hr class="mb-2">	

                      <div class="col-md-12">						 		
                          <div class="row mb-10">		
                            <div class="custom-control custom-radio col-md-3 col-xs-3">
                               <input class="custom-control-input insurance_selector" type="radio" name="Fragile_Criteria" id="Fragile" value='For Fragile' data-id="Fragile">
                               <label class="custom-control-label" for="Fragile">For Fragile</label>
                            </div>			 	   	
                             
                            <div class="custom-control custom-radio col-md-3 col-xs-3">
                               <input class="custom-control-input insurance_selector" type="radio" name="Fragile_Criteria" id="Non-Fragile" value='For Non Fragile' data-id="Non-Fragile">
                               <label class="custom-control-label" for="Non-Fragile">For Non Fragile</label>
                            </div>	
                            
                             <div class="custom-control custom-radio col-md-3 col-xs-3">
                               <input class="custom-control-input insurance_selector" type="radio" name="Fragile_Criteria" id="Electronics" value='For Electronics' data-id="Electronics">
                               <label class="custom-control-label" for="Electronics">For Electronics</label>
                            </div>
                            
                            <div class="custom-control custom-radio col-md-3 col-xs-3">
                             <input class="custom-control-input insurance_selector" type="radio" name="Fragile_Criteria" id="none" value='none' data-id="none">
                             <label class="custom-control-label" for="none">None</label>
                          </div>
                            
                           </div>		   			   	
                 
                         </div> 
                      {{-- <div class="row pt-2">
                        <div class="col-md-3">Add Insurance on Consignment?*</div>
                      
                         <div class="RBpadd">
                          <div class="custom-control custom-radio float-left mr-5">
                            <input class="custom-control-input insurance_selector" type="radio" name="inlineRadioOptions" id="Yes" value='1' data-id="Yes">
                            <label class="custom-control-label" for="Yes">Yes</label>
                         </div>			 	   	
                          
                         <div class="custom-control custom-radio float-left">
                            <input class="custom-control-input insurance_selector" type="radio" name="inlineRadioOptions" id="No" value='0' data-id="No">
                            <label class="custom-control-label" for="No">No</label>
                         </div>	
                         </div>	
                         
                      </div> --}}

                      </div>

                      <div class="col-md-12" id="insurance_yes" style="display:none;">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="control-label mb-10">Product Price*</label>
                              <input type="number" id="product_price" name="product_price" class="form-control" placeholder="" style="font-size: 13px">
                            </div>
                        </div>
                        

                        <hr class="mb-2">

                      
                      </div>
                 
                
                <div class="col-md-12">
               <label class="PT-10 font12">Remarks*</label>
                  <div class="form-group">							 
                    <textarea name="remarks_client" id="remarks_client" class="required" rows="8" style="font-size: 13px"></textarea>
                    </div>
                </div>
                

              </div>    
              
            </div>
            
          <h2 class="_head03">Supplementary Services <span></span></h2>
          
           <div class="row _checkbox-padd">	  

        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_client" value="Holiday" id="id001">
            <label class="custom-control-label" for="id001">Holiday</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_client" value="Special Handling" id="id002">
            <label class="custom-control-label" for="id002">Special Handling</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_client" value="Time Specified" id="id003">
            <label class="custom-control-label" for="id003">Time Specified</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_client" value="Passport" id="id004">
            <label class="custom-control-label" for="id004">Passport</label>
          </div>
        </div>
        
        </div>

        <h2 class="_head03 test_total_price">Total Price<span></span></h2>
        
        
   <div class="bottom-btns">

   <button type="button" class="btn btn-primary mr-2 save_consignment_client">Save</button>
   <button type="button" class="btn btn-cancel" id="cancel_btn">Cancel</button>

    </div>

     
        
        </div>
      </div>
      </form>

</div>

@endsection