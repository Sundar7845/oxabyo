<div class="modal fade" id="searchGameModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-search m_r5"></em>Search Game</h4>
			</div>
			<div class="modal-body">
				
					<div class="m_b10">
						<input type="text" class="form-control input-sm" id="game_name" name="game_name" placeholder="Game Name">
					</div>
					<div class="m_b10">
						<select class="form-control" id="categories" name="categories">
							<option hidden>Category</option>
							@foreach ($gameCategories as $gameCategory)
								<option>{{ $gameCategory->category }}</option>
							@endforeach						
						</select>
					</div>
					<div class="m_b10">
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox" id="game_played_by_me" name="game_played_by_me"> Played by me
							</li>
							<li>
								<input type="checkbox" id="game_played_friends" name="game_played_friends"> Played by friends
							</li>
							<li>
								<input type="checkbox" id="game_played_event" name="game_played_event"> Played in Events
							</li>
						</ul>
					</div>
					<div class="text-center m_t20 m_b10">
						<!-- dismiss modal and show results -->
						<button type="submit" id="game_filtersearch" class="btn btn-default"><em class="fas fa-search m_r5"></em>Search</button>
					</div>
				
			</div>
		</div>
	</div>
</div>