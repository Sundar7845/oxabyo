<div class="modal fade" id="recoverModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Recover password</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/password/email') }}" method="post">

					{{ csrf_field() }}
					<div class="m_b20">
						<label>Registration e-mail</label>
						<input type="email" name="email" class="form-control">
					</div>
					<div class="m_b20 text-center">
						<button type="submit" class="btn btn-default">Recover password</button>
					</div>
				</form>
				<div id="recoverModalResponse">
					{{-- <div class="bg-success text-success p_10">
						Check your inbox, you'll find the instructions to set new password
					</div> --}}
					{{-- <div class="bg-danger text-danger p_10">
						Sorry, this e-mail address does not exists
					</div> --}}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog">
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
					<a href="###-###" class="btn btn-danger">Yes, remove</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="blockUserModal" tabindex="-1" role="dialog">
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
					<a href="###-###" class="btn btn-danger">Yes, block</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="unblockUserModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Unblock User</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to block this user? An unblocked user:
				<ul>
					<li>can ask to connect with you</li>
					<li>can write message to you</li>
					<li>can see your activity</li>
				</ul>
				<div class="text-center m_y20">
					<a data-dismiss="modal" class="btn btn-default">No, cancel</a>
					<a href="###-###" class="btn btn-danger">Yes, unblock</a>
				</div>
			</div>
		</div>
	</div>
</div>







<div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Search</h4>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ route('search') }}">
				{{ csrf_field() }}
					<div class="m_b10">
						<input type="text" name="name" class="form-control input-sm" placeholder="Search tournament, event, team, user...">
					</div>
					<div class="text-center m_b10">
					<button type="submit" class="btn btn-default"><em class="fas fa-search m_r5"></em>Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="searchTeamModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-search m_r5"></em>Search Team</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="m_b10">
						<input type="text" id="team_name" class="form-control input-sm" placeholder="Team Name">
					</div>
					<div class="m_b10">
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox" id="team_created_by_friends"> Created by friends
							</li>
							<li>
								<input type="checkbox" id="team_joined_by_friends"> Joined by friends
							</li>
						</ul>
					</div>
					<div class="m_b10">
						<select class="form-control" id="memberscount">
							<option hidden>Number of E-Players</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="8">9</option>
							<option value="8">10</option>
							<option value="8">11</option>
							<option>...</option>
						</select>
					</div>
					<div class="text-center m_t20 m_b10">
						<!-- dismiss modal and show results -->
						<button type="button" id="team_filtersearch" class="btn btn-default"><em class="fas fa-search m_r5"></em>Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="searchGroupModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-search m_r5"></em>Search Group</h4>
			</div>
			<div class="modal-body">
			 
					<div class="m_b10">
						<input type="text" id="group_name" class="form-control input-sm" placeholder="Group Name">
					</div>
					<div class="m_b10">
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox" id="group_created_by_friends" name="group_created_by_friends"> Created by friends
							</li>
							<li>
								<input type="checkbox"  id="group_joined_by_friends" name="group_joined_by_friends"> Joined by friends
							</li>
						</ul>
					</div>
					<div class="text-center m_t20 m_b10">
						<!-- dismiss modal and show results -->
						<button class="btn btn-default"  id="group_filtersearch"><em class="fas fa-search m_r5"></em>Search</button>
					</div>
				 
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="InviteUserModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Invite friends</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="text-center m_t20 m_b10">
						<table class="table table-hover table-responsive table-condensed table-striped" aria-describedby="mydesc">
							<tr>
								<td class="text-left"><label for="username1">Username 1 lorem ipsum</label></td>
								<td class="text-right"><input id="username1" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username2">Username 2 lorem ipsum</label></td>
								<td class="text-right"><input id="username2" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username3">Username 3 lorem ipsum</label></td>
								<td class="text-right"><input id="username3" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username4">Username 4 lorem ipsum</label></td>
								<td class="text-right"><input id="username4" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username5">Username 5 lorem ipsum</label></td>
								<td class="text-right"><input id="username5" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username6">Username 6 lorem ipsum</label></td>
								<td class="text-right"><input id="username6" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username7">Username 7 lorem ipsum</label></td>
								<td class="text-right"><input id="username7" type="checkbox"></td>
							</tr>
						</table>
						<!-- dismiss modal and send invites -->
						<button type="submit" class="btn btn-default">Invite</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>





<div class="modal fade" id="UserVoteModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Vote</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="m_b40">
						<img src="/img/o.svg" class="m_r10" style="width:40px;" alt=""><b>PERF<span class="red">O</span>RMANCE</b>
						<div class="m_t10">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#perf_1" role="tab" data-toggle="tab">Tag 1</a></li>
								<li role="presentation"><a href="#perf_2" role="tab" data-toggle="tab">Tag 2</a></li>
								<li role="presentation"><a href="#perf_3" role="tab" data-toggle="tab">Tag 3</a></li>
								<li role="presentation"><a href="#perf_4" role="tab" data-toggle="tab">Tag 4</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="perf_1">
									<div data-toggle="buttons" class="m_y20">
										<label class="btn btn-primary">
											<input type="radio" name="optionsPerf_1" id="option1" autocomplete="off">
											<em class="fas fa-tired" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>TERRIBLE</strong></h4>
										</label>
										<label class="btn btn-primary">
											<input type="radio" name="optionsPerf_1" id="option2" autocomplete="off">
											<em class="fas fa-frown-open" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>BAD</strong></h4>
										</label>
										<label class="btn btn-primary">
											<input type="radio" name="optionsPerf_1" id="option3" autocomplete="off">
											<em class="fas fa-meh" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>INDIFFERENT</strong></h4>
										</label>
										<label class="btn btn-primary">
											<input type="radio" name="optionsPerf_1" id="option4" autocomplete="off">
											<em class="fas fa-grin" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>GOOD</strong></h4>
										</label>
										<label class="btn btn-primary">
											<input type="radio" name="optionsPerf_1" id="option5" autocomplete="off">
											<em class="fas fa-grin-stars" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>EXCELLENT</strong></h4>
										</label>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="perf_2">...</div>
								<div role="tabpanel" class="tab-pane" id="perf_3">...</div>
								<div role="tabpanel" class="tab-pane" id="perf_4">...</div>
							</div>

						</div>
					</div>

					<div class="m_b40">
						<img src="/img/y.svg" class="m_r10" style="width:40px;" alt=""><b><span class="ywlloe">Y</span>NFLUENCE</b>
						<div class="m_t10">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#infl_1" role="tab" data-toggle="tab">Tag 1</a></li>
								<li role="presentation"><a href="#infl_2" role="tab" data-toggle="tab">Tag 2</a></li>
								<li role="presentation"><a href="#infl_3" role="tab" data-toggle="tab">Tag 3</a></li>
								<li role="presentation"><a href="#infl_4" role="tab" data-toggle="tab">Tag 4</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="infl_1">
									<div data-toggle="buttons" class="m_y20">
										<label class="btn btn-primary yellow_bg">
											<input type="radio" name="optionsInfl_1" id="option1" autocomplete="off">
											<em class="fas fa-tired" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>TERRIBLE</strong></h4>
										</label>
										<label class="btn btn-primary yellow_bg">
											<input type="radio" name="optionsInfl_1" id="option2" autocomplete="off">
											<em class="fas fa-frown-open" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>BAD</strong></h4>
										</label>
										<label class="btn btn-primary yellow_bg">
											<input type="radio" name="optionsInfl_1" id="option3" autocomplete="off">
											<em class="fas fa-meh" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>INDIFFERENT</strong></h4>
										</label>
										<label class="btn btn-primary yellow_bg">
											<input type="radio" name="optionsInfl_1" id="option4" autocomplete="off">
											<em class="fas fa-grin" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>GOOD</strong></h4>
										</label>
										<label class="btn btn-primary yellow_bg">
											<input type="radio" name="optionsInfl_1" id="option5" autocomplete="off">
											<em class="fas fa-grin-stars" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>EXCELLENT</strong></h4>
										</label>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="infl_2">...</div>
								<div role="tabpanel" class="tab-pane" id="infl_3">...</div>
								<div role="tabpanel" class="tab-pane" id="infl_4">...</div>
							</div>

						</div>
					</div>

					<div class="m_b40">
						<img src="/img/a.svg" class="m_r10" style="width:40px;" alt=""><strong>MONETIZ<span class="green">A</span>TION</strong>
						<div class="m_t10">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#monet_1" role="tab" data-toggle="tab">Tag 1</a></li>
								<li role="presentation"><a href="#monet_2" role="tab" data-toggle="tab">Tag 2</a></li>
								<li role="presentation"><a href="#monet_3" role="tab" data-toggle="tab">Tag 3</a></li>
								<li role="presentation"><a href="#monet_4" role="tab" data-toggle="tab">Tag 4</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="monet_1">


									<div data-toggle="buttons" class="m_y20">
										<label class="btn btn-primary green_bg">
											<input type="radio" name="optionsMonet_1" id="option1" autocomplete="off">
											<em class="fas fa-tired" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>TERRIBLE</strong></h4>
										</label>
										<label class="btn btn-primary green_bg">
											<input type="radio" name="optionsMonet_1" id="option2" autocomplete="off">
											<em class="fas fa-frown-open" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>BAD</strong></h4>
										</label>
										<label class="btn btn-primary green_bg">
											<input type="radio" name="optionsMonet_1" id="option3" autocomplete="off">
											<em class="fas fa-meh" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>INDIFFERENT</strong></h4>
										</label>
										<label class="btn btn-primary green_bg">
											<input type="radio" name="optionsMonet_1" id="option4" autocomplete="off">
											<em class="fas fa-grin" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>GOOD</strong></h4>
										</label>
										<label class="btn btn-primary green_bg">
											<input type="radio" name="optionsMonet_1" id="option5" autocomplete="off">
											<em class="fas fa-grin-stars" style="font-size:40px;"></em>
											<h4 class="m_b0"><strong>EXCELLENT</strong></h4>
										</label>
									</div>

								</div>
								<div role="tabpanel" class="tab-pane" id="monet_2">...</div>
								<div role="tabpanel" class="tab-pane" id="monet_3">...</div>
								<div role="tabpanel" class="tab-pane" id="monet_4">...</div>
							</div>

						</div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-default">VOTE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="InvitePlayerModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Invite Team/Players</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="text-center m_t20 m_b10">
						<table class="table table-hover table-responsive table-condensed table-striped" aria-describedby="mydesc">
							<tr>
								<td class="text-left"><label for="username1">Username 1 lorem ipsum</label></td>
								<td class="text-right"><input id="username1" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username2">Username 2 lorem ipsum</label></td>
								<td class="text-right"><input id="username2" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username3">Username 3 lorem ipsum</label></td>
								<td class="text-right"><input id="username3" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username4">Username 4 lorem ipsum</label></td>
								<td class="text-right"><input id="username4" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username5">Username 5 lorem ipsum</label></td>
								<td class="text-right"><input id="username5" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username6">Username 6 lorem ipsum</label></td>
								<td class="text-right"><input id="username6" type="checkbox"></td>
							</tr>
							<tr>
								<td class="text-left"><label for="username7">Username 7 lorem ipsum</label></td>
								<td class="text-right"><input id="username7" type="checkbox"></td>
							</tr>
						</table>
						<!-- dismiss modal and send invites -->
						<button type="submit" class="btn btn-default">Invite</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

