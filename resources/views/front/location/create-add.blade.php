@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Create Ad</title>
    @endif
@endsection

@section('content')
    <section class="welcome-bg">
        <div class="container">
            <div class="contactus-inner">
                <div class="welcome-content-header inner-heading">
                    <h2>Post Ad</h2>
                </div>
                <div class="text-center"><div class="log-msg-wrapper"></div></div>
                {!! Form::open(['url' => 'create-ad', 'id' => 'create_ad_form']) !!}
                <input type="hidden" name="ad_category_id" id="ad_category_id" value="{{$adcategory->ad_category_id}}">
                <input type="hidden" name="select_from_list" id="select_from_list" value="0">
                <div class="contact-us-bg">
                    <div class="form-group contactus-form-field">
                        <label class="form-lable">Title:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                    </div>
                    <div class="form-group contactus-form-field">
                        <label class="form-lable">Location:</label>
                        <input type="text" class="form-control" name="location" id="location">
                    </div>
                    <div class="form-group contactus-form-field message-field">
                        <label class="form-lable">Post</label>
                        <textarea rows="10" class="form-control" name="content" placeholder="Post"></textarea>
                    </div>

                    <div class="ad-images-file-box contactus-form-field">
                        <div class="signup-form-content">
                            <div class="">
                                <div class="profile-inner-box p-0 form-group">
                                    <div class="uploading-area form-group-input">
                                        <img src="{{asset_front('/images/uploading.png')}}" data-src="{{asset_front('/images/uploading.png')}}" alt="uploading" class="uploading-img">
                                        <div>
                                            <label class="btn btn-upload-photo">
                                                <span>Select photo to upload</span>
                                                <input name="imagefile[]" id="imagefile" type="file" class="form-control d-none" multiple>
                                            </label>
                                        </div>
                                        <p class="drag-and-drop">Or drag and drop photo to this box</p>
                                        <span class="file-types">(JPEG, PNG, GIF, image types are supported)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group contactus-form-field certify-everyone-checkbox">
                        <label class="role-checkbox"> I agree to the <a href="{{url('/service')}}" target="_blank">terms of use</a> by making a post
                            <input class="form-control d-none" value="1" type="checkbox"
                                name="tnc">
                            <span class="checkmark-arrow"></span>
                        </label>
                    </div>
                    <div class="contact-form-submit-btn">
                        <input type="submit" value="Submit" class="btn submit-btn contact-">
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
    </section>
@endsection


@section('page-scripts')
<script src="{{ asset_front('/js/ad/create-ad.js?ver=' . mt_rand(1000, 9999)) }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvWBmF4biee4XgHItzEpHOv6DtuM8MsCo&libraries=places"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function() {

        var options = {
            types: ['(cities)'],
            // componentRestrictions: {
                // country: "us"
            // }
        };

        var input = document.getElementById('location');
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
                        
                        $('#location').val(citytext);
                        $('#full_address').val(fulladdresstext);
                        $('#select_from_list').val(1);
                        
                    }
                }
            });
        });
    });
</script>
@endsection
