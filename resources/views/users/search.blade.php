@include('includes/head')
@include('layouts/header')

<div class="container">
	<div class="row m_b20">
		<div class="col-sm-12" id="mainbody">
			<div class="text-center">
				<h3 class="m_t0"><b><i class="fas fa-search m_r10"></i>Risultati ricerca</b></h3>
			</div>
		</div>
	</div>

	@foreach($events as $event)
	<div class="row m_b20">		
		<div class="col-sm-1 col-xs-2">
			<img src="{{$event->image ??"https://via.placeholder.com/800x800"}}">
		</div>
		<div class="col-sm-11 col-xs-10 p_l0">
			<h4 class="m_t0_m"><b><a href="{{ route('events.show',  $event->id) }}">{{$event->name}}</a></b><br>
			<small>Event</small>
		</h4>
		</div>
	</div>
	@endforeach


	@foreach($teams as $team)
	<div class="row m_b20">		
		<div class="col-sm-1 col-xs-2">
			<img src="{{$team->team_image ??"https://via.placeholder.com/800x800"}}">
		</div>
		<div class="col-sm-11 col-xs-10 p_l0">
			<h4 class="m_t0_m"><b><a href="{{ route('teams.show', $team->id) }}">{{$team->name}}</a></b><br>
			<small>Team</small>
		</h4>
		</div>
	</div>
	@endforeach

	@foreach($users as $user)
	<div class="row m_b20">		
		<div class="col-sm-1 col-xs-2">
			<img src="{{$user->profile_image ?? 'https://via.placeholder.com/800x800' }}">
		</div>
		<div class="col-sm-11 col-xs-10 p_l0">
			<h4 class="m_t0_m"><b><a href="{{ route('users.player-detail', $user->id) }}">{{$user->name}}</a></b><br>
			<small>User</small>
		</h4>
		</div>
	</div>
	@endforeach




</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')


