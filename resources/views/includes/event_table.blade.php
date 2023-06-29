<div class="row">
	<div class="col-sm-12 table-responsive">
		<table class="table sortable_table event_table">
			<thead>
				<th colspan="2" class="text-center"><i class="lbl fas fa-trophy" data-toggle="tooltip" data-original-title="EVENT"></i><i class="fas fa-sort-up sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-user-headset" data-toggle="tooltip" data-original-title="E-PLAYERS"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-calendar-day" data-toggle="tooltip" data-original-title="DATE"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-euro-sign" data-toggle="tooltip" data-original-title="TICKET"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-award" data-toggle="tooltip" data-original-title="PRIZE MONEY"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/x.svg" class="lbl" data-toggle="tooltip" data-original-title="O<span class='blue'>X</span>ARATE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/o.svg" class="lbl" data-toggle="tooltip" data-original-title="PERF<span class='red'>O</span>RMANCE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/y.svg" class="lbl" data-toggle="tooltip" data-original-title="<span class='yellow'>Y</span>NFLUENCE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/a.svg" class="lbl" data-toggle="tooltip" data-original-title="MONETIZ<span class='green'>A</span>TION"><i class="fad fa-sort sort m_l5"></i></th>
				<th></th>
			</thead>
			<tbody>
				@foreach ($allEvents as $allEvent)				
				<tr>
					<td style="width:100px!important">
						<img src="{{ $allEvent->image ?? "https://via.placeholder.com/800x800" }}" class="m_r10 bordered" style="height: 74px;">
					</td>
					<td>
						<div style="font-weight:300">
							<b>{{ $allEvent->name }}</b><br>
							<b>Game:</b> {{ $allEvent->games->name ?? '' }}<br>
							<b>Type:</b> {{ $allEvent->event_types->name ?? '' }}<br>
							<b>Organizer:</b> {{  $allEvent->organizer->name ?? '' }}
						</div>
					</td>
					<td class="text-center">{{ $allEvent->max_num_players ?? 0 }}</td>
					<td class="text-center">{{ $allEvent->match_date }}</td>
					<td class="text-center">{{ $allEvent->ticket . " €" }}</td>
					<td class="text-center">{{ $allEvent->prize_money . " €" }}</td>
					<td class="text-center">{{ $allEvent->oxarate_min }}</td>
					<td class="text-center">{{ $allEvent->performance_rating_min }}</td>
					<td class="text-center">{{ $allEvent->ynfluence_rating_min }}</td>
					<td class="text-center">{{ $allEvent->monetization_rating_min }}</td>
					<td class="text-right"><a href="{{ route('events.show',  $allEvent->id) }}" class="btn btn-default">See More</a></td>
				</tr>
				@endforeach				 
			</tbody>
		</table>
	</div>
</div>
