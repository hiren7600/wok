@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Post</title>
    @endif
@endsection

@section('content')
    <section class="past-ad-page">
        <div class="post-ad-head">
            <ul class="psot-prev-next-bt">
                <li><a href="{{url('/view-ad/'.$prevId)}}"><i class="fas fa-caret-left"></i> Prev</a></li>
                <li><a href="#"><i class="fas fa-caret-up"></i></a></li>
                <li><a href="{{url('/view-ad/'.$nextId)}}">Next <i class="fas fa-caret-right"></i></a></li>
            </ul>
            <div class="postad-head-right-menu">
                @if($globaldata['user']->issuperadmin == 1)
                <a href="#" class="text-danger delete-ad-btn">Delete Ad</a>
                <span class="border-right-side">|</span>
                @endif
                <a href="#">Report Abuse</a>
                <span class="border-right-side">|</span>
                <a href="#">Email this Ad</a>
            </div>
        </div>
        <div class="container-xl">
            <div class="custom-container-wrap">
                <div class="breadcrumb-bg">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a>{{$state}}</a></li>
                            <li class="breadcrumb-item"><a>{{$city}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a>{{$adpost->adcategory->name}}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="fill-my-mouth-bg">
                    <div class="fill-my-mouth-row">
                        <div class="mouth-left-column">
                            <h1 class="fill-mouth-heading">
                                <i class="far fa-star"></i>
                                {{$adpost->title}}
                            </h1>
                            <ul class="ad-about-details">
                                <li>Posted on <span>{{$adpost->created_at->format('d/m/Y')}}</span></li>
                                <!-- <li>Renewed at <span>09/02/2022</span></li> -->
                                <li>Updated at <span>{{$adpost->updated_at->format('d/m/Y')}}</span></li>
                                <li>Post ID <span>#{{$adpost->ad_post_id}}</span></li>
                                <li>By <a href="{{url('/profile/'.$adpost->user->user_id)}}"><b>{{$adpost->user->username}}</b></a></li>
                                <!-- <li>Rank: <span>Newbie </span></li> -->
                            </ul>
                            <p class="ad-post-content">{{$adpost->content}}</p>
                            <p class="ad-error">It is NOT ok to contact this poster with commercial interests.</p>
                            <div class="d-md-none">
                                @if(!$adpost->admedias->isEmpty())
                                    @foreach($adpost->admedias as $admedia)
                                    <div class="msg-box-img">
                                        <a><img src="{{$admedia->imagefile}}" alt="user-image"></a>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="contact-form-box">
                                {!! Form::open(['url' => 'contact-ad-post', 'id' => 'contactadpost_form', 'class' => 'contactadpost_form']) !!}
                                <input type="hidden" name="to_id" value="{{$adpost->user->user_id}}">
                                <input type="hidden" name="subject" value="{{$adpost->title}}">
                                <div class="contact-this-user">
                                    <p>Contact this User: </p>
                                </div>
                                <div class="user-type-message-here form-group">
                                    <textarea name="message" class="form-control"></textarea>
                                </div>
                                <div class="attach-image-to-message form-group">
                                    <span>Attach an image to your message! <input type="file" name="imagefile"></span>
                                </div>
                                <button type="submit" class="user-send-message-btn">Send Message</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="mouth-right-column d-none d-md-block">
                            @if(!$adpost->admedias->isEmpty())
                                @foreach($adpost->admedias as $admedia)
                                <div class="msg-box-img">
                                    <a><img src="{{$admedia->imagefile}}" alt="user-image"></a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::open(['url' => 'delete-ad', 'id' => 'delete_ad_form', 'class' => 'delete_ad_form']) !!}
        <input type="hidden" name="ad_post_id" value="{{$adpost->ad_post_id}}">
    {!! Form::close() !!}
@endsection

@section('page-scripts')
    <script src="{{ asset_front('/js/ad/ad-post-view.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
