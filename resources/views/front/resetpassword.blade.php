@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Reset Password</title>
    @endif
@endsection


@section('content')
    @if($status == 'success')
        <section class="welcome-bg">
            <div class="container">
                <div class="welcome-inner">
                    <div class="welcome-content-header inner-heading">
                        <h2>Reset Password</h2>
                        <p class="sub-title">Phew!</p>
                    </div>
                    <div class="log-msg-wrapper"></div>
                    {!! Form::open(['url' => 'reset-password', 'id' => 'formreset']) !!}
                        <div class="loginForm-bg reset-password-form-bg">
                            <div class="form-group">
                                <label class="form-lable">Member Name or Email</label>
                                <input type="text" class="form-control" value="{{ $usertoken->email_username }}" name="email"placeholder="The Owner" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-lable nth-child-lable">New Password</label>
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'placeholder' => '*********',
                                    'minlength' => 8,
                                    'maxlength' => 24,
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="form-lable nth-child-lable">Re-Enter Password</label>
                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'id' => 'password_confirmation',
                                    'placeholder' => '*********',
                                    'minlength' => 8,
                                    'maxlength' => 24,
                                ]) !!}
                                <span id="password_match" class="password-match d-none" style="">Password and the confirm password matched.</span>
                            </div>
                            <input type="hidden" name="token" value="{{ $usertoken->token }}">
                            <div class="submit-btn reset-password-btn"> <input type="submit"
                                    value="Hey dumbass, click here to store your password" class="btn submit-btn">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <br>
        </section>
    @else
        <section class="content-section account-verification-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center">
                            <h3 class="signup-title">Reset Password Link Expired</h3>
                            <h6 class="verification-text">Your reset password link has expired.<br> Please go to the forgot password page and re-submit the form.</h6>
                            <div class="error-content-area mt-5">
                                <p>Click the below button to go to forgot password page.</p>
                                <a class="btn btn-signup" href="{{ url('/forgot-password')}}">Forgot Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection


@section('page-scripts')

    <script src="{{ asset_front('/js/resetpassword/resetpassword.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
