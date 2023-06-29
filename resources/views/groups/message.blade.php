
 @foreach($messages as $message)
 <div class="row align">
        <div class="col-lg-1 col-sm-2 col-xs-3">
            <a href="{{ route('users.player-detail',1) }}"><img src="/img/avatar.jpg" class="avatar"></a>
        </div>
        <div class="col-sm-8 col-xs-9">
            <h4><b>{{ $message->name }}</b></h4>
            <div class="visible-xs">{{ format_messaging_date($message->created_at) }}</div>
        </div>
        <div class="col-lg-3 col-sm-2 col-xs-12 text-right hidden-xs">
            {{ format_messaging_date($message->created_at) }}
        </div>
    </div>
    <div class="row m_t10">
        <div class="col-sm-10 col-sm-offset-1 ">
            <p>{{ $message->message_body }}</p>

            @if($message->group_image)

            <img src="{{ $message->group_image }}" style="max-width:600px;">

            @endif


        </div>
    </div>
    <hr>

     @endforeach
    