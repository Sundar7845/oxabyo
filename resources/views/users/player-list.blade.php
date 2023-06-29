@include('includes/head')
@include('layouts/header')
@include('users/modals/search-player-modal')

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-user-headset m_r10"></i>E-PLAYERS</b></h3>
			<div class="row">
				<div class="col-sm-6 m_y20">
					<form>
						<input name="player_friends_only1" id="player_friends_only1" type="checkbox"> Show friends only
					</form>
				</div>
				<div class="col-sm-6 m_y20 text-right">
					<!-- after search -->
					<a id="e_player_filter_reset" class="m_r5">Filters Reset</a>
					<a data-toggle="modal" data-target="#searchPlayerModal" class="btn btn-default"><i class="fa fa-search m_r5"></i>SEARCH E-PLAYER</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 append-player-list">
			@include('users/players-table')
		</div>
	</div>
</div>
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