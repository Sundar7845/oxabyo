<div class="modal fade" id="unconnectUserModal" tabindex="-1" role="dialog">
	
	<form action="{{ route('users.un-connect', $player->id) }}" method="post">

		{{ csrf_field() }}

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Remove Connection</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to remove this user?
				<div class="text-center m_y20">
					<a data-dismiss="modal" class="btn btn-default">No, cancel</a>
	 

					<button type="submit" class="btn btn-danger">Yes, remove</button>

				</div>
			</div>
		</div>
	</div>

</form>

</div>
