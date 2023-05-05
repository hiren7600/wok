@extends('front.layouts.front')

@section('metatag')
    <title>Members</title>
@endsection

@section('content')
<section class="casual-encounters-page mt-5">
    <div class="container-xl">
        <div class="casualencounters-w-wrap">
            <h2 class="castle-rock-title">{{$users->count()}} Members</h2>
            <div class="all-members-area">
                <div class="row g-3">
                    @if (!$users->isEmpty())
                        @foreach ($users as $user)
                        <div class="col-md-6 col-12">

                            <div class="friend-box">
                                <div class="fri-img">
                                    <a href="{{url('/profile/'.$user->user_id)}}">
                                        <img src="{{$user->smallthumbimagefilepath}}" alt="user-img">
                                    </a>
                                </div>
                                <div class="fri-info">
                                    <div class="fri-name">
                                        <a href="{{url('/profile/'.$user->user_id)}}">{{$user->username}}</a>
                                        <span class="age">{{ Carbon\Carbon::parse($user->dob)->age }} {{ $user->gender }}</span>
                                    </div>
                                    <div class="fri-details">
                                        <p><b>Relationship Status:</b> {{$user->relationship_status}}</p>
                                        <p><b>Orientation:</b> {{$user->sexual_orientation}}</p>
                                        <p><b>Location:</b> {{string_explode_implode($user->address)}}</p>
                                        <p><b>Role:</b> {{$user->role}}</p>
                                    </div>
                                </div>
                                <div class="fri-btn">
                                    <a href="{{url('/user-images/'.$user->user_id)}}" class="fri-btn-item">{{$user->userimages()->count()}} Images</a>
                                    <a href="{{url('/user-video/'.$user->user_id)}}" class="fri-btn-item">{{$user->uservideos()->count()}} Videos</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="no-image-bg">
                            <div class="container">
                                <!-- <div class="main-height-wrap"> -->
                                <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                    <div class="no-image-msg-show">
                                        <p>No Users Found</p>
                                    </div>
                                </div>
                                <!-- </div> -->
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

@endsection
