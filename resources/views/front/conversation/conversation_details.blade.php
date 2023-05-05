@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>User EMail</title>
    @endif
@endsection

@section('content')
    <section class="message-page">
        <div class="container-lg">
            <div class="internal-page-bg">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-12">
                        <div class="message-inner-wrap">
                            <div class="conversation-heading">
                                <div class="subject-content">
                                    <h1>{{$conversation->first()->subject}}</h1>
                                </div>
                                @if ($conversation->fromuser->user_id ==$globaldata['user']->user_id)
                                    <div class="conversation-with-title">Conversation with: <a href="{{ url('/profile/' . $conversation->touser->user_id) }}">{{$conversation->touser->username}}</a></div>
                                @else
                                    <div class="conversation-with-title">Conversation with: <a href="{{ url('/profile/' . $conversation->fromuser->user_id) }}">{{$conversation->fromuser->username}}</a></div>
                                @endif
                            </div>

                            <div class="message-layout">
                                <div class="message-layout-row">
                                    <div class="message-layout-left-col">
                                        <div class="message-subheading"><p>Messages</p></div>
                                        <div class="all-message-list">
                                            @if (!$conversation->conversationmessages->isEmpty())
                                                @foreach ($conversation->conversationmessages as $conversationmessage )
                                                <div class="new-message-box">
                                                    <div class="message-body">
                                                        <div class="message-user-box">
                                                            <div class="message-author-info"><a href="{{ url('/profile/' . $conversationmessage->user->user_id) }}"><img src="{{$conversationmessage->user->smallthumbimagefilepath}}" alt="mail author image"></a>
                                                            </div>
                                                            <span>
                                                                <a href="{{ url('/profile/' . $conversationmessage->user->user_id) }}" class="message-user-name">{{$conversationmessage->user->username}}</a>

                                                                @if ($conversationmessage->is_read == 0 && $conversationmessage->user->user_id != $globaldata['user']->user_id )
                                                                    <span class="new-msg-tag"> new</span>
                                                                @endif

                                                                <div class="message-status">
                                                                    <span>{{ Carbon\Carbon::parse($conversationmessage->user->dob)->age }}{{ $conversationmessage->user->gender }}</span>
                                                                    <span class="border-right-side">|</span>
                                                                    <span>{{string_explode_implode($conversationmessage->user->address)}}</span>
                                                                </div>
                                                                <span class="user-message-date">{{$conversationmessage->created_at->diffForHumans() }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="user-message-content-box">
                                                            <p>{{$conversationmessage->message}}</p>
                                                            <div class="user-message-media">
                                                            @if (!empty($conversationmessage->imagefile))
                                                                <img src="{{$conversationmessage->imagefile}}" alt="user-message-media">
                                                            @endif

                                                            </div>
                                                            {{-- <button class="particular-message-delete-btn"><i
                                                                class="fas fa-trash"></i> Delete
                                                            Message</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        {!! Form::open(['url' => 'conversation-details', 'id' => 'conversation_details_form', 'class' => 'conversation_details_form']) !!}
                                        <input type="hidden" name="to_id" value="{{$conversation->first()->fromuser->user_id}}">
                                        <div class="feed-post-comment-preview">
                                            <div class="preview-box">
                                                <span class="fas fa-times comment-preview-close"></span>
                                                <img class="preview-img" src="">

                                            </div>
                                        </div>
                                        <div class="user-message-write-box">
                                            <div class="user-msg-column">
                                                <div class="form-group user-message-textarea">
                                                    <textarea rows="10" name="message" class="write-message-area form-control" placeholder="Enter your message here"></textarea>
                                                </div>
                                                <div class="form-group user-image-upload">
                                                    <label href="#" class="message-upload-image"><span>Upload pic</span>
                                                        <input type="file" name="imagefile" class="d-none">
                                                    </label>
                                                </div>
                                            </div>
                                                <input type="hidden" name="conversation_id" value={{$conversation->conversation_id}}>
                                                <button class="send-message-btn">Send Message</button>


                                        </div>
                                        {!! Form::close() !!}
                                        {{-- <button class="globally-delete-conversation"><i class="fas fa-trash"></i> Delete Conversation</button> --}}
                                    </div>
                                    <div class="message-layout-right-col">
                                        <div class="message-subheading"><p>Images</p></div>
                                        <div class="thumbnail-box">
                                            <ul class="thumbnail-group">
                                                {{-- {{dd($conversation->conversationmessages)}} --}}
                                                @if (!$conversation->conversationmessages->isEmpty())
                                                    @foreach ( $conversation->conversationmessages as $imagefile )
                                                        @if (!empty($imagefile->thumbfile))
                                                            <li class="thumbnail-items-list"><a href="#"><img src="{{$imagefile->thumbfile}}" alt="thumbnail-image"></a></li>
                                                        @endif

                                                    @endforeach
                                                @endif

                                            </ul>

                                        </div>
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
<script src="{{ asset_front('/js/conversation/conversationdetails.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
