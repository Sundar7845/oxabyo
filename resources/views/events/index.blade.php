@include('includes/head')
@include('layouts/header')
@include('events/modal/event-create-modal')
@include('events/modal/search-event-modal')
 
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

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-trophy m_r10"></i>EVENTS</b></h3>
		</div>
	</div>
</div>

<div id="eventCar" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">

		@foreach ($sliders as $key => $slider)
		<li data-target="#eventCar" data-slide-to="{{ $key }}"		
			@if ($slider->events->id == $sliders[0]->events->id)
                class="active"
            @endif>	
	</li>
		@endforeach
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
        @foreach ($sliders as $slider)
        <div
            @if ($slider->events->id == $sliders[0]->events->id)
                class="item active"
            @else
                class="item"
            @endif 
			>
			<div style="background-image:url({{ $slider->events->cover }});background-size:cover;background-repeat:no-repeat;background-position:center">
				<div id="event_top_detail">
					<div class="container">
						<div class="row animated fadeIn slower">
							<div class="col-sm-2 m_b20">
								<a href="{{ route('events.show',  $slider->events->id) }}"><img src="{{ $slider->events->image ?? "https://via.placeholder.com/800x800" }}" class="bordered" style="height: 155px;"></a>
							</div>
							<div class="col-sm-10 m_b20">
								<h2><a href="{{ route('events.show',  $slider->events->id) }}"><b>{{ $slider->events->name }}</b></a></h2>
								<div class="row">
									<div class="col-sm-6">
										<b>Game:</b> {{ $slider->events->games->name ?? ''}} <br>
										<b>Type:</b> {{ $slider->events->event_types->name ?? '' }} <br>
									</div>
									<div class="col-sm-6 text-right">
										<b>Date:</b> {{ $slider->events->match_date }} <br>
										<b>Ticket:</b> {{ $slider->events->ticket . " €" }} 
										<h3 class="m_t0"><b>Prize Money:</b> {{ $slider->events->prize_money . " €" }}</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        @endforeach
	</div>
</div>


<div class="row m_x0 vpc" data-vp-add-class="animated fadeIn slower">
	<div class="col-sm-4 p_x0">
		<div class="p_x40 p_y20 red_bg shadow_r" style="height: 450px">
			<h3 class="text-center"><b>+ PLAYERS</b></h3>
            @foreach ($currentEvents as $event)
                <div class="m_t10">
                    <div class="row align">
                        <div class="col-sm-3 col-xs-5 m_b10">
                            <a href="{{ route('events.show',  $event->id) }}">
                                <img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered">
                            </a>
                        </div>
                        <div class="col-sm-9 col-xs-7 m_b10 p_l0">
                            <a href="{{ route('events.show',  $event->id) }}" class="white" style="text-decoration:underline"><b>{{ $event->name }}</b></a><br>
                            <b>Game:</b> <span class="black">{{ $event->games->name }}</span><br>
                            <b>Players:</b> <span class="black">{{ $event->max_num_players ?? 0 }}</span><br>
                        </div>
                    </div>
                </div>
            @endforeach
		</div>
	</div>
	<div class="col-sm-4 p_x0">
		<div class="p_x40 p_y20 orange_bg shadow_r" style="height: 450px">
			<h3 class="text-center"><b>LAST EVENTS</b></h3>
            @foreach ($currentEvents as $event)
                <div class="m_t10">
                    <div class="row align">
                        <div class="col-sm-3 col-xs-5 m_b10">
                            <a href="{{ route('events.show',  $event->id) }}">
                                <img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered">
                            </a>
                        </div>
                        <div class="col-sm-9 col-xs-7 m_b10 p_l0">
                            <a href="{{ route('events.show',  $event->id) }}" class="white" style="text-decoration:underline"><b>{{ $event->name }}</b></a><br>
                            <b>Game:</b> <span class="black">{{ $event->games->name }}</span><br>
                            <b>Players:</b> <span class="black">{{ $event->max_num_players ?? 0 }}</span><br>
                        </div>
                    </div>
                </div>
            @endforeach

		</div>
	</div>
	<div class="col-sm-4 p_x0">
		<div class="p_x40 p_y20 pink_bg shadow_r" style="height: 450px">
			<h3 class="text-center"><b>COMING SOON</b></h3>
            @foreach ($upcomingEvents as $event)
                <div class="m_t10">
                    <div class="row align">
                        <div class="col-sm-3 col-xs-5 m_b10">
                            <a href="{{ route('events.show',  $event->id) }}">
                                <img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered">
                            </a>
                        </div>
                        <div class="col-sm-9 col-xs-7 m_b10 p_l0">
                            <a href="{{ route('events.show',  $event->id) }}" class="white" style="text-decoration:underline"><b>{{ $event->name }}</b></a><br>
                            <b>Game:</b> <span class="black">{{ $event->games->name }}</span><br>
                            <b>Players:</b> <span class="black">{{ $event->max_num_players ?? 0 }}</span><br>
                        </div>
                    </div>
                </div>
            @endforeach

		</div>
	</div>
</div>


<div class="container vpc" data-vp-add-class="animated fadeIn slower">
	<div class="row text-center m_y40">
		<div class="col-sm-12">
			<a data-toggle="modal" data-target="#EventCreateModal" class="btn btn-primary btn-lg"><i class="fas fa-trophy m_r10"></i>NEW EVENT</a>
			<p class="m_t40">Ea ea sunt cillum in cillum ipsum labore minim irure laborum in excepteur enim elit sint. Non officia laborum aliqua consectetur consectetur sint et esse consequat ut cillum est esse occaecat id consectetur in. Consequat elit nisi qui mollit id labore deserunt. In amet duis eiusmod eiusmod fugiat aliquip pariatur consequat tempor aliquip elit officia quis qui. Aliqua consequat consequat eu ipsum laborum qui ad laborum et pariatur esse. Proident non aute ex non qui sint tempor excepteur duis enim. Incididunt cupidatat enim nostrud do aliqua mollit voluptate sit consequat sunt aute tempor irure.</p>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-6 m_y20">
			<form>
				<ul class="list-inline m_b0">
					<li>
						<input type="checkbox" class="event_filter_checkbox event_created_by"> Created
					</li>
					<li>
						<input type="checkbox" class="event_filter_checkbox event_joined_by"> Joined
					</li>
				</ul>
			</form>
		</div>
		<div class="col-sm-6 m_y20 text-right">
			<!-- after search -->
			<a class="m_r5 event_filter_reset">Filters Reset</a>
			<a data-toggle="modal" data-target="#searchEventModal" class="btn btn-default"><i class="fa fa-search m_r5"></i>SEARCH EVENT</a>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="vpc event_table_append" data-vp-add-class="animated fadeIn slower">
        @include('includes/event_table')
	</div>
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
