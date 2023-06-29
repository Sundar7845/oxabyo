<div class="modal fade" id="block-UserModal" tabindex="-1" role="dialog">

    <form action="{{ route('users.block', $player->id) }}" method="post">

		{{ csrf_field() }}

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Block User</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to block this user? A blocked user:
				<ul>
					<li>can not ask to connect with you</li>
					<li>can not write message to you</li>
					<li>can not see your activity</li>
				</ul>
				<div class="text-center m_y20">
					<a data-dismiss="modal" class="btn btn-default">No, cancel</a>
			

                    <button type="submit" class="btn btn-danger">Yes, block</button>

				</div>
			</div>
		</div>
	</div>

    
</form>

</div>