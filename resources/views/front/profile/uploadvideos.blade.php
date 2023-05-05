@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Upload Videos</title>
    @endif
@endsection


@section('content')
    <section class="upload-videos-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading">Your Videos</h3>
                        </div>
                        <div class="profile-tabs-block">
                            <div class="profile-setting-box" id="profileSetting">
                                <ul class="profile-setting-group">
                                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu">Profile</a></li>
                                    <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a>
                                    </li>
                                    <li><a href="{{ url('/upload-videos') }}"
                                            class="profile-setting-menu active-menu">Upload Videos</a>
                                    </li>
                                    <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                                    <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="internal-pages">
                            <div class="common-row">
                                <div class="common-left-column">
                                    <div class="upload-photo-bg">
                                        <div class="log-msg-wrapper"></div>
                                        {!! Form::open(['url' => 'upload-videos', 'id' => 'uploadvideo_form', 'class' => 'uploadvideo_form']) !!}
                                        <input type="hidden" name="thumbimage" id="thumbimage">
                                        <div class="upload-photo-area">
                                            <div class="uploading-area form-group">
                                                <div class="progress-wrapper">
                                                    <div class="progress-loader-wrapper">
                                                        <div class="file-progress progress_streamtext"
                                                            data-progresstext="0%">
                                                            <div class="progress__bar" style="width: 0%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="{{ asset_front('/images/uploading.png') }}" alt="uploading"
                                                    class="uploading-img">
                                                <div class="feed-post-preview">
                                                    <div class="preview-box mb-3">
                                                        <span class="fas fa-times preview-close"></span>
                                                        <video controls="" class="preview-video active">
                                                            <source src="" type="video/mp4">
                                                            Your browser does not support HTML video.
                                                        </video>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <label class="btn btn-upload-photo"><span>Select video to upload</span>
                                                        <input name="mediafile" id="mediafile" type="file"
                                                            class="form-control d-none">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="caption-box">
                                                <div class="form-group caption-form-group">
                                                    <label>Caption</label>
                                                    <input type="text" name="caption"
                                                        placeholder="Story behind this pic?" class="form-control">

                                                </div>
                                                <div class="form-group caption-form-group image-tag-select">
                                                    <label>Tags</label>
                                                    {!! Form::select('tags[]', $image_tag, null, [
                                                        'class' => 'form-control',
                                                        'id' => 'tags',
                                                        'multiple' => 'multiple',
                                                        'data-placeholder' => 'Hotwife, Nipples, Creampie...',
                                                    ]) !!}
                                                </div>
                                                <div class="radio-btn-box">
                                                    <span class="this-image-for">This video is for:</span>
                                                    <div class="radio-btn-items">
                                                        <label class="radio-btn"> Everyone
                                                            <input type="radio" name="showto" value="0" checked>
                                                            <span class="radio-btn-mark"></span>
                                                        </label>
                                                        <label class="radio-btn">Friends Only
                                                            <input type="radio" name="showto" value="1">
                                                            <span class="radio-btn-mark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group certify-everyone-checkbox">
                                                    <label class="role-checkbox"> I certify that everyone in this video is
                                                        over 18 years of age at the time this video was made, and one of the
                                                        following applies: <br> - This video is of me. <br> - This video was
                                                        taken by me. <br> - I have permission to use this video.
                                                        <input class="form-control d-none" value="1" type="checkbox"
                                                            name="tnc">
                                                        <span class="checkmark-arrow"></span>
                                                    </label>
                                                </div>
                                                <input type="submit" value="Add New Video" class="add-new-image-btn">
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="common-right-column">
                                    <div class="view-all-items-block">
                                        <h3 class="your-items-title">Your Videos
                                            <a href="{{ url('/user-video') }}" class="view-all-btn">(View All)</a>
                                        </h3>
                                        <ul class="all-items-list">
                                            @foreach ($user_media as $user_medias)
                                                <li>
                                                    <a href="{{ url('/video-detail/'.$user_medias->media_id) }}">
                                                        @if(!empty($user_medias->videothumbfilepath))
                                                        <img src="{{$user_medias->videothumbfilepath}}">
                                                        @else
                                                        <video>
                                                            <source src="{{ $user_medias->mediafile }}">
                                                        </video>
                                                        @endif
                                                        <span class="play-icon"><i class="fas fa-play"></i></span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

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
    <script src="{{ asset_front('/js/profile/uploadvideo.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
