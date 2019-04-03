@extends('layouts.master')
@section('data-sidebar')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Client <span>Profile</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Client </span></a></li>
            <li><span>Profile</span></li>
        </ol>
    </div>
</div>


<input hidden id="hidden_img_url" value="{{ URL::to('/storage/clients').'/'.($client_data->company_pic) }}" />

<div class="row">
    <div class="col-lg-4 col-12 mb-30">
        <div class="card cp-mh">
            <div class="body">
                <form id="update_client_profile" enctype="multipart/form-data">
                    {!! Form::hidden('employee_updating_id', '') !!}
                    @csrf
                    <input name="id" value="{{ $client_id }}" hidden />
                    <input name="hidden_img" value="{{ $client_data->company_pic }}" hidden />
                    <div class='row'>
                        <div class="_cut-img col-md-12" id="image_div">
                            <img src="{{ ($client_data->company_pic != null ?  URL::to('/storage/clients').'/'.($client_data->company_pic) : '/images/profile-img--.jpg') }}"
                                alt="" />
                        </div>
                        <div class="nam-title col-md-12" id="company_name">
                            {{ ($client_data->company_name != null ? $client_data->company_name : "NA") }}</div>
                    </div>

                    <div class="con_info">
                        <p><i class="fa fa-user"></i><strong
                                id="poc_name">{{ ($client_data->poc_name != null ? $client_data->poc_name : "NA") }}</strong>
                        </p>
                        <p><i class="fa fa-phone-square"></i><strong
                                id="phone_num">{{ ($client_data->office_num != null ? $client_data->office_num : ($client_data->phone != null ? $client_data->phone : "NA")) }}</strong>
                        </p>
                        <p><i class="fa fa-map-marker-alt"></i><span
                                id="address">{{ ($client_data->address != null ? $client_data->address : "NA") }}</span>
                        </p>
                        <a class="btn-primary float-right mt-5 edit_profile_btn"
                            style="color:white !important; cursor:pointer;">Edit </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="col-lg-8 col-12 mb-30">
        <div class="row">

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"> <i class="fa fa-chart-pie"></i> </div>
                    <h5 class="text-muted">Total Bookings</h5>
                    <h3 class="cp-stats-value">{{ ($reports_data ? $reports_data->life_time_consignments : 0) }}</h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"> <i class="fa fa-chart-line"></i> </div>
                    <h5 class="text-muted">Total Revenue</h5>
                    <h3 class="cp-stats-value">Rs.{{ ($reports_data ? number_format($reports_data->life_time_revenue) : 0) }}</h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"> <i class="fa fa-chart-area"></i> </div>
                    <h5 class="text-muted">Avg Rev Per Shipment</h5>
                    <h3 class="cp-stats-value">
                        Rs.{{ ($reports_data ? number_format(Round($reports_data->life_time_revenue / $reports_data->life_time_consignments, 2)) : 0) }}
                    </h3>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"> <i class="fa fa-chart-bar"></i> </div>
                    <h5 class="text-muted">Avg Weight Per Shipment</h5>
                    <h3 class="cp-stats-value">
                        {{ ($reports_data ? number_format(Round($reports_data->total_weight / $reports_data->life_time_consignments, 2)) : 0) }} KG(s)
                    </h3>
                </div>

            </div>

        </div>

    </div>

</div>
<div class="row">



    <div class="col-md-12">

        <div class="body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab01" role="tab"
                        aria-controls="tab01" aria-selected="true">Consignments</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="tab3" data-toggle="tab" href="#tab02" role="tab" aria-controls="tab02"
                        aria-selected="false">Invoices</a>
                </li>
            </ul>
            <div class="tab-content tab-style" id="myTabContent">

                <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab1">

                    <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Month</th>
                                <th>Consignments</th>
                                <th>Amount</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; ?>
                            @if(!empty($month_consignments))
                            @foreach ($month_consignments as $data)
                            <tr>
                                <td>{{ $sno++ }}</td>
                                <td>{{ $data->month_name }}</td>
                                <td>{{ $data->total_consignments }}</td>
                                <td>Rs.{{ number_format($data->amount) }}</td>
                                <td>{{ $data->total_weight }} KG(s)</td>
                                <td>
                                    <a style="color: white !important" id="{{ $data->month_name }}" class="btn btn-default">View Detail</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>

                <div class="tab-pane fade show" id="tab02" role="tabpanel" aria-labelledby="tab2">

                    <table class="table table-hover dt-responsive nowrap" id="poclist" style="width:100% !important">
                        <thead>
                            <tr>
                                <th>POC Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Raheel Khan</td>
                                <td>03224444444</td>
                                <td>info@website.com</td>
                                <td>Manager</td>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-default btn-line">Edit</button>
                                    <button class="btn btn-default">Active</button>
                                    <button class="btn btn-default">Detail</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Raheel Khan</td>
                                <td>03224444444</td>
                                <td>info@website.com</td>
                                <td>Manager</td>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-default btn-line">Edit</button>
                                    <button class="btn btn-default">Active</button>
                                    <button class="btn btn-default">Detail</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Raheel Khan</td>
                                <td>03224444444</td>
                                <td>info@website.com</td>
                                <td>Manager</td>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-default btn-line">Edit</button>
                                    <button class="btn btn-default">Active</button>
                                    <button class="btn btn-default">Detail</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Raheel Khan</td>
                                <td>03224444444</td>
                                <td>info@website.com</td>
                                <td>Manager</td>
                                <td>Admin</td>
                                <td>
                                    <button class="btn btn-default btn-line">Edit</button>
                                    <button class="btn btn-default">Active</button>
                                    <button class="btn btn-default">Detail</button>
                                </td>
                            </tr>




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
