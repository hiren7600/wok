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
                            {!! Form::open(['url' => 'submit/edit-group', 'id' => 'editgroup_form', 'class' => 'editgroup_form']) !!}
                            <input type="hidden" name="group_id" value="{{$group->group_id}}">
                            <div class="group-form-box">
                                <div class="form-group">
                                    <label>Group Title:</label>
                                    <input type="text" name="title" value="{{$group->title}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea  name="desc" class=" group_desc form-control">{{$group->description}}</textarea>
                                </div>
                                <div class="text-radio-btn">
                                    <label class="public-pri-radio-btn">
                                        <h2>Public Group</h2>
                                        <p>Anyone on the site can see the group and join it without any approvals from others or group owners.</p>
                                        <input type="radio" name="group_status" value="0" {{($group->status == 0?'checked="checked"':'')}}>
                                        <span class="public-pri-checkmark"></span>
                                        <span class="redio-bg"></span>
                                    </label>
                                    <label class="public-pri-radio-btn">
                                        <h2>Private Group</h2>
                                        <p>Anyone on the site can find the group but that’s it. They can’t enter the group or read the post until the group owner approves them.</p>
                                        <input type="radio" name="group_status" value="1" {{($group->status == 1?'checked="checked"':'')}}>
                                        <span class="public-pri-checkmark"></span>
                                        <span class="redio-bg"></span>
                                    </label>
                                </div>
                                <button class="create-group-btn" type="submit">Update</button>
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
<script src="{{ asset_front('/js/group/group-edit.js?ver=' . mt_rand(1000, 9999)) }}"></script>

@endsection
