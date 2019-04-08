<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="author" content="">

    <title>Hashmi Shippers</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/css/select2-bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css?v=1.1.5">
    <link rel="stylesheet" type="text/css" href="/css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="/css/datepicker.css" />
    <style>
        #notifDiv {
            display: none;
            background: red;
            color: white;
            font-weight: 400;
            font-size: 15px;
            width: 350px;
            position: fixed;
            top: 80%;
            left: 5%;
            z-index: 1000;
            padding: 10px 20px
        }

    </style>
</head>

<body id="page-top">

    <div class="overlay"></div>

    <div id="notifDiv">
    </div>

    <div class="container" style="margin-top:10px; text-align:right">
        <button class="btn btn-primary print_consignment_invoice">Print</button>
    </div>

    <div id="print_consignment_invoice_div">
    <div id="wrapper">
        
            <div id="content-wrapper">
                <div class="container">

                    <div class="row mt-2 mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            {{-- <h2 class="_head01">Invoice <span> </span></h2> --}}
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <ol class="breadcrumb">
                                {{-- <li><a href="#"><span>Dashboard</span></a></li>
            <li><span>Invoice</span></li> --}}
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div id="printResult">
                                    <div class="invoice-section">

                                        <table width="100%" class="table table-bordered m-0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">

                                                        <div class="inv_logo"><img src="/images/h-shippers.svg"
                                                                alt="" />
                                                        </div>
                                                        <div class="_barcode">
                                                            <span class="barcode_area"
                                                                style="display: inline-block; margin: 10px 0 0; padding: 5px 10px"
                                                                style="display: inline-block; margin: 10px 0 0; padding: 5px 10px"></span>

                                                            <span
                                                                style="text-align: center; letter-spacing: 10px;">{{ $data->cnic }}</span>
                                                            <h2>CONSIGNEE COPY</h2>
                                                        </div>

                                                    </td>
                                                    <td colspan="2" valign="top" class="p-0 m-0">
                                                        <table width="100%" class="table table-bordered m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Date: </td>
                                                                    <td>{{ $data->booking_date }}</td>
                                                                    <td>Time</td>
                                                                    <td>{{ $data->time }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Service</td>
                                                                    <td>{{ ($data->consignment_service_type == 1 ? "Same Day" : ($data->consignment_service_type == 2 ? "Over Night" : ($data->consignment_service_type == 3 ? "Second Day" : "Over Land"))) }}
                                                                    </td>
                                                                    <td>Weight</td>
                                                                    <td>{{ $data->consignment_weight }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fragile</td>
                                                                    <td>{{ ($data->fragile_cost == 0 || $data->fragile_cost == null ? "NO"
                                                    : $data->fragile_cost) }}</td>
                                                                    <td><strong>Pieces</strong></td>
                                                                    <td><strong>{{ $data->consignment_pieces }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Origin</td>
                                                                    <td>{{ $data->origin_city }}</td>
                                                                    <td>Desitination</td>
                                                                    <td>{{ $data->consignment_dest_city }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        {{ ($data->supplementary_services != "" ? $data->supplementary_services : "NA") }}
                                                                    </td>
                                                                    <td colspan="2">Decld. Ins. Value Rs, NA/-</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Shipper: {{ $data->shipper_name }}<br>
                                                        {{ $data->shipper_address }} </td>
                                                    <td colspan="2">Consignee: {{ $data->consignee_name }}
                                                        {{ $data->consignee_cell }}<br>
                                                        Address: {{ $data->consignee_address }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Customer Ref. #:</td>
                                                    <td width="37%">{{ $data->consignee_ref }}</td>
                                                    <td width="14%">Remarks:</td>
                                                    <td width="34%">{{ $data->remarks }}</td>
                                                </tr>

                                                <tr>
                                                    <td height="110" colspan="4" align="left" valign="top">Product
                                                        Detail: {{
                                    $data->consignment_description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="col-md-12 text-center"><strong>SPECIAL NOTE for CONSIGNEE:</strong>
                                        <strong>(1)</strong>
                                        Please
                                        don’t accept, if shipment is not intact. <strong>(2)</strong> Please don’t open
                                        the
                                        parcel before
                                        payment. <strong>(3)</strong>Incase of any defects/complaints in parcel, please
                                        contact the
                                        shipper/brand. Hashmi Shippers is not responsible for any defect.
                                        <br><strong>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - -
                                            - - - - - - - -
                                            - -
                                            - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - -
                                            - - - - - - - -
                                            - -
                                            - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</strong> </div>

                                    <div class="invoice-section">

                                        <table width="100%" class="table table-bordered m-0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">

                                                        <div class="inv_logo"><img src="/images/h-shippers.svg"
                                                                alt="" />
                                                        </div>
                                                        <div class="_barcode">
                                                            <span class="barcode_area" style="margin-top:20px;"
                                                                style="display: inline-block; margin: 10px 0 0; padding: 5px 10px"></span>
                                                            <span
                                                                style="text-align: center; letter-spacing: 10px;">{{ $data->cnic }}</span>
                                                            <h2>Account's Copy</h2>
                                                        </div>

                                                    </td>
                                                    <td colspan="2" valign="top" class="p-0 m-0">
                                                        <table width="100%" class="table table-bordered m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Date: </td>
                                                                    <td>{{ $data->booking_date }}</td>
                                                                    <td>Time</td>
                                                                    <td>{{ $data->time }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Service</td>
                                                                    <td>{{ ($data->consignment_service_type == 1 ? "Same Day" : ($data->consignment_service_type == 2 ? "Over Night" : ($data->consignment_service_type == 3 ? "Second Day" : "Over Land"))) }}
                                                                    </td>
                                                                    <td>Weight</td>
                                                                    <td>{{ $data->consignment_weight }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fragile</td>
                                                                    <td>{{ ($data->fragile_cost == 0 || $data->fragile_cost == null ? "NO"
                                                    : $data->fragile_cost) }}</td>
                                                                    <td><strong>Pieces</strong></td>
                                                                    <td><strong>{{ $data->consignment_pieces }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Origin</td>
                                                                    <td>{{ $data->origin_city }}</td>
                                                                    <td>Desitination</td>
                                                                    <td>{{ $data->consignment_dest_city }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        {{ ($data->supplementary_services != "" ? $data->supplementary_services : "NA") }}
                                                                    </td>
                                                                    <td colspan="2">Decld. Ins. Value Rs, NA/-</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Shipper: {{ $data->shipper_name }}<br>
                                                        {{ $data->shipper_address }} </td>
                                                    <td colspan="2">Consignee: {{ $data->consignee_name }}
                                                        {{ $data->consignee_cell }}<br>
                                                        Address: {{ $data->consignee_address }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Customer Ref. #:</td>
                                                    <td width="37%">{{ $data->consignee_ref }}</td>
                                                    <td width="14%">Remarks:</td>
                                                    <td width="34%">{{ $data->remarks }}</td>
                                                </tr>

                                                <tr>
                                                    <td height="110" colspan="4" align="left" valign="top">Product
                                                        Detail: {{
                                    $data->consignment_description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                    <div class="col-md-12 text-center"><strong>- - - - - - - - - - - - - - - - - - - - -
                                            - -
                                            - - - - - - -
                                            - -
                                            - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - -
                                            - - - - - - - -
                                            - -
                                            - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - -
                                            - - - -</strong>
                                    </div>

                                    <div class="invoice-section">

                                        <table width="100%" class="table table-bordered m-0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">

                                                        <div class="inv_logo"><img src="/images/h-shippers.svg"
                                                                alt="" />
                                                        </div>
                                                        <div class="_barcode">
                                                            <span class="barcode_area" style="margin-top:20px;"
                                                                style="display: inline-block; margin: 10px 0 0; padding: 5px 10px"></span>
                                                            <span
                                                                style="text-align: center; letter-spacing: 10px;">{{ $data->cnic }}</span>
                                                            <h2>Shipper's Copy</h2>
                                                        </div>

                                                    </td>
                                                    <td colspan="2" valign="top" class="p-0 m-0">
                                                        <table width="100%" class="table table-bordered m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Date: </td>
                                                                    <td>{{ $data->booking_date }}</td>
                                                                    <td>Time</td>
                                                                    <td>{{ $data->time }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Service</td>
                                                                    <td>{{ ($data->consignment_service_type == 1 ? "Same Day" : ($data->consignment_service_type == 2 ? "Over Night" : ($data->consignment_service_type == 3 ? "Second Day" : "Over Land"))) }}
                                                                    </td>
                                                                    <td>Weight</td>
                                                                    <td>{{ $data->consignment_weight }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fragile</td>
                                                                    <td>{{ ($data->fragile_cost == 0 || $data->fragile_cost == null ? "NO"
                                                    : $data->fragile_cost) }}</td>
                                                                    <td><strong>Pieces</strong></td>
                                                                    <td><strong>{{ $data->consignment_pieces }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Origin</td>
                                                                    <td>{{ $data->origin_city }}</td>
                                                                    <td>Desitination</td>
                                                                    <td>{{ $data->consignment_dest_city }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        {{ ($data->supplementary_services != "" ? $data->supplementary_services : "NA") }}
                                                                    </td>
                                                                    <td colspan="2">Decld. Ins. Value Rs, NA/-</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Shipper: {{ $data->shipper_name }}<br>
                                                        {{ $data->shipper_address }} </td>
                                                    <td colspan="2">Consignee: {{ $data->consignee_name }}
                                                        {{ $data->consignee_cell }}<br>
                                                        Address: {{ $data->consignee_address }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Customer Ref. #:</td>
                                                    <td width="37%">{{ $data->consignee_ref }}</td>
                                                    <td width="14%">Remarks:</td>
                                                    <td width="34%">{{ $data->remarks }}</td>
                                                </tr>

                                                <tr>
                                                    <td height="110" colspan="4" align="left" valign="top">Product
                                                        Detail: {{
                                    $data->consignment_description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>

                                <div class="col-md-12 pt-20 text-center" style="margin-bottom:10px;">
                                    {{-- <button style="margin-left:10px;" type="button" class="btn btn-primary mr-2 print_invoices">Print</button> --}}
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/datatables.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/dropify.min.js"></script>
    <script src="/js/form-file-upload-data.js"></script>
    <script src="/js/custom.js"></script>
    <script src="/js/master.js?v=1.1.3"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>
    <script src="/js/chart.bundle.min.js"></script>
    <script src="/js/chartjs.js"></script>

    <script src="/js/echarts-en.min.js"></script>
    <script src="/js/echarts-liquidfill.min.js"></script>
    <script src="/js/dashboard-data.js?v=1.2"></script>
    {{-- <script src="/js/dropzone-amd-module.js"></script>
<script src="/js/dropzone-data.js"></script> --}}
    <script src="/js/dropzone.js"></script>


</body>

</html>
