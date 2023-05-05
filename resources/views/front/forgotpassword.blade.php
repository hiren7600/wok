@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Forgot Password</title>
    @endif
@endsection

@section('content')
    <section class="welcome-bg">
        <div class="container">
            <div class="welcome-inner">
                <div class="welcome-content-header inner-heading">
                    <h2>Forgot Password</h2>
                    <p class="sub-title">Thank god for resetting pass pages</p>
                </div>
                <div class="log-msg-wrapper"></div>
                {!! Form::open(['url' => 'forgot-password', 'id' => 'formforgot']) !!}
                <div class="loginForm-bg">
                    <div class="form-group member-name">
                        <label class="form-lable">Member Name or Email</label>
                        {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username']) !!}
                    </div>
                    <div class="submit-btn">
                        <input type="submit" value="Send me a link to reset my password" class="btn submit-btn">
                    </div>

                    <p class="notice-content">For security reasons, we are not able to say if an email exists in our system or not. If you don't get an email from us within 3-5 minutes, it's most likely because we don't have an account associated with that email address.</p>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/forgotpassword/forgotpassword.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
