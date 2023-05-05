@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Sign Up</title>
    @endif
@endsection

@section('content')
<section class="content-section signup-section">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                {!! Form::open(['url' => 'signup', 'id' => 'signup_form', 'class' => 'signup_form']) !!}
                    <input type="hidden" name="full_address" id="full_address">
                    <nav class="d-none">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="signup-input-tab" data-bs-toggle="tab" data-bs-target="#nav-input" type="button" role="tab">Signup</button>
                            <button class="nav-link" id="signup-phone-tab" data-bs-toggle="tab" data-bs-target="#nav-phone" type="button" role="tab">Mobile Verification</button>
                            <button class="nav-link" id="signup-verification-tab" data-bs-toggle="tab" data-bs-target="#nav-verification" type="button" role="tab">Last Step</button>
                            <button class="nav-link" id="signup-upload-tab" data-bs-toggle="tab" data-bs-target="#nav-upload" type="button" role="tab">Upload Profile Picture</button>
                            <button class="nav-link" id="signup-confirm-tab" data-bs-toggle="tab" data-bs-target="#nav-confirm" type="button" role="tab">Confirmation</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-input" role="tabpanel" aria-labelledby="signup-input-tab">
                            <div class="text-center">
                                <h3 class="signup-title">Welcome To World of Kink</h3>
                                <h6 class="signup-subtitle">Give us some brief info about yourself</h6>
                            </div>
                            <div class="signup-form-content">
                                <div class="log-msg-wrapper"></div>
                                <div class="signup-form-wrap">
                                    <div class="signup-form-box">
                                        <div class="form-group row">
                                            <label for="username" class="col-lg-4 col-form-label">Nickname:</label>
                                            <div class="col-lg-8 form-group-input username-input-box">
                                                {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Member Name']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dateofbirth" class="col-lg-4 col-form-label">Date of Birth:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::text('dateofbirth', null, ['class' => 'form-control', 'id' => 'dateofbirth', 'placeholder' => 'MM / DD / YYYY', 'readonly' => 'true']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-form-box">
                                        <div class="form-group row">
                                            <label for="gender" class="col-lg-4 col-form-label">I am/We are a:</label>
                                            <div class="col-lg-8 form-group-input">

                                                {!! Form::select('gender', [null => ''] + $gender, null, ['class' => 'form-control', 'id' => 'gender', 'data-placeholder' => 'Select'])!!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sexual_orientation" class="col-lg-4 col-form-label">Sexual Orientation:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::select('sexual_orientation', [null => ''] + $orientations, null, ['class' => 'form-control', 'id' => 'sexual_orientation', 'data-placeholder' => 'e.g. Bisexual'])!!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="relationship_status" class="col-lg-4 col-form-label">Relationship Status:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::select('relationship_status', [null => ''] + $relationships, null, ['class' => 'form-control', 'id' => 'relationship_status', 'data-placeholder' => 'e.g. Single'])!!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role" class="col-lg-4 col-form-label">Role:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::select('role', [null => ''] + $role, null, ['class' => 'form-control', 'id' => 'role', 'data-placeholder' => 'e.g. Dominate'])!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-form-box">
                                        <div class="form-group row">
                                            <label for="city" class="col-lg-4 col-form-label">Location:</label>
                                            <div class="col-lg-8 form-group-input">
                                                <input type="hidden" name="select_from_list" id="select_from_list" value="0">
                                                {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'e. g.   Denver, Colorado, United States']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-form-box">
                                        <div class="form-group row">
                                            <label for="email" class="col-lg-4 col-form-label">Email Address:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'email@domain.com']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-lg-4 col-form-label">Password:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => '*********']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password_confirmation" class="col-lg-4 col-form-label">Confirm Password:</label>
                                            <div class="col-lg-8 form-group-input">
                                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => '*********']) !!}
                                                <span id="password_match" class="password-match d-none" style="">Password and the confirm password matched.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-8">
                                                <div class="d-grid">
                                                    {!! Form::button('Continue', ['type' => 'button', 'class' => 'btn btn-signup', 'id' => 'btn-input-signup']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-phone" role="tabpanel" aria-labelledby="signup-phone-tab">
                            <div class="verification-code-inner-bg">
                                <div>
                                    <h2 class="avatar-heading mb-2">Verification Time!</h2>
                                    <p class="virification-sub-dis">This is the only text we will ever send</p>
                                    <div class="log-msg-wrapper"></div>
                                    <div class="verification-form-box form-group">
                                        <p>Mobile phone number</p>
                                        <div class="verification-code-box form-group-input">
                                            <input name="phoneno" id="phoneno" type="text" class="form-control mobile-num-type-box" placeholder="+1 201-555-0123">
                                        </div>
                                        <a href="#" class="complete-verification-btn" id="send-verification-btn">Send me verification code</a>
                                    </div>
                                    <p class="verification-code-deis my-3 ">Tip: Make sure you start your number with your
                                        country
                                        code:
                                        +1 for the US and canada, +44 for UK, +61 for Australia, +31 for Netherlands, +49 for
                                        Germany, +33 for France, etc.
                                    </p>
                                    <p class="verification-code-deis py-0">For problems please call suppoart at +1 (800) 706 5313
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-verification" role="tabpanel" aria-labelledby="signup-verification-tab">
                            <div class="verification-code-inner-bg">
                                <div>
                                    <h2 class="avatar-heading mb-2">Last Step</h2>
                                    <p class="virification-sub-dis">Phew, that was simple right?</p>
                                    <div class="log-msg-wrapper"></div>
                                    <div class="verification-form-box form-group">
                                        <p>Verification code</p>
                                        <div class="verification-code-box form-group-input">
                                            <ul>
                                                <li>
                                                    <input type="text" name="otp1" id="otp1" class="form-control" maxlength="1">
                                                </li>
                                                <li>
                                                    <input type="text" name="otp2" id="otp2" class="form-control" maxlength="1">
                                                </li>
                                                <li>
                                                    <input type="text" name="otp3" id="otp3" class="form-control" maxlength="1">
                                                </li>
                                                <li>
                                                    <input type="text" name="otp4" id="otp4" class="form-control" maxlength="1">
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="#" class="complete-verification-btn" id="code-verification-btn">Complete Signup & Verification</a>
                                        <p class="please-call-support mt-3">For problems please call support at +1 (800) 706 5313</p>
                                    </div>
                                    <p class="verification-code-deis">We sent the verfication code to 7209480850. if after a couple
                                        minutes you don't receive a text message form us, <a href="#"><a href="#"> update your
                                                number</a></a> and we'll sent
                                        you a new verification code.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="signup-upload-tab">
                            <div class="text-center">
                                <h3 class="signup-title">Upload Your Profile Avatar</h3>
                            </div>
                            <div class="signup-form-content">
                                <div class="log-msg-wrapper"></div>
                                <div class="profile-upload-box">
                                    <div class="profile-inner-box">
                                        <div class="uploading-area form-group-input">
                                            <img src="{{asset_front('/images/uploading.png')}}" data-src="{{asset_front('/images/uploading.png')}}" alt="uploading" class="uploading-img">
                                            <label class="btn btn-upload-photo">
                                                <span>Select photo to upload</span>
                                                <input name="imagefile" id="imagefile" type="file" class="form-control d-none">
                                            </label>
                                            <p class="drag-and-drop">Or drag and drop photo to this box</p>
                                            <span class="file-types">(JPEG, PNG, GIF, image types are supported)</span>
                                        </div>
                                    </div>
                                    {!! Form::button('Continue', ['type' => 'button', 'class' => 'continue-btn', 'id' => 'btn-upload-signup']) !!}
                                </div>
                                <p class="you-can-skip">If prefer not to show your face, then get creative and show a different side of you! Or, if you prefer, you can <a href="#">skip this step</a> for now.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="signup-confirm-tab">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="text-center">
                                <h3 class="signup-title">Your account is created and verified. </h3>
                            </div>
                            <div class="signup-form-content signup-confirm-content">
                                <div class="log-msg-wrapper"></div>
                                <div class="signup-form-wrap">
                                    <div class="signup-confirm-box">
                                        <p class="signup-confirm-box-text">You have verified successfully. <br>Click <a class="" href="{{url('/login')}}">here</a> to login.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="signup-confirm-tab">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="text-center">
                                <h3 class="signup-title">Verify your Email Address! </h3>
                            </div>
                            <div class="signup-form-content signup-confirm-content">
                                <div class="log-msg-wrapper"></div>
                                <div class="signup-form-wrap">
                                    <div class="signup-confirm-box">
                                        <p class="signup-confirm-box-text">To complete the signup, we need to verify your email address. <br>We've sent an email with the instructions to: <a class="mailto-user" href="mailto:info@showcasehomes.co">info@showcasehomes.co</a></p>
                                    </div>
                                </div>
                                <p class="signup-confirm-resend-text">If you don't receive an email from us within the next 5 minutes, try looking in your junk mail folder.<br>If you still can't find it, click <a href="#" id="resend-verification">Resend the verification email</a>.</p>
                            </div>
                        </div> -->
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')

<script src="{{ asset_front('/js/inputmask.js?ver=' . mt_rand(1000, 9999)) }}"></script>
<script src="{{ asset_front('/js/signup/signup.js?ver=' . mt_rand(1000, 9999)) }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvWBmF4biee4XgHItzEpHOv6DtuM8MsCo&libraries=places"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function() {

        var options = {
            types: ['(cities)'],
            // componentRestrictions: {
                // country: "us"
            // }
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
<?php /*
<script>
    function initialize() {
        var options = {
            types: ['(cities)'],
            // componentRestrictions: {
                // country: "us"
                // }
            };

            var input = document.getElementById('city');
            var autocomplete = new google.maps.places.Autocomplete(input, options);

            // google.maps.event.addListener(autocomplete, 'place_changed', function () {
            //     var place = autocomplete.getPlace();
            //     console.log(place);
            //     // document.getElementById('city2').value = place.name;
            //     // document.getElementById('cityLat').value = place.geometry.location.lat();
            //     // document.getElementById('cityLng').value = place.geometry.location.lng();
            // });
        }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>*/
?>

@endsection
