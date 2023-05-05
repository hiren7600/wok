@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>City List</title>
    @endif
@endsection


@section('content')
<section class="location-bg">
    <div class="container-xl">
        <div class="location-inner-bg">
            <div class="whats-happening-near-you-box">
                <h1>What's Happening Near You</h1>
                <p>Meet local members, browse casual encounter ads, find local<br> groups, and find upcoming events
                    in
                    your area all from this page.</p>
                <div class="profile-is-currently-set-to-view show-all-location">
                    <a href="{{url('/location/'.$statename)}}" class="show-all-location">Show all locations in {{$statename}}</a>
                    <p class="or-divider">- or -</p>
                    <span>Select your location below</span>
                </div>
            </div>
            <div class="all-location-list-box">
                <div class="all-location-inner">
                    <ul class="all-location-group">
                        @foreach ($cities as $city)
                        <?php 
                            $cityclass = '';
                            if($city->membercount > $memberflag1) {
                                $cityclass = 'citis-font1';
                            }
                            elseif($city->membercount > $memberflag2) {
                                $cityclass = 'citis-font2';
                            }
                            elseif($city->membercount > 0) {
                                $cityclass = 'citis-font3';
                            }
                        ?>
                        <li><a href="{{url('/location/'.$statename.'/'.$city->cityname)}}" class="location-items {{$cityclass}}">{{$city->cityname}}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')
@endsection
