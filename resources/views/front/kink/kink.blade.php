@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Kink</title>
    @endif
@endsection


@section('content')
<section class="edit-kink-page">
    <div class="edit-kink-banner-block">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="edit-kink-inner-wrap">
                        <div class="welcome-to-worldof-Kinks-banner-section">
                            <h1 class="welcome-worldof-Kinks">Welcome to a World of Kinks</h1>
                            <p class="how-many-other-people-same">See how many other kinky people are into the same
                                kinks as you.
                            </p>
                            <div class="people-input-box">
                                <input type="text" id="seach_tag" placeholder="lactating, fuck my wife, oh my..."
                                    class="form-control">
                                <button type="button" class="people-search-icon"><i
                                        class="fas fa-search"></i></button>
                            </div>
                            <p class="people-subcontent">To add any of these kinks to your profile, simply click the
                                yellow check box.<br>
                                Click the blue checkbox to remove it from your profile.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="edit-kink-tabs-menu-header">
                    <div class="row">
                        <div class="col-md-6 col-12 order-md-2">
                            <div class="your-profile-status-text">
                                <span class="not-in-your-profile"><i class="fas fa-check"></i> - not in your
                                    profile</span>
                                <span class="in-your-profile"><i class="fas fa-check"></i> - in your
                                    profile</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 order-md-1">
                            <div class="your-profile-upadet-menu">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#random"
                                            type="button">Random
                                            Kinks</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#most_popular" type="button">Most Popular</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#alphabetical"
                                            type="button">Alphabetical
                                            Order</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="edit-kink-tabs-block">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="edit-kink-tabs-content-area">
                        <div class="tab-content">
                            <div class="tab-pane fade" id="random" role="tabpanel">
                                <div class="random-tab-area">
                                    <ul class="random-tags-group">
                                        @foreach ($kinks as $key => $kink)
                                            <?php
                                                $memberclass = '';
                                                if($kink->tagcount > $memberflag1) {
                                                    $memberclass = 'fontsize1';
                                                }
                                                elseif($kink->tagcount > $memberflag2) {
                                                    $memberclass = 'fontsize2';
                                                }
                                                elseif($kink->tagcount > 0) {
                                                    $memberclass = 'fontsize3';
                                                }
                                            ?>

                                            <li class="random-tags-items-list"><a href="{{url('/kink-members/'.$kink->tag_id)}}" class="normal-font {{$memberclass}}">{{$kink->name}}</a>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="see-all-other-member">
                                    <button>Show other member kinks</button>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="most_popular" role="tabpanel">
                                <div class="most-popular-area">

                                    <div class="row justify-content-between  ">
                                        @foreach ($kinks as $key => $kink)
                                            <div class="col-lg-3 col-sm-6 col-12 tag_search">
                                                <div class="most-popular-item-box {{(in_array($kink->tag_id, $kinkmember)?'myshow':'')}}">
                                                    <div class="popular-item-index">
                                                        {{$key+1}}
                                                    </div>
                                                    <div class="popular-item-content">
                                                        <a href="{{url('/kink-members/'.$kink->tag_id)}}">{{$kink->name}}</a>
                                                        <span>{{$kink->members->count()}} kinksters</span>
                                                    </div>
                                                    <div class="popular-item-status">
                                                        <a href="#" class="add-and-remo" data-tag_id="{{$kink->tag_id}}"><i
                                                                class="fas fa-check"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="see-all-other-member">
                                    <button>Show other member kinks</button>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="alphabetical" role="tabpanel">
                                <div class="alphabetical-order-are">
                                    <div class="alphabetical-list">
                                        @foreach ($kinkalphabetics as $key=> $kinkalphabetic)
                                        <h6 class="alphabetical-title">{{$key}}</h6>
                                            <ul class="alphabetical-tags-group">
                                                @foreach ($kinkalphabetic as $kinkalphabeticdata)
                                                <li class="alphabetical-tags-item-list"><a href="{{url('/kink-members/'.$kinkalphabeticdata->tag_id)}}">{{$kinkalphabeticdata->name}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="see-all-other-member">
                                    <button>Show other member kinks</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')

   <script src="{{ asset_front('/js/kink/kink.js?ver=' . mt_rand(1000, 9999)) }}"></script>

<script>
    $("#seach_tag").on("keyup", function() {
        var value = this.value.toLowerCase().trim();
        $(".most-popular-area .tag_search").show().filter(function() {
            return $(this).text().toLowerCase().trim().indexOf(value) == -1;
        }).hide();
    });
</script>
@endsection
