@extends('front.layouts.front')

@section('metatag')

    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Exposed</title>
    @endif
@endsection


@section('content')
{{-- <section class="video-list-page">
    <div class="container-fluid">
        <div class="list-wrap-area">
            <div class="grid grid-row">
                @foreach ($usermedias as $usermedia)
                    <div class="grid-item">
                        <div class="video-items-box">
                            <div class="video-inner-box">
                                @if ($usermedia->mediatype == 1)
                                    <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                                        <img src="{{$usermedia->largethumbimagefilepath}}" alt="image-list">
                                    </a>
                                @else
                                    <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                                        @if (!empty($usermedia->videothumbfile))
                                            <img src="{{$usermedia->videothumbfile}}" alt="img">
                                        @else
                                            <video>
                                                <source src="{{$usermedia->mediafile}}">
                                            </video>

                                        @endif
                                        <span class="play-icon"><i class="fas fa-play"></i></span>
                                    </a>
                                @endif
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
                                    @if(!$usermedia->videocomments->isEmpty())
                                        <div class="counting-box">
                                            <span>-</span><a href="#"><i class="fas fa-comment"></i>
                                            {{($usermedia->videocomments->count())}}
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
                                    @if(!$usermedia->videocomments->isEmpty())
                                    <div class="comments-list-group">
                                        @foreach($usermedia->videocomments->take(2) as $comment)
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
                                            <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $user->user_id) }}">
                                            @if($usermedia->videocomments->count() <=  2)
                                                View all comments
                                            @else
                                                View all {{$usermedia->videocomments->count()}} comments
                                            @endif
                                        </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section> --}}

<section class="new-maso-card-bg">
    <div class="container-fluid">
        <div class="grid" id="expose-items">
            @foreach ($usermedias as $usermedia)
                @if (!empty($usermedia->user))
                    <div class="item">
                        <div class="content">
                            <div class="video-items-box">
                                <div class="video-inner-box">

                                        @if ($usermedia->mediatype == 1)
                                            <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                                                <img src="{{$usermedia->mediafile}}" alt="image-list">
                                            </a>
                                        @else
                                            <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                                                @if (!empty($usermedia->videothumbfilepath))
                                                    <img src="{{$usermedia->videothumbfilepath}}" alt="img">
                                                @else
                                                    <video>
                                                        <source src="{{$usermedia->mediafile}}">
                                                    </video>

                                                @endif
                                                <span class="play-icon"><i class="fas fa-play"></i></span>
                                            </a>
                                        @endif

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
                                        @if(!$usermedia->videocomments->isEmpty())
                                            <div class="counting-box">
                                                <span>-</span><a href="#"><i class="fas fa-comment"></i>
                                                {{($usermedia->videocomments->count())}}
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
                                        @if(!$usermedia->videocomments->isEmpty())
                                            <div class="comments-list-group">
                                                @foreach($usermedia->videocomments->take(2) as $comment)
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
                                                    <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $user->user_id) }}">
                                                    @if($usermedia->videocomments->count() <=  2)
                                                        View all comments
                                                    @else
                                                        View all {{$usermedia->videocomments->count()}} comments
                                                    @endif
                                                </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div id="load_more_loader" class="mt-5 mb-5 pt-5 pb-5">
            <div class="d-flex justify-content-center">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
        </div>
    </div>
</section>
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
    <script src="{{ asset_front('/js/expose/expose.js?ver=' . mt_rand(1000, 9999)) }}"></script>

@endsection
