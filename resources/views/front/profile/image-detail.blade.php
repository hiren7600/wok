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
    <section class="video-details-page">
        <div class="container-xxl">
            <div class="video-content-area">
                <div class="common-row">
                    <div class="common-left-column">
                        <div class="kink-video-play-area">
                            <div class="gallery-pg-profile-box">
                                <div class="gallery-pg-pr-img">
                                    <a href="{{url('profile/'.$user->user_id)}}">
                                        <img src="{{ $user->mediumthumbimagefilepath }}" alt="profile image">
                                    </a>
                                </div>
                                <div class="gallery-pg-pr-details">
                                    <div>
                                        <a href="{{url('profile/'.$user->user_id)}}" class="gallery-pg-user-name">{{ $user->username }}</a>
                                        <ul class="gallery-pg-user-details">
                                            <li>
                                                <a href="#">Trust: +3</a>
                                                <span class="border-right-side">|</span>
                                                <span>Jr  Member</span>
                                                <span class="border-right-side">|</span>
                                                <span>Age  {{ \Carbon\Carbon::parse($user->dob)->age }}
                                                </span>
                                                <span class="border-right-side">|</span>
                                                <span>{{ config('constants.gender')[$user->gender] }}
                                                </span>
                                                <span  class="border-right-side">|</span>
                                                <span>{{ $user->relationship_status }}</span>
                                            </li>
                                            <li><a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/profile') : url('/profile/' . $user->user_id) }}">
                                                <i class="fas fa-long-arrow-alt-left"></i> View Profile</a><span class="border-right-side">|</span><a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-images') : url('/user-images/' . $user->user_id) }}">Pictures ({{ count($user_image) }})</a>
                                                <span class="border-right-side"> | </span>
                                                <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/user-video') : url('/user-video/' . $user->user_id) }}">Videos ({{ $user_video }})</a>
                                                <span class="border-right-side"> | </span>
                                                <span class="feed-status">{{ string_explode_implode($user->address) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    @if ($globaldata['user']->user_id != $user->user_id)
                                        <div class="gallery-profile-follow-btn">
                                            <a href="#">Follow</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="kink-show-pictures">

                                <div class="main-image-box">
                                    <a href="#"><img src="{{ $single_media['mediafile'] }}" alt="main picture"
                                            class="main-picture-item"></a>

                                    <p class="poste-time-view-element">Posted  {{ $single_media->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="kink-video-primary-info-renderer">
                                    <div class="top-level-buttons kink-menu-renderer">
                                        <ul class="top-level-btn-group">
                                            <li class="top-level-btn-item"><a href="#"><i class="fas fa-eye"></i>
                                                {{$usermediaview}}</a>
                                            </li>

                                            <li class="top-level-btn-item">

                                                <a href="#" class="like-button {{($isVideoLiked == true?'active':'')}}" data-media_id="{{$single_media->media_id}}">
                                                    <i class="fas fa-heart"></i>
                                                    <span>{{$user_video_like}}</span>
                                                </a>

                                            </li>
                                            <li class="top-level-btn-item">
                                                <a href="#" class="comment-count"><i
                                                class="fas fa-comment"></i>
                                                <span>{{$media_comment}}</span>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>

                                @if ($globaldata['user']->user_id == $user->user_id)

                                <div class="add-tags-box">
                                    <div class="tags-block">
                                        <div class="tags-title">Tags:</div>
                                        <div class="tags-items">
                                            <a href="#">{{ $single_media->tag}} </a>
                                        </div>
                                        <div class="add-tags-btn">
                                            <div class="edit-tag-open-btn">(Add)</div>
                                            {{-- <button class="edit-tag-open-btn">(Add)</button    > --}}
                                        </div>
                                    </div>

                                    {!! Form::open([
                                        'url' => 'tag-update',
                                        'id' => 'tag_update_form',
                                        'class' => 'tag_update_form',
                                    ]) !!}
                                        <div class="tags-edit-box tag-box-open" style="display: none">
                                            <div class="form-group caption-form-group image-tag-select">
                                                    {!! Form::select('tags[]', $image_tag, explode(',',$single_media->tag), [
                                                    'class' => 'form-control tagify-input-box',
                                                    'id' => 'tags',
                                                    'multiple' => 'multiple',
                                                    'data-placeholder' => 'Hotwife, Nipples, Creampie...',
                                                ]) !!}
                                                <input type="hidden" name="media_id"
                                                value="{{ $single_media['media_id'] }}">
                                            </div>
                                            <div class="tag-update-buttons">
                                                <div class="cancel-tags">Cancel</div>
                                                <button type="submit" class="save-tag">Save changes</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                                <div>
                                    <div class="video-captions">
                                        <p>{{ $single_media['caption'] }}</p>
                                        <div class="">
                                            <button class="edit-caption-open-btn">edit caption</button>
                                            {!! Form::open([
                                                'url' => 'image-detail',
                                                'id' => 'image_detail',
                                                'class' => 'image_detail',
                                            ]) !!}
                                                <div class="tags-edit-box edit-caption-box form-group" style="display: none">
                                                    <input type="hidden" name="media_id"
                                                        value="{{ $single_media['media_id'] }}">
                                                    <div class="tag-select-area">
                                                        <input type="text" name="image_caption" class="caption-text-box"
                                                        value="{{ $single_media['caption'] }}">
                                                    </div>
                                                    <div class="tag-update-buttons">
                                                        <div class="cancel-caption">Cancel</div>
                                                        <button type="submit" class="save-tag">Save changes</button>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}

                                            <div class="edit-expose-box">
                                                {!! Form::open([ 'url' => 'image/show-to', 'id' => 'image_show_form', 'class' => 'image_show_form' ]) !!}
                                                    <input type="hidden" name="media_id"
                                                        value="{{ $single_media['media_id'] }}">
                                                    <div class="set-for-friends-box">
                                                        @if ($single_media->showto == 0)
                                                            <input type="hidden" name="image_show" value="1">
                                                            <button class="set-for-friends-btn">Set for friends</button>
                                                        @else
                                                            <input type="hidden" name="image_show" value="0">
                                                            <button class="set-for-friends-btn"> Everyone</button>
                                                        @endif
                                                    </div>
                                                {!! Form::close() !!}

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if ($globaldata['user']->issuperadmin == 1 || $globaldata['user']->user_id == $user->user_id )
                                    <div class="text-center">
                                        {!! Form::open([
                                            'url' => 'delete-image',
                                            'id' => 'image_delete',
                                            'class' => 'image_delete',
                                        ]) !!}
                                            <button class="delete-out-items">Delete Image</button>
                                            <input type="hidden" name="media_id"
                                            value="{{ $single_media['media_id'] }}">
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                                @if ($globaldata['user']->issuperadmin == 1 )
                                <div class="text-center">
                                    {!! Form::open([ 'url' => 'expose-image', 'id' => 'image_expose_form', 'class' => 'image_expose_form' ]) !!}
                                        <input type="hidden" name="media_id"
                                            value="{{ $single_media['media_id'] }}">
                                        @if ($single_media->is_exposed == 0)
                                            <input type="hidden" name="exposed" value="1">
                                            <div class="set-for-friends-box">
                                                <button class="set-for-friends-btn">Exposed</button>
                                            </div>
                                        @else
                                            <input type="hidden" name="exposed" value="0">
                                            <div class="set-for-friends-box">
                                                <button class="set-for-friends-btn">Unexposed</button>
                                            </div>
                                        @endif
                                    {!! Form::close() !!}
                                </div>
                                @endif
                                <div class="sub-images-mobile d-md-none pt-3">
                                    <div class="user-action-btn-group mb-2">
                                        <a href="{{url('image-detail/'.$prevId)}}" class="user-action-btn new-message-btn-item">Preview</a>
                                        <a href="{{url('image-detail/'.$nextId)}}" class="user-action-btn follow-btn-item">Next</a>
                                    </div>
                                    <div class="sub-image-inner">
                                        <ul class="sub-image-group">
                                            @foreach ($user_image as $user_images)
                                                <li class="sub-image-list">
                                                    <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/image-detail/' . $user_images->media_id) : url('/image-detail/' . $user_images->media_id . '/' . $user->user_id) }}">
                                                        <img src="{{ $user_images->mediumthumbimagefilepath }}" alt="Photos">
                                                    </a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <div class="video-load-more">
                                        <button>Show more related videos</button>
                                    </div>
                                </div>

                                <div class="video-comments-area">
                                    <div class="video-comments-list">
                                        @if(!$single_media->comments->isEmpty())
                                        @foreach($single_media->comments as $mediacomment)
                                        <div class="media-comment-item comment{{ $mediacomment->media_comment_id }}" data-media_comment_id="{{ $mediacomment->media_comment_id }}" data-media_id="{{ $mediacomment->media_id }}">
                                            <div class="feed-box video-main-comment">
                                                <div class="feed-avatar">
                                                    <img class="feed-post-user-img" src="{{$mediacomment->user->smallthumbimagefilepath}}" alt="avatar">
                                                </div>
                                                <div class="feed-data text-start">
                                                    <div class="feed-user-name"><a href="{{url('profile/'.$mediacomment->user->user_id)}}"
                                                        class="feed-user-name-item">{{ $mediacomment->user->username }}</a>
                                                        <span class="feed-status">{{ Carbon\Carbon::parse($mediacomment->user->dob)->age }}{{ $mediacomment->user->gender }}</span>
                                                    </div>
                                                    <div class="feed-post-content">
                                                        {{ $mediacomment->comment }}
                                                    </div>
                                                    <div class="feed-post-time">
                                                        <ul>
                                                            <li class="post-time-item">{{ $mediacomment->created_at->diffForHumans() }}</li>
                                                            <li><a href="#" class="post-rpl">Reply</a></li>

                                                            <!-- <li><a href="#" class="like-comment has-like">Like <span
                                                                class="like-fas-heart"></span> <span
                                                                class="video-like-comment-num">2</span></a>
                                                            </li>
                                                            <li><span class="delete-reply-divider">.</span></li> -->
                                                            {{-- <li><a href="#" class="remove-comment-link">Delete</a></li> --}}

                                                            @if ($globaldata['user']->user_id == $mediacomment->user->user_id || $globaldata['user']->issuperadmin == 1)
                                                            {{-- <li><span class="delete-reply-divider">.</span></li> --}}
                                                            &nbsp;
                                                            <li><a href="#"
                                                                        class="remove-comment-link"> Delete</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="all-comments-here">
                                                <div class="media-rpl-wrap">
                                                    @if(!$mediacomment->replycomments->isEmpty())
                                                    @foreach($mediacomment->replycomments as $mediarplcomment)
                                                        <div class="feed-comment-item reply-comment{{ $mediarplcomment->media_comment_id }}" data-rpl_comment_id="{{$mediarplcomment->media_comment_id}}">
                                                            <div class="feed-box">
                                                                <div class="feed-avatar">
                                                                    <img class="feed-post-user-img" src="{{$mediarplcomment->user->smallthumbimagefilepath}}"
                                                                        alt="feed avatar">
                                                                </div>
                                                                <div class="feed-data text-start">
                                                                    <div class="feed-user-name"><a href="{{url('profile/'.$mediarplcomment->user->user_id)}}"
                                                                        class="feed-user-name-item">{{$mediarplcomment->user->username}}</a>
                                                                        <span class="feed-status mobile-change">{{ Carbon\Carbon::parse($mediarplcomment->user->dob)->age }}{{ $mediarplcomment->user->gender }}</span>
                                                                    </div>
                                                                    <div class="feed-post-content">
                                                                        {{$mediarplcomment->comment}}
                                                                    </div>
                                                                    <div class="feed-post-time">
                                                                        <ul>
                                                                            <li class="post-time-item">{{ $mediarplcomment->created_at->diffForHumans() }}</li>

                                                                            @if ($globaldata['user']->user_id == $mediarplcomment->user->user_id || $globaldata['user']->issuperadmin == 1)
                                                                            {{-- <li><span class="delete-reply-divider">.</span></li> --}}
                                                                                <li class="post-time-item"><a href="#" class="remove-rpl-comment-link">Delete</a></li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                <div class="feed-wrapper comment-reply-write d-none">
                                                    {!! Form::open(['url' => 'media/comment-reply', 'class' => 'media_comment_reply_form']) !!}
                                                    <input type="hidden" name="media_id" value="{{$mediacomment->media_id}}" >
                                                    <input type="hidden" name="mediatype" value="{{ $mediacomment->type }}">
                                                    <input type="hidden" name="media_comment_id" value="{{ $mediacomment->media_comment_id }}" >
                                                    <div class="feed-form-wrap mt-4">
                                                        <div class="feed-form-row">
                                                            <div class="user-avatar">
                                                                <a href="{{ url('/profile/'.$globaldata['user']->user_id)}}">
                                                                    <img src="{{ $globaldata['user']->smallthumbimagefilepath }}"
                                                                    alt="logo">
                                                                </a>
                                                            </div>
                                                            <div class="feed-form-input">
                                                                <div class="form-group">
                                                                    <textarea name="reply_comment" maxlength="250" placeholder="Write a comment..." class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="video-comment-btn-group">
                                                            <button type="button"
                                                                class="btn btn-sm video-comment-cancel-btn cancel-rply-comment-btn">Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="btn btn-sm video-comment-post-btn reply-comment-post-btn">Post it</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

                                    <div class="video-comment-write-box">
                                        <div class="feed-wrapper">
                                            <div class="feed-form-wrap mt-4">
                                                <div class="log-msg-wrapper"></div>

                                                {!! Form::open(['url' => 'media/comment', 'class' => 'media_comment_form']) !!}
                                                <input type="hidden" name="media_id" value="{{$single_media->media_id}}" >
                                                <input type="hidden" name="mediatype" value="0">
                                                <div class="feed-form-row">
                                                    <div class="user-avatar">
                                                        <a href="{{ url('/profile/'.$globaldata['user']->user_id)}}"><img src="{{ $globaldata['user']->smallthumbimagefilepath }}" alt="logo"></a>
                                                    </div>
                                                    <div class="feed-form-input">
                                                        <div class="form-group">
                                                            <textarea name="media_comment" id="media_comment" maxlength="250" placeholder="Write a comment..." class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="video-comment-btn-group">
                                                    <button type="button"
                                                        class="btn btn-sm video-comment-cancel-btn media-comment-cancel-btn">Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-sm video-comment-post-btn">Post
                                                    it</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="common-right-column  d-none d-md-block">
                        <div class="user-action-btn-group mb-2">
                            <a href="{{url('image-detail/'.$prevId)}}" class="user-action-btn new-message-btn-item">Preview</a>
                            <a href="{{url('image-detail/'.$nextId)}}" class="user-action-btn follow-btn-item">Next</a>
                        </div>
                        <div class="view-all-items-block">
                            <ul class="all-items-list">
                                @foreach ($user_image as $user_images)
                                    <li>
                                        <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/image-detail/' . $user_images->media_id) : url('/image-detail/' . $user_images->media_id . '/' . $user->user_id) }}">
                                            <img src="{{ $user_images->mediumthumbimagefilepath }}" alt="Photos">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/profile/image-detail.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
