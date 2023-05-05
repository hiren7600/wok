@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title> {{$user->username}} | World of Kink</title>
    @endif
@endsection


@section('content')
    <?php
    $status = 'friend-none';
    $requestText = 'Request Friendship';
        if(empty($sentRequest)) {
            $status = 'friend-none';
            $requestText = 'Request Friendship';
        }
        elseif(!empty($sentRequest) && $sentRequest->status == 0) {
            $status = 'friend-pending';
            $requestText = 'Cancel Friendship Request';
        }
        else {
            $status = 'friend-remove';
            $requestText = 'Remove Friendship';
        }

        if(!empty($receivedRequest) && $receivedRequest->status == 0) {
            $status = 'friend-request';
            $requestText = 'Decline Friendship Request';
        }

        if((!empty($sentRequest) && $sentRequest->status == 1) || (!empty($receivedRequest) && $receivedRequest->status == 1)) {
            $status = 'friend-remove';
            $requestText = 'Remove Friendship';
        }

        $followStatus = 'follow';
        $followText = 'Follow';

        if(!empty($following)) {
            $followStatus = 'unfollow';
            $followText = 'Unfollow';
        }

        $blockStatus = '';
        $blockText = 'Block member';

        if(!empty($user_block)) {
            $blockStatus = 'unblockd';
            $blockText = 'Unblock member';
        }


    ?>
    <section class="profile-page-bg">
        <div class="container-xxl">
            <div class="profile-tabs-block">
                @if ($user->user_id == $globaldata['user']->user_id)
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
                @endif
            </div>
            @if ($user->user_id != $globaldata['user']->user_id)
                <div class="user-action-btn-group d-md-none">
                    <button type="button" class="user-action-btn friendship-btn-item" data-status="{{$status}}">{{$requestText}}</button>
                    @if($status == 'friend-request')
                    <button type="button" class="user-action-btn friend-accept-btn w-100 mt-1">Accept Friendship Request</button>
                    @endif
                    <button type="button" class="user-action-btn new-message-btn-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Message</button>

                    <button type="button" class="user-action-btn follow-btn-item" data-status="{{$followStatus}}">{{$followText}}</button>
                </div>
            @endif

            <div class="profile-row">
                <div class="profile-left-col">
                    <div class="profile-block">

                        <div class="profile-img-box ">
                            {!! Form::open(['url' => 'profile', 'id' => 'chnage_profile', 'class' => 'uploadimage_form']) !!}
                            <div class="form-group">
                                <div class="user-pro-img ">
                                    <img src="{{ $user->imagefilepath }}" data-src="{{ $user->imagefilepath }}"
                                        alt="profile" class="profile-image">
                                    @if ($user->user_id == $globaldata['user']->user_id)
                                        <div class="change-profile ">
                                            <label class="profile-change-btn">Change Profile Image
                                                <input name="imagefile" id="imagefile" type="file"
                                                    class="form-control d-none">
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {!! Form::close() !!}
                            @if ($user->user_id != $globaldata['user']->user_id)
                                {!! Form::open(['url' => 'block-user', 'id' => 'block_account_form']) !!}
                                    <input type="hidden" name="to_user_id" value="{{$user->user_id}}">

                                    <a href="#" class="block-user {{$blockStatus}}"><i class="fa fa-ban"></i>{{$blockText}}</a>
                                {!! Form::close() !!}
                            @endif
                            @if (($user->user_id == $globaldata['user']->user_id || $globaldata['user']->issuperadmin == 1) && $user->issuperadmin != 1)
                                {!! Form::open(['url' => 'delete-account', 'id' => 'delete_account']) !!}
                                <input type="hidden" name="user_id" value="{{$user->user_id}}">
                                <a href="#" class="delete-account">Delete Account</a>
                                {!! Form::close() !!}
                            @endif
                        </div>
                        <div class="profile-about-box">
                            <div class="user-name-box">
                                <h2>{{ $user->username }}</h2>
                                {{-- <a href="#"><i class="fas fa-gift"></i></a> --}}
                            </div>
                            {{-- <div class="user-status">
                                <ul>
                                    <li>jr member</li>
                                    <li class="right-border">|</li>
                                    <li>merit: 20</li>
                                    <li class="right-border">|</li>
                                    <li><a href="#">Trust: +3</a></li>
                                    <li class="right-border">|</li>
                                    <li><a href="#">Streaks: 1</a></li>
                                    <li class="right-border">|</li>
                                    <li>activity: 30</li>
                                </ul>
                            </div> --}}
                            <div class="user-self-details">
                                {{-- <div class="row">
                                    <div class="col-lg col-lg-6"> --}}
                                        <ul class="user-self-details-group">
                                            <li>
                                                <span class="user-about-property">Age:</span>
                                                <span
                                                    class="user-about-info">{{ \Carbon\Carbon::parse($user->dob)->age }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Sex:</span>
                                                <span class="user-about-info">{{ $gender[$user->gender] }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Relationship Status:</span>
                                                <span class="user-about-info">{{ $user->relationship_status }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Location:</span>
                                                <span class="user-about-info">{{ $address }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Orientation:</span>
                                                <span class="user-about-info">{{ $user->sexual_orientation }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Role:</span>
                                                <span class="user-about-info">{{ $user->role }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Seeking:</span>
                                                <span class="user-about-info">{{ $user->looking_for }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Registration Date:</span>
                                                <span
                                                    class="user-about-info">{{$user->created_at->format('M d, Y')}}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Active Posts:</span>
                                                <span class="user-about-info">0</span>
                                            </li>
                                        </ul>
                                    {{-- </div> --}}
                                    {{-- <div class="col-lg col-lg-6">
                                        <ul class="user-self-details-group">
                                            <li>
                                                <span class="user-about-property">Role:</span>
                                                <span class="user-about-info">{{ $user->role }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Seeking:</span>
                                                <span class="user-about-info">{{ $user->looking_for }}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Registration Date:</span>
                                                <span
                                                    class="user-about-info">{{$user->created_at->format('M d, Y')}}</span>
                                            </li>
                                            <li>
                                                <span class="user-about-property">Active Posts:</span>
                                                <span class="user-about-info">0</span>
                                            </li>
                                        </ul>
                                    </div> --}}
                                {{-- </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="about-me-block">
                        <h3 class="profile-title-elm">About Me</h3>
                        <?php $about_desc = str_replace('<div></div>', '<br>', htmlspecialchars_decode($user->about)); ?>
                        <span class="about-me-description"> {!! str_replace('<div><span></span></div>', '<br>', htmlspecialchars_decode($about_desc)) !!} </span>
                    </div>

                    <?php /*<div class="latest-activity">
                        <h3 class="profile-title-elm">Latest activity</h3>
                        <ul class="latest-activities-group">

                            @foreach ($user_activities as $user_activity)
                            <li class="activities-items">{{$user_activity->activity}}<b>  {{$user_activity->created_at->diffForHumans() }}</b></li>
                            @endforeach

                            {{-- <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li>
                            <li class="activities-items">Kink11 uploaded a <a href="#">new photo</a> 2h ago</li>
                            <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li>
                            <li class="activities-items">Kink11 uploaded a <a href="#">new photo</a> 2h ago</li>
                            <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li>
                            <li class="activities-items">Kink11 uploaded a <a href="#">new photo</a> 2h ago</li>
                            <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li>
                            <li class="activities-items">Kink11 uploaded a <a href="#">new photo</a> 2h ago</li>
                            <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li>
                            <li class="activities-items">Kink11 uploaded a <a href="#">new photo</a> 2h ago</li>
                            <li class="activities-items">Kink11 commented on <a href="#">Jenni1977`s</a> <a
                                    href="#">photo</a> Apr 27, 2022</li> --}}
                        </ul>
                    </div> */?>
                </div>
                <div class="profile-right-col">
                    @if ($user->user_id != $globaldata['user']->user_id)
                        <div class="user-action-btn-group d-none d-md-block">

                            <button type="button" class="user-action-btn friendship-btn-item" data-status="{{$status}}">{{$requestText}}</button>
                            @if($status == 'friend-request')
                            <button type="button" class="user-action-btn friend-accept-btn w-100 mt-1">Accept Friendship Request</button>
                            @endif
                            <button type="button" class="user-action-btn new-message-btn-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Message</button>
                            <button type="button" class="user-action-btn follow-btn-item" data-status="{{$followStatus}}">{{$followText}}</button>
                        </div>
                    @endif
                    <div class="view-all-items-block">

                        <h3 class="profile-title-elm">
                            <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-images') : url('/user-images/' . $user->user_id) }}">{{ $user_image_count }} Images</a>
                            @if ($user_image_count > 20)
                                 <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-images') : url('/user-images/' . $user->user_id) }}" class="view-all-btn">(View All)</a>
                            @endif
                        </h3>

                        <ul class="all-items-list">
                            @foreach ($user_image as $user_images)
                                <li><a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/image-detail/' . $user_images->media_id) : url('/image-detail/' . $user_images->media_id . '/' . $user->user_id) }}">
                                    <img src="{{ $user_images->mediumthumbimagefilepath }}" alt="Photos">
                                </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="view-all-items-block">
                            <h3 class="profile-title-elm">
                                <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-video') : url('/user-video/' . $user->user_id) }}">{{ $user_video_count }} Videos</a>
                                @if ($user_video_count > 20)
                                    <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-video') : url('/user-video/' . $user->user_id) }}"
                                class="view-all-btn">(View All)</a>
                                @endif
                            </h3>
                        <ul class="all-items-list">
                            @foreach ($user_video as $user_videos)
                                <li>
                                    <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/video-detail/' . $user_videos->media_id) : url('/video-detail/' . $user_videos->media_id . '/' . $user->user_id) }}">
                                        @if(!empty($user_videos->videothumbfilepath))
                                        <img src="{{$user_videos->videothumbfilepath}}">
                                        @else
                                        <video>
                                            <source src="{{ $user_videos->mediafile }}">
                                        </video>
                                        @endif
                                        <span class="play-icon"><i class="fas fa-play"></i></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(!$friends->isEmpty())
                    <div class="view-all-items-block">
                        <h3 class="profile-title-elm">{{$friendcounts > 0 ?$friendcounts:''}} Friends <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/friends') : url('/friends/' . $user->user_id) }}" class="view-all-btn">(View All)</a>
                        </h3>
                        <ul class="all-items-list">
                            @foreach($friends as $friend)

                            <?php
                                $frienduser = null;
                                if(!empty($friend->fromuser) && $friend->fromuser->user_id == $user->user_id) {
                                    $frienduser = $friend->touser;
                                }
                                else {
                                    $frienduser = $friend->fromuser;
                                }
                            ?>
                            @if(!empty($frienduser))
                            <li>
                                <a href="{{url('/profile/'.$frienduser->user_id)}}">
                                    <img src="{{$frienduser->mediumthumbimagefilepath}}" alt="{{$frienduser->username}}">
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(!$followers->isEmpty())
                    <div class="view-all-items-block">
                        <h3 class="profile-title-elm">{{$followers->count()}} Followers <!-- <a href="#" class="view-all-btn">(View All)</a> -->
                        </h3>
                        <ul class="all-items-list">
                            @foreach($followers as $follower)
                                @if(!empty($follower->fromuser))
                                <li>
                                    <a href="{{url('profile/'.$follower->fromuser->user_id)}}">
                                        <img src="{{$follower->fromuser->mediumthumbimagefilepath}}" alt="{{$follower->fromuser->username}}">
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(!$followings->isEmpty())
                    <div class="view-all-items-block following-box">
                        <h3 class="profile-title-elm">{{$followings->count()}} Following <!-- <a href="#" class="view-all-btn">(View All)</a> -->
                        </h3>
                        <ul class="all-items-list">
                            @foreach($followings as $following)
                            @if(!empty($following->touser))
                            <li>
                                <a href="{{url('profile/'.$following->touser->user_id)}}">
                                    <img src="{{$following->touser->mediumthumbimagefilepath}}" alt="{{$following->touser->username}}">
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="edit-group-area">
                        <h3 class="profile-title-elm">{{$member_kinks->count()}} Kinks
                            @if($user->user_id == $globaldata['user']->user_id)
                            <a href="{{url('/kink')}}" class="view-all-btn">(edit)</a>
                            @endif
                        </h3>
                        @if($user->user_id == $globaldata['user']->user_id)
                            @if ($member_kinks->count() <= 0 )
                                 <a href="{{url('/kink')}}" class="add-links">Add kinks »</a>
                            @endif
                        @endif
                        {{-- {{dd($member_kinks)}} --}}
                        @foreach ($member_kinks as $member_kink)
                        {{ $loop->first ? ' ' : ', ' }}
                            <a href="{{url('/kink-members/'.$member_kink->tag_id)}}" class="member-tag">{{$member_kink['membertag']->name}} </a>
                        @endforeach


                    </div>
                    @if(!$user->membergroups->isEmpty())
                    <div class="edit-group-area">
                        <h3 class="profile-title-elm">{{$user->membergroups->count()}} Groups <a href="{{url('/group')}}" class="view-all-btn">(View All)</a></h3>
                        @foreach($user->membergroups->take(10) as $groupmember)
                        @if(!empty($groupmember) && !empty($groupmember->group))
                        <a href="{{url('/discussion/'.$groupmember->group->group_id)}}" class="add-links">{{$groupmember->group->title}}</a>
                        @endif
                        @endforeach
                    </div>
                    @endif
                    {{-- <div class="edit-group-area">
                        <h3 class="profile-title-elm">2 Topics <a href="#" class="view-all-btn">(edit)</a></h3>
                        <a href="#" class="add-links">Would you have sex with Conjoined twins?</a>
                        <a href="#" class="add-links">Just an Idea? Post where your at?</a>
                    </div> --}}
                    <div class="current-postings">
                        <h3 class="profile-title-elm">Current Postings
                            @if($user->user_id == $globaldata['user']->user_id)
                            <a href="#" class="view-all-btn">(edit)</a>
                            @endif
                        </h3>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <div class="modal fade message-modal-bg" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    {!! Form::open(['url' => 'conversation', 'id' => 'conversation_form', 'class' => 'conversation_form']) !!}
                    <div class="modal-header">
                        <h5 class="new-conversation-titel">New conversation with {{$user->username}}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="conversation-box">
                            <input type="hidden" name="to_id" value="{{$user->user_id}}">
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" placeholder="Conversation subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" placeholder="Type your message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-conversation-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="start-conversation-btn">Start conversation</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- Modal -->

        <div class="modal fade message-modal-bg" id="friendRequestModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    {!! Form::open(['url' => 'friend-request', 'id' => 'friendrequest_form', 'class' => 'friendrequest_form']) !!}
                    <div class="modal-header mb-3">
                        <h5 class="new-conversation-titel">Friend request to {{$user->username}}</h5>
                        <h6 class="text-start">If you would like to become friends with Mytimetoenjoy, then we suggest you send an intro message. This helps them know who you are and what you're about. Intro messages are great ice breakers when meeting someone new.</h6>
                    </div>
                    <div class="modal-body">
                        <div class="conversation-box">
                            <input type="hidden" name="to_user_id" value="{{$user->user_id}}">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="5" placeholder="Type your message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-modal-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="submit-modal-btn">Start conversation</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {!! Form::open(['url' => 'friend-request-cancel', 'id' => 'friend_cancel_form', 'class' => 'friend_cancel_form']) !!}
            <input type="hidden" name="to_user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

        {!! Form::open(['url' => 'friend-remove', 'id' => 'friend_remove_form', 'class' => 'friend_remove_form']) !!}
            <input type="hidden" name="to_user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

        {!! Form::open(['url' => 'friend-request-decline', 'id' => 'friend_decline_form', 'class' => 'friend_decline_form']) !!}
            <input type="hidden" name="user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

        {!! Form::open(['url' => 'friend-request-accept', 'id' => 'friend_accept_form', 'class' => 'friend_accept_form']) !!}
            <input type="hidden" name="user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

        {!! Form::open(['url' => 'follow', 'id' => 'follow_form', 'class' => 'follow_form']) !!}
            <input type="hidden" name="to_user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

        {!! Form::open(['url' => 'unfollow', 'id' => 'unfollow_form', 'class' => 'unfollow_form']) !!}
            <input type="hidden" name="to_user_id" value="{{$user->user_id}}">
        {!! Form::close() !!}

    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/profile/profile.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
