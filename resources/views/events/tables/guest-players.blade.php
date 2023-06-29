<div class="row">
	<div class="col-sm-12 table-responsive">
		<table class="table sortable_table">
			<thead>
				<th class="text-center"><i class="lbl fas fa-user" data-toggle="tooltip" data-original-title="NICKNAME"></i><i class="fas fa-sort-up sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-trophy" data-toggle="tooltip" data-original-title="VICTORIES"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/x.svg" class="lbl" data-toggle="tooltip" data-original-title="O<span class='blue'>X</span>ARATE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/o.svg" class="lbl" data-toggle="tooltip" data-original-title="PERF<span class='red'>O</span>RMANCE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/y.svg" class="lbl" data-toggle="tooltip" data-original-title="<span class='yellow'>Y</span>NFLUENCE"><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><img src="/img/a.svg" class="lbl" data-toggle="tooltip" data-original-title="MONETIZ<span class='green'>A</span>TION"><i class="fad fa-sort sort m_l5"></i></th>
				<th></th>
			</thead>
			<tbody>

                @foreach ($players as $player)                   
                
                    <tr class="" style="background-color: {{ $player->profile_color ?? "#0000fe !important" }}">
                        <td><a href="{{ route('users.player-detail', $player->id) }}" style="color: white">
                            <img src="{{ $player->profile_image ?? url('/img/avatar.jpg') }}" class="avatar m_r10" style="width:60px!important">{{ $player->name ." ". (isset($player->team_name) ?  '('.$player->team_name.')'  : "") }}</a></td>
                        
                        <td class="text-center">10</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">50%</td>

                        <td class="text-right">
                            <ul class="list-inline m_b0">
                                <li><a href="{{ route('users.player-detail', $player->id) }}" class="btn btn-default">Connect</a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
			</tbody>
		</table>
	</div>
</div>
