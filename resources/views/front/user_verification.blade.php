@extends('front.layouts.front')

@section('metatag')
<title>User Verification</title>
@endsection


@section('content')
    <section class="content-section account-verification-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if($status == 'verified')
                    <div class="text-center">
                        <h3 class="signup-title">Account Verified</h3>
                        <h6 class="verification-text">Your account successfully verified.</h6>
                        <div class="error-content-area mt-5">
                            <p>Click the below button to login now.</p>
                            <a class="btn btn-signup" href="{{ url('/login')}}">Login</a>
                        </div>
                    </div>
                    @else
                    <div class="text-center">
                        <h3 class="signup-title">Account Already Verified</h3>
                        <h6 class="verification-text">Your account has been already verified.</h6>
                        <div class="error-content-area mt-5">
                            <p>Click the below button to login now.</p>
                            <a class="btn btn-signup" href="{{ url('/login')}}">Login</a>
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </section>
@endsection
