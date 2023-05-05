@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Notification List</title>
    @endif
@endsection


@section('content')
<section class="notification-page my-5">
    <div class="main-height-wrap">
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
                            <li><span>99+</span><a href="#">Notifications <span
                                        class="not-show-mobile">Feed</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="middle-column">
                    <h2 class="notification-title">Notification</h2>
                    {{-- <div class="request-notification">
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">requested to join your group</p>
                            <p class="g-message-metadata mt-0">Sext</p>
                            <div class="friend-request-btn">
                                <button>Approve</button>
                                <button>Decline</button>
                            </div>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">requested to join your group</p>
                            <p class="g-message-metadata mt-0">Sext</p>
                            <div class="friend-request-btn">
                                <button>Approve</button>
                                <button>Decline</button>
                            </div>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">requested to join your group</p>
                            <p class="g-message-metadata mt-0">Sext</p>
                            <div class="friend-request-btn">
                                <button>Approve</button>
                                <button>Decline</button>
                            </div>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                    </div> --}}
                    {{-- <div class="regular-notification">
                        {{-- <h2 class="notification-title">Regular Notification</h2>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">requested to join your group</p>
                            <p class="g-message-metadata mt-0">Sext</p>
                            <p class="g-message-metadata mt-0">Approved</p>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">likes your topic <a href="#">xcxc</a></p>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">likes your <a href="#"> image</a></p>
                            <img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="profile" class="liked-items">
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                        <div class="topics-comment-list notification-list-box">
                            <div class="message-user-box">
                                <div class="message-author-info">
                                    <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="mail author image"></a>
                                </div>
                                <span>
                                    <a href="#" class="message-user-name">Kink11</a>
                                    <span class="show-member feed-status">67M</span>
                                    <span class="border-right-side">|</span>
                                    <span class="feed-status">Thornton, Colorado</span>
                                </span>
                            </div>
                            <p class="g-message-metadata mt-0">replied to you in <a href="#"> image</a> comment</p>
                            <img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="profile" class="liked-items">
                            <p class="g-message-metadata mt-0">Looks like their account has been cracked.</p>
                            <span class="notification-time">Aug 24, 2022</span>
                        </div>
                    </div> --}}
                    @if (!$user_notifications->isEmpty())
                        @foreach ($user_notifications as $user_notification)
                            @if(!empty($user_notification->user))
                                <input type="hidden" name="user_notification_id" value="{{$user_notification->user_notification_id}}">
                                <div class="topics-comment-list notification-list-box">
                                    <div class="message-user-box">
                                        <div class="message-author-info">
                                            <a href="{{url('/profile/'.$user_notification->user->user_id)}}"><img src="{{$user_notification->user->smallthumbimagefilepath}}" alt="{{$user_notification->user->username}}"></a>
                                        </div>
                                        <span>
                                            <a href="{{url('/profile/'.$user_notification->user->user_id)}}" class="message-user-name">{{$user_notification->user->username}}</a>
                                            <span class="show-member feed-status">{{ \Carbon\Carbon::parse($user_notification->user->dob)->age }}</span>
                                            <span class="border-right-side">|</span>
                                            <span class="feed-status">{{string_explode_implode($user_notification->user->address)}}</span>
                                        </span>
                                    </div>
                                    @if ($user_notification->type == 'videolike')
                                        <p class="g-message-metadata mt-0">likes your <a href="{{$user_notification->filepath}}"> video</a></p>
                                    @elseif($user_notification->type == 'imagelike')
                                        <p class="g-message-metadata mt-0">likes your <a href="{{$user_notification->filepath}}"> image</a></p>
                                        <a href="{{$user_notification->filepath}}"><img src="{{$user_notification->mediafile}}" alt="profile" class="liked-items"></a>
                                    @elseif($user_notification->type == 'imagerplcomment')
                                        <p class="g-message-metadata mt-0">replied to you in <a href="{{$user_notification->filepath}}"> image</a> comment</p>
                                        <a href="{{$user_notification->filepath}}"><img src="{{$user_notification->mediafile}}" alt="profile" class="liked-items"></a>
                                        <p class="g-message-metadata mt-0">{{$user_notification->content}} </p>
                                    @elseif($user_notification->type == 'newmessage')
                                        <p class="g-message-metadata mt-0">recived new  <a href="{{$user_notification->filepath}}"> conversation</a></p>
                                    @elseif($user_notification->type == 'videorplcomment')
                                        <p class="g-message-metadata mt-0">replied to you in <a href="{{$user_notification->filepath}}"> video</a> comment</p>
                                        <p class="g-message-metadata mt-0">{{$user_notification->content}} </p>
                                    @elseif($user_notification->type == 'discussionlike')
                                        <p class="g-message-metadata mt-0">likes your topic <a href="{{$user_notification->filepath}}"> {{$user_notification->content}}</a></p>
                                    @elseif($user_notification->type == 'imagecomment')
                                        <p class="g-message-metadata mt-0">Comment on your <a href="{{$user_notification->filepath}}">image</a></p>
                                        <a href="{{$user_notification->filepath}}"><img src="{{$user_notification->mediafile}}" alt="profile" class="liked-items"></a>
                                        <p class="g-message-metadata mt-0">{{$user_notification->content}}</p>
                                    @elseif($user_notification->type == 'videocomment')
                                        <p class="g-message-metadata mt-0">Comment on your <a href="{{$user_notification->filepath}}">video</a></p>
                                        <p class="g-message-metadata mt-0">{{$user_notification->content}}</p>
                                    @elseif($user_notification->type == 'discussioncomment')
                                        <p class="g-message-metadata mt-0">Comment on your <a href="{{$user_notification->filepath}}">topic</a></p>
                                    @elseif($user_notification->type == 'follow')
                                        <p class="g-message-metadata mt-0">is now following you</p>
                                    @endif
                                    <span class="notification-time"> {{$user_notification->created_at->format('M d, Y')}}</span>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="no-image-bg">
                            <div class="container">
                                <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                    <div class="no-image-msg-show">
                                        <p>Don't have notification yet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
    </div>
</section>
@endsection


@section('page-scripts')
<script src="{{ asset_front('/js/notification/notification.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
