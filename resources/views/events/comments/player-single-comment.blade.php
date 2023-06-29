@if ($comment && $lastPlayerCommentId != $comment->id)
    <div class="pull-right">{{ $comment->created_at }}</div>
    <div><b>{{ $comment->name }}</b></div>
    <div>{{ $comment->comment }}</div>
    <hr class="m_y5">
    <input type="hidden" class="lastPlayerCommentId" value="{{ $comment->id }}" />
@endif
