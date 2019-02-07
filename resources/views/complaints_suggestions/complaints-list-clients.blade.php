@extends('layouts.master')

@section('data-sidebar')

<div class="row mt-2 mb-3">        
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Complaints <span> Suggestions</span></h2>   
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Complaints</span></a></li>
            <li><span> List</span></li>
        </ol>
    </div>
</div>

<div class="row">
<div class="col-md-12">			    	
        <div class="card">
         <div class="header">
         <a href="complaints-suggestions.html" class="btn add_button"><i class="fa fa-plus"></i> <span>New Complaint</span></a>
         <h2>Complaints<span> List</span></h2>
         </div>
<div class="body">		    	 		
<table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
        <thead>
            <tr>
              <th>Date</th>
              <th>Subject</th>
              <th>Tracking No</th>
              <th>Status</th>						   
              <th>Actions</th>
            </tr>
        </thead>
<tbody> 
        
        <tr>
          <td>7/13/2018</td>
           <td>Delivery not receive</td>
          <td>03244878787</td>
          <td>Pendding</td>
          <td><button  class="btn btn-default">View Detail</button>
      </tr>
        
        <tr>
          <td>7/13/2018</td>
          <td>Delivery not receive</td>
          <td>03244878787</td>
          <td>Processed</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>
        
        <tr>
          <td>7/13/2018</td>
          <td>Delivery not receive</td>
          <td>03244878787</td>
          <td>Processed</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>
        




</tbody>
</table>
    
</div>
         
         
        
        </div>

</div>


</div>

@endsection