@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Location</title>
    @endif
@endsection

@section('content')
<section class="casual-encounters-page">
    <div class="container-xxl">
        <div class="casualencounters-w-wrap">
            <div class="change-citis-header row ">
                {{-- <div class="city-location col-md-3">
                    <a href="#">{{$city_name}}</a>
                    @if(count($users) > 0)<span>({{count($users)}})</span>@endif
                </div> --}}
                {{-- <div class="row"> --}}
                    {{-- <div class=" col-md-4">
                        <input type="hidden" name="state_id" id="state_id" value="{{$state->stateid}}">
                        <select class="js-example-placeholder-single js-states form-control" id="city_id">
                            @foreach ($state->cities as $city)
                                <option value="{{$city->cityid}}"{{ ($city->cityname === $city_name) ? 'selected' : '' }} >{{$city->cityname}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                {{-- </div> --}}
                <div class=" col-12">
                    <div class="text-end">
                        <a href="{{url('/chnagelocation')}}" class="city-change d-inline-block">Change Location</a>
                    </div>
                </div>
            </div>
            <div class="all-members-area">
                <div class="row g-3">
                    @foreach ($users as $user)
                    <div class="col-md-6 col-12">

                        <div class="friend-box">
                            <div class="fri-img">
                                <a href="{{url('/profile/'.$user->user_id)}}">
                                    <img src="{{$user->mediumthumbimagefilepath}}" alt="user-img">
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
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')
<script>
$(".js-example-placeholder-single").select2({
    placeholder: "Select a City"
});
$('#city_id').change(function(){
    var stateid = $('#state_id').val();
    var cityid = $(this).val();
    window.location.href = baseurl()+'/member/'+stateid+'/'+cityid;
});
</script>
@endsection
