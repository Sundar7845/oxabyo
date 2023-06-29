@include('includes/head')
@include('layouts/header')
@include('events/modal/event-rules-modal')

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

<div style="background-image:url({{ $event->cover }});background-size:cover;background-repeat:no-repeat;background-position:center">

	<div id="event_top_detail">
		<div class="container">
			<div class="row vpc" data-vp-add-class="animated fadeIn slower">
				<div class="col-sm-2 m_b20">
					<img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered">
				</div>
				<div class="col-sm-10 m_b20">
					<h2><b>{{ $event->name }}</b></h2>
					<div class="row">
						<div class="col-sm-6">
							<b>Game:</b> {{ $event->games->name ?? '' }}<br>
							<b>Type:</b> {{ $event->event_types->name ?? '' }}<br>
						</div>
						<div class="col-sm-6 text-right">
							<b>Date:</b> {{ $event->match_date ?? '' }}<br>
							<b>Ticket:</b>  {{ $event->ticket . " €" }}
							<h3 class="m_t0"><b>Prize Money:</b> {{ $event->prize_money . " €" }}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="red_bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-9 p_y5">
				<h3 class="m_y5"><b>N. MATCHES: <span class="black">1</span></b></h3>
				<h3 class="m_y5"><b>PLAYERS: <span class="black">SINGLE PLAYER</span></b></h3>
			</div>
			<div class="col-sm-3 text-right p_y5">
				<a data-toggle="modal" data-target="#EventRulesModal" class="btn btn-default m_t10">RULES</a>
			</div>
		</div>
	</div>
</div>

<div class="container">

	<div class="row">

		@if ($event->organizer_id == auth()->user()->id)
	
			<div class="col-sm-12 p_y5">
				<div class="text-center m_t40"><a href="{{ route('events.edit',$event->id) }}" class="btn btn-default btn-lg">MANAGE</a></div>
			</div>
	 @endif

	</div>

	<div class="row m_x0 m_t40 vpc" data-vp-add-class="animated fadeIn slower">
		<div class="col-sm-6 p_x0">
			<div class="p_x40 p_y20 red_bg shadow_r">
				<h4 class="text-center"><b>{{ $event->match_date . " " . $event->match_hour }}</b></h4>
				<div class="text-center">
					<span style="width:41%;display:inline-block;">
						<img src="{{ isset($player->profile_image) ? ($player->profile_image) : "https://via.placeholder.com/800x800" }}" class="avatar">
					</span>
					<h4 class="m_y20"><b>{{ $player->name ?? '' }}</b></h4>
				</div>
				@include('events/comments/all-comments')
			</div>
		</div>
		<div class="col-sm-6 p_x0">
			<div style="background-color:#9147ff;height:825px;" class="h_auto_m p_x40 p_y20 shadow_r">
				{{-- <h3><b><i class="fas fa-desktop m_r10"></i><span class="black">ORGANIZER STREAMING</span></b></h3>
				<img src="https://via.placeholder.com/800x480"> --}}
				{{ csrf_field() }}
				<h4><b>Comment</b></h4>
				<textarea class="form-control event_comment" rows="6" placeholder="Message..." required="required"></textarea>

				<input type="hidden" class="event_id" name="event_id" value="{{ $event->id }}"/>

				<ul class="list-inline m_t10 text-right">
					<li><a data-toggle="modal" data-target="#UserVoteModal" class="btn btn-default">VOTE</a></li>
					
					<li><a class="btn btn-default event_comment_submit">SEND</a></li>
				</ul>
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

		@include('events/player_table')
	</div>
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
