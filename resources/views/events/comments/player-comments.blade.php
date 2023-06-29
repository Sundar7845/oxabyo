<div class="pull-right">{{ $live_comment->created_at }}</div>
<div><b>{{ $live_comment->user->name }}</b></div>
<div>{{ $live_comment->comments->comment }}</div>
<input type="hidden" class="lastPlayerCommentId" value="{{ $live_comment->id }}" />
<hr class="m_y5">
