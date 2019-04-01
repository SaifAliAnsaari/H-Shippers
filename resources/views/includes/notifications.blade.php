@extends('layouts.master')
@section('content')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">All <span> Notification</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Notification</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">


            <div class="body">
                  @if(!empty($all_notif))
                        @foreach($all_notif as $notifications)
                              <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                                    <img src="{{ (!$notifications->message ? '' : ($notifications->message == 'New consignment added' || $notifications->message == 'consignment updated' ? '/images/_not-con.svg' : ($notifications->message == 'New suggestion added' ? '/images/_not-suggestions.svg' : ($notifications->message == 'New complain added' ? '/images/_not-complains.svg' : ($notifications->message == 'Consignmnet Completed' ? '/images/_not-process.svg' : '/images/_not-rider.svg' ))))) }}" class="NU-img float-none mb-0" alt="">
                                    <strong class="notifications_list_all" id="{{$notifications->id}}">{{$notifications->notif_by}} </strong> {{ $notifications->message }}
                              </div>
                        @endforeach
                  @endif

               

                {{-- <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                    <img src="images/profile-img.jpg" class="NU-img float-none mb-0" alt="">
                    <strong>Sulman Khan </strong> Add New Customer Add New Customer You should check in on some of
                    those fields below.
                </div>

                <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                    <img src="images/profile-img.jpg" class="NU-img float-none mb-0" alt="">
                    <strong>Sulman Khan </strong> Add New Customer Add New Customer You should check in on some of
                    those fields below.
                </div>

                <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                    <img src="images/profile-img.jpg" class="NU-img float-none mb-0" alt="">
                    <strong>Sulman Khan </strong> Add New Customer Add New Customer You should check in on some of
                    those fields below.
                </div>

                <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                    <img src="images/profile-img.jpg" class="NU-img float-none mb-0" alt="">
                    <strong>Sulman Khan </strong> Add New Customer Add New Customer You should check in on some of
                    those fields below.
                </div> --}}

            </div>

        </div>

    </div>


</div>

@endsection
