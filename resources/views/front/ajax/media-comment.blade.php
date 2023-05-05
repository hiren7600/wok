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
                    {{-- <li><span class="delete-reply-divider">.</span></li> --}}
                    <!-- <li><a href="#" class="like-comment has-like">Like <span
                        class="like-fas-heart"></span> <span
                        class="video-like-comment-num">2</span></a>
                    </li>
                    <li><span class="delete-reply-divider">.</span></li> -->
                    @if ($globaldata['user']->user_id == $mediacomment->user->user_id || $globaldata['user']->issuperadmin == 1)

                    &nbsp;
                    <li><a href="#" class="remove-comment-link"> Delete</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="all-comments-here">
        <div class="media-rpl-wrap">

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
