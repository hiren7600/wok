@extends('manage.layouts.admin')

@section('pagetitle', ' - Users')

@section('content')

	<div class="page-header">
        <div class="row align-items-center">
        	<div class="col">
	            <h3 class="page-title">Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ul>
         	</div>
         	<div class="col-auto float-right ml-auto">
	            <a href="{{ url_admin('users/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add User</a>
         	</div>
            
        </div>
    </div>
    <div class="filter-row">
    	{!! Form::open(['url' => url_admin('users/load'), 'id' => 'searchform', 'class' => '']) !!}
	    	<div class="row">
		        <div class="col-sm-6 col-md-3">
		            <div class="form-group form-focus">
		            	<input class="form-control floating" name="search" title="Search by email, name, phone no" id="searchtextbox" data-toggle="tooltip">
		            	<label class="focus-label">Search text</label>
		            </div>
		        </div>
		        <div class="col-sm-6 col-md-3">
		            <button type="submit" class="btn btn-success btn-block"> Search </button>
		        </div>
	        </div>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Enabled</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tabledata"></tbody>
            	</table>
        	</div>
        	<div class="text-right" id="pagingdata" style="display: none;"></div>
    	</div>
	</div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/users/users.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection