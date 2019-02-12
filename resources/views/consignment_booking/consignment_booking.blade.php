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
         <div class="col-md-12 sm-pb-30">
          <div class="row">					
         
                 <div class="_new-consign-top">
                    <label class="control-label label1">Booking Date:</label>
                    <div class="form-group">
                      <div class="input-append date position-relative" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                    <input type="text" value="12-02-2012" readonly style="font-size: 13px">
                                    <span class="add-on calendar-icon">
                                    <img src="images/calendar-icon.svg" alt=""/> </span> 
                      </div>
                      <style>.datepicker{margin-left: -200px}</style>
                  </div>
                   </div>
     
                  <div class="_new-consign-top">
                    <label class="control-label label2">CNNo:*</label>
                    <input type="text" id="cnno" id="cnic" class="form-control" placeholder="" style="font-size: 13px">				 
                </div>
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
                    <label class="control-label mb-10">Name*</label>
                    <input type="text" id="shipper_name" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
              <div class="col-md-4">
                <div class="form-s2 pt-19">
                          <select class="form-control formselect" placeholder="Select City" id="select_city_shipper">
                            <option value="0">Select City*</option>
                            <option value="lahore">Lahore</option>
                          </select>
                </div>
                </div>
                  

              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Area*</label>
                    <input type="text" id="shipper_area" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Cell#*</label>
                    <input type="number" id="shipper_cell_num" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Land Line#*</label>
                    <input type="number" id="shipper_land_line" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div> 
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Email*</label>
                    <input type="email" id="shipper_email" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="control-label mb-10">Address*</label>
                    <input type="text" id="shipper_address" class="form-control" placeholder="" style="font-size: 13px">
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
                    <input type="text" id="consignee_name" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Consignee Ref#*</label>
                    <input type="text" id="consignee_ref_num" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Consignee Cell#*</label>
                    <input type="number" id="consignee_cell_num" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Email*</label>
                    <input type="email" id="consignee_email" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div> 

                <div class="col-md-8">
                  <div class="form-group">
                    <label class="control-label mb-10">Address*</label>
                    <input type="text" id="consignee_address" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>

              </div>    
              
            </div>
            
          <h2 class="_head03">Consignment <span></span></h2>
          
          <div class="form-wrap pt-0 PB-20">						  		 
              <div class="row">
              
              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Region City*</label>
                    <input type="text" id="consignment_regin_city" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                <div class="form-s2 pt-19">
                          <select class="form-control formselect" placeholder="Services Type" id="service_type">
                            <option value="0">Select Services Type*</option>
                            <option value="1">Services Type 1</option>
                          </select>
                </div>
                </div>
                
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Pieces*</label>
                    <input type="number" id="consignment_pieces" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Weight(Kgs)*</label>
                    <input type="number" id="consignment_weight" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div> 

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Description (Product/Item)*</label>
                    <input type="text" id="consignment_description" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Price*</label>
                    <input type="number" id="consignment_price" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                <div class="row radio_topPD">
                 <div class="col-md-6">					   	
                     <div class="custom-control custom-radio">
                          <input class="custom-control-input consignment_destination" type="radio" name="inlineRadioOptions" id="Domestic" value='valuable' data-id="Domestic">
                          <label class="custom-control-label" for="Domestic">Domestic*</label>
                     </div>					   	
                </div>
                 <div class="col-md-6">					   	
                     <div class="custom-control custom-radio">
                          <input class="custom-control-input consignment_destination" type="radio" name="inlineRadioOptions" id="International" value='valuable' data-id="International">
                          <label class="custom-control-label" for="International">International*</label>
                     </div>					   	
                 </div>
                </div>
                </div> 
                 
                     
              <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label mb-10">Dest.City*</label>
                    <input type="text" id="consignment_dest_city" class="form-control" placeholder="" style="font-size: 13px">
                  </div>
                </div>
                
                <div class="col-md-12">
               <label class="PT-10 font12">Remarks*</label>
                  <div class="form-group">							 
                    <textarea name="description" id="consignment_remarks" rows="8" style="font-size: 13px"></textarea>
                    </div>
                </div>

              </div>    
              
            </div>
            
          <h2 class="_head03">Supplementary Services <span></span></h2>
          
           <div class="row _checkbox-padd">	  

        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Holiday" id="id001">
            <label class="custom-control-label" for="id001">Holiday</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Special Handing" id="id002">
            <label class="custom-control-label" for="id002">Special Handing</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Return Services" id="id003">
            <label class="custom-control-label" for="id003">Return Services</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Hand Carry" id="id004">
            <label class="custom-control-label" for="id004">Hand Carry</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Time Specified" id="id005">
            <label class="custom-control-label" for="id005">Time Specified</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="Green Flyer" id="id006">
            <label class="custom-control-label" for="id006">Green Flyer</label>
          </div>
        </div>
        
        <div class="col-md-3 col-xs-3">
              <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input supplementary_services_admin" name="supplementary_services_admin" value="GreenBox" id="id007">
            <label class="custom-control-label" for="id007">GreenBox</label>
          </div>
        </div>	
                                    
  
        </div>
        
        
   <div class="bottom-btns">

   <button type="button" class="btn btn-primary mr-2 save_consignment_admin">Save</button>
   <button type="button" class="btn btn-cancel">Cancel</button>

    </div>

     
        
        </div></div>
      </form>

</div>


@endsection