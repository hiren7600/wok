@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Edit Discussion</title>
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
                            <h2 class="create-group-form-title">Edit discussion  </h2>
                            {!! Form::open(['url' => 'edit-discussion', 'id' => 'edit_discussion_form', 'class' => 'edit_discussion_form']) !!}
                            <input type="hidden" name="discussion_id" value="{{$group_discussion->group_discussion_id}}">
                            <div class="group-form-box">
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text" name="title" class="form-control" value="{{$group_discussion->title}}">
                                </div>
                                <div class="form-group">
                                    <label>Body:</label>
                                    <textarea name="desc" class="group_desc ckeditor form-control" id="tiny" >{{$group_discussion->content}}</textarea>
                                </div>

                                <div class="uploading-area form-group form-group-input">
                                    @if ($group_discussion->imagefile)
                                        <img src="{{$group_discussion->imagefile }}"
                                    data-src="{{ $group_discussion->imagefile }}" alt="uploading"
                                    class="uploading-img">
                                    @else
                                        <img src="{{ asset_front('/images/uploading.png') }}"
                                        data-src="{{ asset_front('/images/uploading.png') }}" alt="uploading"
                                        class="uploading-img">
                                    @endif

                                    <label class="btn btn-upload-photo">
                                        <span>Select photo to upload</span>
                                        <input name="imagefile" id="imagefile" type="file"
                                            class="form-control d-none">
                                    </label>
                                    <p class="drag-and-drop">Or drag and drop photo to this box</p>
                                    <span class="file-types">(JPEG, PNG, GIF, image types are
                                        supported)</span>
                                </div>
                                <div class="make-sticky-box">
                                    <label>Make sticky: <input type="checkbox" name="sticky" value="1"
                                         @if ($group_discussion->is_sticky == 1) checked @endif>
                                        </label>
                                </div>
                                <button class="create-group-btn" type="submit">Update Now</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset_front('/js/group/discussion-edit.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
