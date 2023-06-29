@include('includes/head')
@include('layouts/header')
@include('games/search-modal')

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-gamepad m_r10"></i>GAMES</b></h3>
			<div class="row">
				<div class="col-sm-4 m_y20">
					<form>
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox" class="game_filter_checkbox game_played_by" id="game_played_by"> Played
							</li>
							<li>
								<input type="checkbox" class="game_filter_checkbox game_played_event" id="game_played_event"> Played in Events
							</li>
						</ul>
					</form>
				</div>
				<div class="col-sm-8 m_y20 text-right">
					<ul class="list-inline m_b0">
						<!-- after search -->
						<li>
							<a href="#" class="m_r5 game_filter_reset" id="game_filter_reset">Filters Reset</a>
						</li>
						<li>
							<a data-toggle="modal" data-target="#searchGameModal" class="btn btn-default"><i class="fa fa-search m_r5"></i>SEARCH GAME</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@include('games/list')



<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x600">
		</div>
	</div>
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')

