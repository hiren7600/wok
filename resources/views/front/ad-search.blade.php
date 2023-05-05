@extends('front.layouts.front')

@section('metatag')
    <title>Ads</title>
@endsection

@section('content')
<section class="location-bg">
    <div class="container-xl">
        <div class="custom-container-wrap">
            <div class="casual-encounter-ads-list-box">
                <div class="row d-flex">
                    <div class="col-12 order-md-1">

                        <h2 class="castle-rock-title">{{$adpostcount}} Casual Encounter ads </h2>

                        <div class="time-line-box">
                            @if (!$adposts->isEmpty())
                                @foreach ($adposts as $key =>  $adpost)
                                    <p class="ad-post-date">{{ date(' F j, Y', strtotime($key)) }}</p>
                                    @foreach ($adpost as $adpostdata)
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
                                    @endforeach
                                @endforeach
                            @else
                                <div class="no-image-bg">
                                    <div class="container">
                                        <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                            <div class="no-image-msg-show">
                                                <p>Not Found Casual Encounter ads</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')
@endsection
