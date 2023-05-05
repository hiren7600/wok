@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Friends</title>
    @endif
@endsection


@section('content')
    <section class="casual-encounters-page pt-4">
        <div class="container-xxl">
            <div class="casualencounters-w-wrap">
                <div class="friends-header">
                    <div class="friends-header-img">
                        <img src="{{$user->smallthumbimagefilepath}}" alt="{{$user->username}}">
                    </div>
                    <div class="friends-header-text">
                        <h5>{{$user->username}} Friends</h5>
                    </div>
                </div>

                <div class="all-members-area mt-4">
                    <div class="row g-3">
                        @if(!$friends->isEmpty())
                            @foreach($friends as $friend)
                                <?php
                                    $frienduser = null;
                                    if(!empty($friend->fromuser) && $friend->fromuser->user_id == $user->user_id) {
                                        $frienduser = $friend->touser;
                                    }
                                    else {
                                        $frienduser = $friend->fromuser;
                                    }
                                ?>
                                @if(!empty($frienduser))
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
                            @endforeach
                        @else
                            <div class="no-image-bg">
                                <div class="container">
                                    <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                        <div class="no-image-msg-show">
                                            <p>You Don't have Friends.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
    <!-- <script src="{{ asset_front('/js/friend/friend-request.js?ver=' . mt_rand(1000, 9999)) }}"></script> -->
@endsection
