@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Friend Requests</title>
    @endif
@endsection


@section('content')
    <section class="all-friends-bg">
        <div class="container-xl">
            <div class="friends-w-box">
                <h1 class="friend-page-title">Friend requests</h1>
                <div class="row g-3">
                    @if(!$friends->isEmpty())
                        @foreach($friends as $friend)
                        <div class="col-md-6 col-12 friend-item friend{{$friend->fromuser->user_id}}" data-from_user_id="{{$friend->fromuser->user_id}}">
                            <div class="friend-box">
                                <div class="fri-img">
                                    <a href="{{url('/profile/'.$friend->fromuser->user_id)}}">
                                        <img src="{{$friend->fromuser->mediumthumbimagefilepath}}" alt="{{$friend->fromuser->username}}">
                                    </a>
                                </div>
                                <div class="fri-info">
                                    <div class="fri-name">
                                        <a href="{{url('/profile/'.$friend->fromuser->user_id)}}">{{$friend->fromuser->username}}</a>
                                        <span class="age">{{ Carbon\Carbon::parse($friend->fromuser->dob)->age }}{{ $friend->fromuser->gender }}</span>
                                    </div>
                                    <div class="fri-details">
                                        <p><b>Status:</b> {{$friend->fromuser->relationship_status}}</p>
                                        <p><b>Orientation:</b> {{$friend->fromuser->sexual_orientation}}</p>
                                        <p><b>Location:</b> {{$friend->fromuser->address}}</p>
                                    </div>
                                </div>
                                <div class="fri-btn">
                                    <button type="button" class="fri-btn-item approve-btn">Approve</button>
                                    <button type="button" class="fri-btn-item decline-btn">Decline</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-12">
                        <h5>No Pending Request.</h5>
                    </div>
                    @endif

                </div>

                <h1 class="friend-page-title">Your Friends</h1>

                <div class="all-members-area mt-4">
                    <div class="row g-3">
                        @if(!$friendslist->isEmpty())
                        @foreach($friendslist as $friend)
                                @if (!empty($friend->fromuser))
                                    <?php
                                        $frienduser = null;
                                        if($friend->fromuser->user_id ==  $globaldata['user']->user_id) {
                                            $frienduser = $friend->touser;
                                        }
                                        else {
                                            $frienduser = $friend->fromuser;
                                        }
                                    ?>
                                    @if (!empty($frienduser->user_id))
                                        <div class="col-md-6 col-12">
                                            <div class="friend-box">
                                                <div class="fri-img">

                                                    <a href="{{url('/profile/'.$frienduser->user_id)}}">
                                                        <img src="{{$frienduser->mediumthumbimagefilepath}}" alt="{{$frienduser->username}}">
                                                    </a>
                                                </div>
                                                <div class="fri-info">
                                                    <div class="fri-name">
                                                        <a href="{{url('/profile/'.$frienduser->user_id)}}">{{$frienduser->username}}</a>
                                                        <span class="age">{{ Carbon\Carbon::parse($frienduser->dob)->age }}{{ $frienduser->gender }}</span>
                                                    </div>
                                                    <div class="fri-details">
                                                        <p><b>Relationship Status:</b> {{$frienduser->relationship_status}}</p>
                                                        <p><b>Orientation:</b> {{$frienduser->sexual_orientation}}</p>
                                                        <p><b>Location:</b> {{$frienduser->address}}</p>
                                                        <p><b>Role:</b> {{$frienduser->role}}</p>
                                                    </div>
                                                </div>
                                                <div class="fri-btn">
                                                    <a href="{{url('/user-images/'.$frienduser->user_id)}}" class="fri-btn-item">{{$frienduser->userimages()->count()}} Images</a>
                                                    <a href="{{url('/user-video/'.$frienduser->user_id)}}" class="fri-btn-item">{{$frienduser->uservideos()->count()}} Videos</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                        
                        @endforeach
                        @endif
                    </div>
                </div>
                <!-- <a href="#" class="continue-page">Next Page</a> -->
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/friend/friend-request.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
