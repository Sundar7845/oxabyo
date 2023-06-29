@include('includes/head')
@include('includes/g_header')

<div style="background-image:url({{ $event->cover ?? "https://via.placeholder.com/800x1024" }});background-size:cover;background-repeat:no-repeat;background-position:center">

	<div id="event_top_detail">
		<div class="container">
			<div class="row vpc" data-vp-add-class="row animated fadeIn slower">
				<div class="col-sm-2 m_b20"> 
					<div class="vpc" data-vp-add-class="animated fadeInLeft slow">
					<a href="{{ route('events.event-detail', $event->id) }}">
					<img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered">
					</a>
					</div>
				</div>
				<div class="col-sm-10 m_b20">
					<h2><b>{{ $event->name }}</b></h2>
					<div class="row">
						<div class="col-sm-6">
							<b>Game :</b>{{ $event->games->name ?? '' }} <br><br>
							<b>Type :</b>{{ $event->event_types->name ?? '' }} <br>
						</div>
						<div class="col-sm-6 text-right">
							<b>Date :</b>{{ $event->match_date ?? '' }}<br><br>
							<b>Ticket :</b>{{ $event->ticket ?? '' }}  <br><br>
							<h3 class="m_t0"><b>Prize Money :</b>{{ $event->prize_money . " €" }}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="red_bg">
	<div class="container">
		<div class="vpc" data-vp-add-class="animated fadeInLeft slow">
		<div class="row">
			<div class="col-sm-12 p_y5">
				<h3 class="m_y5"><b>N.MATCHES: <span class="black">{{ $event->number_of_rounds }}</span></b></h3>
				<h3 class="m_y5"><b>PLAYERS: <span class="black">{{ $event->max_num_players }}</span></b></h3>
			</div>
		</div>
	</div>
	</div>
</div>

<div class="container">
	
	<div class="row">
		<div class="vpc" data-vp-add-class="animated fadeInRight slow">
		<div class="col-sm-12 p_y5">
			
			<h3><b>RULES</b></h3>
			<div id="rules_text">
				<p>{{ $event->rules }}</p>
			</div>
			<div class="text-center m_t40"><a href="/login" class="btn btn-default btn-lg">SIGN UP</a></div>
		</div>
	</div>
  </div>
</div>

<div class="container-fluid">
	<div class="vpc" data-vp-add-class="animated fadeIn slower">
		<div class="row text-center m_t40 m_b10">
			<div class="col-sm-12">
				<h3><b><i class="fas fa-clipboard-list m_r10"></i>PLAYERS</b></h3>
			</div>
		</div>
 

		@include('events/tables/guest-players')
		
	</div>
</div>

 @include('includes/footer')
 @include('includes/modal') 
 @include('includes/foot') 
