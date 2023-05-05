@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Contact Us</title>
    @endif
@endsection


@section('content')
    <section class="welcome-bg">
        <div class="container">
            <div class="contactus-inner">
                <div class="welcome-content-header inner-heading">
                    <h2>Want to get in contact with us?</h2>
                    <p class="sub-title">Just fill out the form below and click submit. It's that simple.</p>
                </div>
                <div class="text-center"><div class="log-msg-wrapper"></div></div>
                {!! Form::open(['url' => 'contact-us', 'id' => 'formcontactus']) !!}
                <div class="contact-us-bg">
                    <div class="form-group contactus-form-field">
                        <label class="form-lable">Name:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group contactus-form-field">
                        <label class="form-lable">Email Address:</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group contactus-form-field">
                        <label class="form-lable">Subject:</label>
                        <input type="text" class="form-control" name="subject">
                    </div>
                    <div class="form-group contactus-form-field message-field">
                        <label class="form-lable">Message</label>
                        <textarea rows="10" class="form-control" name="message"></textarea>
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
    <script src="{{ asset_front('/js/contact-us/contact-us.js') }}"></script>
@endsection
