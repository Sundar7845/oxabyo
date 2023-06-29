@include('includes/head')
@include('layouts/header')

<div class="shadow_v p_y20" style="background-image:url('https://via.placeholder.com/1920x1080/aaaaaa');background-size:cover;background-position:center top">
	<div class="container">
		<div class="row align">
			<div class="col-sm-2 m_y10 text-center">
				<img src="{{ $game->game_image ?? 'https://via.placeholder.com/800x800' }}" class="avatar" style="height: 165px;">
			</div>
			<div class="col-sm-10">
				<ul class="list-inline text-right">
					<!-- if not played yet -->
					<div style="margin-top:28px" 
						@if ( ! $game->is_played) 
							class="game_play game-played-first" 
						@else 
							class="game_play hidden game-played-first" 
						@endif
						
						
						data-id="{{ $game->id }}">						
							<a class="btn btn-default">I PLAYED IT</a>					
						</div>
					 
						<div style="margin-top:28px" 
						
						@if ( ! $game->is_played) 
							class="game_play hidden game-played-second" 
						@else 
							class="game_play game-played-second" 
						@endif
						
						data-id="{{ $game->id }}">
							<b><i class="fas fa-check m_r5"></i>PLAYED</b>
						</div>

				</ul>
				<h4><b>{{$game->name}}</b></h4>
				<p><b>Category:</b> <a href="{{ route('games.index') }}" class="white">{{$game->category}}</a></p>
				<p class="m_b40">{{$game->description}}</p>
			</div>
		</div>
	</div>
</div>

<div class="red_bg p_y10 text-center"><a href="{{ route('games.index') }}" class="btn btn-default">BACK TO GAMES</a></div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')