@if ($message && $lastMessageId != $message->id)
    @if ($message->sender_user_id != Auth()->user()->id)
        <div class="row no-gutters">
            <div class="col-md-5">
                <div class="chat-bubble chat-bubble--left">
                    <span class="time small">{{ format_messaging_date($message->created_at) }}</span>
                    <br>
                    {!! $message->message_body !!}

                </div>
            </div>
        </div>
    @else
        {{-- <div class="row no-gutters">
            <div class="col-md-5 offset-md-9" style="float: right; ">

                <div class="chat-bubble chat-bubble--right">
                    <span class="time small">{{ format_messaging_date($message->created_at) }}</span> <br>
                    {!! $message->message_body !!}

                </div>
            </div>
        </div> --}}
    @endif
    <input type="hidden" class="lastMessageId" value="{{ $message->id }}"/>
@endif
