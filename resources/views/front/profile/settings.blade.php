@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Settings</title>
    @endif
@endsection


@section('content')
    <section class="profile-settings-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading">Profile Settings</h3>
                        </div>
                        <div class="profile-tabs-block">
                            <div class="profile-setting-box" id="profileSetting">
                                <ul class="profile-setting-group">
                                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu">Profile</a></li>
                                    <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a>
                                    </li>
                                    <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload Videos</a>
                                    </li>
                                    <li><a href="{{ url('/settings') }}"
                                            class="profile-setting-menu active-menu">Settings</a></li>
                                    <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="profile-settings-bg">
                            <div class="profile-setting-form-bg">
                                <div class="setting-form-inner-box">
                                    {!! Form::open(['url' => 'settings', 'id' => 'setting_form', 'class' => 'setting_form']) !!}
                                    <div class="form-group profile-setting-group">
                                        <label>Email Address</label>
                                        {!! Form::text('email', $globaldata['user']->email, [
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                    <div class="form-group profile-setting-group">
                                        <label>Username</label>
                                        {!! Form::text('username', $globaldata['user']->username, [
                                            'class' => 'form-control',
                                            'disabled' => 'disabled',
                                        ]) !!}
                                    </div>
                                    <div class="form-group profile-setting-group">
                                        <label>New Password</label>
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'id' => 'password',
                                            'placeholder' => '*********',
                                        ]) !!}
                                    </div>
                                    <div class="form-group profile-setting-group">
                                        <label>Confirm New Password</label>
                                        {!! Form::password('password_confirmation', [
                                            'class' => 'form-control',
                                            'id' => 'password_confirmation',
                                            'placeholder' => '*********',
                                        ]) !!}
                                        <span id="password_match" class="password-match d-none" style="">Password and
                                            the confirm password matched.</span>
                                    </div>
                                    <div class="certify-everyone-checkbox subscribe-to-newsletter">
                                        <label class="role-checkbox">Subscribe to newsletter
                                            <input type="checkbox">
                                            <span class="checkmark-arrow"></span>
                                        </label>
                                    </div>
                                    <div class="profile-setting-btn-group">
                                        <input type="submit" class="profile-setting-btn" value="Update Profile">
                                        <input type="submit" class="profile-setting-btn" value="Back to My Account">
                                        <button class="profile-setting-btn delete-btn">Delete Profile</button>
                                    </div>
                                    {!! Form::close() !!}
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
    <script src="{{ asset_front('/js/profile/setting.js?ver=' . mt_rand(1000, 9999)) }}"></script>
    <script>
    @endsection
