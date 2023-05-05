<div class="feed-comment-item comment{{$comment->comment_id}}" data-comment_id="{{$comment->comment_id}}">
    <div class="feed-box">
        <div class="feed-avatar">
            <a href="{{ url('/profile/'.$comment->user->user_id) }}" class="feed-user-name-item">
                <img class="feed-post-user-img" src="{{ $comment->user->imagefilepath }}">
            </a>
        </div>
        <div class="feed-data text-start">
            <div class="feed-user-name">
                <a href="{{ url('/profile/'.$comment->user->user_id ) }}" class="feed-user-name-item">{{ $comment->user->username }}</a>
                <span class="feed-status mobile-change">{{Carbon\Carbon::parse($comment->user->dob)->age}}{{$comment->user->gender}}</span>
                <span class="border-right-side">|</span>
                <span class="feed-status">{{ string_explode_implode($comment->user->address) }}</span>
                <!-- <span class="border-right-side">|</span>
                <span class="feed-status">Moderator</span>
                <a href="#" class="feed-status"><img src="{{ asset_front('/images/wok.png') }}" alt=""></a> -->

            </div>
            <!-- <div class="user-rating-post">
                <ul class="feed-status">
                    <li><span>Legendary</span></li>
                    <li><span class="border-right-side">|</span></li>
                    <li><a href="#">Trust: +61</a></li>
                </ul>
            </div> -->
            <div class="feed-post-content">{{ $comment->comment }}</div>
            @if(!empty($comment->media))
                @if($comment->media->media_type == 0)
                <div class="feed-media">
                    <img src="{{$comment->media->filesize}}">
                </div>
                @else
                <div class="feed-media">
                    <video width="400" controls>
                        <source src="{{$comment->media->filesize}}" type="video/{{$comment->media->extension}}">
                        Your browser does not support HTML video.
                    </video>
                </div>
                @endif
            @endif

            <div class="feed-post-time">
                <ul>
                    <li class="post-time-item">{{$comment->created_at->diffForHumans()}}</li>
                    @if($globaldata['user']->user_id == $comment->user->user_id)
                    <li><a href="#" class="delete-comment" >Delete</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
