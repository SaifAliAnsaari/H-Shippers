@extends('layouts.master')

@section('data-sidebar')



<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Consignments <span> & Booking</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Consignments</span></a></li>
            <li><span> Booked List</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Booked<span> List</span></h2>
            </div>
            <div class="body">
                <div style="min-height: 400px" id="dataSidebarLoader" style="">
                    <img src="/images/loader.gif" width="30px" height="auto"
                        style="position: absolute; left: 50%; top: 45%;">
                </div>
                {{-- <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
        <thead>
            <tr>
              <th>CNNo.</th>
              <th>Booking Date</th>
              <th>Sender’s</th>
              <th>Phone</th>
              <th>Area</th>
              <th>Receiver's</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>
        </thead>
<tbody>

        <tr>
          <td>0721</td>
          <td>7/13/2018</td>
          <td>Ali Zafar</td>
          <td>03244878787</td>
          <td>Town Ship Area</td>
          <td>Shahroze Khan</td>
          <td>03244878787</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>
        
        <tr>
          <td>0721</td>
          <td>7/13/2018</td>
          <td>Ali Zafar</td>
          <td>03244878787</td>
          <td>Town Ship Area</td>
          <td>Shahroze Khan</td>
          <td>03244878787</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>
        
        <tr>
          <td>0721</td>
          <td>7/13/2018</td>
          <td>Ali Zafar</td>
          <td>03244878787</td>
          <td>Town Ship Area</td>
          <td>Shahroze Khan</td>
          <td>03244878787</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>
        
        <tr>
          <td>0721</td>
          <td>7/13/2018</td>
          <td>Ali Zafar</td>
          <td>03244878787</td>
          <td>Town Ship Area</td>
          <td>Shahroze Khan</td>
          <td>03244878787</td>
          <td><button  class="btn btn-default">View Detail</button>
        </tr>



</tbody>
</table> --}}

            </div>



        </div>

    </div>


</div>

@endsection
