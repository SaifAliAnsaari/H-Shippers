<nav class="navbar navbar-expand  static-top">
    <a class="hamburger" href="#" id="sidebarToggle"><i class="fas fa-bars"></i></a>
    <a class="_logo" href="/"><img class="logo-md" src="/images/h-shippers.svg" alt=""/> <img class="logo-xs" src="/images/h-shippers-sm.svg" alt=""/></a>

    
    <ul class="navbar-nav ml-auto top_nav">
            @if(Auth::user())
        <li class="nav-item TM_icon dropdown no-arrow">
                {{-- <a hidden href="" id="hidden_link_to_shipment"> </a> --}}
            <a class="nav-link dropdown-toggle" href="#" id="track-id" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/images/search-icon.svg" alt=""/></a>
                <div class="dropdown-menu track-id" aria-labelledby="track-id">			 
                <button type="button" id="search_shipment_button" class="btn btn-primary"><img src="/images/search-icon-w.svg" alt=""/></button>
                <input type="number" class="M_search search_shipment_field" placeholder="Enter Tracking No" style="font-size: 13px">			
            </div>
        </li>

       
        <li class="nav-item TM_icon dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="Qlinks" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ URL::to('/images/q-link-icon.svg') }}" alt=""/></a>
             <div class="dropdown-menu dropdown-menu-right Qlinks" aria-labelledby="Qlinks">
              <h4 class="notiF-title">Quick Actions</h4>
              <a href="#"><img src="{{ URL::to('/images/graph.svg') }}" alt=""> Add New CVR</a>
              <a href="#"><img src="{{ URL::to('/images/add-report.svg') }}" alt=""> CVR List</a>
              <a href="#"><img src="{{ URL::to('/images/employee-list.svg') }}" alt=""> Employee List</a>
              <a href="#"><img src="{{ URL::to('/images/customer-list.svg') }}" alt=""> Customer List</a>
            </div>
          </li>
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
               <h4 class="notiF-title">Notification </h4>
                @if(!empty($notif_data))
                   @foreach($notif_data as $notifications)
                   <a href="#"><img src="{{ $notifications->picture != null ? URL::to('/storage/clients').'/'.$notifications->picture : '/images/profile-img--.jpg'}} " class="NU-img" alt=""><strong class="notifications_list" id="{{$notifications->id}}">{{$notifications->message}} </strong><p>
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
                <img src="{{ Auth::check() ? URL::to(Auth::user()->picture) : URL::to('/storage/clients/'.$name->company_pic) }}" class="user_log" alt="" />
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



