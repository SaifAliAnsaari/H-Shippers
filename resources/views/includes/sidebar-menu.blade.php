<ul class="sidebar navbar-nav toggled">
    <?php
   if(Cookie::get('client_session')){ ?>
   
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/package-delivery.svg" alt="" />
            <span>Consignment & Booking</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            <a class="dropdown-item" href="/consignment_booking_client">New Consignment</a>
            <a class="dropdown-item" href="/consignment_booked">Booked List</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/comment.svg" alt="" />
            <span>Complaints & Suggestions</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            <a class="dropdown-item" href="/complaints_suggestions">Complaints & Suggestions</a>
            <a class="dropdown-item" href="/complaints_list_client">Complaints List</a>
            <a class="dropdown-item" href="/suggestions_list_client">Suggestion List</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-categorie.svg" alt="" />
            <span>Notification Center</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l7">
            <a class="dropdown-item" href="/notification_prefrences">Notification Prefrences</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-categorie.svg" alt="" />
            <span>Download Invoice</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l7">
            <a class="dropdown-item" href="/download_invoice_c">Download</a>
        </div>
    </li>
    <?php }else{
        if(!empty($check_rights)){
            $test_array = array();
            $counter = 0;
            foreach($check_rights as $rights){
                $test_array[$counter] = $rights->access;
                $counter++;
            } ?>

    @if(Auth::check())
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <img src="/images/icon-dash-board.svg" alt="" />
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-organization.svg" alt="" />
            <span>Organization Management</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            @if(in_array("/pick_up_and_delivery", $test_array))
            <a class="dropdown-item" href="/pick_up_and_delivery">Pick Up & Delivery Locations</a>
            @endif
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/users-group.svg" alt="" />
            <span>Client Management</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            @if(in_array("/clients", $test_array))
            <a class="dropdown-item" href="/clients">Clients List</a>
            @endif
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-organization.svg" alt="" />
            <span>Employees Management</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            @if(in_array("/register", $test_array))
            <a class="dropdown-item" href="/register">Employees List</a>
            @endif
            @if(in_array("/select_employee", $test_array))
            <a class="dropdown-item" href="/select_employee">Access Rights</a>
            @endif


        </div>
    </li>
    @endif

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/package-delivery.svg" alt="" />
            <span>Consignment & Booking</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            @if(Auth::check())
            @if(in_array("/consignment_booking", $test_array))
            <a class="dropdown-item" href="/consignment_booking">Consignment & Booking</a>
            @endif
            @endif
            @if(in_array("/consignment_booking_client", $test_array))
            <a class="dropdown-item" href="/consignment_booking_client">Consignment & Booking client</a>
            @endif
            @if(in_array("/pending_consignments", $test_array))
            <a class="dropdown-item" href="/pending_consignments">Booked Consignments</a>
            @endif
            @if(in_array("/confirmed_consignments", $test_array))
            <a class="dropdown-item" href="/confirmed_consignments">Confirmed Consignments</a>
            @endif
            @if(in_array("/consignment_statuses", $test_array))
            <a class="dropdown-item" href="/consignment_statuses">Consignment Statuses</a>
            @endif
            {{-- @if(in_array("/consignment_booked", $test_array))
            <a class="dropdown-item" href="/consignment_booked">Booked List</a>
            @endif --}}
            {{-- @if(in_array("/shipment_tracking", $test_array))
            <a class="dropdown-item" href="/shipment_tracking/pg">Shipment Tracking</a>
            @endif --}}
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/comment.svg" alt="" />
            <span>Complaints & Suggestions</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l1">
            @if(!Auth::check())
            @if(in_array("/complaints_suggestions", $test_array))
            <a class="dropdown-item" href="/complaints_suggestions">Complaints & Suggestions</a>
            @endif
            @endif
            @if(in_array("/complaints_list_client", $test_array))
            <a class="dropdown-item" href="/complaints_list_client">Complaints List</a>
            @endif
            @if(in_array("/suggestions_list_client", $test_array))
            <a class="dropdown-item" href="/suggestions_list_client">Suggestion List</a>
            @endif
        </div>
    </li>

    @if(Auth::check())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-categorie.svg" alt="" />
            <span>Billing</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l7">
            @if(in_array("/select_customer", $test_array))
            <a class="dropdown-item" href="/select_customer">Create Billing</a>
            @endif
            @if(in_array("/select_customer_BA", $test_array))
            <a class="dropdown-item" href="/select_customer_BA">Manage Billing</a>
            @endif
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <img src="/images/icon-categorie.svg" alt="" />
            <span>Notification Center</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navi-l7">
            @if(in_array("/notification_prefrences", $test_array))
            <a class="dropdown-item" href="/notification_prefrences">Notification Prefrences</a>
            @endif
        </div>
    </li>
    @endif

    <?php }
       }
   ?>





</ul>
