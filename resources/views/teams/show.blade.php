@include('includes/head')
@include('layouts/header')

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif
@if (session('subscription-alert-model'))
    <div class="modal" tabindex="-1" role="dialog" id="success_alert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <div class="submission-notes">
                        <span class="note-text">{{ session('subscription-alert-model') }} </span>
                        <form class="js-passnote-form">

                            <div class="text-right">

                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="shadow_v p_y20" style="background-color: {{ $team->team_color ?? "#990099" }} ">
	<div class="container">
		<div class="row align">
			<div class="col-sm-2 m_y10 text-center">
				<img src="{{ $team->team_image ?? 'https://via.placeholder.com/800x800' }}" class="avatar" style="height: 162px;">
			</div>
			<div class="col-sm-10">
				<h4><b>{{ $team->name }}</b></h4>
				<p>
					<b>Date:</b> {{  date_format($team->created_at,"d/m/Y") }} <br>
					<b>Players:</b> {{ $members->count() }}<br>
					<b>Games:</b> 
					{{-- {{ $games->count() }}<br> --}}
					@php
					$my_string = '';
						foreach($games as $game)
						{
							$my_string = $my_string .  $game->games->name .',';
						 
						}
					@endphp

					{{ rtrim($my_string, ',') }}

					
				</p>
				<p>{{ $team->description }}</p>
				<ul class="list-inline">
					@if ($isContactAdminVisible)
						<li><a href="{{ route('users.player-detail', $team->admin_user_id) }}" class="btn btn-default btn-sm">Contact the admin</a></li>
					@endif
					@if ($isJoinButtonVisible)
						<li><a href="{{ route('teams.join', $team->id) }}" class="btn btn-default btn-sm">Join Team</a></li>
					@endif
					@if ($isEditButtonVisible)
						<li class="m_t10_m"><a href="{{ route('teams.edit', $team->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit m_r5"></i>Edit Team</a></li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>

<div style="height:20px;" class="red_bg m_b20"></div>

<div class="container-fluid">

	@include('includes/player_table')
 
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')