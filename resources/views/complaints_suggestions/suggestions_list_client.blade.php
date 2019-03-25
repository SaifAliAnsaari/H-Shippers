@extends('layouts.master')

@section('data-sidebar')

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-borderRed">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete <span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <p>Are you sure you want to delete?</p>
                </div>

            </div>
            <div class="modal-footer border-0">
                <a id="link_delete_complain"><button type="button" data-dismiss="modal" class="btn btn-primary">Yes</button></a>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>


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