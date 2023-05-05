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

<section class="topics-page">
    <div class="container-xl">
        <div class="casualencounters-w-wrap">
            <div class="group-discussion-bg">
                <div class="group-discussion-title align-items-center">
                    <div><a href="#">{{$group->title}}</a></div> 
                    <?php /*@if($group->status == 1 && empty($grouprequest) && empty($groupmember))
                        <button class="group-action-btn btn-request-group">Request to Join Group </button>
                    @elseif($group->status == 1 && !empty($grouprequest) && empty($groupmember))
                        <button class="group-action-btn btn-request-group leave">Cancel Join Group Request </button>
                    @elseif($group->status == 0 && empty($groupmember))
                        <button class="group-action-btn btn-join-group">Join Group</button>
                    @else
                        <button class="group-action-btn btn-join-group leave">Leave Group</button>
                    @endif */?>
                    <div class="group-btn-group">
                        @if($group->user_id != $globaldata['user']->user_id)
                            @if(empty($groupmember))
                                <button class="group-action-btn btn-join-group">Join Group</button>
                            @else
                                <button class="group-action-btn btn-join-group leave">Leave Group</button>
                            @endif
                        @endif
                        @if($group->user_id == $globaldata['user']->user_id || $globaldata['user']->issuperadmin == 1)
                        <button class="group-action-btn btn-delete btn-delete-group">Delete Group</button>
                        @endif

                        @if($group->user_id == $globaldata['user']->user_id)
                        <a href="{{url('/edit-group/'.$group->group_id)}}" class="group-action-btn btn-edit btn-edit-group">Edit Group</a>
                        @endif

                    </div>
                </div>
                @if($group->user_id == $globaldata['user']->user_id || $globaldata['user']->issuperadmin == 1)
                    {!! Form::open([ 'url' => 'delete-group', 'id' => 'delete_group_form', 'class' => 'delete_group_form' ]) !!}
                        <input type="hidden" name="group_id" value="{{$group->group_id}}">
                    {!! Form::close() !!}
                @endif
                <div class="gallery-pg-profile-box">
                    <div class="gallery-pg-pr-img">
                        <a href="{{url('profile/'.$group->user->user_id)}}">
                            <img src="{{ $group->user->mediumthumbimagefilepath }}" alt="profile image">
                        </a>
                    </div>
                    <div class="gallery-pg-pr-details">
                        <div>
                            <a href="{{url('profile/'.$group->user->user_id)}}" class="gallery-pg-user-name">{{ $group->user->username }}</a>
                            <ul class="gallery-pg-user-details">
                                <li>
                                    <a href="#">Trust: +3</a>
                                    <span class="border-right-side">|</span>
                                    <span>Jr  Member</span>
                                    <span class="border-right-side">|</span>
                                    <span>Age  {{ \Carbon\Carbon::parse($group->user->dob)->age }}
                                    </span>
                                    <span class="border-right-side">|</span>
                                    <span>{{ config('constants.gender')[$group->user->gender] }}
                                    </span>
                                    <span  class="border-right-side">|</span>
                                    <span>{{ $group->user->relationship_status }}</span>
                                </li>
                                <li>
                                    <a href="{{ $globaldata['user']->user_id == $group->user->user_id ? url('/profile') : url('/profile/' . $group->user->user_id) }}">
                                        <i class="fas fa-long-arrow-alt-left"></i> View Profile
                                    </a>
                                    <span class="border-right-side">|</span>
                                    <a href="{{ $globaldata['user']->user_id == $group->user->user_id ? url('/user-images') : url('/user-images/' . $group->user->user_id) }}">
                                        Pictures ({{ $user_image }})
                                    </a>
                                    <span class="border-right-side"> | </span>
                                    <a href="{{ $globaldata['user']->user_id == $group->user->user_id ? url('/user-video') : url('/user-video/' . $group->user->user_id) }}">
                                        Videos ({{ $user_video }})
                                    </a>
                                    <span class="border-right-side"> | </span>
                                    <span class="feed-status">
                                        {{ string_explode_implode($group->user->address) }}
                                    </span>

                                    
                                    @if($group->status == 1)
                                    <span class="border-right-side"> | </span>
                                    <span class="feed-status">
                                        <span class="feed-status rounded-pill badge bg-danger text-white" style="font-size: 11px;">Private</span>
                                    </span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="group-by">

                    <p class="g-message-metadata">
                        {{$group->description}}
                    </p>

                </div>
                <div class="text-end mb-2">
                    @if(empty($groupmember))
                    <a href="#" class="create-a-topic btn-join-group">Join group to start a new discussion</a>
                    @else
                    <a href="{{url('/creatediscussion/'.$group->group_id)}}" class="create-a-topic">Start a new discussion</a>
                    @endif
                </div>

                @if(!$sticky_discussions->isEmpty())
                <div class="sticky-label-items">
                    <ul class="sticky-items-group">
                        @foreach($sticky_discussions as $discussion)
                        <li>
                            <a href="{{url('/view-discussion/'.$discussion->group_discussion_id)}}" class="{{($discussion->isdiscussionread == 0?'unread':'')}}">
                            {{-- <a href="#" class="unread"> --}}
                                <div class="sticky-label">
                                    <span class="d-none d-md-block">Sticky</span>
                                    <i class="fas fa-thumbtack d-md-none"></i>
                                </div>
                                <p class="sticky-title">{{$discussion->title}}</p>
                                <span class="sticky-time">last updated {{$discussion->updated_at->format('M d, Y')}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(!$discussions->isEmpty())
                <div class="topics-items-list">
                    @foreach($discussions as $discussion)
                    <div class="topics-item-box {{($discussion->isdiscussionread == 0?'unread':'')}}" data-discussion_id="{{$discussion->group_discussion_id}}">
                        <a href="{{url('/view-discussion/'.$discussion->group_discussion_id)}}" class="blog-entry-box ">
                            <div class="blog-msg-avtar">
                                <img src="{{$discussion->user->smallthumbimagefilepath}}" alt="{{$discussion->user->username}}">
                            </div>
                            <div class="blog-msg-content">
                                <h2 class="topic-title">{{$discussion->title}}</h2>
                                <div class="topics-stats">
                                    <span>By: <span>{{$discussion->user->username}} </span><span>{{ Carbon\Carbon::parse($discussion->user->dob)->age }}{{ $discussion->user->gender }}</span></span>
                                    <span>|</span>
                                    <span>{{string_explode_implode($discussion->user->address)}}</span>
                                </div>
                                <div class="topic-content">
                                    {!! $discussion->content !!}
                                </div>
                            </div>
                        </a>
                        <div class="blog-stats-box">

                            <p>Total comments:<span>{{$discussion->comments->count()}}</span></p>
                            <p class="only-desktop">Created:<span>{{$discussion->created_at->format('M d, Y')}} </span></p>
                            @if(!empty($discussion->comments->last()))
                            <p>Last comment:<span>{{$discussion->comments->last()->created_at->format('M d, Y')}}</span></p>
                            <p class="only-desktop">By:<a href="{{url('/profile/'.$discussion->comments->last()->user->user_id)}}">{{$discussion->comments->last()->user->username}}</a></p>
                            @endif
                                <p class="only-desktop">Total views:<a href="#">{{$discussion->discussionviews->count()}}</a></p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($sticky_discussions->isEmpty() && $discussions->isEmpty())
                <div class="group-by-creating-box">
                    <p>There are no open discussions in this group<br class="d-none d-lg-block"> Be the first to kick off this group by creating the<br class="d-none d-lg-block"> very first <a href="{{url('/creatediscussion/'.$group->group_id)}}">open discussion</a></p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
{!! Form::open(['url' => 'request-join-group', 'id' => 'requestgroup_form', 'class' => 'requestgroup_form']) !!}
    <input type="hidden" name="group_id" value="{{$group->group_id}}">
{!! Form::close() !!}

{!! Form::open(['url' => 'join-group', 'id' => 'joingroup_form', 'class' => 'joingroup_form']) !!}
    <input type="hidden" name="group_id" value="{{$group->group_id}}">
{!! Form::close() !!}
@endsection
@section('page-scripts')
<script src="{{ asset_front('/js/group/discussion_details.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
