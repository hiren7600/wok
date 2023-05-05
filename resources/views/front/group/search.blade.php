@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Search Discussions</title>
    @endif
@endsection

@section('content')
<section class="group-page">
    <div class="container-xl">
        <div>
            <div class="groups-main-bg mt-5 mb-5">
                <div class="row">
                    <div class="col-12">
                        <div class="discussions-area-inner">
                            <div class="search-for-a-group">
                                <div class="row g-2">
                                    <div class="col-xl-6">
                                        <div class="search-input-box position-relative">
                                            {!! Form::open(['url' => 'search/group', 'id' => 'search_group_form', 'class' => 'search_group_form']) !!}
                                            <input type="text" name="search" placeholder="Search for a group" class="search-inp" value="{{$searchtext}}">
                                            <button type="submit" class="g-search-btn"><i class="fas fa-search"></i></button>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="quick-links">
                                            <a href="{{url('/group')}}">overview</a>
                                            <a href="{{url('/groups')}}">browse</a>
                                            <a href="{{url('/search/group')}}" class="active">search</a>
                                            <a href="{{url('/most-popular-groups')}}">Most popular groups</a>
                                            <a href="{{url('/newest-groups')}}">Newest groups</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <!-- <div class="search-and-browse-btn">
                                            <span class="or-1">or</span>
                                            <button>Browse all member groups</button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="group-members-list">
                                @if(!$groups->isEmpty())
                                <div class="row">
                                    @foreach($groups as $group)
                                    <div class="col-md-6 col-12">
                                        <div class="group-box">
                                            <a href="{{url('/discussion/'.$group->group_id)}}">
                                                <img src="{{$group->user->smallthumbimagefilepath}}" alt="{{$group->user->username}}" class="group-members-avtar">
                                                <div class="group-box-details">
                                                    <span class="group-mem-name">
                                                        {{$group->title}}
                                                    </span>
                                                    <p class="comment-description">
                                                        {{$group->description}}
                                                    </p>
                                                    <ul class="comment-num-list">
                                                        @if(!$group->members->isEmpty())
                                                        <li>{{$group->members->count()}} {{($group->members->count() > 1?'members':'member')}}</li>
                                                        <li>|</li>
                                                        @endif
                                                        <li>{{($group->discussions->count() > 0? $group->discussions->count().' discussions':'No discussions')}}</li>
                                                        <li>|</li>
                                                        <li>{{($group->discussioncomments->count() > 0? $group->discussioncomments->count().' comments':'No comments')}}</li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="no-image-bg">
                                    <div class="container">
                                        <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                            <div class="no-image-msg-show">
                                                <p>Not Found Groups</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- <div class="common-right-column pt-0 px-md-2 px-0">
                        <div class="group-you-created-box">
                            <h2 class="create-group-title">Groups You Created (1)</h2>
                            <div class="group-list">
                                <div class="group-box unread">
                                    <a href="#">
                                        <span class="group-mem-name">
                                            Kinkyads Announcements
                                        </span>
                                        <p class="comment-description">This group was created to keep you up-to-date
                                            on
                                            the changes
                                            and new
                                            features we have rolling out as well as any site related news.</p>
                                        <ul class="comment-num-list">
                                            <li>246,221 members</li>
                                            <li>|</li>
                                            <li>69 discussions</li>
                                            <li>|</li>
                                            <li>441 comments</li>
                                        </ul>
                                    </a>
                                </div>
                                <div class="group-box">
                                    <a href="#">
                                        <span class="group-mem-name">
                                            Kinkyads Announcements
                                        </span>
                                        <p class="comment-description">This group was created to keep you up-to-date
                                            on
                                            the changes
                                            and new
                                            features we have rolling out as well as any site related news.</p>
                                        <ul class="comment-num-list">
                                            <li>246,221 members</li>
                                            <li>|</li>
                                            <li>69 discussions</li>
                                            <li>|</li>
                                            <li>441 comments</li>
                                        </ul>
                                    </a>
                                </div>
                                <button class="start-new-groyp-btn">Start a New Group</button>
                            </div>
                            <h2 class="create-group-title">Groups Joined (3)</h2>
                            <div class="group-list">
                                <div class="group-box">
                                    <a href="#">
                                        <span class="group-mem-name">
                                            Kinkyads Announcements
                                        </span>
                                        <p class="comment-description">This group was created to keep you up-to-date
                                            on
                                            the changes
                                            and new
                                            features we have rolling out as well as any site related news.</p>
                                        <ul class="comment-num-list">
                                            <li>246,221 members</li>
                                            <li>|</li>
                                            <li>69 discussions</li>
                                            <li>|</li>
                                            <li>441 comments</li>
                                        </ul>
                                    </a>
                                </div>
                                <div class="group-box">
                                    <a href="#">
                                        <span class="group-mem-name">
                                            Kinkyads Announcements
                                        </span>
                                        <p class="comment-description">This group was created to keep you up-to-date
                                            on
                                            the changes
                                            and new
                                            features we have rolling out as well as any site related news.</p>
                                        <ul class="comment-num-list">
                                            <li>246,221 members</li>
                                            <li>|</li>
                                            <li>69 discussions</li>
                                            <li>|</li>
                                            <li>441 comments</li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('page-scripts')
<!-- <script src="{{ asset_front('/js/group/discussion_details.js?ver=' . mt_rand(1000, 9999)) }}"></script> -->
@endsection
