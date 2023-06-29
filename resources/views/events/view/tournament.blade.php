

@include('includes/head')
@include('includes/g_header')


<div class="container">
	<div class="vpc" data-vp-add-class="animated fadeIn slower">
		<div class="row text-center m_y40">
			<div class="col-sm-12">
				<h3><b><i class="fas fa-trophy m_r10"></i>EVENTS AGENDA</b></h3>
			</div>
		</div>
	</div>
    
	<div class="row vpc" data-vp-add-class="animated fadeIn slower">
		
		@foreach ($currentEvents as $event)
            <div class="col-sm-6 p_r0 p_l0">
                <div class="event_list item">
                    <div class="p_x p_y40">
                        <div class="row align">
                            <div class="col-sm-5 col-sm-offset-0 col-xs-6 col-xs-offset-3 m_b20">
                                <a href="{{ route('events.event-detail', $event->id) }}">
                                <img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered"style="height:143px;">

                                </a>
                            </div>
                            <div class="col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1 m_b20">
                                        <b>{{ $event->name }}</b><br>
                                            <b>Game:</b> <span class="black">{{ $event->games->name ?? '' }}</span><br>
                                            <b>Type:</b> <span class="black"> {{ $event->event_types->name ?? '' }}</span><br>
                                            <b>Date:</b> <span class="black">{{ $event->match_date ?? '' }}</span><br>
                                            <b>Prize Money:</b> <span class="black">{{ $event->prize_money . " €" }}</span><br>
                            </div>
                        </div>
                        <div class="text-center">
                            <p><a href="{{ route('events.event-detail', $event->id) }}" class="btn btn-default">View event</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
	</div>
	 

   

	<div class="row">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x600">
		</div>
	</div>

	


</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')

