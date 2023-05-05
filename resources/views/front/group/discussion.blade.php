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
                            <h2 class="create-group-form-title">Create your discussion in {{$groups->title}}</h2>
                            {!! Form::open(['url' => 'creatediscussion', 'id' => 'creatediscussion_form', 'class' => 'creatediscussion_form']) !!}
                            <input type="hidden" name="group_id" value="{{$groups->group_id}}">
                            <div class="group-form-box">
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Body:</label>
                                    <textarea name="desc" class="group_desc ckeditor form-control" id="tiny"></textarea>
                                </div>
                                {{-- <div class="from-group  uploading-area ">
                                    <input type='file' id="imagefile" name="imagefile" class="g-upload-file-input" />
                                    <span>Select an image or drag and drop your file here</span>
                                    <img id="image-preview" class="uploading-img" src="" class="upload-filebox" />
                                </div> --}}

                                <div class="uploading-area form-group form-group-input">
                                    <img src="{{ asset_front('/images/uploading.png') }}"
                                        data-src="{{ asset_front('/images/uploading.png') }}" alt="uploading"
                                        class="uploading-img">
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
                                    <label>Make sticky: <input type="checkbox" name="sticky" value="1"></label>
                                </div>
                                <button class="create-group-btn" type="submit">Post Now</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="common-right-column pt-0 px-md-2 px-0">
                        <div class="side-description">
                            <p><b>Got something to say?</b></p>
                            <p>Start writing and share your story,<br> experiences or thoughts with the community.
                            </p>
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
<script src="{{ asset_front('/js/group/discussion.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
