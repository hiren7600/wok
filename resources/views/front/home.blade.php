@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <!-- Primary Meta Tags -->
    <title>World of Kink - A Network of People into Kink, Fetish & BDSM</title>
    <meta name="title" content="World of Kink - A Network of People into Kink, Fetish & BDSM">
    <meta name="description" content="WOK is designed for open-minded people who are into kink, fetishes, and BDSM.  We are a community of open-minded, non-judging people.  Welcome to your new home.">
    @endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{url('/')}}">
<meta property="og:title" content="World of Kink - A Network of People into Kink, Fetish & BDSM">
<meta property="og:description" content="WOK is designed for open-minded people who are into kink, fetishes, and BDSM.  We are a community of open-minded, non-judging people.  Welcome to your new home.">
<meta property="og:image" content="{{asset_front('/images/logo.png')}}">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{url('/')}}">
<meta property="twitter:title" content="World of Kink - A Network of People into Kink, Fetish & BDSM">
<meta property="twitter:description" content="WOK is designed for open-minded people who are into kink, fetishes, and BDSM.  We are a community of open-minded, non-judging people.  Welcome to your new home.">
<meta property="twitter:image" content="{{asset_front('/images/logo.png')}}">
@endsection


@section('content')
<section class="main-section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-content">
                    <h1 class="banner-title">World of Kink is an adult network dedicated to people in the Kink, Fetish and BDSM lifestyles.</h1>
                    <p class="sub-description">Designed for open-minded people who are <strong>male/female to transgender,</strong> whose sexual orientation is somewhere between <strong>straight</strong> and <strong>gay,</strong> and whose role in life ranges from <strong>submissive</strong> to <strong>dominant.</strong> Hell, even if you're not sure at all, you're welcome too.</p>

                    <h2>Welcome to A World of Kink!</h2>
                    <a href="{{url('/signup')}}" class="index-login-service-btn signup-btn d-md-none">Sign Up For Free</a>
                    <a href="{{url('/login')}}" class="index-login-service-btn login-btn d-md-none">Member Login</a>
                    <a href="{{url('/signup')}}" class="btn-sign-up-btn d-none d-md-inline-block">
                        Sign Up Now!
                    </a>
                    <p class="already-member d-none d-md-block">Already a member? <a href="{{url('/login')}}">Login</a></p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection


@section('page-scripts')
@endsection
