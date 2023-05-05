@extends('front.layouts.front')

@section('pagetitle', ' - Dashboard')


@section('content')
    <section class="profile-page-bg">
        <div class="container">
            <div class="profile-tabs-block">
                <div class="about-heading-block">
                    <h3 class="about-heading">About Me</h3>
                </div>
                {{-- <a href="#" class="edit-profile-btn" id="editBtn"><i class="fas fa-edit"></i>Edit Profile</a>
                <div class="profile-setting-box" id="profileSetting"> --}}
                <ul class="profile-setting-group">
                    <li><a href="{{ url('/profile') }}" class="profile-setting-menu active-menu">Profile</a></li>
                    <li><a href="{{ url('/about') }}" class="profile-setting-menu">About Me</a></li>
                    <li><a href="{{ url('/filters') }}" class="profile-setting-menu">Filters</a></li>
                    <li><a href="{{ url('/upload-image') }}" class="profile-setting-menu">Upload Photos</a></li>
                    <li><a href="{{ url('/upload-videos') }}" class="profile-setting-menu">Upload Videos</a></li>
                    <li><a href="{{ url('/settings') }}" class="profile-setting-menu">Settings</a></li>
                    <li><a href="{{ url('/notifications') }}" class="profile-setting-menu">Notifications
                        </a></li>
                </ul>
                {{-- </div> --}}
            </div>
            <div class="about-block">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="about-left-block">
                            {!! Form::open(['url' => 'about', 'id' => 'about_form', 'class' => 'about_form']) !!}
                            <span><a href="#">Upgraded members</a> can change their member name</span>
                            <input type="text" name="" value="{{ $user->username }}" disabled class="dark-input">
                            {!! Form::text('username', $user->username, [
                                'class' => 'form-control',
                                'id' => 'username',
                            ]) !!}
                            <p>About You</p>
                            <textarea class="ckeditor form-control" id="tiny" name="description"></textarea>
                            <p>Gender (required)</p>
                            {!! Form::select('gender', [null => ''] + $gender, $user->gender, [
                                'class' => 'form-control',
                                'id' => 'gender',
                                'data-placeholder' => 'Select',
                            ]) !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <p>Relationship Status (required)</p>
                                        {!! Form::select('relationship_status', [null => ''] + $relationships, $user->relationship_status, [
                                            'class' => 'form-control',
                                            'id' => 'relationship_status',
                                            'data-placeholder' => 'e.g. Single',
                                        ]) !!}
                                    </div>

                                </div>
                                <div class="col-lg-6" style="display: none">
                                    <div>
                                        <p>with</p>
                                        <select value="#" class="status">
                                            <option name="#" id="">The owner</option>
                                            <option name="#" id="">Yourstruly</option>
                                            <option name="#" id="">That1guy1</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <p>Sexual Orientation (required)</p>
                            {!! Form::select('sexual_orientation', [null => ''] + $orientations, $user->sexual_orientation, [
                                'class' => 'form-control',
                                'id' => 'sexual_orientation',
                                'data-placeholder' => 'e.g. Bisexual',
                            ]) !!}
                            <p>Role (required)</p>
                            <div class="about-role">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Babygirl</span>
                                        </label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Bottom</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Caregiver</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Cuckold</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Cuckqueen</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Daddy</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Disciplinarian</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Dominant</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Domme</span></label>
                                        <label for="#"> <input type="checkbox" value=""> <span>Drag</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Exhibitionist</span></label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Feminizer</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Furry</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Kinkster</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Kitten</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Masochist</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Master</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Mistress</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Mommy</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Pet</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Pony</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Pup</span></label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Sadist</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Sadomasochist</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Sensualist</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Sissy</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Slave</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Submissive</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Swinger</span></label>
                                        <label for="#"> <input type="checkbox" value="">
                                            <span>Switch</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Top</span></label>
                                        <label for="#"><input type="checkbox" value="">
                                            <span>Voyeur</span></label>


                                    </div>
                                </div>
                                <input type="text" placeholder="Custom Role" id="status-role">
                            </div>
                            <p>Looking for(required)</p>
                            <div class="about-role">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="#"><input type="checkbox" value="" id="chkbox"><span
                                                id="role">Women</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="" id="chkbox">
                                            <span id="role">Men</span></label>
                                        <label for="#"><input type="checkbox" value="" id="chkbox">
                                            <span id="role">Couples</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label for="#"><input type="checkbox" value="" id="chkbox"><span
                                                id="role">TV/TS</span>
                                        </label>
                                        <label for="#"><input type="checkbox" value="" id="chkbox">
                                            <span id="role">Cross
                                                Dresser</span></label>
                                        <label for="#"><input type="checkbox" value="" id="chkbox">
                                            <span id="role">Online Only
                                            </span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <p>Birthday (required)</p>
                            <label for="#">

                                {!! Form::text('dateofbirth', date(' m/d/Y', strtotime($user->dob)), [
                                    'class' => 'form-control',
                                    'id' => 'dateofbirth',
                                    'placeholder' => 'MM / DD / YYYY',
                                ]) !!}
                            </label>

                            <p>Country (required)</p>
                            <label for="#">
                                {!! Form::text('city', $user->address, [
                                    'class' => 'form-control',
                                    'id' => 'city',
                                    'placeholder' => 'e. g.   Denver, Colorado, United States',
                                ]) !!}
                            </label>

                            {!! Form::button('Continue', ['type' => 'button', 'class' => 'continue-btn', 'id' => 'btn-upload-about']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="about-fill">
                            <h4>Why should I fill this out?</h4>
                            <p>It's simple, people want to know a little about the person they are going to hookup with.
                                This is where you can sell youself and let them know what a great catch you are.</p>
                            <p>Don't be to shy here, you will be amazed as how far you can get with a nice about me
                                section.</p>
                            </p>
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
                            var pin = results[0].address_components[results[0].address_components
                                .length - 1].long_name;
                            var country = results[0].address_components[results[0]
                                .address_components.length - 2].long_name;
                            var state = results[0].address_components[results[0].address_components
                                .length - 3].long_name;
                            var city = results[0].address_components[results[0].address_components
                                .length - 4].long_name;
                            var mytxtCity = results[0].address_components[results[0]
                                .address_components.length - 5].long_name;

                            citytext = mytxtCity.concat(", ", state, ", ", country);
                            console.log(citytext);
                            $('#city').val(citytext);
                        }
                    }
                });
            });
        });
    </script>
@endsection
