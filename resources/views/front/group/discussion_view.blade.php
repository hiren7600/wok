@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Discussion</title>
    @endif
@endsection

@section('content')

<section class="discussion-details-page">
    <div class="container-xl">
        <div>
            <div class="discussion-details-main-bg mt-5 mb-5">
                <div class="common-row">
                    <div class="common-left-column pe-md-5">
                        <div class="discussion-main-box">
                            <div class="group-by mb-0">

                                @if (!empty($group_discussion->user))
                                <div class="message-user-box">
                                    <a href="#" class="report-toggle-menu">Report</a>
                                    <div class="message-author-info">
                                        <a href="{{url('/profile/'.$group_discussion->user->user_id)}}"><img src="{{$group_discussion->user->smallthumbimagefilepath}}" alt="{{$group_discussion->user->username}}"></a>
                                    </div>

                                    <span>
                                        <a href="#" class="message-user-name">{{$group_discussion->user->username}}</a>
                                        <span class="show-member feed-status">{{ Carbon\Carbon::parse($group_discussion->user->dob)->age }}{{ $group_discussion->user->gender }}</span>
                                        <span class="border-right-side">|</span>
                                        <span class="feed-status">{{string_explode_implode($group_discussion->user->address)}}</span>
                                        {{-- <ul class="gallery-pg-user-details">
                                            <li>
                                                <a href="#">Trust: +3</a>
                                                <span class="border-right-side">|</span>
                                                <span>Jr  Member</span>
                                                <span class="border-right-side">|</span>
                                                <span>Age  {{ \Carbon\Carbon::parse($group_discussion->user->dob)->age }}
                                                </span>
                                                <span class="border-right-side">|</span>
                                                <span>{{ config('constants.gender')[$group_discussion->user->gender] }}
                                                </span>
                                                <span  class="border-right-side">|</span>
                                                <span>{{ $group_discussion->user->relationship_status }}</span>
                                            </li>
                                            <li>
                                                <a href="{{ $globaldata['user']->user_id == $group_discussion->user->user_id ? url('/profile') : url('/profile/' . $group_discussion->user->user_id) }}">
                                                    <i class="fas fa-long-arrow-alt-left"></i> View Profile
                                                </a>
                                                <span class="border-right-side">|</span>
                                                <a href="{{ $globaldata['user']->user_id == $group_discussion->user->user_id ? url('/user-images') : url('/user-images/' . $group_discussion->user->user_id) }}">
                                                    Pictures ({{ $user_image}})
                                                </a>
                                                <span class="border-right-side"> | </span>
                                                <a href="{{ $globaldata['user']->user_id == $group_discussion->user->user_id ? url('/user-video') : url('/user-video/' . $group_discussion->user->user_id) }}">
                                                    Videos ({{ $user_video}})
                                                </a>


                                            </li>
                                        </ul> --}}
                                    </span>
                                </div>
                                @endif
                                <h2 class="discussion-for-title">{{$group_discussion->title}}</h2>
                            </div>

                            <div class="topic-content-body">
                                {!!$group_discussion->content!!}
                                @if (!empty($group_discussion->imagefile))
                                    <img src="{{$group_discussion->imagefile}}" alt="post-image">
                                @endif
                            </div>
                            <p class="post-share-date">Posted {{$group_discussion->created_at->format('M d, Y')}} </p>
                            <div class="kinky-likes-btn">
                               {{--  <a href="#" class="has-like">Like<i class="fas fa-heart"></i> <span class="like-cunt">0</span></a> --}}
                                <a href="#" class="like-button {{($isVideoLiked == true?'has-like':'')}}" data-discussion_id="{{$group_discussion->group_discussion_id}}">Like
                                    <i class="fas fa-heart"></i>  <span class="like-cunt">{{$discussion_like}}</span>
                                </a>
                                <div class="delete-edit-act-btn">
                                    @if (!empty($group_discussion->user))
                                        @if ($globaldata['user']->user_id == $group_discussion->user->user_id || $globaldata['user']->issuperadmin == 1)
                                        {!! Form::open([ 'url' => 'delete-discussion', 'id' => 'delete_discussion_form', 'class' => 'delete_discussion_form' ]) !!}
                                            <input type="hidden" name="group_discussion_id" value="{{$group_discussion->group_discussion_id}}">
                                            <button class="delete-discussion-btn"><i class="fas fa-trash-alt"></i></button>
                                        {!! Form::close() !!}

                                        <a href="{{url('/edit-discussion/'.$group_discussion->group_discussion_id)}}"><i class="fas fa-pen"></i></a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!empty($group_discussion->user) && $globaldata['user']->user_id == $group_discussion->user->user_id)
                            @if ($group_discussion->is_closed == 0)
                                <button class="close-topic"  data-discussion_id="{{$group_discussion->group_discussion_id}}" data-is_closed="1">Close Topic</button>
                            @else
                                <button class="close-topic"  data-discussion_id="{{$group_discussion->group_discussion_id}}" data-is_closed="0">Open Topic</button>
                            @endif
                        @endif

                        <div class="report-topic-comment-form">
                            <h2 class="report-comment-title">Report Topic or Comment</h2>
                            <div class="report-topic-content">
                                If you feel this topic or comment is not appropriate for any of the following
                                reasons: <br>
                                <b>Personal attacking - threat's - spam - violation of our terms</b>
                                Report it to us, and we will have a look at it and remove it if needed.
                            </div>
                            <div class="report-controler-btn">
                                <a href="#" class="report-cancel-toggle">Cancel</a>
                                <button type="submit">Report</button>
                            </div>
                        </div>
                        <div class="topic-comment-box">

                            <span class="comment-number-text"><span>{{count($group_discussion->allcomments)}}</span> Comment(s)</span>

                            <div class="topic-comment-list">
                                @if(!$group_discussion->comments->isEmpty())
                                @foreach($group_discussion->comments as $discussioncomment)
                                    <div class="topics-comment-list comment{{           $discussioncomment->group_discussion_comment_id }}" data-media_comment_id="{{ $discussioncomment->group_discussion_comment_id }}" data-media_id="{{ $discussioncomment->group_discussion_id }}">
                                        <div class="hover-show-menu">
                                            <div class="comment-toggle-menu">
                                                <a href="#" class="comment-toggle-btn"><i class="fas fa-ellipsis-h"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Merit</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Report
                                                        </a></li>
                                                </ul>
                                            </div>
                                            <div class="message-user-box">
                                                <div class="message-author-info">
                                                    <a href="{{url('/profile/'.$discussioncomment->user->user_id)}}">
                                                        <img src="{{$discussioncomment->user->smallthumbimagefilepath}}" alt="{{$discussioncomment->user->username}}">
                                                    </a>
                                                </div>
                                                <span>
                                                    <a href="{{url('/profile/'.$discussioncomment->user->user_id)}}" class="message-user-name">{{$discussioncomment->user->username}}</a>
                                                    <span class="show-member feed-status">{{ Carbon\Carbon::parse($discussioncomment->user->dob)->age }}{{ $discussioncomment->user->gender }}</span>
                                                    <span class="border-right-side">|</span>
                                                    <span class="feed-status">{{string_explode_implode($discussioncomment->user->address)}}</span>
                                                </span>
                                            </div>
                                            {{-- {{dd($discussioncomment->comments)}} --}}
                                            <p class="g-message-metadata mt-1">
                                                {!!$discussioncomment->comments!!}
                                            </p>
                                        </div>
                                            @if ($discussioncomment->imagefile)
                                                <img src="{{$discussioncomment->imagefile}}" alt="media" class="share-img-in-topic-comm">
                                            @endif

                                        <ul class="topic-comment-status-time">
                                            <li class="post-time-item"> {{ $discussioncomment->created_at->diffForHumans() }}</li>
                                            <li><span class="divid-dot">.</span></li>
                                            <li><a class="post-cmt-rpl" href="#">Reply</a></li>
                                        </ul>
                                        <div class="all-comments-data">
                                            <div class="all-comment-replay">
                                                @if(!$discussioncomment->replycomments->isEmpty())
                                                    @foreach($discussioncomment->replycomments as $discussionrplcomment)

                                                        <div class="toipc-reply-comment-list reply-comment{{ $discussionrplcomment->discussion_comment_id }}" data-rpl_comment_id="{{$discussionrplcomment->discussion_comment_id}}">
                                                            <div class="hover-show-menu">
                                                                <div class="comment-toggle-menu">
                                                                    <a href="#" class="comment-toggle-btn"><i
                                                                            class="fas fa-ellipsis-h"></i></a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#">Merit</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#">Report
                                                                            </a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="message-user-box">
                                                                    <div class="reply-author-info">
                                                                        <a href="{{url('/profile/'.$discussionrplcomment->user->user_id)}}">
                                                                            <img src="{{$discussionrplcomment->user->smallthumbimagefilepath}}" alt=" {{$discussionrplcomment->user->username}}">
                                                                        </a>
                                                                    </div>
                                                                    <span>
                                                                        <a href="{{url('/profile/'.$discussionrplcomment->user->user_id)}}" class="message-user-name">{{$discussionrplcomment->user->username}}</a>
                                                                        <span class="show-member feed-status">{{ Carbon\Carbon::parse($discussionrplcomment->user->dob)->age }}{{ $discussionrplcomment->user->gender }}</span>
                                                                        <span class="border-right-side">|</span>
                                                                        <span class="feed-status">{{string_explode_implode($discussionrplcomment->user->address)}}</span>
                                                                    </span>
                                                                </div>
                                                                <p class="g-message-metadata mt-1">{!!$discussionrplcomment->comments!!}</p>
                                                            </div>
                                                            <ul class="topic-reply-comm-status">
                                                                <li>{{ $discussionrplcomment->created_at->diffForHumans() }}</li>
                                                                {{-- <li><span class="divid-dot">.</span></li>
                                                                <li class=""><a href="#" class="topic-reply-delete">Delete</a>
                                                                </li>
                                                                <li><span class="divid-dot">.</span></li>
                                                                <li><a href="#">Report</a></li>
                                                                <li><span class="divid-dot">.</span></li>
                                                                <li>
                                                                    <a href="#" class="has-like">Like
                                                                        <span class="like-cunt">0</span></a>
                                                                </li> --}}
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="topic-reply-textarea-box mt-3 pb-0 d-none">
                                                {!! Form::open(['url' => 'discussion/comment-reply', 'class' => 'discussion_comment_repl_form' ,'id'=>'discussion_comment_repl_form']) !!}
                                                    <input type="hidden" name="group_discussion_id" value="{{ $discussioncomment->group_discussion_id }}" >
                                                    <input type="hidden" name="group_discussion_comment_id" value="{{ $discussioncomment->group_discussion_comment_id }}">

                                                    <div class="feed-form-row">
                                                        <div class="user-avatar">
                                                            <a href="{{url('/profile/'.$globaldata['user']->user_id)}}"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="{{$globaldata['user']->username}}"></a>
                                                        </div>
                                                        <div class="topic-comment-input">
                                                            <div class="form-group">
                                                                <textarea name="reply_comment"  placeholder="Write a comment..." class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="video-comment-btn-group">
                                                        <button type="button" class="btn btn-sm video-comment-cancel-btn">Cancel
                                                        </button>
                                                        <button type="submit" id="repl-comment-post-btn" class="btn btn-sm video-comment-post-btn">Post
                                                            it</button>
                                                    </div>

                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            @if ($group_discussion->is_closed == 0)
                                @if(!empty($group_discussion->user) && $group_discussion->user->user_id != $globaldata['user']->user_id && empty($groupmember))
                                    <div class="join-group-text"><a href="#" class="btn-join-group">click here </a>to join this group and comment on it</div>
                                @else
                                    {!! Form::open(['url' => 'discussion/comment', 'class' => 'discussion_comment_form' ,'id'=>'discussion_comment_form']) !!}
                                        <div class="topic-comment-create-msgbox">
                                            <input type="hidden" name="discussion_id" value="{{$group_discussion->group_discussion_id}}" >
                                            <div class="create-msg-form-box">
                                                <div class="topic-comm-user">
                                                    <img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="profile">
                                                </div>
                                                <div class="topic-comment-textarea">
                                                    <textarea name="discussion_comment" id="discussion_comment" placeholder="Comments"
                                                        class="form-control"></textarea>
                                                </div>
                                                <div class="your-image-uploader">
                                                    <label>
                                                        <span>Select an image or drag/drop your pic here</span>
                                                        {{-- <input type="file"> --}}
                                                        <input name="imagefile" id="imagefile" type="file"
                                                        class="form-control">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="video-comment-btn-group mt-2">
                                                <button type="button" class="btn btn-sm video-comment-cancel-btn">Cancel
                                                </button>
                                                <button type="submit"  class="btn btn-sm video-comment-post-btn">Post
                                                    it</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                @endif
                            @else
                                <div class="topic-close-text">This topic is closed for comments</div>
                            @endif
                        </div>
                    </div>
                    <div class="common-right-column pt-0 ps-0">
                        <div class="side-description px-0">
                            <p><b>What are subgroups?</b></p>
                            <p>Subgroups are like topics inside groups. For example, if the group is called Breast,
                                then the subgroups would be anything related to breast.</p>
                            <p>Another example is Massage Parlors</p>
                            <p>Subgroups could be:<br>
                                - Denver Massage<br>
                                - Miami Massage<br>
                                - Houston Massage.</p>

                            @if(!empty($group_discussion->user) && $group_discussion->user->user_id != $globaldata['user']->user_id)
                                @if(empty($groupmember))
                                    <button class="leave-group-btn btn-join-group">Join Group</button>
                                @else
                                     <a href="{{url('/creatediscussion/'.$group_discussion->group_id)}}" class="start-writing">Start Writing Something Good!</a>
                                     <button class="leave-group-btn btn-join-group leave">Leave Group</button>
                                @endif
                            @endif

                            @if(!empty($group_discussion->user) && $group_discussion->user->user_id == $globaldata['user']->user_id)
                                <a href="{{url('/creatediscussion/'.$group_discussion->group_id)}}" class="start-writing">Start Writing Something Good!</a>
                            @endif

                            <a href="{{url('/group')}}" class="back-to-group-page">Back to Groups</a>
                        </div>
                        <div class="group-members-view-box">
                            <div class="view-all-items-block">
                                <h3 class="profile-title-elm mb-3">Group members ({{number_format($group_member_count)}}) <a href="{{url('/group-member/'.$group_discussion->group_id)}}"
                                        class="view-all-btn">(View All)</a></h3>

                                <ul class="all-items-list">
                                    @foreach ($group_members as $group_member)
                                        @if (!empty($group_member))
                                        @if (!empty($group_member->user))
                                            <li><a href="{{url('/profile/'.$group_member->user_id)}}"><img src="{{$group_member->user->smallthumbimagefilepath}}" alt="{{$group_member->username}}"></a></li>
                                        @endif
                                        @endif
                                    @endforeach
                                </ul>
                                {{-- <a href="#"
                                    class="view-all-btn text-center d-block golden-color text-decoration-none">View
                                    All</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{!! Form::open(['url' => 'join-group', 'id' => 'joingroup_form', 'class' => 'joingroup_form']) !!}
    <input type="hidden" name="group_id" value="{{$group_discussion->group_id}}">
{!! Form::close() !!}
@endsection
@section('page-scripts')
<script src="{{ asset_front('/js/group/discussion_view.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
