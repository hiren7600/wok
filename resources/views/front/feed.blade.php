@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Feed</title>
    @endif
@endsection


@section('content')
    <section class="feed-section-bg mt-5">
        <div class="container-xxl">
            <div class="feed-row">
                <div class="left-column">
                    <div class="nav-news-feed interactions-block">
                        <h3 class="interactions-title">My Interactions</h3>
                        <ul class="interactions-items">
                            <li><span>0</span><a href="#">Members Viewed Me</a></li>
                            <li><span> @if($globaldata['newMsgCounts'] > 0){{$globaldata['newMsgCounts']}}</span>@else<span>0</span>@endif<a href="{{ url('/conversation') }}">New Messages</a></li>
                            <li><span> @if($globaldata['friendrequestcounts'] > 0){{$globaldata['friendrequestcounts']}}</span>@else<span>0</span>@endif<a href="{{ url('/friend-requests') }}">New Friend Requests</a></li>
                            {{-- <li><span> @if($globaldata['friendrequestcounts'] > 0){{$globaldata['friendrequestcounts']}}</span>@else<span>0</span> @endif<a href="{{url('/friend-requests')}}">New Friend Requests</a></li> --}}
                        </ul>
                    </div>
                    <div class="nav-news-feed feeds-block">
                        <h3 class="interactions-title">Feeds</h3>
                        <ul class="interactions-items">
                            <li><span>0</span><a href="#" class="selected">Friends <span class="not-show-mobile">
                                        Feed</span></a></li>
                            <li><span>0</span><a href="#"><span class="not-show-mobile">Friends</span> Activity</a>
                            </li>
                            <li><span>0</span><a href="#"><span class="not-show-mobile">Friends</span> Photos</a></li>
                            <li><span>0</span><a href="#"><span class="not-show-mobile">Friends</span> Videos</a></li>
                            <li><span>0</span><a href="#">Notifications <span
                                        class="not-show-mobile">Feed</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="middle-column">
                    <!-- <img src="{{ asset_front('/images/logo.png') }}" alt="logo"> -->
                    <div class="feed-wrapper feed-post-wrapper">
                        <div class="log-msg-wrapper"></div>
                        {!! Form::open(['url' => 'feed', 'id' => 'feed_form']) !!}
                        <div class="feed-form-wrap">
                            <div class="feed-form-row">
                                <div class="user-avatar">
                                    <a href="#"><img src="{{ $globaldata['user']->smallthumbimagefilepath }}"
                                            alt="logo"></a>
                                </div>
                                <div class="feed-form-input">
                                    <div class="form-group">
                                        <textarea name="content" id="content" maxlength="250" placeholder="Share something new {{($friendcounts > 0? 'with your '.$friendcounts. ($friendcounts == 1? ' friend': ' friends'):'' )}}"
                                            class="form-control"></textarea>
                                    </div>
                                    <div class="upload-btn form-group text-center">
                                        <label href="#" class=""><span class="upload_pic_comment"> <i class="fa fa-camera" aria-hidden="true"></i> Upload pic</span>
                                            <input type="file" name="feedmedia" class="form-control d-none">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="feed-post-preview">
                                <div class="preview-box">
                                    <span class="fas fa-times preview-close"></span>
                                    <img class="preview-img" src="">
                                    <video controls="" class="preview-video">
                                        <source src="" type="video/mp4">
                                        Your browser does not support HTML video.
                                    </video>
                                </div>
                            </div>
                            <div class="feed-post-btn-wrapper text-end">
                                <button type="submit" class="btn btn-primary btn-sm post-comment-btn">Post</button>
                                <button class="btn btn-secondary btn-sm cancel-post-btn">Cancel</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="feed-lists" id="feed-list">
                        
                        @if (!$posts->isEmpty())
                            @foreach ($posts as $post)
                                <div class="feed-item feed{{ $post->post_id }}" data-id="{{ $post->post_id }}">
                                    <div class="feed-box">
                                        <div class="feed-avatar">
                                            <a href="{{ url('/profile/'.$post->user->user_id) }}" class="feed-user-name-item">
                                                <img class="feed-post-user-img" src="{{ $post->user->smallthumbimagefilepath }}">
                                            </a>

                                        </div>
                                        <div class="feed-data text-start">
                                            <div class="feed-user-name">
                                                <a href="{{ url('/profile/'.$post->user->user_id) }}"
                                                    class="feed-user-name-item">{{ $post->user->username }}</a>
                                                <span
                                                    class="feed-status">{{ Carbon\Carbon::parse($post->user->dob)->age }}{{ $post->user->gender }}</span>
                                                <span class="border-right-side">|</span>
                                                <span
                                                    class="feed-status">{{ string_explode_implode($post->user->address) }}</span>
                                                <!-- <span class="border-right-side">|</span>
                                                    <span class="feed-status">Moderator</span>
                                                    <a href="#" class="feed-status"><img src="" alt=""></a>
                                                        -->
                                            </div>
                                            <div class="feed-post-content">{{ $post->content }}</div>
                                            @if (!empty($post->media))
                                                @if ($post->media->media_type == 0)
                                                    <div class="feed-media">
                                                        <img src="{{ $post->media->filesize }}">
                                                    </div>
                                                @else
                                                    <div class="feed-media">
                                                        <video width="400" controls>
                                                            <source src="{{ $post->media->filesize }}"
                                                                type="video/{{ $post->media->extension }}">
                                                            Your browser does not support HTML video.
                                                        </video>
                                                     </div>
                                                @endif
                                            @endif
                                            <div class="feed-post-time">
                                                <ul>
                                                    <li class="post-time-item">{{ $post->created_at->diffForHumans() }}
                                                    </li>
                                                    <li><a href="#" class="post-rpl">Reply</a></li>
                                                    @if ($globaldata['user']->user_id == $post->user->user_id || $globaldata['user']->issuperadmin == 1 )
                                                        <li><span class="delete-reply-divider">|</span></li>
                                                        <li><a href="#" class="delete-post">Delete</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="all-comments-here">
                                        <?php
                                        $totalCommentCount = $post->comments->count();
                                        $showComments = 3;
                                        $commentsCounter = 0;
                                        $commentsHide = $totalCommentCount - $showComments;

                                        ?>
                                        @if ($commentsHide > 0)
                                            <div class="show-all-comments-btn">
                                                <a href="#" class="show-comment">
                                                    <span class="show-comment-text m-0 p-0">Show all {{$totalCommentCount}} comments</span>
                                                    <span class="hide-comment-text m-0 p-0 d-none">Hide all comments</span>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="feed-comment-list">

                                            @if (!$post->comments->isEmpty())
                                                @foreach ($post->comments as $index => $comment)
                                                    <div class="feed-comment-item comment{{ $comment->comment_id }} {{ $index + 1 <= $commentsHide ? 'collapsible' : '' }}"
                                                        data-comment_id="{{ $comment->comment_id }}">
                                                        <div class="feed-box">
                                                            <div class="feed-avatar">
                                                                <a href="{{ url('/profile/'.$comment->user->user_id) }}" class="feed-user-name-item">
                                                                    <img class="feed-post-user-img" src="{{ $comment->user->smallthumbimagefilepath }}">
                                                                </a>

                                                            </div>
                                                            <div class="feed-data text-start">
                                                                <div class="feed-user-name">
                                                                    <a href="{{ url('/profile/'.$comment->user->user_id) }}" class="feed-user-name-item">{{ $comment->user->username }}</a>
                                                                    <span
                                                                        class="feed-status mobile-change">{{ Carbon\Carbon::parse($comment->user->dob)->age }}{{ $comment->user->gender }}</span>
                                                                    <span class="border-right-side">|</span>
                                                                    <span class="feed-status">
                                                                        {{ string_explode_implode($comment->user->address) }}
                                                                    </span>

                                                                </div>
                                                                <div class="feed-post-content">{{ $comment->comment }}
                                                                </div>
                                                                @if (!empty($comment->media))
                                                                    @if ($comment->media->media_type == 0)
                                                                        <div class="feed-media">
                                                                            <img src="{{ $comment->media->filesize }}">
                                                                        </div>
                                                                    @else
                                                                        <div class="feed-media">
                                                                            <video width="400" controls>
                                                                                <source src="{{ $comment->media->filesize }}"
                                                                                    type="video/{{ $comment->media->extension }}">
                                                                                Your browser does not support HTML video.
                                                                            </video>
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                                <div class="feed-post-time">
                                                                    <ul>
                                                                        <li class="post-time-item">
                                                                            {{ $comment->created_at->diffForHumans() }}
                                                                        </li>
                                                                        @if ($globaldata['user']->user_id == $comment->user->user_id || $globaldata['user']->issuperadmin == 1)
                                                                            <li><a href="#"
                                                                                    class="delete-comment">Delete</a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="feed-wrapper feed-comment-wrapper">
                                            <div class="feed-form-wrap feed-comment-form-wrap mt-5 d-none">
                                                <div class="log-msg-wrapper"></div>
                                                {!! Form::open(['url' => 'feed/comment', 'class' => 'feed_comment_form']) !!}
                                                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                                                <div class="feed-form-row">
                                                    <div class="user-avatar">
                                                        <a href="{{ url('/profile/'.$post->user->user_id) }}"
                                                            class="feed-user-name-item">
                                                            <img src="{{ $globaldata['user']->smallthumbimagefilepath }}"
                                                                alt="logo">
                                                        </a>
                                                    </div>
                                                    <div class="feed-form-input">
                                                        <div class="form-group">
                                                            <textarea name="feed_comment" maxlength="250" placeholder="Write a comment..."
                                                                class="form-control feed_comment_input"></textarea>
                                                        </div>

                                                        <div class="upload-btn form-group text-center">
                                                            <label href="#" class=""><span class="upload_pic_sub_comment"><i class="fa fa-camera" aria-hidden="true"></i> Upload pic</span>
                                                                <input type="file" name="commentmedia"
                                                                    class="comment_media_file d-none">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feed-post-comment-preview">
                                                    <div class="preview-box">
                                                        <span class="fas fa-times comment-preview-close"></span>
                                                        <img class="preview-img" src="">
                                                        <video controls="" class="preview-video">
                                                            <source src="" type="video/mp4">
                                                            Your browser does not support HTML video.
                                                        </video>
                                                    </div>
                                                </div>
                                                <div class="feed-post-btn-wrapper feed-comment-btn-wrapper text-end">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm feed-comment-btn">Post
                                                        Comment</button>
                                                    <button
                                                        class="btn btn-secondary btn-sm cancel-comment-btn">Cancel</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if (!$posts->isEmpty())
                    <div id="load_more_loader" class="mt-5 mb-5 pt-5 pb-5">
                        <div class="d-flex justify-content-center">
                            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </div>
                    </div>
                    @endif
                    <div class="welcome-content pt-5 pb-5">
                            <h2 class="welcome-worldofking-title">Welcome to a World of Kink!</h2>
                            <p class="welcome-worldofking-subtitle">Looks like you are at the end of your feed!</p>
                            <p class="welcome-pra-b">Below are a few ways to get some friends and start populating your feed.</p>
                            <p class="welcome-pra-b">Search for members in your local area: </p>
                            <ul class="local-area-menu">
                                @if(!empty($city))
                                <li><a href="{{url('/location/'.$state->statename.'/'.$city->cityname)}}">{{$city->cityname}}, </a></li>
                                @endif
                                @if(!empty($state))
                                <li><a href="{{url('/selectcity/'.$state->statename)}}">{{$state->statename}}, </a></li>
                                @endif
                                <li><a href="{{url('/chnagelocation')}}">United States</a></li>
                            </ul>
                            <p class="welcome-pra-b">Find some sexy members to start to follow. </p>
                            <ul class="local-area-menu">
                                <li><a href="#">Follow Members</a></li>
                            </ul>
                            <p class="welcome-pra-b">Join some of our discussion groups and make some friends.</p>
                            <ul class="local-area-menu">
                                <li><a href="{{url('/most-popular-groups')}}">Most Popular Groups</a></li>
                            </ul>
                        </div>
                    {{-- <div class="upgrade-block">
                        <div class="upgrade-inner-box">
                            <img src="{{ asset_front('/images/hand.png') }}" alt="hand" class="hand-image">
                            <div class="upgrade-message">
                                Upgrade now and get 100% unlimited access
                            </div>
                            <div class="upgrade-slider-area">
                                <div class="row upgradeslider">
                                    <div class="col">
                                        <p class="slider-content"><b>591</b> people viewed your profile. As an upgraded
                                            member, you will have access to view all the member profiles who checked you
                                            out.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Watch all <b>2,642</b> personal erotic videos that our
                                            kinky members have taken and uploaded for you to view.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Go back 1000x more in the feeds; hell, you can go all the
                                            way back to the very first post on the feed.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">No limit on how many profiles you can view; that's right,
                                            you can look at 290,428 profiles on Kinkyads.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Send unlimited emails per day to as many members as you
                                            want with no email restrictions whatsoever.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Are you a man seeking a couple? With alerts, you can be
                                            notified when a local member posts an ad in that category you are interested in.
                                        </p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Got someone who is bugging you? You can now block them
                                            from viewing your profile and sending you emails.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Want to know if that person you sent an email to has seen
                                            it? Now you can see if they had time to view the email you sent them.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Want to know who was looking at your ad? As an upgraded
                                            member, you will see each profile who checked your ad out.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Start building your trust on Kinkyads with merit points.
                                            By upgrading, you will earn points that help improve your member ranking.</p>
                                    </div>
                                    <div class="col">
                                        <p class="slider-content">Want to update your member name to something cooler?
                                            Well, upgrade now, and you can change it as often as you like.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="upgrade-plans-area">
                                <div class="plan-item">
                                    <span>6</span>
                                    <span>MONTHS</span>
                                    <span>$30.00</span>
                                </div>
                                <div class="plan-item plan-selected">
                                    <div class="save-item">
                                        Save 20%
                                    </div>
                                    <span>12</span>
                                    <span>MONTHS</span>
                                    <span>$50.00</span>
                                </div>
                                <div class="plan-item">
                                    <span>24</span>
                                    <span>MONTHS</span>
                                    <span>$90.00</span>
                                </div>
                            </div>
                            <div class="upgrade-continue">
                                <a href="#">CONTINUE</a>
                            </div>
                            <div class="hint-item">
                                One time billing, no rebills
                            </div>
                            <div class="hint-item">
                                Credit Card | Zelle | Bitcoin | Cash App | Venmo | Physical Mail
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="right-column">
                    <div class="enjoy-kinkyads-has-to-offer">
                        <a href="#">
                            <img src="{{ asset_front('/images/logo.png') }}" alt="" class="">
                            <span>Enjoy all Kinkyads <br> has to offer.</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/feeds/feed.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
