@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Profile - User Gallery</title>
    @endif
@endsection


@section('content')
    <section class="profile-gallery-page">
        <div class="">
            <div class="container-fluid">
                @if ($user->user_id == $globaldata['user']->user_id)
                <div class="profile-tabs-block">
                    <div class="profile-setting-box" id="profileSetting">
                        <ul class="profile-setting-group">
                            <li><a href="{{ url('/profile') }}" class="profile-setting-menu active-menu">Profile</a></li>
                            <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                            <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                            <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a></li>
                            <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload Videos</a></li>
                            <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                            <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                                </a></li>
                        </ul>
                    </div>
                </div>
                @endif
                <div class="gallery-content-area">
                    <div class="gallery-pg-profile-box">
                        <div class="gallery-pg-pr-img">
                            <a href="{{ url('/profile/' . $user->user_id) }}">
                                <img src="{{ $user->mediumthumbimagefilepath }}" alt="profile image">
                            </a>
                        </div>
                        <div class="gallery-pg-pr-details">
                            <div>
                                <a href="{{ url('/profile/' . $user->user_id) }}"
                                    class="gallery-pg-user-name">{{ $user->username }}</a>
                                <ul class="gallery-pg-user-details">
                                    <li><a href="#">Trust: +3</a>
                                        <span class="border-right-side">|</span>
                                        <span>Jr Member</span>
                                        <span class="border-right-side">|</span>
                                        <span>Age  {{ \Carbon\Carbon::parse($user->dob)->age }}</span>
                                        <span class="border-right-side">|</span>
                                        <span>{{ config('constants.gender')[$user->gender] }}</span>
                                        <span class="border-right-side">|</span>
                                        <span>{{ $user->relationship_status }}</span>
                                    </li>
                                    <li><a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/profile') : url('/profile/' . $user->user_id) }}"><i class="fas fa-long-arrow-alt-left"></i> View profile</a>
                                        <span class="border-right-side">|</span>
                                        <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-images') : url('/user-images/' . $user->user_id) }}">
                                            Pictures ({{ count($user_media) }})
                                        </a>
                                        <span class="border-right-side">|</span>
                                        <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-video') : url('/user-video/' . $user->user_id) }}">Videos ({{ $user_video }})
                                        </a>
                                        <span class="border-right-side"> | </span>
                                        <span class="feed-status">{{ string_explode_implode($user->address) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="gallery-profile-follow-btn">
                                @if ($user->user_id == $globaldata['user']->user_id)
                                    <a href="{{ url('/upload-image') }}">Upload</a>
                                @endif
                                @if ($user->user_id != $globaldata['user']->user_id)
                                    <a href="#">Following</a>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <section class="new-maso-card-bg pt-0">
        <div class="main-height-wrap">
            @if(!$user_media->isEmpty())
            <div class="container-fluid">
                <div class="grid" id="image-items">
                    @foreach ($user_media as $usermedia)
                    <div class="item">
                        <div class="content">
                            @if (!empty($usermedia->user))
                            <div class="video-items-box">
                                <div class="video-inner-box">
                                    <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                                        <img src="{{$usermedia->mediafile}}" alt="image-list">
                                    </a>
                                </div>
                                <div class="list-wrap-all-comment-here">
                                    <div class="video-comments-count-box">
                                        <div class="for-comments">
                                            <span>by</span><a href="{{  url('/profile/' . $usermedia->user->user_id)}}" class="author-name">{{$usermedia->user->username}}</a>
                                        </div>
                                        @if (!($usermedia->comments->isEmpty()))
                                            <div class="counting-box">
                                                <span>-</span><a href="#"><i class="fas fa-comment"></i>
                                                    {{($usermedia->comments->count())}}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="comment-list-wrap">

                                        @if (!($usermedia->comments->isEmpty()))
                                        <div class="comments-list-group">
                                            @foreach($usermedia->comments->take(2) as $comment)
                                            <div class="comments-list-items">
                                                <a href="#" class="avatar-image">
                                                    <img src="{{$comment->user->smallthumbimagefilepath}}"
                                                        alt="avatar image">
                                                </a>
                                                <div class="comment-text">
                                                    <a href="{{url('profile/'.$comment->user->user_id)}}">{{ $comment->user->username }}:</a>
                                                    <p>{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="view-list-all-comments">
                                                <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}"> @if($usermedia->comments->count() <=  2)
                                                    View all comments
                                                @else
                                                    View all {{$usermedia->comments->count()}} comments
                                                @endif
                                            </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="load_more_loader" class="mt-5 mb-5 pt-5 pb-5">
                    <div class="d-flex justify-content-center">
                        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>
                </div>
            </div>
            @else
                <div class="no-image-bg">
                    <div class="container">
                        <div class="main-height-wrap d-flex justify-content-center align-items-center">
                            <div class="no-image-msg-show">
                                <p>Don't have image yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <input type="hidden" name="load_user_id" id="load_user_id" value="{{$user->user_id}}">
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/imagesloaded.pkgd.min.js?ver=' . mt_rand(1000, 9999)) }}"></script>
    <script>
        function resizeGridItem(item) {
            grid = document.getElementsByClassName("grid")[0];
            rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
            rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
            rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
            item.style.gridRowEnd = "span " + rowSpan;
        }

        function resizeAllGridItems() {
            allItems = document.getElementsByClassName("item");
            for (x = 0; x < allItems.length; x++) {
                resizeGridItem(allItems[x]);
            }
        }

        function resizeInstance(instance) {
            item = instance.elements[0];
            resizeGridItem(item);
        }

        window.onload = resizeAllGridItems();
        window.addEventListener("resize", resizeAllGridItems);

        allItems = document.getElementsByClassName("item");
        for (x = 0; x < allItems.length; x++) {
            imagesLoaded(allItems[x], resizeInstance);
        }

    </script>
    <script src="{{ asset_front('/js/profile/user-image.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
