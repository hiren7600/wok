<!DOCTYPE html>
<html lang="en">

<head>
    @include('front.layouts.head')

    @yield('page-css')
</head>

<body>

<!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVSG4TJ"height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
<!-- End Google Tag Manager (noscript) -->
    @if (!isset($globaldata['user']))
        <header class="header-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="logo">
                                    <a href="{{ url('/') }}"><img src="{{ asset_front('/images/logo.png?ver=' . mt_rand(1000, 9999)) }}"
                                            alt="logo"></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="header-right-menu d-none d-md-block">
                                    <span>Already a member?</span>
                                    <a href="{{ url('/login') }}">Login</a>
                                    <span>or</span>
                                    <a href="{{ url('/signup') }}">Signup</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @else
        <div class="main-wrap"></div>
        <header>
            <div class="main-header-bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2 col-xl-8 col-md-5">
                            <div class="left-header-inner-box">
                                <div class="main-header-logo">
                                    <a href="{{ url('/') }}"><img src="{{ asset_front('/images/wok.png') }}" alt="logo"
                                            class="logo-img"></a>
                                </div>
                                <div class="search-area">
                                    <div class="search-inner-box header-search">
                                        {!! Form::open(['url' => 'search', 'id' => 'headersearch']) !!}
                                        <input type="text" name="search" placeholder="Search Members " class="search-box" value="{{(isset($searchtext)?$searchtext:'')}}">
                                        <input type="hidden" name="type" value="{{(isset($searchtype)?$searchtype:'member')}}" id="search-type">
                                        <div class="dropdown selected-drop">
                                            <button class="selected-drop " type="button" data-bs-toggle="dropdown">
                                                @if(isset($searchtype))
                                                    @if($searchtype == 'group')
                                                        <i class="fas fa-comments"></i>
                                                    @elseif($searchtype == 'ads')
                                                        <i class="fas fa-ad"></i>
                                                    @else
                                                        <i class="fas fa-users"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-users"></i>
                                                @endif

                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-type="member" data-iclass="fa-users">
                                                        <i class="fas fa-users"></i>
                                                        Members
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-type="group" data-iclass="fa-comments">
                                                        <i class="fas fa-comments"></i>
                                                        Groups
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-type="ads" data-iclass="fa-ad">
                                                        <i class="fas fa-ad"></i>
                                                        Ads
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <button type="submit" class="search-icon">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="header-menu-area">
                                    <ul class="menu-group">
                                        <li><a href="{{ url('/feed') }}" class="menu-items">Home</a></li>
                                        <li><a href="{{url('/exposed')}}" class="menu-items">Exposed</a></li>
                                        {{-- <li><a href="#" class="menu-items">Casual Encounters</a></li> --}}
                                        <li><a href="{{url('/location')}}" class="menu-items">Location</a></li>
                                        <li><a href="{{url('/group')}}" class="menu-items">Groups</a></li>
                                        {{-- <li><a href="#" class="menu-items">Groups/Topics</a>
                                            <ul class="groups-topics-dropdown">
                                                <li><a href="{{url('/group')}}">Groups</a></li>
                                                <li><a href="#">Topics</a></li>
                                            </ul>
                                        </li> --}}
                                        <li><a href="{{url('/videos')}}" class="menu-items">Videos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-xl-4 col-md-7 align-self-center">
                            <div class="right-header-inner-box">
                                <div class="header-icons-menu">
                                    <ul class="icons-menu-group">
                                        <li><a href="{{ url('/conversation') }}" class="icon-menu-items">
                                            @if($globaldata['newMsgCounts'] > 0)<span>{{$globaldata['newMsgCounts']}}</span>@endif
                                            <i
                                                    class="fas fa-envelope"></i></a>
                                        </li>
                                        <li><a href="{{url('/friend-requests')}}" class="icon-menu-items">
                                            @if($globaldata['friendrequestcounts'] > 0)<span>{{$globaldata['friendrequestcounts']}}</span>@endif
                                            <i class="fas fa-users"></i></a>
                                        </li>
                                        <li><a href="{{url('/upload-image')}}" class="icon-menu-items"><i class="fas fa-upload"></i></a>
                                        </li>
                                        <li><a href="{{url('/notification-list')}}" class="icon-menu-items">
                                            @if($globaldata['notificationcount'] > 0)<span>{{$globaldata['notificationcount']}}</span>@endif
                                            <i class="fas fa-bell"></i></a>
                                        </li>
                                        <li class="header-profile-menu"><a href="{{ url('/profile/'.$globaldata['user']->user_id) }}"
                                                class="profile-menu-items"><img
                                                    src="{{ $globaldata['user']->smallthumbimagefilepath }}"
                                                    alt="profile-image">{{ $globaldata['user']['username'] }}</a>
                                        </li>
                                    </ul>
                                    <button class="menu-toggle-btn" id="toggleMenu"></button>
                                </div>

                                <div class="right-menu-dropdown" id="rightmenu">
                                    <div class="right-menu-inner">
                                        <div class="menu-list-group">
                                            <a class="collapse-toggle-menu collapsed" data-bs-toggle="collapse"
                                                href="#usercollapse">
                                                <img src="{{ $globaldata['user']->smallthumbimagefilepath }}"
                                                    alt="profile-image">{{ $globaldata['user']['username'] }}
                                            </a>
                                            <div class="collapse collapse-menu-btn" id="usercollapse">
                                                <ul class="collapse-inner-menu-list">
                                                    {{-- <li><a href="#" class="collapse-menu-item">Upgrade
                                                            Membership</a></li>--}}
                                                    <li><a href="{{ url('/feed') }}" class="collapse-menu-item">My Feed</a></li>
                                                    <li><a href="{{ url('/profile') }}" class="collapse-menu-item">My Profile</a>
                                                    </li>
                                                    <li><a href="{{url('/conversation')}}" class="collapse-menu-item">My Messages</a>
                                                    </li>
                                                    <li><a href="#" class="collapse-menu-item">My Followers</a>
                                                    </li>
                                                    <li><a href="{{url('/friends')}}" class="collapse-menu-item">My Friends</a>
                                                    </li>
                                                    <li><a href="{{url('/user-video')}}" class="collapse-menu-item">My Videos</a>
                                                    </li>
                                                    <li><a href="{{url('/user-images')}}" class="collapse-menu-item">My Images</a>
                                                    </li>
                                                    <li><a href="#" class="collapse-menu-item">My Ads</a></li>
                                                    <li><a href="#" class="collapse-menu-item">Viewed Me - Coming Soon </a>
                                                    </li>
                                                    <li><a href="{{url('/about')}}" class="collapse-menu-item">Edit Profile</a>
                                                    </li>
                                                    <li><a href="{{url('/settings')}}" class="collapse-menu-item">Settings</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="menu-list-group">
                                            <ul>
                                                <li><a href="{{url('/feed')}}" class="not-collapse-toggle-menu">Home</a></li>
                                                <li><a href="{{url('/exposed')}}" class="not-collapse-toggle-menu">Exposed</a>
                                                </li>
                                                <li><a href="{{url('/location')}}" class="not-collapse-toggle-menu">Location</a></li>
                                                {{-- <li><a href="{{url('/groups')}}" class="not-collapse-toggle-menu">Browse
                                                        Members</a></li> --}}
                                                <li><a href="{{url('/group')}}"
                                                            class="not-collapse-toggle-menu">Groups </a></li>
                                                {{-- <li><a href="#topics" data-bs-toggle="collapse"
                                                        class="collapse-toggle-menu collapsed">Groups / Topics</a></li>
                                                <div class="collapse collapse-menu-btn" id="topics">
                                                    <ul class="collapse-inner-menu-list">
                                                        <li><a href="#" class="collapse-menu-item">Groups</a>
                                                        </li>
                                                        <li><a href="#" class="collapse-menu-item">Topics</a>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                                <li><a href="{{url('/kink')}}" class="not-collapse-toggle-menu">Kinks</a></li>
                                                {{-- <li><a href="#" class="not-collapse-toggle-menu">Images by
                                                        Kink</a></li> --}}
                                                <li><a href="#" class="not-collapse-toggle-menu">Events - Coming Soon!</a></li>
                                                <li><a href="{{url('/videos')}}" class="not-collapse-toggle-menu">Videos</a></li>
                                            </ul>
                                        </div>
                                        <div class="menu-list-group">
                                            <a class="collapse-toggle-menu collapsed" data-bs-toggle="collapse"
                                                href="#collapsesupport">
                                                Support - Coming Soon!
                                            </a>
                                            <div class="collapse collapse-menu-btn" id="collapsesupport">
                                                <ul class="collapse-inner-menu-list">
                                                    <li><a href="#" class="collapse-menu-item">FAQ
                                                            <span></span></a></li>
                                                    <li><a href="#" class="collapse-menu-item">Feedback
                                                            Forum</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="menu-list-group">
                                            <a class="not-collapse-toggle-menu" href="https://www.secretbenefits.com/welcome/instable_barcelona_d_68_c/kink_nav/not%20escorts?utm_campaign=kink_nav&utm_source=kink_nav&utm_medium=nav&utm_term=not%20escorts&utm_content=text&cep=mbLJXDik1NuJOTEeS5oKAH4tCIaUkAAdGFewj_sjWk3y6ms-d0sPJOUnbR1Sn55bt1RyJCo_qasugWXGh3roC5keVbWe92NrJYr_y41CLWdxrcOPiBbOmUSXDssOXOecLM-fx7NejfkEvgF4FYeie26anRJhGRFBn-vD-xZAofc7wbIdfhaBfG7TyZL1qMx5k7nwjdjudqVTg6FfQVWd60y50hpHBtPmSu6gYm5ekOTwLRAc1JU531Koujo6fEVBRqQXnIiHM4CWdczjqPemzhWbeasCkxY_8jmY3pZrTOe6KfJYFcmPyFMQtelbekMuz3INouMeMYJBbaN89gillBQwodpVwfr7FR1j_Oi1Flo&lptoken=16b263de46d6917813a6">
                                                Sugar Babies - <span>Sponsored</span>
                                            </a>
                                            {{-- <a class="not-collapse-toggle-menu" href="#">
                                                Meet & Fuck - <span>Sponsored</span>
                                            </a> --}}
                                        </div>
                                        @if ($globaldata['user']->issuperadmin == 1 )
                                            <div class="menu-list-group">
                                                <a class="collapse-toggle-menu collapsed" data-bs-toggle="collapse"
                                                    href="#collapsesupport1">
                                                    Mod
                                                </a>
                                                <div class="collapse collapse-menu-btn" id="collapsesupport1">
                                                    <ul class="collapse-inner-menu-list">
                                                        <!-- <li><a href="{{'/all-videos'}}" class="collapse-menu-item">Videos</a></li> -->
                                                        <li><a href="{{url('/image')}}" class="collapse-menu-item">Member Images</a></li>
                                                        <li><a href="{{url('/seo')}}" class="collapse-menu-item">Seo Setting</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="menu-list-group">

                                            <a class="logout-btn" href="{{ url('/logout') }}">
                                                Logout
                                            </a>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div id="message" class="important-message-box">
            <a href="#">Important Message From Kinkyads, Click Here</a>
            <button id="msg-close" class="close-message">✕</button>
        </div> -->
        </header>
    @endif

    <div class="page-wrapper">

        @yield('content')

    </div>
    <footer>
        <div class="footer-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm col-md-9 col-lg-8 col-xxl-7">
                        <div class="footer-inner d-flex justify-content-between">
                            <div class=" col-footer">
                                <h4 class="footer-title">Our Company</h4>
                                <ul class="footer-menu">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Caretakers</a></li>
                                    <li><a href="https://www.professionalidiots.com/advertising"
                                            target="_blank">Advertising</a></li>
                                    <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="col-footer">
                                <h4 class="footer-title">General</h4>
                                <ul class="footer-menu">
                                    <li><a href="https://worldofkink.com/blog/">Blogs</a></li>
                                    <li><a href="#">Affiliates</a></li>
                                    <li><a href="#">Browse Ads</a></li>
                                </ul>
                            </div>
                            <div class="col-footer">
                                <h4 class="footer-title">Legal</h4>
                                <ul class="footer-menu">
                                    <li><a href="{{ url('/dmca') }}">DMCA</a></li>
                                    <li><a href="{{ url('/privacy') }}">Privacy Policy.</a></li>
                                    <li><a href="{{ url('/service') }}">Terms of Services</a></li>
                                    <li><a href="{{ url('/guidelines') }}">Posting Guidelines</a></li>
                                    <li><a href="{{ url('/2257') }}">2257</a></li>
                                </ul>
                            </div>
                            <div class="col-footer">
                                <h4 class="footer-title">Social</h4>
                                <ul class="footer-menu">
                                    <li><a href="#">Facebook</a></li>
                                    <li><a href="#">Twitter</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm col-md-9 col-lg-8 col-xxl-7 copyright">
                        <div class="row ">
                            <div class="col-9">
                                <p>&#169; 2022 Professional Idiots Inc</p>
                            </div>
                            <div class="col-3">
                                <div class="footer-logo">
                                    <img src="{{ asset_front('/images/footer-logo.png') }}" alt="logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    @include('front.layouts.foot')

    @yield('page-scripts')
</body>

</html>
