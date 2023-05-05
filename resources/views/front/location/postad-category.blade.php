@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Location</title>
    @endif
@endsection

@section('content')
<section class="location-bg">
    <div class="container-xl">
        <div class="custom-container-wrap">
            {{-- <div class="casual-encounter-ads-list-box"> --}}
                {{-- <div class="member-add-post-row d-flex"> --}}
                    {{-- <div class="member-post-right-column order-md-2"> --}}
                        {{-- <span>Post Ad - Category</span> --}}
                        {{-- <div class="add-ads-box"> --}}
                            {{-- <h3 class="cities-title-item categories d-md-none">Categories
                                <span>»</span>
                            </h3> --}}
                            {{-- <div class="categories-box">
                                <ul>
                                    @foreach ($ad_categories as $category)
                                         <li><a href="{{url('create-ad/'.$category->slug)}}" class="">{{$category->name}}</a> </li>
                                    @endforeach

                                </ul>
                            </div> --}}

                            <div class="container-xl">
                                <div class="main-height-wrap">
                                    <div class="post-ad-category-box">
                                        <p class="post-ad-title">Post Ad - Category</p>
                                        <ul class="post-ad-category-list">
                                            @foreach ($ad_categories as $category)
                                                <li><a href="{{url('create-ad/'.$category->slug)}}" class="">{{$category->name}}</a> </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</section>
@endsection
@section('page-scripts')
@endsection
