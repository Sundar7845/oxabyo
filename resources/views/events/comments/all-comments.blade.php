<div class="white_bg black m_y20 p_10 comment-list-single" style="overflow-y:scroll;height:465px;">
    @foreach ($comments as $comment)
        <div class="pull-right">{{ $comment->created_at }}</div>
        <div><b>{{ $comment->name }}</b></div>
        <div>{{ $comment->comment }}</div>
        <hr class="m_y5">
        <input type="hidden" class="lastCommentId" value="{{ $comment->id }}" />
    @endforeach
</div>
