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
<section class="mail-page">
    <div class="main-height-wrap">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-12">
                    <div class="lime-body mailbox">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="inbox-heading">Inbox</h1>
                                <div class="mailbox-inner-box">
                                    <div class="mailbox-menu">
                                        <ul class="mailmenu-list-unstyled">
                                            <li><a href="{{ url('/conversation') }} " class="active" >Inbox <span
                                                        class="mail-index">({{$globaldata['newMsgCounts']}})</span></a>
                                            </li>
                                            <li><a href="{{ url('/conversation-sent') }} ">Sent</a></li>
                                            {{-- <li><a href="{{ url('/conversation-archived') }}">Archived</a></li> --}}
                                            <li><a href="#">Archived</a></li>
                                        </ul>
                                    </div>
                                    <div class="mail-list-container">
                                    @if (!$conversations->isEmpty())
                                        @foreach ($conversations as $conversation)
                                            <?php
                                                $messageread = $conversation->conversationmessages()->where('user_id', '!=', $user->user_id)->latest()->first();
                                            ?>
                                            <div class="mail-info">
                                                <div class="mail-list-items {{(!empty($messageread) && $messageread->is_read == 1?'read':'unread')}}">
                                                    <a href="{{ url('/conversation-details/'. $conversation->conversation_id) }}" class="mail-author-info">
                                                        <img src="{{$conversation->fromuser->imagefilepath}}" alt="mail author image"
                                                            class="mail-author-image">
                                                            <div>
                                                                <span class="mail-author-name">
                                                                    {{$conversation->fromuser->username}}
                                                                </span>
                                                                <span>{{ Carbon\Carbon::parse($conversation->fromuser->dob)->age }}{{ $conversation->fromuser->gender }}</span>
                                                                <p>{{string_explode_implode($conversation->fromuser->address)}}</p>
                                                                <div class="archive-items">
                                                                    <span>
                                                                        @if (!empty($conversation->conversationmessages))
                                                                            {{$conversation->conversationmessages()->latest()->first()->created_at->diffForHumans()}}
                                                                        @else
                                                                            {{ $conversation->created_at->diffForHumans() }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    <a href="{{ url('/conversation-details/'. $conversation->conversation_id) }}" class="message-info">
                                                            <div class="subject-text">{{$conversation->subject}} </div>
                                                            <div class="message-text">
                                                                <p>
                                                                    @if (!empty($conversation->conversationmessages))
                                                                        {{$conversation->conversationmessages->first()->message}}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                    </a>
                                                    {!! Form::open(['url' => 'conversation-delete', 'id' => 'conversation_delete_form', 'class' => 'conversation_delete_form']) !!}
                                                    <div class="controler-menu">
                                                        <input type="hidden" name="conversation_id" value="{{$conversation->conversation_id}}">
                                                        <button type="submit" class="delete-mail-box">
                                                            <span class="dsk-for">Delete</span></button>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-image-bg">
                                            <div class="container">
                                                <div class="main-height-wrap d-flex justify-content-center align-items-center">
                                                    <div class="no-image-msg-show">
                                                        <p>No Inbox Messages</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
<script src="{{ asset_front('/js/conversation/sent_conversation.js?ver=' . mt_rand(1000, 9999)) }}"></script>
@endsection
