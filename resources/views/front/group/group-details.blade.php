@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Discussion</title>
    @endif
@endsection

@section('content')

<section class="create-a-new-group-page">
        <div class="container-xxl">
            <div>
                <div class="create-a-new-group-main-bg mt-5 mb-5">
                    <div class="common-row">
                        <div class="common-left-column pe-md-5">
                            <div class="pe-lg-5">
                                <div class="group-discussion-title">
                                    <a href="#">Group name here</a>
                                </div>
                                <div class="group-by">
                                    <div class="message-user-box">
                                        <div class="message-author-info">
                                            <a href="#"><img src="images/profile-img.png" alt="mail author image"></a>
                                        </div>
                                        <div>
                                            <a href="#" class="message-user-name">The Owner</a>
                                            <ul class="gallery-pg-user-details">
                                                <li><a href="#">Trust: +3</a><span class="border-right-side">|</span>
                                                    <span>Jr
                                                        Member</span>
                                                    <span>Age
                                                        49</span><span
                                                        class="border-right-side">|</span><span>Non-Binary</span><span
                                                        class="border-right-side">|</span><span>Married</span>
                                                </li>
                                                <li><a href="#"><i class="fas fa-long-arrow-alt-left"></i> View
                                                        profile</a><span class="border-right-side">|</span><a
                                                        href="#">Pictures(200)</a> <span
                                                        class="border-right-side">|</span>
                                                    <a href="#">Videos(200)</a>
                                                    <span class="border-right-side">|</span>
                                                    <a href="#">Castle Rock, Colorado</a>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-by-creating-box">
                                    <p>There are no open discussions in this group<br class="d-none d-lg-block">
                                        Be the first to kick off this group by creating the<br
                                            class="d-none d-lg-block">
                                        very first <a href="#">open discussion</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="common-right-column pt-0 ps-0">
                            <div class="side-description px-0">
                                <p class="mb-3">Welcome to "group name here"I</p>
                                <p>Feel free to browse the open discussions or start your own.</p>
                                <a href="#" class="start-writing">Start A New Discussion</a>
                            </div>
                            <ul class="group-stats-box">
                                <li class="group-stats-title">Group Stats</li>
                                <li>Members: <span>1</span></li>
                                <li>Discussions: <span>0</span></li>
                                <li>Comments: <span>0</span></li>
                                <li>Last Comment: <span>Sept 12, 2020</span></li>
                                <li>By: <span>member name</span></li>
                                <li>Total views: <span>0</span></li>
                                <li>Created: <span>September, 1, 2020</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection

@section('page-scripts')

@endsection
