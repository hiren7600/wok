@extends('manage.layouts.admin')

@section('page-title', $pagetitle)

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">{{ $statuscode }} error</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $pagetitle }}</li>
            </ul>
        </div>
    </div>
</div>
<div class="main-wrapper">
    <div class="error-box">
        <h1>{{ $statuscode }}</h1>
        <h3><i class="fa fa-warning"></i> Oops! {{ $subtitle }}</h3>
        <a href="{{ url_admin('dashboard') }}" class="btn btn-custom">Back to Dashboard</a>
    </div>
</div>

@endsection