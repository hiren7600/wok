@extends('front.layouts.front')

@section('metatag')
    <title>Block User</title>
@endsection


@section('content')
    <section class="blocked-page">
        <div class="container-xxl">
            <div class="blocked-box">
                <img src="{{$check_block_user->user->mediumthumbimagefilepath}}" alt="profile" class="blocked-avtar-img">
                <div class="blocked-info">
                    <h1><b>{{$check_block_user->user->username}}</b> isn't available at this time</h1>
                    <div class="blocked-content">
                        You aren't able to contact <b>{{$check_block_user->user->username}}</b> because they've either deactivated their account or
                        blocked you.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')

@endsection
