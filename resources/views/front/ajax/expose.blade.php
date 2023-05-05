@foreach ($usermedias as $usermedia)
<div class="item">
    <div class="content">
        <div class="video-items-box">
            <div class="video-inner-box">
                @if ($usermedia->mediatype == 1)
                    <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                        <img src="{{$usermedia->mediafile}}" alt="image-list">
                    </a>
                @else
                    <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}" class="video-list-item-link">
                        @if (!empty($usermedia->videothumbfile))
                            <img src="{{$usermedia->videothumbfile}}" alt="img">
                        @else
                            <video>
                                <source src="{{$usermedia->mediafile}}">
                            </video>

                        @endif
                        <span class="play-icon"><i class="fas fa-play"></i></span>
                    </a>
                @endif
            </div>
            <div class="list-wrap-all-comment-here">
                <div class="video-comments-count-box">
                    <div class="for-comments">
                        <span>by</span><a href="{{  url('/profile/' . $usermedia->user->user_id)}}" class="author-name">{{$usermedia->user->username}}</a>
                    </div>
                    @if (!($usermedia->comments->isEmpty()))
                        <div class="counting-box">
                            <span>-</span><a href="#"><i class="fas fa-comment"></i>
                                {{($usermedia->comments->count())}}
                            </a>
                        </div>
                    @endif
                    @if(!$usermedia->videocomments->isEmpty())
                        <div class="counting-box">
                            <span>-</span><a href="#"><i class="fas fa-comment"></i>
                            {{($usermedia->videocomments->count())}}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="comment-list-wrap">
                    @if (!($usermedia->comments->isEmpty()))
                        <div class="comments-list-group">
                            @foreach($usermedia->comments->take(2) as $comment)
                            <div class="comments-list-items">
                                <a href="#" class="avatar-image">
                                    <img src="{{$comment->user->smallthumbimagefilepath}}"
                                        alt="avatar image">
                                </a>
                                <div class="comment-text">
                                    <a href="{{url('profile/'.$comment->user->user_id)}}">{{ $comment->user->username }}:</a>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div>
                            @endforeach
                            <div class="view-list-all-comments">
                                <a href="{{ $globaldata['user']->user_id == $usermedia->user->user_id ? url('/image-detail/' . $usermedia->media_id) : url('/image-detail/' . $usermedia->media_id . '/' . $usermedia->user->user_id) }}"> @if($usermedia->comments->count() <=  2)
                                    View all comments
                                @else
                                    View all {{$usermedia->comments->count()}} comments
                                @endif
                            </a>
                            </div>
                        </div>
                    @endif
                    @if(!$usermedia->videocomments->isEmpty())
                        <div class="comments-list-group">
                            @foreach($usermedia->videocomments->take(2) as $comment)
                            <div class="comments-list-items">
                                <a href="#" class="avatar-image">
                                    <img src="{{$comment->user->smallthumbimagefilepath}}"
                                        alt="avatar image">
                                </a>
                                <div class="comment-text">
                                    <a href="{{url('profile/'.$comment->user->user_id)}}">{{ $comment->user->username }}:</a>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div>
                            @endforeach
                            <div class="view-list-all-comments">
                                <a href="{{ $globaldata['user']->user_id == $user->user_id ? url('/video-detail/' . $usermedia->media_id) : url('/video-detail/' . $usermedia->media_id . '/' . $user->user_id) }}">
                                @if($usermedia->videocomments->count() <=  2)
                                    View all comments
                                @else
                                    View all {{$usermedia->videocomments->count()}} comments
                                @endif
                            </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach