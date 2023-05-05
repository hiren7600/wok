@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Kink member</title>
    @endif
@endsection

@section('content')
<section class="location-bg">
    <div class="container-xl">
        <div class="custom-container-wrap">
            <div class="castle-rock-box">
                <div class="members-list-in-castle-rock">
                    <div class="row g-3">
                        @foreach ($kink_members as $kink_member)
                            @foreach ($kink_member as $kink_member_data)
                                @if(!empty($kink_member_data->kinkmembers))
                                    <div class="col-md-6 col-12">
                                        <div class="friend-box">
                                            <div class="fri-img">
                                                <a href="{{url('/profile/'.$kink_member_data->kinkmembers->user_id)}}">
                                                    <img src="{{$kink_member_data->kinkmembers->smallthumbimagefilepath}}" alt="user-img">
                                                </a>
                                            </div>
                                            <div class="fri-info">
                                                <div class="fri-name">
                                                    <a href="{{url('/profile/'.$kink_member_data->kinkmembers->user_id)}}">kink</a>
                                                    <span class="age">{{ Carbon\Carbon::parse($kink_member_data->kinkmembers->dob)->age }} {{ $kink_member_data->kinkmembers->gender }}</span>
                                                </div>
                                                <div class="fri-details">
                                                    <p><b>Relationship Status:</b> {{$kink_member_data->kinkmembers->relationship_status}}</p>
                                                    <p><b>Orientation:</b> {{$kink_member_data->kinkmembers->sexual_orientation}}</p>
                                                    <p><b>Location:</b> {{string_explode_implode($kink_member_data->kinkmembers->address)}}</p>
                                                    <p><b>Role:</b> {{$kink_member_data->kinkmembers->role}}</p>
                                                </div>
                                            </div>
                                            <div class="fri-btn">
                                                <a href="{{url('/user-images/'.$kink_member_data->kinkmembers->user_id)}}" class="fri-btn-item">{{$kink_member_data->kinkmembers->userimages()->count()}} Images</a>
                                                <a href="{{url('/user-video/'.$kink_member_data->kinkmembers->user_id)}}" class="fri-btn-item">{{$kink_member_data->kinkmembers->uservideos()->count()}} Videos</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
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
