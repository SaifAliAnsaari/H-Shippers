@extends('layouts.master')

@section('data-sidebar')

<div class="row mt-2 mb-3">        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Complaints <span> Suggestions</span></h2> 
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Dashboard</span></a></li>
                <li><span>Complaints Suggestions</span></li>
            </ol>
        </div>
</div>
 
 
             <div class="CS-top-sec">

                     <div class="float-left pr-3">Please Specify:</div>	
       
                         <div class="custom-control custom-radio mr-5">
                              <input class="custom-control-input" checked type="radio" name="inlineRadioOptions" id="rb-complaint" value='valuable' data-id="rb-complaint">
                              <label class="custom-control-label" for="rb-complaint">Complaint</label>
                         </div>					   	
            
                         <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" name="inlineRadioOptions" id="rb-suggestione" value='valuable' data-id="rb-suggestione">
                              <label class="custom-control-label" for="rb-suggestione">Suggestion</label>
                         </div>	
     
            </div>
            

<div class="row">
 
    <div class="col-md-12">
     <div id="floating-label" class="card p-20 top_border mb-3">
      
            <form id="saveComplaints">
            {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
            @csrf
            <input name="client_id" id="client_id" value="<?= $client_id ?>" hidden/>
                <h2 class="_head03 header_complaint" style="">Complaint</h2>
                <div class="form-wrap pt-0 PB-20 complaints_div" style="">	
                        
                    <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Name</label>
                            <input type="text" id="name_complaint" name="name_complaint" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Cell#</label>
                            <input type="number" id="cell_complaint" name="cell_complaint" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Email</label>
                            <input type="text" id="email_complaint" name="email_complaint" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Subject</label>
                            <input type="text" id="subject_complaint" name="subject_complaint" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Tracking No</label>
                            <input type="text" id="tracking_no_complaint" name="tracking_no_complaint" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                    <div class="col-md-12">
                    <label class="PT-10 font12">Complaint</label>
                        <div>							 
                            <textarea name="description" id="description_complaint" rows="6"></textarea>
                            </div>
                    </div>
                        
        
                    </div>
                </div>
            </form>
             
            <form id="saveSuggestions">
            {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
            @csrf
            <input name="client_id" id="client_id" value="<?= $client_id ?>" hidden/>
                <h2 class="_head03 header_suggestion" style="display:none;">Suggestion <span></span></h2>
                <div class="form-wrap pt-0 PB-20 suggestions_div" style="display:none;" >	
                        
                    <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Name</label>
                            <input type="text" id="name_suggestions" name="name_suggestions" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Cell#</label>
                            <input type="number" id="call_suggestions" name="cell_suggestions" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Email</label>
                            <input type="text" id="email_suggestions" name="email_suggestions" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                        <div class="form-s2 pt-19">
                                <select class="form-control formselect" name="city_suggestions" style="width:250px;" id="city_suggestions" placeholder="Select City">
                                    <option value="0" selected disabled>Select City</option>
                                    <option value="Lahore">Lahore</option>
                                    <option value="Multan">Multan</option>
                                </select>
                        </div>
                        </div>
                        
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">Subject</label>
                            <input type="text" id="subject_suggestions" name="subject_suggestions" class="form-control" placeholder="" style="font-size: 13px">
                        </div>
                        </div>
                        
                    <div class="col-md-12">
                    <label class="PT-10 font12">Suggestion</label>
                        <div>							 
                            <textarea name="description" id="description_suggestions" rows="6" style="font-size: 13px"></textarea>
                            </div>
                    </div>
                        
        
                        </div>    
                    
                </div>
            </form>
            
       <div class="bottom-btns">

       <button type="submit" class="btn btn-primary mr-2 save_btn">Save</button>
       <button type="submit" class="btn btn-cancel">Cancel</button>

        </div>

         
            
            </div></div>

</div>

@endsection