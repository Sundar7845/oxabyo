@include('includes/head')
@include('layouts/header')
@include('events/modal/invite-players')

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><i class="fas fa-trophy m_r10"></i>YOUR EVENT</b></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 m_b10">
				<label>Event date</label>
				<input type="date" class="form-control" name="match_date">
			</div>
			<div class="col-sm-4 m_b10">
				<label>Event hour</label>
				<input type="time" class="form-control" name="match_hour">
			</div>
			<div class="col-sm-4 m_b10">
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
				<input type="text" class="form-control" name="name">
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
				<select name="game_id" class="form-control">
					@foreach ($games as $game)
						<option value="{{ $game->id }}">{{ $game->name }}</option>
					@endforeach
				</select>
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
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Update Image</label>
				<a class="btn btn-default m_b10">Delete Image</a> -->
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
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Update Image</label>
				<a class="btn btn-default m_b10">Delete Image</a> -->
			</div>
		</div>

		 
	<input type="hidden" class="InviteEPlayerModal" name="inviteUsers" value=""> 


		<div class="row e-player-class">
			<div class="col-sm-12 m_b10">
				<div class="text-center">
					<a data-toggle="modal" data-target="#InviteEPlayerModal" class="btn btn-default">Invite Team/Players</a>
				</div>
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

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
