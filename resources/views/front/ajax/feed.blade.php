<div class="feed-item feed{{$post->post_id}}" data-id="{{ $post->post_id }}">
    <div class="feed-box">
        <div class="feed-avatar">
            <img class="feed-post-user-img" src="{{ $post->user->smallthumbimagefilepath }}">
        </div>
        <div class="feed-data text-start">
            <div class="feed-user-name">
                <a href="{{ url('/profile/'.$post->user->user_id ) }}" class="feed-user-name-item">{{ $post->user->username }}</a>
                <span class="feed-status">{{Carbon\Carbon::parse($post->user->dob)->age}}{{$post->user->gender}}</span>
                <span class="border-right-side">|</span>
                <span class="feed-status">{{ string_explode_implode($post->user->address)}}</span>
                <!-- <span class="border-right-side">|</span>
                <span class="feed-status">Moderator</span>
                <a href="#" class="feed-status"><img src="" alt=""></a>
                 -->
            </div>
            <div class="feed-post-content">{{ $post->content }}</div>
            @if(!empty($post->media))
                @if($post->media->media_type == 0)
                <div class="feed-media">
                    <img src="{{$post->media->filesize}}">
                </div>
                @else
                <div class="feed-media">
                    <video width="400" controls>
                        <source src="{{$post->media->filesize}}" type="video/{{$post->media->extension}}">
                        Your browser does not support HTML video.
                    </video>
                </div>
                @endif
            @endif
            <div class="feed-post-time">
                <ul>
                    <li class="post-time-item">{{$post->created_at->diffForHumans()}}</li>
                    <li><a href="#" class="post-rpl">Reply</a></li>
                    @if($globaldata['user']->user_id == $post->user->user_id)
                    <li><span class="delete-reply-divider">|</span></li>
                    <li><a href="#" class="delete-post" >Delete</a></li>
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
        @if($commentsHide > 0)
        <div class="show-all-comments-btn">
            <a href="#" class="show-comment">Show all comments</a>
        </div>
        @endif
        <div class="feed-comment-list">


        </div>
        <div class="feed-wrapper feed-comment-wrapper">
            <div class="feed-form-wrap feed-comment-form-wrap mt-5 d-none">
                <div class="log-msg-wrapper"></div>
                {!! Form::open(['url' => 'feed/comment', 'class' => 'feed_comment_form']) !!}
                <input type="hidden" name="post_id" value="{{$post->post_id}}">
                <div class="feed-form-row">
                    <div class="user-avatar">
                        <a href="#"><img src="{{ $globaldata['user']->smallthumbimagefilepath }}" alt="logo"></a>
                    </div>
                    <div class="feed-form-input">
                        <div class="form-group">
                            <textarea name="feed_comment" maxlength="250" placeholder="Write a comment..." class="form-control feed_comment_input"></textarea>
                        </div>

                        <div class="upload-btn form-group text-center">
                            <label href="#" class=""><span class="media-upload"><i class="fa fa-camera" aria-hidden="true"></i> Upload pic</span>
                                <input type="file" name="commentmedia" class="comment_media_file d-none">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="  feed-post-comment-preview">
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
                    <button type="submit" class="btn btn-primary btn-sm feed-comment-btn">Post Comment</button>
                    <button class="btn btn-secondary btn-sm cancel-comment-btn">Cancel</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
