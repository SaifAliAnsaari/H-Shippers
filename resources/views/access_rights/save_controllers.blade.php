@extends('layouts.master')
@section('data-sidebar')
<div class="row mt-2 mb-3">        
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Save <span> Controllers</span></h2> 
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Dashboard</span></a></li>
            <li><span>Save Controllers</span></li>
        </ol>
    </div>
</div>

<div class="col-md-12">
    <form id="saveRoute">
    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
    @csrf
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label mb-10">Enter Route*</label>
                    <input type="text" id="route_name" name="route_name" class="form-control" placeholder="" style="font-size: 13px">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label mb-10">Show Up Name*</label>
                    <input type="text" id="show_up_name" name="show_up_name" class="form-control" placeholder="" style="font-size: 13px">
                </div>
            </div>
            <div class="col-md-2"></div>
        </div> 
        <div class="row">
            <button style="position:relative; left:46%; top:15px;" type="button" class="btn btn-primary mr-2 save_btn">Save</button>
        </div>
    </form>
</div>
@endsection