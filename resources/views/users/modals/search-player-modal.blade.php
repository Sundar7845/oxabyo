<div class="modal fade" id="searchPlayerModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-search m_r5"></em>Search E-Player</h4>
			</div>
			<div class="modal-body">
		 
					<div class="m_b10">
						<input type="text" id="player_name" class="form-control input-sm" placeholder="E-Player Name">
					</div>
					<div class="m_b10">
						<input type="checkbox" id="player_friends_only"> Friends
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/x.svg" style="width:30px;" alt=""> OXARATE min <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">OXARATE max <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/o.svg" style="width:30px;" alt=""> Performance rating min <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Performance rating max <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/y.svg" style="width:30px;" alt=""> Ynfluence rating min <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Ynfluence rating max <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="m_b20"><img src="/img/a.svg" style="width:30px;" alt=""> Monetization rating min <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
						<div class="col-sm-6">
							<div class="m_b20">Monetization rating max <input type="number" class="form-control pull-right" min="1" max="100" style="width:70px"></div>
						</div>
					</div>
					<div class="text-center m_t20 m_b10">
						<!-- dismiss modal and show results -->
						<button id="e_player_filtersearch" class="btn btn-default"><em class="fas fa-search m_r5"></em>Search</button>
					</div>
		 
			</div>
		</div>
	</div>
</div>