<ul class="sidebar navbar-nav toggled">
     
        @if(Auth::check())
        <li class="nav-item">
             <a class="nav-link" href="/">
                 <img src="/images/icon-dash-board.svg" alt="" />
                 <span>Dashboard</span>
             </a>
         </li>
         <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <img src="/images/icon-organization.svg" alt="" />
                 <span>Organization Management</span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navi-l1">
                 {{-- <a class="dropdown-item" href="/company_profile">Company Profile</a> --}}
                 <a class="dropdown-item" href="/pick_up_and_delivery">Pick Up & Delivery Locations</a>
                 {{-- <a class="dropdown-item" href="/employee_managment">Employee Management</a> --}}
             </div>
         </li>
         
         <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <img src="/images/users-group.svg" alt="" />
                 <span>Client Management</span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navi-l1">
                 <a class="dropdown-item" href="/clients">Clients List</a>
                 {{-- <a class="dropdown-item" href="/Customer">Customer List</a> --}}
                 {{-- <a class="dropdown-item" href="/CustomerTypes">Customer Types</a> --}}
                 {{-- <a class="dropdown-item" href="customer-documents.html">Document List</a>
                 <a class="dropdown-item" href="customer-types-management.html">Document Types</a>
                 <a class="dropdown-item" href="/ProspectCustomers">Prospects List</a>
                 <a class="dropdown-item" href="customer-movement.html">Movement List</a>
                 <a class="dropdown-item" href="churned-list.html">Churned List</a> --}}
             </div>
         </li>
         <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <img src="/images/icon-organization.svg" alt="" />
                 <span>Employees Management</span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navi-l1">
                 <a class="dropdown-item" href="/register">Employees List</a>
                 <a class="dropdown-item" href="/select_employee">Access Rights</a>
             </div>
         </li>
        @endif
             
             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/package-delivery.svg" alt="" />
                     <span>Consignment & Booking</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l1">
                     @if(Auth::check())
                     <a class="dropdown-item" href="/consignment_booking">Consignment & Booking</a>
                     @endif
                     <a class="dropdown-item" href="/consignment_booking_client">Consignment & Booking client</a>
                     <a class="dropdown-item" href="/consignment_booked">Booked List</a>
                 </div>
             </li>
     
             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/comment.svg" alt="" />
                     <span>Complaints & Suggestions</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l1">
                     <a class="dropdown-item" href="/complaints_suggestions">Complaints & Suggestions</a>
                     {{-- <a class="dropdown-item" href="/complaints_list">Complaints List</a> --}}
                     <a class="dropdown-item" href="/complaints_list_client">Complaints List</a>
                     {{-- <a class="dropdown-item" href="/suggestions_list">Suggestions List</a> --}}
                     <a class="dropdown-item" href="/suggestions_list_client">Suggestion List</a>
                 </div>
             </li>
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/icon-inv.svg" alt="" />
                     <span>Product Management</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l2">
                     <a class="dropdown-item" href="#">Product List</a>
                     <a class="dropdown-item" href="#">Add Product</a>
                 </div>
             </li> --}}
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/supplier.svg" alt="" />
                     <span>Supplier Management</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l3">
                     <a class="dropdown-item" href="supplier-orders-list.html">Supplier Orders List</a>
                     <a class="dropdown-item" href="supplier-add.html">Supplier Add</a>
                     <a class="dropdown-item" href="supplier-product-assignment.html">Product Assignment</a>
                 </div>
             </li> --}}
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/icon-ecommerce.svg" alt="" />
                     <span>Order Management</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l4">
                     <a class="dropdown-item" href="shipping-add.html">Shipping</a>
                 </div>
             </li> --}}
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-15" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/credit-card.svg" alt="" />
                     <span>Payment Management</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l5">
                     <a class="dropdown-item" href="#">Payment</a>
                 </div>
             </li> --}}
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-l6" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/icon-categorie.svg" alt="" />
                     <span>Invoices Management</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l6">
                     <a class="dropdown-item" href="#">Invoices</a>
                 </div>
             </li> --}}
             {{-- <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/icon-categorie.svg" alt="" />
                     <span>Login</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l7">
                     <a class="dropdown-item" href="login.html">Login</a>
                 </div>
             </li> --}}
             @if(Auth::check())
             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navi-17" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="/images/icon-categorie.svg" alt="" />
                     <span>Billing</span>
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navi-l7">
                     <a class="dropdown-item" href="/select_customer">Create Billing</a>
                 </div>
             </li>
             @endif
         </ul>