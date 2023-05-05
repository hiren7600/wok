@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Group</title>
    @endif
@endsection

@section('content')
<section class="group-page">
    <div class="main-height-wrap">
        <div class="container-xl">
            <div >
                <div class="groups-main-bg mt-5 mb-5">
                    <div class="common-row">
                        <div class="common-left-column pe-md-4">
                            <div class="discussions-area-inner">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h2 class="create-group-title text-md-start text-center">
                                            Groups Discussions Following ({{$groups->count()}})
                                        </h2>
                                    </div>
                                </div>
                                <div class="search-for-a-group">
                                    <div class="row g-2">
                                        <!-- <div class="col-xl-6"> -->
                                        <div class="col-12">
                                            <div class="search-input-box position-relative">
                                                {!! Form::open(['url' => 'search/group', 'id' => 'search_group_form', 'class' => 'search_group_form']) !!}
                                                <input type="text" name="search" placeholder="Search for a group" class="search-inp">
                                                <button type="submit" class="g-search-btn"><i class="fas fa-search"></i></button>
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="quick-links">
                                                <a href="{{url('/group')}}" class="active">overview</a>
                                                <a href="{{url('/groups')}}">browse</a>
                                                <a href="{{url('/search/group')}}">search</a>
                                                <a href="{{url('/most-popular-groups')}}">Most popular groups</a>
                                                <a href="{{url('/newest-groups')}}">Newest groups</a>
                                            </div>
                                        </div>
                                        <!-- <div class="col-xl-6">
                                            <div class="search-and-browse-btn">
                                                <span class="or-1">or</span>
                                                <button>Search</button>
                                                <span class="or-2">or</span>
                                                <button>Browse all member groups</button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="group-members-list">
                                    @if(!$groups->isEmpty())
                                    @foreach($groups as $group)
                                    <div class="group-box {{($group->isgroupread == 0?'unread':'')}}">
                                        <a href="{{url('/discussion/'.$group->group_id)}}">
                                            <img src="{{$group->user->smallthumbimagefilepath}}" alt="{{$group->user->username}}" class="group-members-avtar">
                                            <div>
                                                <span class="group-mem-name">
                                                    {{$group->title}}
                                                </span>
                                                <p class="comment-description">
                                                    {{$group->description}}
                                                </p>
                                                <ul class="comment-num-list">
                                                    @if(!$group->members->isEmpty())
                                                    <li>{{number_format($group->members->count())}} {{($group->members->count() > 1?'members':'member')}}</li>
                                                    <li>|</li>
                                                    @endif
                                                    <li>{{($group->discussions->count() > 0? $group->discussions->count().' discussions':'No discussions')}}</li>
                                                    <li>|</li>
                                                    <li>{{($group->discussioncomments->count() > 0? $group->discussioncomments->count().' comments':'No comments')}}</li>
                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="common-right-column pt-0 px-md-2 px-0">
                            <div class="group-you-created-box">
                                <h2 class="create-group-title">Groups You Created ({{count($mygroups)}})</h2>
                                <div class="group-list">

                                        @foreach ($mygroups as $group)
                                            <div class="group-box {{($group->isgroupread == 0?'unread':'')}}" >
                                                <a href="{{url('/discussion/'.$group->group_id)}}">
                                                    <span class="group-mem-name">
                                                        {{$group->title}}
                                                    </span>
                                                    <p class="comment-description">{{$group->description}}</p>
                                                    <ul class="comment-num-list">
                                                        @if(!$group->members->isEmpty())
                                                        <li>{{number_format($group->members->count())}} {{($group->members->count() > 1?'members':'member')}}</li>
                                                        <li>|</li>
                                                        @endif
                                                        <li>{{($group->discussions->count() > 0? $group->discussions->count().' discussions':'No discussions')}} </li>
                                                        <li>|</li>
                                                        <li>{{($group->discussioncomments->count() > 0? $group->discussioncomments->count().' comments':'No comments')}}</li>
                                                    </ul>
                                                </a>
                                            </div>
                                        @endforeach

                                    <a href="{{url('/creategroup')}}" class="start-new-groyp-btn">Start a New Group</a>
                                </div>
                                <!-- <h2 class="create-group-title">Groups Joined (3)</h2>
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
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')

@endsection
