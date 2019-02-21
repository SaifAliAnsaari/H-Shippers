@extends('layouts.master')


@section('content')
<div id="content-wrapper">

        <div class="container">     
           
        <div class="row mt-2 mb-3">        
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="_head01">User <span>Profile</span></h2>
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><a href="#"><span>User </span></a></li>
						<li><span>Profile</span></li>
					</ol>
				</div>
		</div>
		 
		
		<div class="row">
		<div class="col-lg-4 col-12 mb-30">			    	
		<div class="card cp_user-l top_border">
 		<div class="body">
 		<div class="_cut-img mt-30" ><img src="{{ URL::to(Auth::user()->picture) }}" alt=""/>
            <div class="nam-title">{{ (Auth::user()->name != null ? Auth::user()->name : "NA") }}</div> 		
            </div>
            
            <div class="con_info lineHeight30">
            <p><i class="fa fa-user"></i><strong>{{ (Auth::user()->designation == 1 ? "Admin" : (Auth::user()->designation == 2 ? "Manager" : (Auth::user()->designation == 3 ? "Salesman" : (Auth::user()->designation == 4 ? "Rider" : "Cashier" )))) }} </strong></p>
            <p><i class="fa fa-phone-square"></i><strong>{{ (Auth::user()->phone != null ? Auth::user()->phone : "NA") }}</strong></p>
            <p><i class="fa fa-envelope-square"></i>{{ (Auth::user()->email != null ? Auth::user()->email : "NA") }}</p>
            <p><i class="fa fa-globe"></i>{{ (Auth::user()->city != null ? Auth::user()->city : "NA") }}</p>
            
            </div>				
		</div>
		</div>
		
		</div>
		
		<div class="col-lg-8 col-12 mb-30">			    	
		<div class="row">
		
	<div class="body" style="width: 100%">		    	 		
		
		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item">
			<a class="nav-link active" id="tab1" data-toggle="tab" href="#tab01" role="tab" aria-controls="tab01" aria-selected="true">Info</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="tab2" data-toggle="tab" href="#tab02" role="tab" aria-controls="tab02" aria-selected="false">Setting</a>
		  </li>
		</ul>
		<div class="tab-content tab-style" id="myTabContent">
	  
		  <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab1">
		  
		 <div class="form-wrap p-0 _user-profile-info">			 
						  <div class="row">
							<div class="col-md-6 p-col-L">
							  <div class="form-group">
								<label class="control-label mb-10">Full Name</label>
								<p>{{ (Auth::user()->name != null ? Auth::user()->name : "NA") }}</p>
							  </div>
							</div>
							<div class="col-md-6 p-col-R">
							  <div class="form-group">
								<label class="control-label mb-10">Phone No</label>
								<p>{{ (Auth::user()->phone != null ? Auth::user()->phone : "NA") }}</p>
							  </div>
							</div>
						  </div>
						  
						  <div class="row">
							<div class="col-md-6 p-col-L">
							  <div class="form-group">
								<label class="control-label mb-10">Email ID</label>
								<p>{{ (Auth::user()->email != null ? Auth::user()->email : "NA") }}</p>
							  </div>
							</div>
							<div class="col-md-6 p-col-R">
							  <div class="form-group">
								<label class="control-label mb-10">CNIC No</label>
								<p>{{ (Auth::user()->cnic != null ? Auth::user()->cnic : "NA") }}</p>
							  </div>
							</div>
						  </div> 
						  
						  <div class="row">
							<div class="col-md-6 p-col-L">
							  <div class="form-group">
								<label class="control-label mb-10">City</label>
								<p>{{ (Auth::user()->city != null ? Auth::user()->city : "NA") }}</p>
							  </div>
							</div> 
 
							<div class="col-md-6 p-col-R">
							  <div class="form-group">
								<label class="control-label mb-10">Address</label>
								<p>{{ (Auth::user()->address != null ? Auth::user()->address : "NA") }}</p>
							  </div>
							</div>
						  </div>
			 
					      <div class="row">
							<div class="col-md-6 p-col-L">
							  <div class="form-group">
								<label class="control-label mb-10">Designation</label>
								<p>{{ (Auth::user()->designation == 1 ? "Admin" : (Auth::user()->designation == 2 ? "Manager" : (Auth::user()->designation == 3 ? "Salesman" : (Auth::user()->designation == 4 ? "Rider" : "Cashier" )))) }}</p>
							  </div>
							</div> 
 
							<div class="col-md-6 p-col-R">
							  <div class="form-group">
								<label class="control-label mb-10">Reporting To</label>
								<p>{{ (Auth::user()->reporting_to == 1 ? "Admin" : (Auth::user()->reporting_to == 2 ? "Manager" : (Auth::user()->reporting_to == 3 ? "Salesman" : (Auth::user()->reporting_to == 4 ? "Rider" : "Cashier" )))) }}</p>
							  </div>
							</div>
			 
						  </div>   
						 
						  </div>
		  
		  </div>
		  
		  <div class="tab-pane fade show" id="tab02" role="tabpanel" aria-labelledby="tab2">
		   <div class="form-wrap p-0">			 
						  <div class="row">

							  <div class="col-md-6">
							  <div class="form-group">
								<label class="control-label mb-10">Password</label>
								<input type="password" class="form-control" placeholder=""  disabled value="12345"> 
							  </div>
							  </div>
							  <div class="col-md-6 _ch-pass">							  
								 <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Change Password </a>
						 
							  </div>
							  
					
                    <form style="display: flex; width:100%" id="saveEditProfileForm">
                    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                    @csrf	
                    <input type="text" hidden name="user_id" value="{{ Auth::user()->id  }}"/>
					    <div class="collapse" id="collapseExample">
                            <div class="col-md-12">						
                            
                            <div id="floating-label" class="card p-20 mb-3 mt-20">
                            <h2 class="_head03">Change <span>Password</span></h2>
                            
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Current Password*</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder=""  value=""> 
                                </div>
                            </div>
                                <div class="col-md-12"><hr></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">New Password*</label>
                                    <input type="password" class="form-control" id="new_password" placeholder=""  value=""> 
                                </div>
                            </div>
                            <div class="col-md-6 _ch-pass-p">
                                Minimum 6 Characters 	 
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Confirm Password*</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder=""  value=""> 
                                </div>
                            </div>	
                            <div class="col-md-12 PT-10">
                                    <button type="button" class="btn btn-primary mr-2 mb-10" id="save_changes_userProfile">Save Changes</button>
                                    <button class="btn btn-cancel mr-2 mb-10" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Cancel</button>
                                </div>
                        
                            </div>
                                
                            </div>
                        
                            </div>
                            <div class="col-md-6">
                                <div class="form-wrap up_h">
                                <div class="upload-pic"></div>
                                    <input type="file" id="input-file-now" class="dropify" name="employeePicture" data-default-file="{{ URL::to(Auth::user()->picture) }}" />
                                </div> 
                            </div> 

                            


                        </div>
                    </form>
							
							 			  
 
						  </div>
					  </div>
		  </div>
 
 
		</div>

				
		</div>
            
		</div>
		
		</div>
		
		</div>
@endsection