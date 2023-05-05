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
                        <li><a href="#">{{$state->statename}},</a></li>
                        @if ($city_name != $state->statename)
                            <li><a href="#">{{$city_name}}</a></li>
                        @endif

                    </ul>
                </div>
                <!-- <div class=" col-md-4">
                    <input type="hidden" name="state_id" id="state_id" value="{{$state->stateid}}">
                    <select class="js-example-placeholder-single js-states form-control" id="city_id">
                        @foreach ($state->cities as $city)
                            <option value="{{$city->cityid}}"{{ ($city->cityname === $city_name) ? 'selected' : '' }} >{{$city->cityname}}</option>
                        @endforeach
                    </select>
                </div> -->
            </div>
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
                                    <li><a href="#" class="selected">All Ads</a> (<span>75</span>)</li>
                                    <li><a href="#">Men Seeking Men</a> (<span>23</span>)</li>
                                    <li><a href="#">Men Seeking Women</a> (<span>12</span>)</li>
                                    <li><a href="#">Men Seeking Couples</a> (<span>9</span>)</li>
                                    <li><a href="#">Men Seeking TV/TS</a> (<span>5</span>)</li>
                                    <li><a href="#">Women Seeking Men</a> (<span>3</span>)</li>
                                    <li><a href="#">Women Seeking Women</a> (<span>6</span>)</li>
                                    <li><a href="#">Women Seeking Couples</a> (<span>3</span>)</li>
                                    <li><a href="#">Couples Seeking Men</a> (<span>2</span>)</li>
                                    <li><a href="#">Couples Seeking Women</a> (<span>1</span>)</li>
                                    <li><a href="#">Couples Seeking Couples</a> (<span>7</span>)</li>
                                    <li><a href="#">Couples Seeking TV/TS</a> (<span>5</span>)</li>
                                    <li><a href="#">TV/TS Seeking Men</a> (<span>3</span>)</li>
                                    <li><a href="#">TV/TS Seeking Women</a> (<span>0</span>)</li>
                                    <li><a href="#">TV/TS Seeking Couples</a> (<span>5</span>)</li>
                                    <li><a href="#">TV/TS Seeking TV/TS</a> (<span>0</span>)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="member-post-left-column order-md-1">
                        <h2 class="castle-rock-title">67 Casual Encounter ads in Castle Rock (<a href="#">view
                                all</a>)</h2>
                        <div class="time-line-box">
                            <p class="ad-post-date">Sep 04, 2022</p>
                            <ul class="ad-post-list">
                                <li><a href="#"><span class="title-text">Looking for HER!!!</span><span
                                            class="place-text"><span>(Santa Clara)</span>35 T4M</span><span
                                            class="item-title">-Photo</span></a>
                                </li>
                                <li><a href="#"><span class="title-text">Looking for HER!!!</span><span
                                            class="place-text"><span>(Santa Clara)</span>35 T4M</span><span
                                            class="item-title">-Photo</span></a>
                                </li>
                                <li><a href="#"><span class="title-text">Looking for HER!!!</span><span
                                            class="place-text"><span>(Santa Clara)</span>35 T4M</span><span
                                            class="item-title">-Photo</span></a>
                                </li>
                                <li><a href="#"><span class="title-text">Looking for HER!!!</span><span
                                            class="place-text"><span>(Santa Clara)</span>35 T4M</span><span
                                            class="item-title">-Photo</span></a>
                                </li>
                            </ul>
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
$('#city_id').change(function(){
    var stateid = $('#state_id').val();
    var cityid = $(this).val();
    window.location.href = baseurl()+'/location/'+stateid+'/'+cityid;
});
</script>
@endsection
