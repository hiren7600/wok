@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Profile About</title>
    @endif
@endsection

@section('content')
    <section class="about">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading">About Me</h3>
                        </div>
                        <div class="profile-tabs-block">
                            <div class="profile-setting-box" id="profileSetting">
                                <ul class="profile-setting-group">
                                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu">Profile</a>
                                    </li>
                                    <li><a href="{{ url('/about') }}" class="profile-setting-menu active-menu">About Me</a>
                                    </li>
                                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a>
                                    </li>
                                    <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload Videos</a>
                                    </li>
                                    <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                                    <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="about-block">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="about-left-block">
                                        {!! Form::open(['url' => 'about', 'id' => 'about_form', 'class' => 'about_form']) !!}
                                        <input type="hidden" name="full_address" id="full_address">
                                        <div class="form-group">
                                            <span class="upgradde-member"><a href="#">Upgraded members</a> can
                                                change
                                                their member name</span>
                                            {!! Form::text('username', $user->username, [
                                                'class' => 'dark-input',
                                                'id' => 'username',
                                            ]) !!}
                                        </div>
                                        <p>About You</p>
                                        <div class="about-content-type">
                                            {!! Form::textarea('description', $user->about, [
                                                'class' => 'ckeditor form-control',
                                                'id' => 'tiny',
                                            ]) !!}
                                        </div>
                                        <div class="form-select-bloxk">
                                            <div class=" all-selection-items">
                                                <div class="form-selection-row ">
                                                    <div class="form-selection-col form-group">
                                                        <label>Gender (required)</label>
                                                        {!! Form::select('gender', [null => ''] + $gender, $user->gender, [
                                                            'class' => 'about-left-select',
                                                            'id' => 'gender',
                                                            'data-placeholder' => 'Select',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-selection-row ">
                                                    <div class="form-selection-col form-group me-3">
                                                        <label>Relationship Status (required)</label>
                                                        {!! Form::select('relationship_status', [null => ''] + $relationships, $user->relationship_status, [
                                                            'class' => 'about-left-select',
                                                            'id' => 'relationship_status',
                                                            'data-placeholder' => 'e.g. Single',
                                                        ]) !!}
                                                    </div>
                                                    <div class="form-selection-col" style="display: none">
                                                        <label>with</label>
                                                        <select value="#" class="about-left-select">
                                                            <option name="#" id="">The owner</option>
                                                            <option name="#" id="">Yourstruly
                                                            </option>
                                                            <option name="#" id="">That1guy1</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-selection-row ">
                                                    <div class="form-selection-col form-group">
                                                        <label>Sexual Orientation (required)</label>
                                                        {!! Form::select('sexual_orientation', [null => ''] + $orientations, $user->sexual_orientation, [
                                                            'class' => 'about-left-select',
                                                            'id' => 'sexual_orientation',
                                                            'data-placeholder' => 'e.g. Bisexual',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>Role (required)</p>
                                        <div class="about-role form-group">
                                            <div class="row">
                                                @foreach ($role as $roles)
                                                    <div class="col-sm-4">
                                                        <label class="role-checkbox"> {{ $roles }}
                                                            {!! Form::checkbox('role[]', $roles, in_array($roles, explode(',', $user->role)) ? 'checked' : '', []) !!}
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            {!! Form::text('role_new', '', [
                                                'placeholder' => 'Custom Role',
                                                'class' => 'status-role',
                                            ]) !!}
                                        </div>
                                        <p>Looking for(required)</p>
                                        <div class="about-role form-group">
                                            <div class="row">
                                                @foreach ($looking_for as $looking_for_cunk)
                                                    <div class="col-sm-6">
                                                        <label class="role-checkbox"> {{ $looking_for_cunk }}
                                                            {!! Form::checkbox(
                                                                'looking_for[]',
                                                                $looking_for_cunk,
                                                                in_array($looking_for_cunk, explode(',', $user->looking_for)) ? 'checked' : '',
                                                                [],
                                                            ) !!}
                                                            <span class="checkmark-arrow"></span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="birth-and-country-box">
                                            <div class="form-group">
                                                <label>Birthday (required)</label>
                                                {!! Form::text('dateofbirth', date(' m/d/Y', strtotime($user->dob)), [
                                                    'class' => 'form-control',
                                                    'id' => 'dateofbirth',
                                                    'placeholder' => 'MM / DD / YYYY',
                                                ]) !!}
                                            </div>
                                            <div class="form-group">
                                                <label>Location (required)</label>
                                                <input type="hidden" name="select_from_list" id="select_from_list" value="1">
                                                {!! Form::text('city', $user->address, [
                                                    'class' => 'form-control',
                                                    'id' => 'city',
                                                    'placeholder' => 'e. g.   Denver, Colorado, United States',
                                                ]) !!}
                                            </div>
                                        </div>
                                        {!! Form::button('Continue', ['type' => 'submit', 'class' => 'about-btn', 'id' => 'btn-upload-about']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="col-lg-5 d-none">
                                    <div class="about-fill">
                                        <h4>Why should I fill this out?</h4>
                                        <p>It's simple, people want to know a little about the person they are going
                                            to
                                            hookup
                                            with.
                                            This is where you can sell youself and let them know what a great catch
                                            you are.
                                        </p>
                                        <p>Don't be to shy here, you will be amazed as how far you can get with a
                                            nice about
                                            me
                                            section.
                                        </p>
                                        </p>
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvWBmF4biee4XgHItzEpHOv6DtuM8MsCo&libraries=places">
    </script>
    <script src="{{ asset_front('/js/profile/about.js?ver=' . mt_rand(1000, 9999)) }}"></script>
    <script>
        google.maps.event.addDomListener(window, 'load', function() {

            var options = {
                types: ['(cities)'],
            };

            var input = document.getElementById('city');
            var places = new google.maps.places.Autocomplete(input, options);

            google.maps.event.addListener(places, 'place_changed', function() {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var latlng = new google.maps.LatLng(latitude, longitude);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            var address = results[0].formatted_address;
                            var addresslength = results[0].address_components.length;
                            console.log(addresslength);

                            if(addresslength == 9)
                            {
                                var city = results[0].address_components[results[0].address_components.length - 6].long_name;
                                var county = results[0].address_components[results[0].address_components.length - 5].long_name;
                                var state = results[0].address_components[results[0].address_components.length - 4].long_name;
                                var country = results[0].address_components[results[0].address_components.length - 3].long_name;
                                var pin = results[0].address_components[results[0].address_components.length - 2].long_name;
                            }
                            else if(addresslength == 8) {
                                var city = results[0].address_components[results[0].address_components.length - 5].long_name;
                                var county = results[0].address_components[results[0].address_components.length - 4].long_name;
                                var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                                var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                                var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                            }
                            else {
                                var city = results[0].address_components[results[0].address_components.length - 5].long_name;
                                var county = results[0].address_components[results[0].address_components.length - 4].long_name;
                                var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                                var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                                var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                            }

                            if(!isNaN(country)) {
                                console.log(country);
                                var city = results[0].address_components[results[0].address_components.length - 6].long_name;
                                var state = results[0].address_components[results[0].address_components.length - 4].long_name;
                                var country = results[0].address_components[results[0].address_components.length - 3].long_name;

                                fulladdresstext = city +", "+ state +", "+ country +", "+ county +", "+ pin;
                                citytext = city +", "+ state +", "+ country;
                            }
                            else {
                                fulladdresstext = city +", "+ state +", "+ country +", "+ county +", "+ pin;
                                citytext = city +", "+ state +", "+ country;
                            }

                            $('#city').val(citytext);
                            $('#full_address').val(fulladdresstext);
                            $('#select_from_list').val(1);
                        }
                    }
                });
            });
        });
    </script>
@endsection
