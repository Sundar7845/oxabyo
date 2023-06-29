<div class="modal fade" id="CalendarModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Calendar and Ranking</h4>
			</div>
			<div class="modal-body">

        @foreach ($completedEventPhase as $completedPhase)
				<div class="m_b20"><h3 class="text-center"><strong>PHASE {{ $completedPhase->match }} ({{ $completedPhase->phases->value }}°)</strong></h3>
				<div class="row text-center hidden-xs">
					<div class="col-sm-2"><strong>DATE</strong></div>
					<div class="col-sm-5"><strong>CHALLENGER 1</strong></div>
					<div class="col-sm-5"><strong>CHALLENGER 2</strong></div>
				</div>

                @foreach ($completedPhase->fixtures as $fixtures)
				<div class="row">
					<div class="col-sm-2 m_t20">{{ $fixtures->date }}</div>
					<div class="col-sm-5 p_y10" class="white" style="background-color: {{ $fixtures->fixture_results->winner->players->profile_color ?? '#0000fe !important' }}"><a href="/player-detail.php" class="white">
                        <img src="{{ $fixtures->challenger1->players->profile_image ?? url('/img/avatar.jpg') }}" class="avatar m_r10" style="width:60px;" 
                        alt="">{{ $fixtures->fixture_results->winner->players->name ?? '' }}</a></div>
					<div class="col-sm-5 p_y10 loser" style="background-color: {{ $fixtures->fixture_results->looser->players->profile_color ?? '#0000fe !important' }}"><a href="/player-detail.php" 
                        class="white" ><img src="{{ $fixtures->challenger2->players->profile_image ?? url('/img/avatar.jpg') }}" class="avatar m_r10" 
                        style="width:60px;" alt=""><s>{{ $fixtures->fixture_results->looser->players->name ?? '' }}</s></a></div>
				</div>

                
@endforeach
			</div>
<br>
<br>

@endforeach

		</div>
	</div>
</div>
</div>