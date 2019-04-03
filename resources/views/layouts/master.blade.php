<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="author" content="">

    <title>Hashmi Shippers</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/css/select2-bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css?v=1.1.4">
    <link rel="stylesheet" type="text/css" href="/css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="/css/datepicker.css" />
    <style>
        #notifDiv{
            display: none;
            background: red;
            color:white;
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

    @include('includes.nav')
    <div id="wrapper">
        @include('includes.sidebar-menu')
        
        <div id="content-wrapper">
            @include('includes.alerts')
            <div class="container">
                @yield('data-sidebar')
                @yield('content')
                @include('includes.footer')
            </div>
        </div>
    </div>
    <script src="/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/js/popper.min.js" ></script>
    <script src="/js/bootstrap.min.js" ></script>
    <script src="/js/datatables.min.js" ></script>
    <script src="/js/select2.min.js" ></script>
    <script src="/js/dropify.min.js"></script>
    <script src="/js/form-file-upload-data.js"></script>
    <script src="/js/custom.js" ></script>
    <script src="/js/master.js?v=1.1.3" ></script>
    <script src="/js/jquery.form.min.js" ></script>
    <script src="/js/bootstrap-datepicker.js"></script>
    <script src="/js/chart.bundle.min.js"></script>
    <script src="/js/chartjs.js"></script>

    <script src="/js/echarts-en.min.js"></script>
    <script src="/js/echarts-liquidfill.min.js"></script>
    <script src="/js/dashboard-data.js?v=1.2"></script>
    {{-- <script src="/js/dropzone-amd-module.js"></script>
    <script src="/js/dropzone-data.js"></script> --}}
    <script src="/js/dropzone.js"></script>

    {{-- <form action="/test-upload" class="dropzone" id="dropzonewidget" method="POST" enctype="multipart/form-data">
        @csrf
    </form>  --}}
    

    @if($controller == "Customer")
        <script src="/js/custom/customer.js?v=2.3.0" ></script>
    @elseif($controller == "CustomerTypes")
        <script src="/js/custom/customer-types.js?v=2.3.0" ></script>
    @elseif($controller == "RegisterController")
        <script src="/js/custom/employee.js?v=2.3.0" ></script>
    @elseif($controller == "Clients")
        <script src="/js/client/clients.js?v=2.3.3" ></script>
    @elseif($controller == "OrganizationManagement")
        <script src="/js/manage_organization/manage_organization.js?v=2.3.1" ></script>
    @elseif($controller == "ManageBilling")
        <script src="/js/manage_billing/manage_billing.js?v=2.3.0" ></script>
    @elseif($controller == "ClientsForBilling")
        <script src="/js/manage_billing/customers_for_biling.js?v=2.3.1" ></script>
    @elseif($controller == "ComplaintsAndSuggestions")
        <script src="/js/manage_complaints_suggestions/complaints_suggestions.js?v=2.3.0" ></script>
    @elseif($controller == "ConsignmentManagement")
        <script src="/js/manage_consignment/consignment.js?v=2.3.8" ></script>
    @elseif($controller == "AccessRights")
        <script src="/js/access_rights/access_rights.js?v=2.3.0" ></script>
    @elseif($controller == "HomeController")
        <script src="/js/notif_pref/notif_pref.js?v=2.3.0" ></script>
    @endif

    <script type="text/javascript"></script>

</body>

</html>