@extends('layouts.master')
@section('data-sidebar')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Settings <span> </span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>User </span></a></li>
            <li><span>Settings</span></li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12 col-12 mb-30">
        <div class="row">

            <div class="body" style="width: 100%">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab01" role="tab"
                            aria-controls="tab01" aria-selected="true">Client Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-toggle="tab" href="#tab02" role="tab" aria-controls="tab02"
                            aria-selected="false">Login Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" data-toggle="tab" href="#tab03" role="tab" aria-controls="tab03"
                            aria-selected="false">Notification Preferences</a>
                    </li>
                </ul>

                <div class="tab-content tab-style" id="myTabContent">

                    <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab1">

                        <div class="form-wrap p-0 _user-profile-info">
                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Company Name</label>
                                        <p>{{ ($name->company_name != '' ? $name->company_name : "--") }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">POC Name</label>
                                        <p>{{ ($name->poc_name != '' ? $name->poc_name : "--") }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">POC Contact#</label>
                                        <p>{{ ($name->phone != '' ? $name->phone : "--") }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Office#</label>
                                        <p>{{ ($name->office_num != '' ? $name->office_num : "--") }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Website</label>
                                        <p>{{ ($name->website != '' ? $name->website : "--") }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Address</label>
                                        <p>{{ ($name->address != '' ? $name->address : "--") }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">NTN</label>
                                        <p>{{ ($name->ntn != '' ? $name->ntn : "--") }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">STRN</label>
                                        <p>{{ ($name->strn != '' ? $name->strn : "--") }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-l">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Customer Type</label>
                                        <p>{{ ($name->customer_type != '' ? $name->customer_type : "--") }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-r">
                                    <div class="form-group">
                                        <label class="control-label mb-10">City</label>
                                        <p>{{ ($name->city != '' ? $name->city : "--") }} </p>
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
                                        <input type="password" class="form-control" placeholder="" value="1234567"
                                            style="font-size: 13px">
                                    </div>
                                </div>
                                <div class="col-md-6 _ch-pass">
                                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample"
                                        role="button" aria-expanded="false" aria-controls="collapseExample">Change
                                        Password </a>

                                </div>



                                <div class="collapse" id="collapseExample">
                                    <div class="col-md-12">

                                        <div id="floating-label" class="card p-20 mb-3 mt-20">
                                            <h2 class="_head03">Change <span>Password</span></h2>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Current Password</label>
                                                        <input type="password" class="form-control required" id="current_pass_client" placeholder=""
                                                            value="" style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">New Password</label>
                                                        <input type="password" class="form-control required" id="new_pass_client" placeholder=""
                                                            value="" style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 _ch-pass-p">
                                                    Minimum 6 Characters
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Confirm Password</label>
                                                        <input type="password" class="form-control required" id="confirm_pass_client" placeholder=""
                                                            value="" style="font-size: 13px">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 PT-10">
                                                    <button type="submit" class="btn btn-primary mr-2 mb-10 change_client_password">Change
                                                        Password</button>
                                                    <button class="btn btn-cancel mr-2 mb-10" type="button"
                                                        data-toggle="collapse" data-target="#collapseExample"
                                                        aria-expanded="false"
                                                        aria-controls="collapseExample">Cancel</button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show " id="tab03" role="tabpanel" aria-labelledby="tab3">


                            <table class="table table-bordered dt-responsive AssNotification" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>General Notification</th>
                                            <th>Email</th>
                                            <th>Web</th>
                                        </tr>
                                    </thead>
                                   
                                    @if(Cookie::get('client_session'))
                                        <tbody id="table_notif_client">
                                            @if(!empty($notifications_codes))
                                                @foreach($notifications_codes as $codes)
                                                    <tr>
                                                        <td>{{ $codes->name }}</td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" name="notification_permissions_client" value="email" id="{{ $codes->code }}" class="check_box_client {{ $codes->code }}">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" name="notification_permissions_client" value="web" id="{{ $codes->code }}" class="check_box_client {{ $codes->code }}">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    @endif
                                </table>
                               

                    </div>


                </div>


            </div>

        </div>

    </div>

</div>

@endsection
