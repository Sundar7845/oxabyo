<ul class="list-inline" id="bar_menu">
	<li class="hidden-sm hidden-md hidden-lg">
		<a data-toggle="modal" data-target="#searchModal" class="btn btn-primary" data-toggle="tooltip" data-original-title="SEARCH">
			<i class="fas fa-search"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "wall.php") !== false){echo ' class="active"';}?>>
		<a href="wall.php" class="btn btn-primary green_bg_h" data-toggle="tooltip" data-original-title="WALL">
			<i class="fas fa-globe-europe"></i>
		</a>
	</li>
		<li<?php if (strpos($_SERVER['REQUEST_URI'], "event-list.php") !== false){echo ' class="active"';}?>>
		<a href="event-list.php" class="btn btn-primary blue_bg_h" data-toggle="tooltip" data-original-title="EVENTS">
			<i class="fas fa-trophy"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "player-list.php") !== false){echo ' class="active"';}?>>
		<a href="player-list.php" class="btn btn-primary yellow_bg_h" data-toggle="tooltip" data-original-title="E-PLAYERS">
			<i class="fas fa-user-headset"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "teams") !== false){echo ' class="active"';}?>>
		<a href="/teams" class="btn btn-primary orange_bg_h" data-toggle="tooltip" data-original-title="TEAMS">
			<i class="fas fa-user-friends"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "group-list.php") !== false){echo ' class="active"';}?>>
		<a href="group-list.php" class="btn btn-primary pink_bg_h" data-toggle="tooltip" data-original-title="GROUPS">
			<i class="fas fa-comments"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "achievements.php") !== false){echo ' class="active"';}?>>
		<a href="achievements.php" class="btn btn-primary purple_bg_h" data-toggle="tooltip" data-original-title="ACHIEVEMENTS">
			<i class="fas fa-layer-group"></i>
		</a>
	</li>
	<li<?php if (strpos($_SERVER['REQUEST_URI'], "game-list.php") !== false){echo ' class="active"';}?>>
		<a href="game-list.php" class="btn btn-primary orange_bg_h" data-toggle="tooltip" data-original-title="GAMES">
			<i class="fas fa-gamepad"></i>
		</a>
	</li>
</ul>
