@extends('front.layouts.front')


@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Notifications</title>
    @endif
@endsection


@section('content')
    <section class="profile-settings-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading">Notification</h3>
                        </div>
                        <div class="profile-tabs-block">
                            <div class="profile-setting-box" id="profileSetting">
                                <ul class="profile-setting-group">
                                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu">Profile</a></li>
                                    <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a>
                                    </li>
                                    <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload Videos</a>
                                    </li>
                                    <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                                    <li><a href="{{ url('/notifications') }}"
                                            class="profile-setting-menu active-menu">Notifications
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="about-block">
                            <div class="row">
                                <div class="col-md-8">
                                    {!! Form::open(['url' => 'notifications', 'id' => 'notification_setting_form', 'class' => 'notification_setting_form']) !!}
                                        <div class="filter-left">
                                            <h5 class="interested-in-viewing">Email notifications</h5>
                                            <div class="all-filters-box p-3">
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when I receive new inbox
                                                        message
                                                        <input type="checkbox" name="inbox_message" value="1" {{$notification->inbox_message == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <h5 class="interested-in-viewing">Push notifications you want to receive</h5>

                                            <div class="all-filters-box p-3">
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when I get a new friend
                                                        request
                                                        <input type="checkbox" name="friend_request" value="1" {{$notification->friend_request == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone follows me
                                                        <input type="checkbox" name="follow_me" value="1" {{$notification->follow_me == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <br><br>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone likes my image
                                                        <input type="checkbox" name="like_image" value="1" {{$notification->like_image == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone likes my
                                                        videos
                                                        <input type="checkbox" name="like_video" value="1" {{$notification->like_video == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone likes my
                                                        topics
                                                        <input type="checkbox" name="like_topic" value="1" {{$notification->like_topic == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                {{-- <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone likes my
                                                        comments
                                                        <input type="checkbox" name="like_comment" value="1" {{$notification->like_comment == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div> --}}
                                                <br><br>
                                                {{-- <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone mentions my
                                                        member name
                                                        <input type="checkbox" name="mention_member" value="1" {{$notification->mention_member == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div> --}}
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone comments on my
                                                        image
                                                        <input type="checkbox" name="comment_image" value="1" {{$notification->comment_image == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone comments on my
                                                        video
                                                        <input type="checkbox" name="comment_video" value="1" {{$notification->comment_video == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone comments on my
                                                        topics
                                                        <input type="checkbox"  name="comment_topic" value="1" {{$notification->comment_topic == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>

                                                <div class="form-chk pro-notification-check">
                                                    <label class="role-checkbox mb-0"> Notify me when someone replies to my
                                                        comments
                                                        <input type="checkbox"  name="replay_comment" value="1" {{$notification->replay_comment == 1 ? 'checked' : ''}}>
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <input class="noti-update-btn" type="submit" value="Update">
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-md-4">
                                    <div class="filter-right-block">
                                        <h3 class="push-notification">Push notifications</h3>
                                        <p class="filter-description">Push notifications are messages that come World of Kink. You get them on your desktop or device even when World of Kink is not  open in your browser. These messages will be sent based on the checked items on the left.</p>
                                        <p class="filter-description">You can subscribe or unsubscribe here to push
                                            notifications</p>
                                        <button class="subscribe-btn">SUBSCRIBE</button>
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
<script src="{{ asset_front('/js/profile/notification_setting.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
