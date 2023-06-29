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
				<th class="text-center"><i class="lbl fas fa-users" data-toggle="tooltip" data-original-title="FRIENDS"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th class="text-center"><i class="lbl fas fa-heart" data-toggle="tooltip" data-original-title="LIKE"></i><i class="fad fa-sort sort m_l5"></i></th>
				<th></th>
			</thead>
			<tbody>
			@if(isset($members))
				@foreach($members as $member)
				<tr class="" style="background-color: {{ $member->users->profile_color ?? "#0000fe !important" }}">
					<td><a href="{{ route('users.player-detail', $member->users->id) }}" style="color: white"><img src="{{ $member->users->profile_image ?? url('/img/avatar.jpg') }}" class="avatar m_r10" style="width:60px!important">{{ $member->users->name }}</a></td>
					<td class="text-center">{{ $member->wins }}</td>
					<td class="text-center">{{ $member->oxarate . "%" }}</td>
					<td class="text-center">{{ $member->performance . "%" }}</td>
					<td class="text-center">{{ $member->social . "%" }}</td>
					<td class="text-center">{{ $member->monetization . "%" }}</td>
					<td class="text-center">{{ $member->users->friends ? count($member->users->friends->where('friend_id', $member->users->id)->where('is_connected', 1)->get()) : 0 }}</td>
					<td class="text-center">{{ $member->users->friends ? count($member->users->friends->where('friend_id', $member->users->id)->where('is_like', 1)->get()) : 0}}</td>
					<td class="text-right"><a href="{{ route('users.player-detail', $member->users->id) }}" class="btn btn-default">Connect</a></td>
				</tr>
				@endforeach
			@endif
				
			</tbody>
		</table>
	</div>
</div>
