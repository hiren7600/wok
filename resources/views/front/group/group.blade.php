@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Group</title>
    @endif
@endsection

@section('content')
<section class="create-group-page">
    <div class="container-xl">
        <div class="casualencounters-w-wrap">
            <div class="create-groups-main-bg mt-5 mb-5">
                <div class="common-row">
                    <div class="common-left-column pe-md-4">
                        <div class="create-group-form-area">
                            <h2 class="create-group-form-title">Create a New Group</h2>
                            {!! Form::open(['url' => 'creategroup', 'id' => 'creategroup_form', 'class' => 'creategroup_form']) !!}
                            <div class="group-form-box">
                                <div class="form-group">
                                    <label>Group Title:</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea  name="desc" class=" group_desc form-control"></textarea>
                                </div>
                                <div class="text-radio-btn">
                                    <label class="public-pri-radio-btn">
                                        <h2>Public Group</h2>
                                        <p>Anyone on the site can see the group and join it without any approvals
                                            from others or group owners.</p>
                                        <input type="radio" checked="checked" name="group_status" value="0">
                                        <span class="public-pri-checkmark"></span>
                                        <span class="redio-bg"></span>
                                    </label>
                                    <label class="public-pri-radio-btn">
                                        <h2>
                                            Private Group</h2>
                                        <p>Anyone on the site can find the group but that’s it. They can’t enter the
                                            group or read the post until the group owner approves them.</p>
                                        <input type="radio" name="group_status" value="1">
                                        <span class="public-pri-checkmark"></span>
                                        <span class="redio-bg"></span>
                                    </label>
                                </div>
                                <button class="create-group-btn" type="submit">Create Now</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="common-right-column pt-0 px-md-2 px-0">
                        <div class="side-description">
                            <p>Groups are discussions of focused topics you want to start. When you create a group,
                                people can join and comment on your group topics or create sub topics related to
                                your group.</p>
                            <p>Groups are joined by members who share the same interest as your group topic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')
<script src="{{ asset_front('/js/group/group.js?ver=' . mt_rand(1000, 9999)) }}"></script>

@endsection
