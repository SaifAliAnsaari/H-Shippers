@extends('layouts.master')

@section('content')

@if(Auth::check())
<div class="row m-t-30">
    <div class="col-md-12 align-center">
        <h1 class="dash-heading"><strong>H Shippers</strong></h1>
        <h4 class="dash-sm-heading">We Are A One-Stop Cost-Effective Delivery Solution.</h4>
    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/emp-m-icon.svg" alt=""></span>
            <strong>Employee</strong> Management
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/courier.svg" alt=""></span>
            <strong>Consignment</strong> & Booking
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/client-management.svg" alt=""></span>
            <strong>Client</strong> Management
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/cod-pay.svg" alt=""></span>
            <strong>COD Payment</strong> Tracking
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/complain-icon.svg" alt=""></span>
            <strong>Complaints</strong> & Suggestions
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/analytics.svg" alt=""></span>
            <strong>Reports</strong> Management
        </a>
    </div>
</div>
@endif

@if(Cookie::get('client_session'))
<div class="row m-t-30">
    <div class="col-md-12 align-center">
        <h1 class="dash-heading"><strong>H Shippers</strong></h1>
        <h4 class="dash-sm-heading">We Are A One-Stop Cost-Effective Delivery Solution.</h4>
    </div>

</div>


<div class="row">
    <div class="col-md-4">
        <a href="/consignment_booking_client" class="box-sec">
            <span class="img-svg"><img src="/images/creat-con-icon.svg" alt=""></span>
            <strong>Create</strong> Consignment
        </a>
    </div>

    <div class="col-md-4">
        <a href="/consignment_booked" class="box-sec">
            <span class="img-svg"><img src="/images/courier.svg" alt=""></span>
            <strong>Booked</strong> Consignment
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/invoices-icon.svg" alt=""></span>
            <strong>Invoices </strong> & Payments
        </a>
    </div>

    <div class="col-md-4">
        <a href="#" class="box-sec">
            <span class="img-svg"><img src="/images/analytics.svg" alt=""></span>
            <strong>Reports</strong>
        </a>
    </div>

    <div class="col-md-4">
        <a href="/complaints_suggestions" class="box-sec">
            <span class="img-svg"><img src="/images/complain-icon.svg" alt=""></span>
            <strong>Complaints</strong> & Suggestions
        </a>
    </div>

    <div class="col-md-4">
        <a href="/client_settings" class="box-sec">
            <span class="img-svg"><img src="/images/cont-setting.svg" alt=""></span>
            <strong>Settings</strong>
        </a>
    </div>




</div>
@endif

@endsection
