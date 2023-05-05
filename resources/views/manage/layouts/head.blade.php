<!-- Meta Tags -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="base-url" content="{{ url_admin('') }}" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<!-- Title -->
<title>
	{{ config('constants.website') }} | Admin
	@if(isset($pagetitle))
		{{ $pagetitle }}
	@else
		@yield('pagetitle')
	@endif
</title>

<link rel="shortcut icon" type="image/x-icon" href="{{ asset_admin('/img/favicon.png?ver=1.0.'.getCacheCounter()) }}">
<link rel="stylesheet" href="{{asset_admin('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('css/line-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('plugins/summernote/dist/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset_admin('plugins/PNotify/PNotify.css')}}">
<link rel="stylesheet" href="{{asset_admin('css/style.css?ver=1.0.'.getCacheCounter())}}">





