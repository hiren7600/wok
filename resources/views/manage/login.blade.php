<!DOCTYPE html>
<html>
<head>
	@include('manage.layouts.head', ['pagetitle' => ' - Login'])
</head>
<body class="account-page">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <div class="account-logo">
                    <img src="{{asset_admin('img/logo2.png')}}" alt="Platinum">
                </div>
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Login</h3>
                        <p class="account-subtitle">Access to our dashboard</p>
        				{!! Form::open(['url' => 'login', 'id' => 'formlogin']) !!}

                            <div class="form-group">
                                <label>Email Address</label>
                                {!! Form::text('email', '', ['class' => 'form-control']) !!}
                            </div>

        					<div class="form-group">
                                <label>Password</label>
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Login</button>
                            </div>
        				{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('manage.layouts.foot')
<script src="{{ asset_admin('/js/login.js?ver=1.0.'.getCacheCounter()) }}"></script>
</body>
</html>