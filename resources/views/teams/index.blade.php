@include('includes/head')
@include('layouts/header')

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif

@if (session('subscription-alert-model'))
    <div class="modal" tabindex="-1" role="dialog" id="success_alert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <div class="submission-notes">
                        <span class="note-text">{{ session('subscription-alert-model') }} </span>
                        <form class="js-passnote-form">

                            <div class="text-right">

                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class=" stickyheader">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><strong><em class="fas fa-user-friends m_r10"></em>TEAMS</strong></h3>
				<div class="row">
					<div class="col-sm-4 m_y20">
						<form>
							<ul class="list-inline m_b0">
								<li>
									<input type="checkbox" name="team_created_by" id="team_created_by"> Created
								</li>
								<li>
									<input type="checkbox" id="team_joined_by"> Joined
								</li>
							</ul>
						</form>
					</div>
					<div class="col-sm-8 m_y20 text-right">
						<ul class="list-inline m_b0">
							<!-- after search -->
							<li>
								<a href="#" class="m_r5" id="team_filter_reset">Filters Reset</a>
							</li>
							<li>
								<a data-toggle="modal" data-target="#searchTeamModal" class="btn btn-default"><em class="fa fa-search m_r5"></em>SEARCH TEAM</a>
							</li>
							<li class="m_t10_m">
								<a href="{{ route('teams.create') }}" class="btn btn-primary"><em class="fa fa-user-friends m_r5"></em>CREATE TEAM</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid p_x0 teamscroll" id="team_list">
	<div class="row m_x0 append-teams-list">
	@include('teams/list')
	</div>
</div>
<div class="ajax-loading"><img src="{{ url('img/loading-buffering.gif') }}" alt="loading-icon" class="img-fluid" /></div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x600" alt="placeholder">
		</div>
	</div>
</div>

<script type="text/javascript">
	// $("img").lazyload({
	//     effect : "fadeIn"
	// });
</script>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')