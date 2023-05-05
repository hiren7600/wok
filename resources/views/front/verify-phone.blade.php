@extends('front.layouts.front')

@section('metatag')
    <title>Verify Phone</title>
@endsection

@section('content')
<section class="content-section signup-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {!! Form::open(['url' => 'verify-phone', 'id' => 'verify_form', 'class' => 'verify_form']) !!}
                    <input type="hidden" name="email" id="email" value="{{$user->email}}">
                    <nav class="d-none">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="signup-phone-tab" data-bs-toggle="tab" data-bs-target="#nav-phone" type="button" role="tab">Mobile Verification</button>
                            <button class="nav-link" id="signup-verification-tab" data-bs-toggle="tab" data-bs-target="#nav-verification" type="button" role="tab">Last Step</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-phone" role="tabpanel" aria-labelledby="signup-phone-tab">
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
                                        <p class="please-call-support">For problems please call support at +1 (800) 706 5313</p>
                                    </div>
                                    <p class="verification-code-deis">We sent the verfication code to 7209480850. if after a couple
                                        minutes you don't receive a text message form us, <a href="#"><a href="#"> update your
                                                number</a></a> and we'll sent
                                        you a new verification code.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')

<script src="{{ asset_front('/js/verify/verify-phone.js?ver=' . mt_rand(1000, 9999)) }}"></script>

@endsection
