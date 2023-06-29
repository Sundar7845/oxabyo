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
                        
                            <td class="text-center">{{ $player->wins }}</td>
                            <td class="text-center">{{ $player->oxarate . "%" }}</td>
                            <td class="text-center">{{ $player->performance . "%" }}</td>
                            <td class="text-center">{{ $player->social . "%" }}</td>
                            <td class="text-center">{{ $player->monetization . "%" }}</td>
               
                        <td class="text-right">
                            <ul class="list-inline m_b0">
                                <li><a data-toggle="collapse" href="#collapseUser-{{ $player->player_id }}" class="btn btn-default">STREAM</a></li>
                                <li><a data-toggle="modal" data-target="#UserVoteModal" class="btn btn-default">VOTE</a></li>
                                <li><a href="{{ route('users.player-detail', $player->id) }}" class="btn btn-default">Connect</a></li>
                            </ul>
                        </td>
                    
                    </tr>

                    <tr>
                        <td colspan="7" class="usercollapse">
                            <div class="blue_bg collapse custom-comment-{{ $player->player_id }}" id="collapseUser-{{ $player->player_id }}">
                                <div class="p_10">
                                    <div class="row">
                                        <div class="col-sm-6 text-center m_b10" > 
                                            
                                            @if (isset($player->players->twitch) && $player->players->twitch) 
                                            <iframe
                                                src={{ $player->players->twitch->channel_name }}                                                
                                                width="500"
                                                allowfullscreen
                                                style="height:500px !important"
                                                >
                                            </iframe>
                                            @endif
                                            {{-- <h4><b>Streaming started from: 00h 00m 00s</b></h4> --}}
                                        </div>                                        
                                        <div class="col-sm-6 m_b10 player_event_comment_class player_event_comment_class-{{ $player->player_id }}">

                                            
                                                
                                            
                                                <div class="white_bg black p_10 player_event_comment_div player_event_comment_append-{{ $player->player_id }}"
                                                    data-user-id="{{  $player->player_id }}"  
                                                    style="overflow-y:scroll;height:500px;font-weight:300">
                                                   
                                                    @foreach ($player->live_comments as $live_comment)
                                                    

                                                    @include('events/comments/player-comments')
                                                    
                                                    
                                                    @endforeach  

                                                </div>

                                        
                                         
                                            <h4><b>Comment</b></h4>

                                            <textarea class="form-control player_event_comment" rows="6" placeholder="Message..."></textarea>
                                             
                                            
                                            
                                            <div class="m_y5 text-right">
                                                <a  data-event-id="{{  $event->id }}" 
                                                    data-user-id="{{  $player->player_id }}" 
                                                    class="btn btn-default event_comment_bby_single_user_submit">SEND</a>
                                            </div>
                                           

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                @endforeach
			</tbody>
		</table>
	</div>
</div>
