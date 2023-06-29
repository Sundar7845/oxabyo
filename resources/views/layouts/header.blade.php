<div class="heightWrapper">
	<header class="logged copyHeight">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-8 m_t5" id="logo">
					<a href="/dashboard"><img src="{{ url('img/logo.svg') }}" alt=""></a>
				</div>
				<div class="col-xs-4 text-right visible-xs m_t5">

                    @include('includes/dropdown')
				</div>
				<div class="col-sm-8 col-xs-12 text-right p_x0">
					<ul class="list-inline" id="bar_menu">
					<li<?php if (strpos($_SERVER['REQUEST_URI'], "/search") !== false){echo ' class="active"';}?>>
						<a href="/search" data-toggle="tooltip" data-placement="bottom" data-original-title="SEARCH">
							<a data-toggle="modal" data-target="#searchModal" class="btn btn-primary">
								<i class="fas fa-search"></i>
							</a>
                        </a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "dashboard") !== false){echo ' class="active"';}?>>
							<a href="/dashboard" class="btn btn-primary green_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="WALL">
								<i class="fas fa-globe-europe"></i>
							</a>
						</li>
							<li<?php if (strpos($_SERVER['REQUEST_URI'], "events") !== false){echo ' class="active"';}?>>
							<a href="/events" class="btn btn-primary blue_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="EVENTS">
								<i class="fas fa-trophy"></i>
							</a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "player-list") !== false){echo ' class="active"';}?>>
							<a href="/player-list" class="btn btn-primary yellow_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="E-PLAYERS">
								<i class="fas fa-user-headset"></i>
							</a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "teams") !== false){echo ' class="active"';}?>>
							<a href="/teams" class="btn btn-primary orange_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="TEAMS">
								<i class="fas fa-user-friends"></i>
							</a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "groups") !== false){echo ' class="active"';}?>>
							<a href="/groups" class="btn btn-primary pink_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="GROUPS">
								<i class="fas fa-comments"></i>
							</a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "achievements.php") !== false){echo ' class="active"';}?>>
							<a href="achievements.php" class="btn btn-primary purple_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="ACHIEVEMENTS">
								<i class="fas fa-layer-group"></i>
							</a>
						</li>
						<li<?php if (strpos($_SERVER['REQUEST_URI'], "/games") !== false){echo ' class="active"';}?>>
							<a href="/games" class="btn btn-primary orange_bg_h" data-toggle="tooltip" data-placement="bottom" data-original-title="GAMES">
								<i class="fas fa-gamepad"></i>
							</a>
						</li>
					</ul>

				</div>
				<div class="col-sm-1">
					<span class="hidden-xs navbar-right" id="main_menu">
						@include('includes/dropdown')
					</span>
				</div>
			</div>
		</div>
	</header>
	<div class="pasteHeight" style="height: 93px;"></div>
</div>
