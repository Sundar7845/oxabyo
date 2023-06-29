<div class="modal fade" id="deleteChatModal" class="deleteChatModal" tabindex="-1" role="dialog">

	<form action="{{ route('message-list.delete') }}" method="post">

		{{ csrf_field() }}


	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Delete Chat</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to delete this chat? All messages will be lost
				<div class="text-center m_y20">
					<a data-dismiss="modal" class="btn btn-default">No, cancel</a>

					<input type="hidden" id="deleteId" name="deleteId" value={{ isset($player->id) ? $player->id : '' }}/>

					<button type="submit" class="btn btn-danger">Yes, delete</button>


				</div>
			</div>
		</div>
	</div>

	</form>

</div>