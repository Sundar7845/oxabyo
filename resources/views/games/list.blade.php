<div class="container-fluid p_x0" id="game_list">
    <div class="row m_x0 append-games-list" id="append_games_list"">
 	@foreach ($games as $game)
        <div class="col-md-3 col-sm-6 p_x0 l_blue_bg text-center shadow_r" style="height: 486px;">
            <div class="p_20">
                <a href="{{ route('games.show', $game->id) }}">
                    <img src="{{ $game->game_image ?? 'https://via.placeholder.com/800x800' }}" class="avatar"
                        style="height: 340px;">
                    <p><b></b></p>
                    <h4 class="m_b0"><b>{{ $game->name }}</b></h4>
                    <p><b><a>{{ $game->category }}</a></b></p>
                    <div style="margin-top:28px"
                        @if (isset($game->user_games->is_played) && $game->user_games->is_played) 
                            class="game_played hidden game-played-first-{{ $game->id }}"
						@else 							
                            class="game_played game-played-first-{{ $game->id }}" 
                        @endif
                        data-id="{{ $game->id }}">
                        <a class="btn btn-default">I PLAYED IT</a>
                    </div>
                    <div style="margin-top:28px"
                        @if (isset($game->user_games->is_played) &&  $game->user_games->is_played) 
                            class="game_played game-played-second-{{ $game->id }}"
					    @else							
                            class="game_played hidden game-played-second-{{ $game->id }}"
                        @endif
                        data-id="{{ $game->id }}">
                        <b><i class="fas fa-check m_r5"></i>PLAYED</b>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
