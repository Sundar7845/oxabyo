@include('includes/head')
@include('layouts/header')

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
			<div class="col-sm-4 m_b10">
				<label>Event date</label>
				<input type="date" class="form-control" name="match_date" value="{{ getDateByTimZone($event->match_date,$event->match_hour,$event->time_zone) }}">
			</div>
			<div class="col-sm-4 m_b10">
				<label>Event hour</label>
				<input type="time" class="form-control" name="match_hour" value="{{ getTimeByTimeZone($event->match_date,$event->match_hour,$event->time_zone) }}">
			</div>
			<div class="col-sm-4 m_b10">
				<label>Time Zone</label>
				<select name="time_zone" class="form-control">
					@foreach (timezone_identifiers_list() as $timeZone)
						<option value="{{ $timeZone }}" 
						@if ($event->time_zone == $timeZone) 
                        {{ 'selected' }}
                        {{-- @elseif (getTimeZoneByIpAddress() == $timeZone)  
                        {{ 'selected' }}  --}}
						@endif >{{ $timeZone }}
						</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event name</label>
				<input type="text" class="form-control" name="name" value="{{ ($event->name) }}">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event description</label>
				<textarea class="form-control" rows="6" name="description">{{ ($event->description) }}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 m_b10">
				<label>Event rules</label>
				<textarea class="form-control" rows="10" name="rules">{{ ($event->rules) }}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 m_b10">
				<label>Game</label>
				<select name="game_id" class="form-control">
					@foreach ($games as $game)
						<option value="{{ $game->id }}" @if ($event->game_id) {{ 
							$game->id == $event->game_id ? 'selected' : '' }} 
					@endif>{{ $game->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<h4><b>Event Image</b></h4>
				<img src="{{ $event->image ?? 'https://via.placeholder.com/800x800' }}" id="event-image" class="bordered">
			</div>
			<div class="col-sm-4 col-xs-12 m_b10">
				<input type="file" id="uploadImage1" class="hidden" name="file"
				onchange="document.getElementById('event-image').src = window.URL.createObjectURL(this.files[0])">

				<label for="uploadImage1" class="btn btn-default m_b10">Choose Image</label>
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Update Image</label>
				<a class="btn btn-default m_b10">Delete Image</a> -->
			</div>
			<div class="col-sm-3 col-xs-6 m_b10">
				<h4><b>Event Cover</b></h4>
				<img src="{{ $event->cover ?? 'https://via.placeholder.com/1920x1080' }}" id="event-cover" class="bordered">
			</div>
			<div class="col-sm-3 col-xs-12 m_b10">
				<input type="file" id="uploadImage2" class="hidden" name="cover" 
				onchange="document.getElementById('event-cover').src = window.URL.createObjectURL(this.files[0])"
				>
				<label for="uploadImage2" class="btn btn-default m_b10">Choose Image</label>
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Update Image</label>
				<a class="btn btn-default m_b10">Delete Image</a> -->
			</div>
		</div>

		<div class="row m_y20">
			<div class="col-sm-12 m_b10 text-center">
				<input type="hidden" class="form-control" name="event_type" value="Single Player">

				<button type="submit" class="btn btn-default btn-lg">SAVE</button>
			</div>
		</div>
	</div>
</form>
<div class="container-fluid p_t20">
	@include('events/tables/player-table-manage',  ['whereData' => 'is_admin',  'value' => 0])
</div>
@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
