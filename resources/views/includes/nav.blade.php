<nav class="navbar navbar-expand  static-top">
    <a class="hamburger" href="#" id="sidebarToggle"><i class="fas fa-bars"></i></a>
    <a class="_logo" href="/"><img class="logo-md" src="/images/h-shippers.svg" alt=""/> <img class="logo-xs" src="/images/h-shippers-sm.svg" alt=""/></a>

    
    <ul class="navbar-nav ml-auto top_nav">
            <li class="nav-item TM_icon dropdown no-arrow">
                    {{-- <a hidden href="" id="hidden_link_to_shipment"> </a> --}}
                <a class="nav-link dropdown-toggle" href="#" id="track-id" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/images/search-icon.svg" alt=""/></a>
                    <div class="dropdown-menu track-id" aria-labelledby="track-id">			 
                    <button type="button" id="search_shipment_button" class="btn btn-primary"><img src="/images/search-icon-w.svg" alt=""/></button>
                    <input type="number" class="M_search search_shipment_field" placeholder="Enter Tracking No" style="font-size: 13px">			
                </div>
            </li>
        @if(Auth::user())
        <?php 
         if(!empty($check_rights)){
            $test_array = array();
            $counter = 0;
            foreach($check_rights as $rights){
                $test_array[$counter] = $rights->access;
                $counter++;
            } ?>
            <li class="nav-item TM_icon dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="Qlinks" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ URL::to('/images/q-link-icon.svg') }}" alt=""/></a>
                <div class="dropdown-menu dropdown-menu-right Qlinks" aria-labelledby="Qlinks" style="height:auto; padding-bottom:10px;">
                <h4 class="notiF-title">Quick Actions</h4>
                @if(in_array("/consignment_booking", $test_array))
                    <a href="/consignment_booking"><img src="{{ URL::to('/images/add-new-consignment.svg') }}" alt=""> Add New Consignment</a>
                @endif
                @if(in_array("/pending_consignments", $test_array))
                    <a href="/pending_consignments"><img src="{{ URL::to('/images/book-consignment.svg') }}" alt=""> Booked Consignments</a>
                @endif
                @if(in_array("/invoices_generate", $test_array))
                    <a href="/invoices_generate"><img src="{{ URL::to('/images/invoices-g.svg') }}" alt=""> Generate Invoice</a>
                @endif
                @if(in_array("/paid_invoices", $test_array))
                    <a href="/paid_invoices"><img src="{{ URL::to('/images/paid-inv.svg') }}" alt=""> Paid Invoices</a>
                @endif
                @if(in_array("/register", $test_array))
                    <a href="/register"><img src="{{ URL::to('/images/add-employee.svg') }}" alt=""> Add Employee</a>
                @endif
                </div>
            </li>
            <?php
            }
            ?>
            {{-- <li class="nav-item TM_icon">
                <a class="nav-link" href="#"><img src="/images/settings-icon.svg" alt="" /></a>
            </li> --}}
            
            @csrf
            <li class="nav-item TM_icon dropdown no-arrow"> 
                <a class="nav-link dropdown-toggle" href="#" id="NotiFications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="badge">
                    @if($notifications_counts != "")
                        {{ $notifications_counts->counts }}
                    @endif
                    @if($notifications_counts == "")
                        {{ 0 }}
                    @endif
                </span> <img src="{{ URL::to('/images/bell-icon.svg') }}" alt=""/></a>
                <div class="dropdown-menu dropdown-menu-right notiF" aria-labelledby="NotiFications">
                <h4 class="notiF-title">Notification 
                        <a href="/notifications" class="all-NF">View All ( {{ sizeof($all_notif) }} )</a>
                </h4>
                
                    @if(!empty($notif_data))
                    @foreach($notif_data as $notifications)
                    <a href="#"><img src="{{ (!$notifications->message ? '' : ($notifications->message == 'New consignment added' || $notifications->message == 'consignment updated' ? '/images/_not-con.svg' : ($notifications->message == 'New suggestion added' ? '/images/_not-suggestions.svg' : ($notifications->message == 'New complain added' ? '/images/_not-complains.svg' : ($notifications->message == 'Consignmnet Completed' ? '/images/_not-process.svg' : '/images/_not-rider.svg' ))))) }} " class="NU-img" alt=""><strong class="notifications_list" id="{{$notifications->id}}">{{$notifications->message}} </strong><p>
                        <?php 
                                $datetime1 = new DateTime(date('Y-m-d H:i:s'));//start time
                                $datetime2 = new DateTime($notifications->created_at);//end time
                                $interval = $datetime1->diff($datetime2);
                                echo $interval->format('%d days %H hours %i minutes %s seconds ago');
                            ?>
                    </p></a>
                    @endforeach     
                    @endif
                </div> 
            </li>
        @endif


        
        @if(Cookie::get('client_session'))
            @csrf
            
            <li class="nav-item TM_icon dropdown no-arrow">
                <a class="nav-link" href="/consignment_booking_client" id="" role="button"><img src="/images/add-consignment.svg" alt=""/></a>
            </li>
            <li class="nav-item TM_icon dropdown no-arrow">
                <a class="nav-link" href="/client_settings" id="" role="button"><img src="/images/settings-icon.svg" alt=""/></a>
            </li>
            <li class="nav-item TM_icon dropdown no-arrow"> 
                <a class="nav-link dropdown-toggle" href="#" id="NotiFications_client" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="badge">
                    @if($notifications_counts != "")
                        {{ $notifications_counts->counts }}
                    @endif
                    @if($notifications_counts == "")
                        {{ 0 }}
                    @endif
                </span> <img src="{{ URL::to('/images/bell-icon.svg') }}" alt=""/></a>
                <div class="dropdown-menu dropdown-menu-right notiF" aria-labelledby="NotiFications">
                <h4 class="notiF-title">Notification </h4>
                    @if(!empty($notif_data))
                    @foreach($notif_data as $notifications)
                    <a href="#"><img src="{{ (!$notifications->message ? '' : ($notifications->message == 'New consignment added' || $notifications->message == 'consignment updated' ? '/images/_not-con.svg' : ($notifications->message == 'New suggestion added' ? '/images/_not-suggestions.svg' : ($notifications->message == 'New complain added' ? '/images/_not-complains.svg' : ($notifications->message == 'Consignmnet Completed' ? '/images/_not-process.svg' : '/images/_not-rider.svg' ))))) }} " class="NU-img" alt=""><strong class="notifications_list_client" id="{{$notifications->id}}">{{$notifications->message}} </strong><p>
                        <?php 
                            $datetime1 = new DateTime(date('Y-m-d H:i:s'));//start time
                            $datetime2 = new DateTime($notifications->created_at);//end time
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%d days %H hours %i minutes %s seconds ago');
                            ?>
                    </p></a>
                    @endforeach     
                    @endif
                    <a href="/notifications" class="all-NF">View All ( {{ sizeof($all_notif) }} )</a>
                </div> 
            </li>
        @endif
        
        

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if(Auth::check())
                    <img src="{{ (Auth::user()->picture ? URL::to(Auth::user()->picture) : '/images/profile.jpeg') }}" class="user_log" alt="" />
                @endif
                @if(Cookie::get('client_session'))
                    <img src="{{  ($name->company_pic ? URL::to('/storage/clients/'.$name->company_pic) : '/images/profile.jpeg') }}" class="user_log" alt="" />
                @endif
                
                <span>{{ Auth::check() ? Auth::user()->name : $name->username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <span class="dropdown-item usernamelab">{{ Auth::check() ? Auth::user()->name : "Client Name" }}</span>
                
                <?php
                    if(Auth::check()){ ?>
                        <a class="dropdown-item" href="/edit_profile/{{ Auth::user()->id }}"><i class="fa fa-user"> </i> Profile</a>
                        <a class="dropdown-item" href="/edit_profile/{{ Auth::user()->id }}"><i class="fa fa-cogs"> </i> Settings</a>
                        <a class="dropdown-item" href="/logout"><i class="fa fa-power-off"> </i> Logout</a>
                    <?php }else{ ?>
                        <a class="dropdown-item" href="/cout"><i class="fa fa-power-off"> </i> Logout</a>
                   <?php }
                ?>
                
            </div>
        </li>
    </ul>

</nav>



