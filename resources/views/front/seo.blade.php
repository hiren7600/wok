@extends('front.layouts.front')

@section('metatag')
<title>Seo</title>
@endsection


@section('content')
    <section class="about-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="about-heading-block">
                            <h3 class="about-heading mb-3">SEO</h3>
                        </div>
                        <div class="about-block">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="about-left-block">
                                        {!! Form::open(['url' => 'seo', 'id' => 'formseo']) !!}
                                            <div class="seo-form-bg">
                                                <div class="form-group">
                                                    <label class="seo-label-items">Select Page:</label>
                                                    {!! Form::select('page', [null => 'Select Page'] + $page, null, ['class' => 'form-control about-left-select', 'id' => 'page', 'data-placeholder' => 'Select'])!!}
                                                </div>

                                                <div class="form-group state-box d-none">
                                                    <label class="seo-label-items">Select State:</label>
                                                    {!! Form::select('state', [null => 'Select State'] + $states, null, ['class' => 'form-control about-left-select', 'id' => 'state', 'data-placeholder' => 'Select'])!!}
                                                </div>
                                                <div class="form-group">
                                                    <label class="seo-label-items">Meta title</label>
                                                    <input name="meta_title" id="meta_title" type="text" placeholder="Meta title" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="seo-label-items">Meta keyword</label>
                                                    <input name="meta_keyword" id="meta_keyword" type="text" placeholder="Meta keyword" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="seo-label-items">Meta description</label>
                                                    <textarea name="meta_description" id="meta_description" placeholder="Meta description" class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="seo-label-items">Meta robots</label>
                                                    <input name="meta_robot" id="meta_robot" type="text" placeholder="Meta robots" class="form-control">
                                                </div>
                                            </div>
                                            <button type="submit" class="about-btn">Save</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
    <script src="{{ asset_front('/js/seo/seo.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
