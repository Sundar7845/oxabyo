<div class="row">
    <div class="col-sm-12 table-responsive">
        @if (count($players->where($whereData, $value)) > 0)
            <table class="table sortable_table">
                <thead>
                    <th class="text-center"><i class="lbl fas fa-user" data-toggle="tooltip"
                            data-original-title="NICKNAME"></i><i class="fas fa-sort-up sort m_l5"></i></th>
                    <th class="text-center"><i class="lbl fas fa-trophy" data-toggle="tooltip"
                            data-original-title="VICTORIES"></i><i class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><img src="/img/x.svg" class="lbl" data-toggle="tooltip"
                            data-original-title="O<span class='blue'>X</span>ARATE"><i
                            class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><img src="/img/o.svg" class="lbl" data-toggle="tooltip"
                            data-original-title="PERF<span class='red'>O</span>RMANCE"><i
                            class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><img src="/img/y.svg" class="lbl" data-toggle="tooltip"
                            data-original-title="<span class='yellow'>Y</span>NFLUENCE"><i
                            class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><img src="/img/a.svg" class="lbl" data-toggle="tooltip"
                            data-original-title="MONETIZ<span class='green'>A</span>TION"><i
                            class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><i class="lbl fas fa-users" data-toggle="tooltip"
                            data-original-title="FRIENDS"></i><i class="fad fa-sort sort m_l5"></i></th>
                    <th class="text-center"><i class="lbl fas fa-heart" data-toggle="tooltip"
                            data-original-title="LIKE"></i><i class="fad fa-sort sort m_l5"></i></th>
                    <th></th>
                </thead>
                <tbody>
                    <!-- red_bg is default background class for user doesn't choose a color yet -->
                    @foreach ($players->where($whereData, $value) as $player)
                        <tr style="background-color: {{ $player->profile_color ?? '#0000fe !important' }}">
                            <td><img src="{{ $player->profile_image ?? url('/img/avatar.jpg') }}"
                                    class="avatar m_r10" style="width:60px!important">{{ $player->user_name }}</td>
                        
                                    
                                    <td class="text-center">{{ $player->wins }}</td>
                            <td class="text-center">{{ $player->oxarate . "%" }}</td>
                            <td class="text-center">{{ $player->performance . "%" }}</td>
                            <td class="text-center">{{ $player->social . "%" }}</td>
                            <td class="text-center">{{ $player->monetization . "%" }}</td>

                            
                            <td class="text-center">
                                {{ $player->friends? count($player->friends->where('friend_id', $player->user_id)->where('is_connected', 1)->get()): 0 }}
                            </td>
                            <td class="text-center">
                                {{ $player->friends? count($player->friends->where('friend_id', $player->user_id)->where('is_like', 1)->get()): 0 }}
                            </td>
                            <td class="text-right">
                                <form style="display:inline-block"
                                    action="{{ route('event-player-delete', $player->event_player_id) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-icon"
                                        onclick="return confirm('Are you sure want to remove {{ $player->user_name }}?')"><i
                                            class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
