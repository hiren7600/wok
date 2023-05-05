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
<section class="location-bg">
    <div class="container-xl">
        <div class="custom-container-wrap">
            <div class="whats-happening-near-you-box">
                <h1>What's Happening Near You</h1>
                <p>Meet local members, browse casual encounter ads, find local<br> groups, and find upcoming events
                    in
                    your area all from this page.</p>
                <div class="profile-is-currently-set-to-view">
                    <span>You're profile is currently set to view</span>
                    <ul>
                        <li><a href="{{url('/chnagelocation')}}">United States,</a></li>
                        @if (!empty($state))
                            <li><a href="{{url('/selectcity/'.$state->statename)}}">{{$state->statename}},</a></li>
                            @if ($city_name != $state->statename)
                                <li><a href="#">{{$city_name}}</a></li>
                            @endif
                        @endif
                    </ul>
                    @if (!empty($state))
                        @if ($city_name != $state->statename)
                            <a class="click-here-to-view-all" href="{{url('/location/'.$state->statename)}}"><span>Click here to View all {{$state->statename}}'s ads/members.
                            </span></a>
                        @endif
                    @else
                    <a class="click-here-to-view-all" href="{{url('/location/?country=United States')}}"><span>Click here to view all of  United States's ads and members.</span></a>
                    @endif
                </div>
            </div>
            <div class="castle-rock-box">
                @if (!empty($city_name))
                    <h2 class="castle-rock-title">{{$userscount}} Members in {{$city_name}} (<a href="{{url('/member/'.$state->statename.'/'.$city_name)}}">view all</a>)</h2>
                @else
                    <h2 class="castle-rock-title">{{$userscount}} Members in United State's (<a href="{{url('/member/?country=United States')}}">view all</a>)</h2>
                @endif

                <div class="members-list-in-castle-rock">
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
                <div class="text-end">
                    @if (!empty($city_name))
                        <h2 class="castle-rock-title">{{$userscount}} Members in {{$city_name}} (<a href="{{url('/member/'.$state->statename.'/'.$city_name)}}">view all</a>)</h2>
                    @else
                        <h2 class="castle-rock-title">{{$userscount}} Members in United State's (<a href="{{url('/member/?country=United States')}}">view all</a>)</h2>
                    @endif
                </div>
            </div>
            {{-- <h2 class="castle-rock-title"><a href="{{url('/member/'.$state->statename.'/'.$city_name)}}">view all</a> {{$userscount}} member in {{$city_name}}</h2> --}}
            <div class="casual-encounter-ads-list-box">
                <div class="member-add-post-row d-flex">
                    <div class="member-post-right-column order-md-2">
                        <a href="{{url('/ad-category')}}" class="post-ad-btn">Post Ad</a>
                        <div class="add-ads-box">
                            <h3 class="cities-title-item categories d-md-none">Categories
                                <span>»</span>
                            </h3>
                            <div class="categories-box">
                                <ul>

                                    <li><a href="{{url()->current()}}" class="selected">All Ads</a> (<span>{{$ad_categories->sum('adcount')}}</span>)</li>
                                    @foreach ($ad_categories as $ad_category)
                                        <li><a href="{{url()->current().'/?category='.$ad_category->slug}}">{{$ad_category->name}}</a> (<span>{{$ad_category->adcount}}</span>)</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="member-post-left-column order-md-1">
                        @if (!empty($city_name))
                            <h2 class="castle-rock-title">{{$adpostcount}} Casual Encounter ads in {{$city_name}} <!-- (<a href="{{url('/casual-encounter')}}">view
                            all</a>) --></h2>
                        @else
                            <h2 class="castle-rock-title">{{$adpostcount}} Casual Encounter ads in United state's <!-- (<a href="{{url('/casual-encounter')}}">view
                            all</a>) --></h2>
                        @endif


                        <div class="time-line-box">
                            @foreach ($adposts as $key =>  $adpost)
                                <p class="ad-post-date">{{ date(' F j, Y', strtotime($key)) }}</p>
                                @foreach ($adpost as $adpostdata)
                                    @if(!empty($adpostdata->user))
                                    <ul class="ad-post-list">
                                        <li>
                                            <a href="{{url('view-ad/'.(empty($adpostdata->slug)?$adpostdata->ad_post_id:$adpostdata->slug))}}">
                                                <span class="title-text">{{$adpostdata->title}}</span>
                                                <span class="place-text">
                                                    <span>({{trim(explode(',',$adpostdata->location)[0])}})</span>
                                                    {{ Carbon\Carbon::parse($adpostdata->user->dob)->age }} {{$adpostdata->adcategory->code}}
                                                </span>
                                                @if(!$adpostdata->admedias->isEmpty())
                                                <span class="item-title">-Photo</span>
                                                @endif
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                @endforeach

                            @endforeach

                        </div>
                    </div>
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
$('#cityname').change(function(){
    var statename = $('#statename').val();
    var cityname = $(this).val();
    window.location.href = baseurl()+'/location/'+statename+'/'+cityname;
});
</script>
@endsection
