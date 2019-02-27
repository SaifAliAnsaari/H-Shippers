<nav class="navbar navbar-expand  static-top">
    <a class="hamburger" href="#" id="sidebarToggle"><i class="fas fa-bars"></i></a>
    <a class="_logo" href="/"><img src="/images/h-shippers.svg" alt="" /></a>

    
    <ul class="navbar-nav ml-auto top_nav">
        @if(Auth::user())
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
                   <a href="#"><img src="{{ URL::to('/storage/clients').'/'.$notifications->picture}}" class="NU-img" alt=""><strong class="notifications_list" id="{{$notifications->id}}">{{$notifications->message}} </strong><p>
                       <?php 
                            
                            // $date2 = $notifications->created_at;   
                            // $date = new DateTime($date2);
                            // $now = new DateTime();
                            // echo $date->diff($now)->format("%d days, %h hours and %i minuts and %s seconds ago");

                            $datetime1 = new DateTime(date('Y-m-d H:i:s'));//start time
                            $datetime2 = new DateTime($notifications->created_at);//end time
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%d days %H hours %i minutes %s seconds ago');
                        ?>
                   </p></a>
                   @endforeach     
                @endif
               {{-- <a href="#"><img src="images/profile-img.jpg" class="NU-img" alt=""><strong>Usman Khan CVR has been generated </strong><p>5 minutes ago</p></a>
               <a href="#"><img src="images/profile-img.jpg" class="NU-img" alt=""><strong>Sulman Khan Add New Customer Add New Customer</strong><p>5 minutes ago</p></a>
               <a href="#"><img src="images/profile-img.jpg" class="NU-img" alt=""><strong>New user registered</strong><p>5 minutes ago</p></a>
               <a href="#"><img src="images/profile-img.jpg" class="NU-img" alt=""><strong>New user registered</strong><p>5 minutes ago</p></a> --}}
               <a href="/notifications" class="all-NF">View All</a>
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



