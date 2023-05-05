@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Group Member</title>
    @endif
@endsection

@section('content')
<section class="location-bg">
    <div class="container-xl">
        <div class="custom-container-wrap">
            <div class="castle-rock-box">
                <div class="members-list-in-castle-rock">
                    <div class="row g-3">
                        @foreach ($group_members as $group_member)
                            @if(!empty($group_member->user))
                                <div class="col-md-6 col-12">
                                    <div class="friend-box">
                                        <div class="fri-img">
                                            <a href="{{url('/profile/'.$group_member->user->user_id)}}">
                                                <img src="{{$group_member->user->smallthumbimagefilepath}}" alt="user-img">
                                            </a>
                                        </div>
                                        <div class="fri-info">
                                            <div class="fri-info">
                                                <div class="fri-name">
                                                    <a href="{{url('/profile/'.$group_member->user->user_id)}}">{{$group_member->user->username}}</a>
                                                    <span class="age">{{ Carbon\Carbon::parse($group_member->user->dob)->age }} {{ $group_member->user->gender }}</span>
                                                </div>
                                                <div class="fri-details">
                                                    <p><b>Relationship Status:</b> {{$group_member->user->relationship_status}}</p>
                                                    <p><b>Orientation:</b> {{$group_member->user->sexual_orientation}}</p>
                                                    <p><b>Location:</b> {{string_explode_implode($group_member->user->address)}}</p>
                                                    <p><b>Role:</b> {{$group_member->user->role}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fri-btn">
                                            <a href="{{url('/user-images/'.$group_member->user->user_id)}}" class="fri-btn-item">

                                                {{$group_member->user->userimages()->count()}} Images</a>
                                            <a href="{{url('/user-video/'.$group_member->user->user_id)}}" class="fri-btn-item">{{$group_member->user->uservideos()->count()}} Videos</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')

@endsection
