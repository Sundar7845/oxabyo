<div class="modal fade" id="searchEventModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-search m_r5"></em>Search Event</h4>
			</div>
			<div class="modal-body">
		 <form class="event_search_form" id="event_search_form" name="event_search_form" action="javascript:void(0)">
					<div class="m_b10">
						<input type="text" class="form-control input-sm" id="event_name" name="event_name" placeholder="Event Name">
					</div>
					<div class="m_b10">
						<input type="checkbox" id="event_joined_by" name="event_joined_by"> Joined
					</div>
					<div class="m_b10">
						<input type="text" class="form-control input-sm" placeholder="Organizer Name"
						name="event_organizer_name" id="event_organizer_name">
					</div>
					<div class="m_b10">
						<input type="checkbox" id="event_created_by" name="event_created_by"> Organized by me
					</div>

					<div class="m_b10">
						<select class="form-control" id="event_games" name="event_games">
							<option hidden value="">Game</option>
							@foreach ($games as $game)
                                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                                    @endforeach
						</select>
					</div>

					<label>Type</label>
					<div class="m_b10">
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox" id="event_one_shot_type" name="event_one_shot_type"> One shot
							</li>
							<li>
								<input type="checkbox" id="event_play_off_type" name="event_play_off_type"> Playoff
							</li>
							<li>
								<input type="checkbox" id="event_challenge_round_type" name="event_challenge_round_type"> Challenge Round
							</li>
							<li>
								<input type="checkbox" id="event_single_player_type" name="event_single_player_type"> Single Player
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-sm-4 m_b10">
							<label>Date from</label>
							<input type="date" class="form-control" id="event_date_from" name="event_date_from">
						</div>
						<div class="col-sm-4 m_b10">
							<label>Date to</label>
							<input type="date" class="form-control" id="event_date_to" name="event_date_to">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 m_b10">
							<label>Ticket from €</label>
							<input type="text" class="form-control" id="event_ticket_from" name="event_ticket_from">
						</div>
						<div class="col-sm-4 m_b10">
							<label>Ticket to €</label>
							<input type="text" class="form-control" id="event_ticket_to" name="event_ticket_to">
						</div>
						<div class="col-sm-4 m_b10">
							<div>&nbsp;</div>
							<input type="checkbox" id="free_events_only" name="free_events_only"> Free Events Only
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 m_b10">
							<label>Prize Money from €</label>
							<input type="text" class="form-control" id="event_prize_money_from" name="event_prize_money_from">
						</div>
						<div class="col-sm-4 m_b10">
							<label>Prize Money to €</label>
							<input type="text" class="form-control" id="event_prize_money_to" name="event_prize_money_to">
						</div>
						
					</div>
					<div class="row m_t10">
						<div class="col-sm-6">
							<div class="m_b20">
								<img src="/img/x.svg" style="width:30px;" alt=""> OXARATE min 
									<input type="number" class="form-control pull-right" min="1" 
										max="100" style="width:70px" id="oxarate_min" name="oxarate_min"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">OXARATE max <input type="number" class="form-control pull-right" 
								min="1" max="100" style="width:70px" id="oxarate_max" name="oxarate_max"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/o.svg" style="width:30px;" alt=""> Performance rating min 
								<input type="number" class="form-control pull-right" min="1" max="100" style="width:70px" id="performance_rating_min" name="performance_rating_min"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Performance rating max <input type="number" class="form-control pull-right" 
								min="1" max="100" style="width:70px" id="performance_rating_max" name="performance_rating_max"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/y.svg" style="width:30px;" alt=""> Ynfluence rating min 
								<input type="number" class="form-control pull-right" min="1" max="100" style="width:70px" id="ynfluence_rating_min" name="ynfluence_rating_min"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Ynfluence rating max <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px" 
								id="ynfluence_rating_max" name="ynfluence_rating_max"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/a.svg" style="width:30px;" alt=""> Monetization rating min 
								<input type="number" class="form-control pull-right" min="1" max="100" style="width:70px" 
									id="monetization_rating_min" name="monetization_rating_min"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Monetization rating max <input type="number" class="form-control pull-right" min="1" 
								max="100" style="width:70px" id="monetization_rating_max" name="monetization_rating_max"></div>
						</div>
					</div>
					<div class="text-center m_t20 m_b10">
						<!-- dismiss modal and show results -->
						<button  type="submit" class="btn btn-default event_search_form" ><em class="fas fa-search m_r5"></em>Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>