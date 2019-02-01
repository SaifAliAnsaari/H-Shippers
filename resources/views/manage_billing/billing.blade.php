@extends('layouts.master')

@section('data-sidebar')

<div id="content-wrapper">

    <div class="container">     
       
    <div class="row mt-2 mb-3">        
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2 class="_head01">Service	 <span> Charges	For	Domestic Courier</span></h2>
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
                
                <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              
                  <a class="nav-link active" id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01" role="tab" aria-controls="v-pills-01" aria-selected="true">Start Date</a>
                  <a class="nav-link" id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab" aria-controls="v-pills-02" aria-selected="false">Same Day Delivery Rate</a>
                  <a class="nav-link" id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab" aria-controls="v-pills-03" aria-selected="false">Over <span> Night Delivery</a>
                  <a class="nav-link" id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab" aria-controls="v-pills-04" aria-selected="false">Second Day Delivery</a>
                  <a class="nav-link" id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab" aria-controls="v-pills-05" aria-selected="false">Over Land Service</a>
                  <a class="nav-link" id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab" aria-controls="v-pills-06" aria-selected="false">Fragile Items Cost</a>
                  <a class="nav-link" id="v-pills-07-tab" data-toggle="pill" href="#v-pills-07" role="tab" aria-controls="v-pills-07" aria-selected="false">Insurance on Consignment </a>
                  <a class="nav-link" id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab" aria-controls="v-pills-08" aria-selected="false">Supplementary Services</a>
                  <a class="nav-link" id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab" aria-controls="v-pills-09" aria-selected="false">Fuel Charges</a>
                  <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab" aria-controls="v-pills-10" aria-selected="false">Government Taxes</a>
                  <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab" aria-controls="v-pills-11" aria-selected="false">Contract Copy</a>
                </div> 
                </div>
                
                
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
                            <label class="PT-10 font12">Start Date</label>
                              <div class="form-group" style="height: auto">
                            <input type="text" id="datepicker" class="form-control" placeholder="" style="font-size:13px">
                            </div>
                           </div>

                             
                               
                               
                          </div>	
                          
              <div class="row m-0 PT-30">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="with_in_city_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="with_in_city_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="with_in_city_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="with_in_city_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div>

                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Within <span> Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="with_in_province_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="with_in_province_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="with_in_province_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="with_in_province_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Province <span> to Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="prov_to_prov_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="prov_to_prov_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="prov_to_prov_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="prov_to_prov_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div> 
                            
                          </div>	
                                                
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
              </div>
                                                    
                        </div>
                      </div>
                    </div>
              
                  </div>
                  
              </div>
              
              <div class="tab-pane fade" id="v-pills-03" role="tabpanel" aria-labelledby="v-pills-03-tab">
                 
                   <div class="tab-pane fade show active" id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                
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
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="with_in_city_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="with_in_city_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="with_in_city_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="with_in_city_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div>

                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Within <span> Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="with_in_prov_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="with_in_prov_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="with_in_prov_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="with_in_prov_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Province <span> to Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.25 KGs</label>
                                <input type="text" id="provience_to_prov_twentyfive" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	0.50 KGs</label>
                                <input type="text" id="provience_to_prov_fifty" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" id="provience_to_prov_six" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" id="provience_to_prov_additional" class="form-control" style="font-size:13px">
                              </div>
                            </div> 
                            
                          </div>	
                                                
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <label class="control-label mb-10">Upto	3 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 1 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                             
                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Province <span> to Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	3 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 1 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">0.6-1 KG</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div> 
                            
                          </div>	
                                                
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                              <h2 class="_head04">Over <span>  Land Service</span></h2>
                            </div> 
                      
                             <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Within <span> Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto	10 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional	1 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div>
                             
                            <div class="col-md-12 pt-10 mb-10">
                              <h2 class="_head04">Province <span> to Province</span></h2>
                            </div>
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Upto 10 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div> 
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label mb-10">Each	Additional 0.5 KGs</label>
                                <input type="text" class="form-control" style="font-size:13px">
                              </div>
                            </div> 
        
                              
                          </div>	 
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <div  class="form-group">
                                  <label class="control-label mb-10">Cost</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                          </div>	
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <div  class="form-group">
                                  <label class="control-label mb-10">For Fragile</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                              
                              <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">For Non Fragile</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                              
                              <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">For Electronics</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div> 
                      
                          </div>	
                          
             <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                              <h2 class="_head04">Supplementary	<span> Services</span></h2>
                            </div> 
                      
                               <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">Holiday</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                          
                           <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">Special Handling</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                          
                           <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">Time Specified</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                          
                           <div class="col-md-6">
                                <div  class="form-group">
                                  <label class="control-label mb-10">Passport</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div> 
                              
                          </div>	
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <div  class="form-group">
                                  <label class="control-label mb-10">Fuel Charges</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                              
                          </div>	
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                                <div  class="form-group">
                                  <label class="control-label mb-10">GST</label>
                                  <input type="text" class="form-control" style="font-size:13px">
                                </div>
                              </div>
                              
                          </div>
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveCurrentData">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
              </div>
              
                       
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
                                                <form action="#" class="dropzone" id="my-awesome-dropzone">
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple />
                                                    </div>
                                                </form>
                                            </div>
                                </div>  
                              
                          </div>
                          
              <div class="row m-0 PT-15">
              <button type="submit" class="btn btn-primary mr-2 saveWholeForm">Save</button>
              <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
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
                    <div class="CBR_value"><strong>Rates:</strong> 2500</div>
                    <div class="CBR_value"><strong>Billing:</strong> 2500</div>
                    <div class="CBR_value"><strong>Assets Amount:</strong> 3500</div>
                    <div class="CBR_value"><strong>Rates:</strong> 2500</div>
                    <div class="CBR_value"><strong>Rates:</strong> 2500</div>
                </div>	
                </div>			 

                </div>	
                        
                </div>
    
    </div>
        
 
    </div>

  </div>
 

</div>

@endsection