<div class="modal fade" id="InviteGroupFriendsModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Invite Group/Players</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('groups.invite', $group->id) }}"  method="POST" enctype="multipart/form-data">

					@method('put')
                    {{ csrf_field() }}

					<div class="text-center m_t20 m_b10">
						<table class="table table-hover table-responsive table-condensed table-striped" aria-describedby="mydesc">
							
                            @foreach($users as $user)
                            
                            <tr>
								<td class="text-left"><label for="username1">{{ $user->name }}</label></td>
								<td class="text-right"><input id="username1" name="inviteUsers[]" value="{{ $user->id }}" type="checkbox"></td>
							</tr>

                            @endforeach

						</table>
						<!-- dismiss modal and send invites -->
						<button type="submit" class="btn btn-default">Invite</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>