@extends('layouts.master')

@section('data-sidebar')

<div class="row mt-2 mb-3">        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Complaints <span> Suggestions</span></h2>   
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Suggestions</span></a></li>
                <li><span> List</span></li>
            </ol>
        </div>
</div>

<div class="row">
<div class="col-md-12">			    	
            <div class="card">
             <div class="header">
             @if(!Auth::check())
             <a href="complaints-suggestions.html" class="btn add_button"><i class="fa fa-plus"></i> <span>New Suggestion</span></a>
             @endif
             <h2>Suggestions<span> List</span></h2>
             </div>
<div class="body">
        <div style="min-height: 400px" id="dataSidebarLoader" style="">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>		    	 		
{{-- <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
            <thead>
                <tr>
                  <th>Date</th>
                  <th>Subject</th>
                  <th>City</th>
                  <th>Status</th>						   
                  <th>Actions</th>
                </tr>
            </thead>
<tbody> 
            
            <tr>
              <td>7/13/2018</td>
               <td>Delivery not receive</td>
              <td>Lahore</td>
              <td>Pendding</td>
              <td><button  class="btn btn-default">View Detail</button>
          </tr>
            
            <tr>
              <td>7/13/2018</td>
              <td>Delivery not receive</td>
              <td>Lahore</td>
              <td>Processed</td>
              <td><button  class="btn btn-default">View Detail</button>
            </tr>
            
            <tr>
              <td>7/13/2018</td>
              <td>Delivery not receive</td>
              <td>Lahore</td>
              <td>Processed</td>
              <td><button  class="btn btn-default">View Detail</button>
            </tr>
            




    </tbody>
</table> --}}
        
</div>
             
             
            
            </div>

</div>
    

</div>

@endsection