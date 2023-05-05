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
                    <!-- <li><span class="delete-reply-divider">.</span></li>
                    <li>
                        <a href="#" class="like-comment">Like
                            <span class="like-fas-heart"></span>
                            <span class="video-like-comment-num">2</span>
                        </a>
                    </li>
                    <li><span class="delete-reply-divider">.</span></li> -->
                    @if ($globaldata['user']->user_id == $mediarplcomment->user->user_id || $globaldata['user']->issuperadmin == 1)
                    {{-- <li><span class="delete-reply-divider">.</span></li> --}}
                        <li class="post-time-item"><a href="#" class="remove-rpl-comment-link">Delete</a></li>
                     @endif
                </ul>
            </div>
        </div>
    </div>
</div>
