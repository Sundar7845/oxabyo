@include('includes/head')
@include('layouts/header')

@include('events/modal/invite-players')
@include('events/modal/invite-champion')
@include('events/modal/invite-admin')
@include('events/modal/event-invite-team-modal')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@php	
$event_id = $event->id
@endphp

<form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    @method('put')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center"><b><i class="fas fa-trophy m_r10"></i>{{ strtoupper($event->name) }}</b></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 m_b10">
                <label>Event type</label>
                <select name="event_type_id" class="form-control event_type_id" id="event_type_id">
                    @foreach ($eventTypes as $eventType)
                        <option value="{{ $eventType->id }}"
                            @if ($event->event_type_id) {{ $eventType->id == $event->event_type_id ? 'selected' : '' }} @endif>
                            {{ $eventType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 m_b10">
                <label>Players type</label>
                <select name="player_type_id" class="form-control" id="player_type_id">
                    @foreach ($playerTypes as $playerType)
                        <option value="{{ $playerType->id }}"
                            @if ($event->player_type_id) {{ $playerType->id == $event->player_type_id ? 'selected' : '' }} @endif>
                            {{ $playerType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 m_b10">
                <label>Event start date</label>
                <input type="date" class="form-control" value="{{ getDateByTimZone($event->match_date,$event->match_hour,$event->time_zone) }}" name="match_date"
                    required>
            </div>
            <div class="col-sm-2 m_b10">
                <label>Event hour</label>
                <input type="time" class="form-control" name="match_hour" value="{{ getTimeByTimeZone($event->match_date,$event->match_hour,$event->time_zone) }}"
                    required>
            </div>
            <div class="col-sm-3 m_b10">
				<label>Time Zone</label>
				<select name="time_zone" class="form-control">
					@foreach (timezone_identifiers_list() as $timeZone)
						<option value="{{ $timeZone }}" 
                        
                        @if($event->time_zone == $timeZone) 
                        {{ 'selected' }}
                        {{-- @elseif(getTimeZoneByIpAddress() == $timeZone)  
                        {{ 'selected' }}  --}}
						@endif>{{ $timeZone }}
						</option>
					@endforeach
				</select>
			</div>

        </div>
        <div class="row">
            <div class="col-sm-12 m_b10">
                <label>Event name</label>
                <input type="text" class="form-control" name="name" value="{{ $event->name }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m_b10">
                <label>Event description</label>
                <textarea class="form-control" rows="6" name="description">{{ $event->description }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m_b10">
                <label>Event rules</label>
                <textarea class="form-control" rows="10" name="rules">{{ $event->rules }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 m_b10">
                <label>Game</label>
                <select name="game_id" class="form-control" required>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}"
                            @if ($event->game_id) {{ $game->id == $event->game_id ? 'selected' : '' }} @endif>
                            {{ $game->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 m_b10">
                <label>Prize Money (€)</label>
                <input type="number" class="form-control" name="prize_money" value="{{ $event->prize_money }}">
            </div>
        </div>
        <div class="row align">
            <div class="col-sm-2 col-xs-6 m_b10">
                <h4><b>Event Image</b></h4>
                <img src="{{ $event->image ?? 'https://via.placeholder.com/800x800' }}" id="event-image"
                    class="bordered">
            </div>
            <div class="col-sm-4 col-xs-12 m_b10">
                <input type="file" id="uploadImage1" class="hidden" name="file"
                    onchange="document.getElementById('event-image').src = window.URL.createObjectURL(this.files[0])">
                <label for="uploadImage1" class="btn btn-default m_b10">Choose Image</label>
            </div>
            <div class="col-sm-3 col-xs-6 m_b10">
                <h4><b>Event Cover</b></h4>
                <img src="{{ $event->cover ?? 'https://via.placeholder.com/1920x1080' }}" id="event-cover"
                    class="bordered">
            </div>
            <div class="col-sm-3 col-xs-12 m_b10">
                <input type="file" id="uploadImage2" class="hidden" name="cover"
                    onchange="document.getElementById('event-cover').src = window.URL.createObjectURL(this.files[0])">
                <label for="uploadImage2" class="btn btn-default m_b10">Choose Image</label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m_b10">
                <h4><b>MINIMUM REQUIREMENT</b></h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="m_b20"><img src="/img/x.svg" style="width:30px;"> OXARATE min <input
                                type="number" name="oxarate_min" value="{{ $event->oxarate_min }}"
                                class="form-control pull-right" min="1" max="100" style="width:70px">
						</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="m_b20"><img src="/img/o.svg" style="width:30px;"> Performance rating min
                            <input type="number" name="performance_rating_min"
                                value="{{ $event->performance_rating_min }}" class="form-control pull-right"
                                min="1" max="100" style="width:70px">
						</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="m_b20"><img src="/img/y.svg" style="width:30px;"> Ynfluence rating min
                            <input type="number" name="ynfluence_rating_min"
                                value="{{ $event->ynfluence_rating_min }}" class="form-control pull-right" min="1"
                                max="100" style="width:70px">
						</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="m_b20"><img src="/img/a.svg" style="width:30px;"> Monetization rating min
                            <input type="number" name="monetization_rating_min"
                                value="{{ $event->monetization_rating_min }}" class="form-control pull-right"
                                min="1" max="100" style="width:70px">
						</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 m_b10">
                <label>Ticket (€)</label>
                <input type="number" class="form-control" name="ticket" value="{{ $event->ticket }}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m_b10">
                <input type="checkbox" name="allow_players_streaming" @if ($event->allow_players_streaming) checked @endif>
                Allow players streaming
            </div>
        </div>
        {{-- <div class="row">
			<div class="col-sm-3 m_b10">
				<label>Maximum E-Players</label>
				<select name="max_num_players" class="form-control">				  
						<option value="">Select Players</option>
						@foreach ($phases as $phase)
							<option value="{{ $phase->value }}" @if ($event->max_num_players) {{ 
								$phase->value == $event->max_num_players ? 'selected' : '' }} 
						@endif>{{ $phase->value }}</option>
						@endforeach
				</select>
			</div>
		</div> --}}
    </div>

    <input type="hidden" class="currentEventId" value="{{ $event->id }}">
    <input type="hidden" class="InviteChampionModal" name="inviteChampions" value="">
    <input type="hidden" class="InviteEPlayerModal" name="inviteUsers" value="">
    <input type="hidden" class="InviteAdminModal" name="inviteEventAdmin" value="">
    <input type="hidden" class="InviteTeamPlayerModal" name="inviteTeamPlayers" value="">

    <div class="container">
        <div class="row m_y20">
            <div class="col-sm-12 m_b10 text-center">
                <button type="submit" class="btn btn-default btn-lg">SAVE</button>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <div
        @if ($event->event_type_id == 2) class="row player-champion-class" @else class="row player-champion-class" @endif>
        <div class="col-sm-12 m_b10">
            <div class="text-center">
                <a data-toggle="modal" data-target="#InviteChampionModal" class="btn btn-default">Invite Team/Player
                    Champion</a>
            </div>
        </div>
    </div>
</div>
<div
    @if ($event->event_type_id == 2) class="container-fluid p_t20 player-champion-class" @else class="container-fluid p_t20 player-champion-class hidden" @endif>
    @include('events/tables/player-table-manage', [
        'whereData' => 'is_champion',
        'value' => 1,
    ])
</div>
<div class="container">
    <div @if ($event->player_type_id == 2) class='row e-player-class  hidden' @else class='row e-player-class ' @endif>
        <div class="col-sm-12 m_b10">
            <div class="text-center">
                <a data-toggle="modal" data-target="#InviteEPlayerModal" class="btn btn-default">Invite Team/Players</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div @if ($event->player_type_id == 1) class='row e-player-team-class  hidden' @else class='row e-player-team-class ' @endif
        }}">
        <div class="col-sm-12 m_b10">
            <div class="text-center">
                <a data-toggle="modal" data-target="#InviteTeamPlayerModal" class="btn btn-default">Invite
                    Team/Players</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p_t20">
    @include('events/tables/player-table-manage', [
        'whereData' => 'is_admin',
        'value' => 0,
    ])
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

<div class="container-fluid p_t20">
    @include('events/tables/player-table-manage', [
        'whereData' => 'is_admin',
        'value' => 1,
    ])
</div>

@if ($currentEventPhase && $currentEventPhase->value)
    <h3 class="text-center"><b>CALENDAR MATCH PHASE {{ $currentEventPhase->match }}
            ({{ $currentEventPhase->value }}°)</b></h3>
    <form action="{{ route('fixtures.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="event_id" value="{{ $event->id }}" />
        <input type="hidden" name="event_phase_id" value="{{ $currentEventPhase->event_phase_id }}" />

        <div class="container">
            @for ($i = 0; $i < $currentEventPhase->value / 2; $i++)

                <input type="hidden" name="calender_match[{{ $i }}][edit_id]"
                    value="{{ isset($currentEventFixtureResult[$i]['id']) ? $currentEventFixtureResult[$i]['id'] : '' }}" />

                <div class="row">
                    <div class="col-sm-3 col-sm-23 m_b10">
                        <input type="date" class="form-control" name="calender_match[{{ $i }}][date]"
                            value="{{ isset($currentEventFixtureResult[$i]['date']) ? $currentEventFixtureResult[$i]['date'] : '' }}">
                    </div>
                    <div class="col-sm-3 col-sm-23 m_b10">
                        <input type="time" class="form-control" name="calender_match[{{ $i }}][time]"
                            value="{{ isset($currentEventFixtureResult[$i]['time']) ? $currentEventFixtureResult[$i]['time'] : '' }}">
                    </div>
                    <div class="col-sm-3 col-sm-23 m_b10">
                        <select class="form-control" name="calender_match[{{ $i }}][challenger1_id]">
                            <option value="" hidden>Challenger 1</option>
                            @foreach ($lastWinners as $player)
                                <option value="{{ $player->event_player_id }}"
                                    @if (isset($currentEventFixtureResult[$i]['challenger1_id']) && $currentEventFixtureResult[$i]['challenger1_id'] == $player->event_player_id) selected @endif>{{ $player->user_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 col-sm-23 m_b10">
                        <select class="form-control" name="calender_match[{{ $i }}][challenger2_id]">
                            <option value="" hidden>Challenger 2</option>
                            @foreach ($lastWinners as $player)
                                <option value="{{ $player->event_player_id }}"
                                    @if (isset($currentEventFixtureResult[$i]['challenger2_id']) && $currentEventFixtureResult[$i]['challenger2_id'] == $player->event_player_id) selected @endif>{{ $player->user_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 col-sm-23 m_b10">
                        <select class="form-control" name="calender_match[{{ $i }}][winner_id]">
                            <option value="" hidden>Winner</option>
                            <option value="no-winner" @if (isset($currentEventFixtureResult[$i]['fixture_results']['status']) && $currentEventFixtureResult[$i]['fixture_results']['status'] == 'no-winner') selected @endif>No winners
                            </option>
                            @if (isset($currentEventFixtureResult[$i]['id']) && $currentEventFixtureResult[$i]['id'])
                                <option value="{{ $currentEventFixtureResult[$i]['challenger1_id'] ?? '' }}"
                                    @if (isset($currentEventFixtureResult[$i]['fixture_results']['winner_id']) && $currentEventFixtureResult[$i]['fixture_results']['winner_id'] == $currentEventFixtureResult[$i]['challenger1_id']) selected @endif>
                                    {{ $currentEventFixtureResult[$i]['challenger1']->players->name ?? '' }}
                                </option>
                                <option value="{{ $currentEventFixtureResult[$i]['challenger2_id'] ?? '' }}"
                                    @if (isset($currentEventFixtureResult[$i]['fixture_results']['winner_id']) && $currentEventFixtureResult[$i]['fixture_results']['winner_id'] == $currentEventFixtureResult[$i]['challenger2_id']) selected @endif>
                                    {{ $currentEventFixtureResult[$i]['challenger2']->players->name ?? '' }}
                                </option>
                            @else
                                @foreach ($lastWinners as $player)
                                    <option value="{{ $player->event_player_id }}"
                                        @if (isset($currentEventFixtureResult[$i]['fixture_results']['winner_id']) && $currentEventFixtureResult[$i]['fixture_results']['winner_id'] == $player->event_player_id) selected @endif>{{ $player->user_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <hr class="visible-xs">
            @endfor
            <div class="row m_y20">
                <div class="col-sm-12 m_b10 text-center">
                    <button type="submit" class="btn btn-default btn-lg">SAVE</button>
                </div>
            </div>
        </div>
    </form>
@endif

<div class="row winner-list">
	@include('events/tables/winner-table-list')
</div> 

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
