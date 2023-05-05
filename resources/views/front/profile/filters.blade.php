@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Profile Filters</title>
    @endif
@endsection


@section('content')
    <section class="filter-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading">Filters</h3>
                        </div>
                        <div class="profile-tabs-block">
                            <div class="profile-setting-box" id="profileSetting">
                                <ul class="profile-setting-group">
                                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu">Profile</a></li>
                                    <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu active-menu">Filters</a>
                                    </li>
                                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a>
                                    </li>
                                    <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload
                                            Videos</a></li>
                                    <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                                    <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="about-block">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="filter-left">
                                        <h5 class="interested-in-viewing">Interested in viewing images from:</h5>
                                        <div class="all-filters-box">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-chk">
                                                        <label class="role-checkbox"> Male
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Female
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Couple
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox">
                                                            Transgender
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Trans - Male to Female
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Trans - Female to Male
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Crossdresser/Transvestite
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-chk">
                                                        <label class="role-checkbox"> Non-Binary
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Genderqueer
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Gender Fluid
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Intersex
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Femme
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                        <label class="role-checkbox"> Butch
                                                            <input type="checkbox">
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="upgrade-now-filter-btn">Upgrade now to be able to filter
                                            images!</button>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="filter-right-block">
                                        <h6 class="filter-right-text">What are filters?</h6>
                                        <p class="filter-description">Filters, by default, will show you all of the
                                            images
                                            uploaded
                                            by members of all
                                            sexes. If
                                            you want to edit the list of
                                            images you see based on sex, you can check the boxes you want to see.</p>
                                        <p class="filter-description">Example: If you are tired of looking at all of the
                                            sausage
                                            pics, don't check men,
                                            but
                                            select others.</p>
                                        <p class="filter-description">Note: this will remove 90% of all men pics, but if
                                            a woman
                                            uploads her hubby's
                                            pic,
                                            you
                                            will see that still as it was a
                                            woman's profile who uploaded it.</p>
                                        <p class="filter-description">Once done, go to the Newest Photos or videos page,
                                            and you
                                            will see what we mean.
                                        </p>
                                        <button class="upgrade-now-filter-btn">Member Videos</button>
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
@endsection
