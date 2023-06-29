@include('includes/head')
@include('layouts/header')
{{-- @include('teams/invite-player-modal') --}}

<form name="createteam" action="{{ route('teams.store') }}"  method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><em class="fas fa-user-friends m_r10"></em>YOUR TEAM</b></h3>
				<h4><b>TEAM IMAGE</b></h4>
			</div>
		</div>
		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<img src="{{ url('/img/avatar.jpg') }}" class="avatar" id="team-image" alt="avatar">
			</div>
			<div class="col-sm-10 col-xs-12 m_b10">
				<input type="file" id="uploadImage" name="file" class="hidden" onchange="document.getElementById('team-image').src = window.URL.createObjectURL(this.files[0])">
				<label for="uploadImage" class="btn btn-default m_b10">Choose your Team Image</label>
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Upload your Team Image</label>
				<a class="btn btn-default m_b10">Delete Team Image/a> -->
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h4 class="m_b0"><b>TEAM COLOR</b></h4>
				<p>Choose your Cover color</p>
				<ul class="list-inline color_choose">
					<li><span class="red_bg team_color"><div data-color_code="#DC0024"></div><em class="fas fa-check"></em></span></li>
					<li><span class="l_blue_bg team_color"><div data-color_code="#00CCFF"></div><em class="fas"></em></span></li>
					<li><span class="yellow_bg team_color"><div data-color_code="#FFCC00"></div><em class="fas"></em></span></li>
					<li><span class="pink_bg team_color"><div data-color_code="#FF339A"></div><em class="fas"></em></span></li>
					<li><span class="green_bg team_color"><div data-color_code="#34CC67"></div><em class="fas"></em></span></li>
					<li><span class="orange_bg team_color"><div data-color_code="#FF6634"></div><em class="fas"></em></span></li>
					<li><span class="blue_bg team_color"><div data-color_code="#0000FE"></div><em class="fas"></em></span></li>
					<li><span class="purple_bg team_color"><div data-color_code="#990099"></div><em class="fas"></em></span></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="gray_bg">
		<div class="container p_y20">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="m_b0"><strong>INFO</strong></h4>
					<p>Insert your Team info</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="m_b10">
						<label>Name*</label>
						<input type="text" name="name" class="form-control" placeholder="Team Name" required>
					</div>
					<div class="m_b10">
						<label>Description</label>
						<textarea class="form-control" name="description" rows="10" placeholder="Team Description"></textarea>
					</div>
					<div class="m_b10">
						<label>Games</label>
						<select class="form-control" id="teamGames" name="game_ids[]" multiple="multiple" required>
					

							@foreach ($games as $game)
								<option value="{{ $game->id }}">{{ $game->name }}</option>
							@endforeach
					
						</select>
					</div>

					<div class="m_b10">
						<label>Players</label>
						<select class="form-control" id="teamUsers" name="teamUsers[]" multiple="multiple" required>
					

							@foreach ($users as $user)
								<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
					
						</select>
					</div>

					<input type="hidden" name="team_color" id="teamcolour" value="#DC0024"/>
				</div>
			</div>
{{-- 
			<div class="text-center m_y40">
				<a data-toggle="modal" data-target="#InviteUserPlayerModal" class="btn btn-default">Invite Friends</a>
			</div> --}}

		</div>
	</div>

	<div class="container-fluid p_t20">

		{{-- @include('includes/player_table2') --}}
 
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 m_y40 text-center">
				<button type="submit" class="btn btn-default btn-lg">Save</button>
			</div>
		</div>
	</div>

</form>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')