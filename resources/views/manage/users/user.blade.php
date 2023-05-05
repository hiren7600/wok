@extends('manage.layouts.admin')

@section('pagetitle', ' - User '.((empty($user->user_id)) ? 'Add' : 'Edit'))

@section('content')


    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">User</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url_admin('users') }}">Users</a></li>
                    <li class="breadcrumb-item active">{{ (empty($user->user_id)) ? 'Create' : 'Edit' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">{{ (empty($user->user_id)) ? 'Please fill in the below fields to add a new user' : 'Please modify the details below' }}</h4>
        </div>
        <div class="card-body">
            {!! Form::model($user, ['url' => url_admin('users/store'), 'id' => 'formuser', 'files' => true]) !!}
            {!! Form::hidden('user_id', null, ['id' => 'user_id']) !!}
            <input name="deleteimage" id="deleteimage" type="hidden" value="0" class="form-control" />
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="firstname">First Name <span class="text-danger">*</span></label>
                    {!! Form::text('firstname', null, ['class' => 'form-control', 'id' => 'firstname']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="lastname">Last Name <span class="text-danger">*</span></label>
                    {!! Form::text('lastname', null, ['class' => 'form-control', 'id' => 'lastname']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Designation <span class="text-danger">*</span></label>
                    {!! Form::select('designation_id', [null => 'Select designation'] + $designations, $user->designation_id, ['class' => 'form-control select', 'id' => 'designation_id'])!!}
                    
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password @if(empty($user->user_id))<span class="text-danger">*</span>@endif </label>
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Confirm Password @if(empty($user->user_id))<span class="text-danger">*</span>@endif</label>
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="phoneno">Phone No <span class="text-danger">*</span></label>
                    {!! Form::text('phoneno', null, ['class' => 'form-control', 'id' => 'phoneno']) !!}
                </div>


                <div class="form-group col-md-6">
                    <label for="image">Image</label>
                    <div>
                        <h2 class="form-control-avatar">
                            <div class="avatar">
                                <img src="{{ $user->imagefilepath }}" alt="User image">
                                @if($user->hasimage)
                                    <span class="la la-close remove-img" title="Remove" onclick="removeUserPic();"></span>
                                @endif
                            </div>
                            {!! Form::file('imagefile', ['id' => 'imagefile', 'class' => 'form-control']) !!}
                        </h2>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Enabled</label>
                    <div class="onoffswitch statusswitch">
                        <input type="checkbox" value="1" name="status" class="onoffswitch-checkbox" id="switch_status" {{(!empty($user) && $user->status == 1)?'checked':'' }} {{(empty($user->user_id))?'checked':'' }}>
                        <label class="onoffswitch-label" for="switch_status">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="text-right">
                <a class="btn btn-light mt-3" href="{{ url_admin('users') }}">Cancel</a>
                {!! Form::button('Submit', ['id'=>'btnsubmit', 'type' => 'submit', 'class' => 'btn btn-primary mt-3']) !!}
            </div>

        {!! Form::close() !!}
        </div>
    </div>

@endsection
@section('page-scripts')
<script src="{{ asset_admin('js/users/user.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection