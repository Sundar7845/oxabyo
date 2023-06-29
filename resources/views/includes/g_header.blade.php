<div class="heightWrapper">
	<header class="guest copyHeight">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 hidden-xs">
					<a href="/"><img src={{ url("img/logo.svg") }}></a>
				</div>
				<div class="col-sm-9 text-right">
					<nav class="navbar navbar-default navbar-right">
						<div class="navbar-header">
							<div class="row">
								<div class="col-xs-12">
									<div class="visible-xs navbar-toggle toggle-menu menu-left push-body" data-toggle="collapse" data-target="#main_menu">
										<a><img src={{ url("img/logo.svg") }} id="mobile_logo"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="main_menu">
							<ul class="nav navbar-nav">
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/home") !== false){echo ' class="active"';}?>><a href="/">HOME</a></li>
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/tournament") !== false){echo ' class="active"';}?>><a href="/tournament">TOURNAMENTS</a></li>
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/g_players") !== false){echo ' class="active"';}?>><a href="/g_players">E-PLAYERS</a></li>
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/pricing") !== false){echo ' class="active"';}?>><a href="/pricing">PRICING</a></li>
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/contact") !== false){echo ' class="active"';}?>><a href="/contact">CONTACTS</a></li>

								@if(! Auth::check())
								
								<li<?php if (strpos($_SERVER['REQUEST_URI'], "/login") !== false){echo ' class="active"';}?>><a href="/login">LOGIN</a></li>

								@endif 
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<div class="pasteHeight" style="height: 93px;"></div>
</div>
