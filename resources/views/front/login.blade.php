@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Login</title>
    @endif
@endsection


@section('content')


    <section class="welcome-bg">
        <div class="container">
            <div class="welcome-inner">
                <div class="welcome-content-header">
                    <h2>Welcome Back!</h2>
                </div>
                <div class="log-msg-wrapper"></div>
                {!! Form::open(['url' => 'login', 'id' => 'formlogin']) !!}
                <div class="loginForm-bg">
                    <div class="form-group">
                        <label class="form-lable">Member Name or Email</label>
                        <input type="text" name="login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-lable nth-child-lable">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="submit-btn"> <input type="submit" value="Login to World of Kink" class="btn submit-btn">
                    </div>
                    <div class="forgot-pass">
                        <a href="{{ url('/forgot-password') }}" class="forgpt-password-menu">Forgot your login
                            information?</a>
                        <a href="{{ url('/signup') }}" class="dont-have-an-account"> Not a member yet? Signup to World of
                            Kink</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
    </section>

@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/login/login.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
