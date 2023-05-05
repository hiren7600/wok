@extends('manage.layouts.admin')

@section('pagetitle', ' - Profile')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Dashboard</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Please modify the details below</h4>
        </div>
        <div class="card-body">
            <!-- form start -->
            {!! Form::open(['url' => url_admin('profile'), 'class' => 'tooltip-right-bottom', 'id' => 'formprofile']) !!}
                <input name="deleteimage" id="deleteimage" type="hidden" value="0" class="form-control" />
                {!! Form::hidden('user_id', $admin->user_id) !!}

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="firstname">First Name <span class="text-danger">*</span></label>
                        {!! Form::text('firstname', $admin->firstname, ['class' => 'form-control', 'id' => 'firstname']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Last Name <span class="text-danger">*</span></label>
                        {!! Form::text('lastname', $admin->lastname, ['class' => 'form-control', 'id' => 'lastname']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        {!! Form::text('email', $admin->email, ['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Old Password</label>
                        {!! Form::password('oldpassword', ['class' => 'form-control', 'id' => 'oldpassword']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">New Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Confirm Password</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        <label for="image">Image</label>
                        <div>
                            <h2 class="form-control-avatar">
                                <div class="avatar">
                                    <img src="{{ $admin->imagefilepath }}" alt="{{ $admin->firstname }}">
                                    @if($admin->hasimage)
                                        <span class="la la-close remove-img" title="Remove" onclick="removeProfilePic();"></span>
                                    @endif
                                </div>
                                {!! Form::file('imagefile', ['id' => 'imagefile', 'class' => 'form-control']) !!}
                            </h2>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/profile.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection
