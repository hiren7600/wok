<div class="topics-comment-list comment{{ $discussioncomment->group_discussion_comment_id }}" data-media_comment_id="{{ $discussioncomment->group_discussion_comment_id }}" data-media_id="{{ $discussioncomment->group_discussion_id }}">
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
                <a href="#"><img src="{{$discussioncomment->user->smallthumbimagefilepath}}"
                        alt="{{$discussioncomment->user->username}}">
                </a>
            </div>
            <span>
                <a href="#" class="message-user-name">{{$discussioncomment->user->username}}</a>
                <span class="show-member feed-status">{{ Carbon\Carbon::parse($discussioncomment->user->dob)->age }}{{ $discussioncomment->user->gender }}</span>
                <span class="border-right-side">|</span>
                <span class="feed-status">{{string_explode_implode($discussioncomment->user->address)}}</span>
            </span>
        </div>
        <p class="g-message-metadata mt-1">
            {!!$discussioncomment->comments!!}
        </p>
    </div>
        @if ($discussioncomment->imagefile)
            <img src="{{$discussioncomment->imagefile}}" alt="media" class="share-img-in-topic-comm">
        @endif
​
    <ul class="topic-comment-status-time">
        <li class="post-time-item"> {{ $discussioncomment->created_at->diffForHumans() }}</li>
        <li><span class="divid-dot">.</span></li>
        <li><a class="post-cmt-rpl" href="#">Reply</a></li>
    </ul>
    <div class="all-comments-data">
        <div class="all-comment-replay">

        </div>
        <div class="topic-reply-textarea-box mt-3 pb-0 d-none">
            {!! Form::open(['url' => 'discussion/comment-reply', 'class' => 'discussion_comment_repl_form' ,'id'=>'discussion_comment_repl_form']) !!}
                <input type="hidden" name="group_discussion_id" value="{{ $discussioncomment->group_discussion_id }}" >
                <input type="hidden" name="group_discussion_comment_id" value="{{ $discussioncomment->group_discussion_comment_id }}">
​
                <div class="feed-form-row">
                    <div class="user-avatar">
                        <a href="#"><img src="{{$globaldata['user']->smallthumbimagefilepath}}" alt="{{$globaldata['user']->username}}"></a>
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
​
            {!! Form::close() !!}
        </div>
    </div>
</div>
