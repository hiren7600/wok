<div class="new-message-box">
    <div class="message-body">
        <div class="message-user-box">
            <div class="message-author-info"><a href="#"><img src="{{$conversationmessage->user->imagefilepath}}" alt="mail author image"></a>
            </div>
            <span>
                <a href="#" class="message-user-name">{{$conversationmessage->user->username}}</a>
                <div class="message-status">
                    <span>{{ Carbon\Carbon::parse($conversationmessage->user->dob)->age }}{{ $conversationmessage->user->gender }}</span>
                    <span class="border-right-side">|</span>
                    <span>{{string_explode_implode($conversationmessage->user->address)}}</span>
                </div>
                <span class="user-message-date"> {{ date(' F j, Y', strtotime($conversationmessage->created_at)) }}
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
