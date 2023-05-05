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
