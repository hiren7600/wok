<!DOCTYPE html>
<html>
<head>
	@include('manage.layouts.head', ['pagetitle' => $pagetitle])
</head>
<body class="error-page">

    <div class="main-wrapper">
        <div class="error-box">
            <h1>{{ $statuscode }}</h1>
            <h3><i class="fa fa-warning"></i> Oops! {{ $subtitle }}</h3>
            <a href="{{ url('/login') }}" class="btn btn-custom">Back to Home</a>
        </div>
    </div>

@include('manage.layouts.foot')
</body>
</html>