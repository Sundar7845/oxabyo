@include('includes/head')
@include('layouts/header')

@include('events/modal/invite-players')
@include('events/modal/invite-champion')
@include('events/modal/invite-admin')
@include('events/modal/event-invite-team-modal')

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><i class="fas fa-trophy m_r10"></i>YOUR EVENT</b></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 m_b10">
				<label>Event type</label>
				<select name="event_type_id" class="form-control event_type_id" id="event_type_id">
					@foreach ($eventTypes as $eventType)
						<option value="{{ $eventType->id }}">{{ $eventType->name }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-2 m_b10">
				<label>Players type</label>
				<select name="player_type_id" class="form-control" id="player_type_id">
					@foreach ($playerTypes as $playerType)
						<option value="{{ $playerType->id }}">{{ $playerType->name }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-2 m_b10">
				<label>Event start date</label>
				<input type="date" class="form-control" name="match_date" required>
			</div>
			<div class="col-sm-2 m_b10">
				<label>Event hour</label>
				<input type="time" class="form-control" name="match_hour" required>
			</div>
			<div class="col-sm-3 m_b10">
				<label>Time Zone</label>
				<select name="time_zone" class="form-control">
					@foreach (timezone_identifiers_list() as $timeZone)
						<option value="{{ $timeZone }}" 
						@if(getTimeZoneByIpAddress() == $timeZone) {{
							'selected' }}
						@endif>{{ $timeZone }}
						</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event name</label>
				<input type="text" class="form-control" name="name" required>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event description</label>
				<textarea class="form-control" rows="6" name="description"></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event rules</label>
				<textarea class="form-control" rows="10" name="rules"></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 m_b10">
				<label>Game</label>
				<select name="game_id" class="form-control" required>
					@foreach ($games as $game)
						<option value="{{ $game->id }}">{{ $game->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-6 m_b10">
				<label>Prize Money (€)</label>
				<input type="number" class="form-control" name="prize_money">
			</div>
		</div>

		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<h4><b>Event Image</b></h4>
				<img src="https://via.placeholder.com/800x800" id="event-image" class="bordered">
			</div>
			<div class="col-sm-4 col-xs-12 m_b10">
				<input type="file" id="uploadImage1" class="hidden" name="file"
				onchange="document.getElementById('event-image').src = window.URL.createObjectURL(this.files[0])">
				<label for="uploadImage1" class="btn btn-default m_b10">Choose Image</label>
			 
			</div>
			<div class="col-sm-3 col-xs-6 m_b10">
				<h4><b>Event Cover</b></h4>
				<img src="https://via.placeholder.com/1920x1080" id="event-cover" class="bordered">
			</div>
			<div class="col-sm-3 col-xs-12 m_b10">
				<input type="file" id="uploadImage2" class="hidden" name="cover" 
				onchange="document.getElementById('event-cover').src = window.URL.createObjectURL(this.files[0])"
				>
				<label for="uploadImage2" class="btn btn-default m_b10">Choose Image</label>				 
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<h4><b>MINIMUM REQUIREMENT</b></h4>
				<div class="row">
					<div class="col-sm-6">
						<div class="m_b20"><img src="/img/x.svg" style="width:30px;"> OXARATE min <input type="number" name="oxarate_min" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="m_b20"><img src="/img/o.svg" style="width:30px;"> Performance rating min <input type="number" name="performance_rating_min" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="m_b20"><img src="/img/y.svg" style="width:30px;"> Ynfluence rating min <input type="number" name="ynfluence_rating_min" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="m_b20"><img src="/img/a.svg" style="width:30px;"> Monetization rating min <input type="number" name="monetization_rating_min" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 m_b10">
				<label>Ticket (€)</label>
				<input type="number" class="form-control" name="ticket">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 m_b10">
				<input type="checkbox" name="allow_players_streaming"> Allow players streaming
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 m_b10">
				<label>Maximum E-Players</label>
				<select name="max_num_players" class="form-control" required>				  
						<option value="">Select Players</option>
						@foreach($phases as $phase)
							<option value="{{ $phase->value }}">{{ $phase->value }}</option>
						@endforeach
				</select>
			</div>
		</div>

	</div>

	<input type="hidden" class="currentEventId" value="">
	<input type="hidden" class="InviteChampionModal" name="inviteChampions" value="">
	<input type="hidden" class="InviteEPlayerModal" name="inviteUsers" value="">
	<input type="hidden" class="InviteAdminModal" name="inviteEventAdmin" value="">
	<input type="hidden" class="InviteTeamPlayerModal" name="inviteTeamPlayers" value="">	

	<div class="container" >
		<div class="row player-champion-class hidden">
			<div class="col-sm-12 m_b10">
				<div class="text-center">
					<a data-toggle="modal" data-target="#InviteChampionModal" class="btn btn-default">Invite Team/Player Champion</a>
				</div>
			</div>
		</div>
	</div>

	{{-- <div class="container-fluid p_t20">
		@include('includes/player_table4')
	</div> --}}

	<div class="container">
		<div class="row e-player-class">
			<div class="col-sm-12 m_b10">
				<div class="text-center">
					<a data-toggle="modal" data-target="#InviteEPlayerModal" class="btn btn-default">Invite Team/Players</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row e-player-team-class hidden">
			<div class="col-sm-12 m_b10">
				<div class="text-center">
					<a data-toggle="modal" data-target="#InviteTeamPlayerModal" class="btn btn-default">Invite Team/Players</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 m_b10">
				<div class="text-center">
					<a data-toggle="modal" data-target="#InviteAdminModal" class="btn btn-default">Invite Event Admin</a>
				</div>
			</div>
		</div>
	</div>

	{{-- <div class="container-fluid p_t20">
		@include('includes/player_table4')
	</div> --}}

	<div class="container">
		<div class="row m_y20">
			<div class="col-sm-12 m_b10 text-center">
				<button type="submit" class="btn btn-default btn-lg">SAVE</button>
			</div>
		</div>
	</div>
</form>

{{-- <h3 class="text-center"><b>CALENDAR MATCH PHASE 1 (32°)</b></h3>

<form>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>
		<hr class="visible-xs">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>
		<hr class="visible-xs">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>

		<div class="row m_y20">
			<div class="col-sm-12 m_b10 text-center">
				<button type="submit" class="btn btn-default btn-lg">SAVE</button>
			</div>
		</div>

	</div>
</form>


<pre>dopo il salvataggio</pre>


<h3 class="text-center"><b>CALENDAR MATCH PHASE 2 (16°)</b></h3>

<form>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>
		<hr class="visible-xs">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>
		<hr class="visible-xs">
		<div class="row">
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="date" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<input type="time" class="form-control">
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 1</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Challenger 2</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
			<div class="col-sm-3 col-sm-23 m_b10">
				<select class="form-control">
					<option hidden>Winner</option>
					<option>Username/Team Name 1</option>
					<option>Username/Team Name 2</option>
				</select>
			</div>
		</div>

		<div class="row m_y20">
			<div class="col-sm-12 m_b10 text-center">
				<button type="submit" class="btn btn-default btn-lg">SAVE</button>
			</div>
		</div>

	</div>
</form>

<h3 class="text-center"><b>CALENDAR MATCH PHASE 2 (16°)</b></h3>

<div class="container">
	<div class="row text-center hidden-xs m_b10">
		<div class="col-sm-3 m_b10">DATE</div>
		<div class="col-sm-3 m_b10">CHALLENGER 1</div>
		<div class="col-sm-3 m_b10">CHALLENGER 2</div>
		<div class="col-sm-3 m_b10">WINNER</div>
	</div>
	<div class="row text-center">
		<div class="col-sm-3 col-xs-12 m_b10">01/01/2022</div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;"><s>Team/Player</s></div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player</div>
		<div class="col-sm-3 hidden-xs m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player <a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
		<div class="col-sm-3 col-xs-12 visible-xs m_b10"><a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
	</div>
	<hr class="m_t10 m_b20">
	<div class="row text-center">
		<div class="col-sm-3 col-xs-12 m_b10">01/01/2022</div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;"><s>Team/Player</s></div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player</div>
		<div class="col-sm-3 hidden-xs m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player <a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
		<div class="col-sm-3 col-xs-12 visible-xs m_b10"><a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
	</div>
	<hr class="m_t10 m_b20">
	<div class="row text-center">
		<div class="col-sm-3 col-xs-12 m_b10">01/01/2022</div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;"><s>Team/Player</s></div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player</div>
		<div class="col-sm-3 hidden-xs m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player <a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
		<div class="col-sm-3 col-xs-12 visible-xs m_b10"><a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
	</div>
	<hr class="m_t10 m_b20">
	<div class="row text-center">
		<div class="col-sm-3 col-xs-12 m_b10">01/01/2022</div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;"><s>Team/Player</s></div>
		<div class="col-sm-3 col-xs-6 m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player</div>
		<div class="col-sm-3 hidden-xs m_b10"><img src="/img/avatar.jpg" class="avatar m_r10" style="width:30px;">Team/Player <a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
		<div class="col-sm-3 col-xs-12 visible-xs m_b10"><a href="" class="btn btn-icon" data-toggle="tooltip" data-original-title="SWITCH WINNER"><i class="fas fa-toggle-on"></i></a></div>
	</div>
	<hr class="m_t10 m_b20">
</div> --}}



@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
