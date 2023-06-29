<?php include('includes/head.php') ?>
<?php include('includes/header.php') ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-gamepad m_r10"></i>GAMES</b></h3>
			<div class="row">
				<div class="col-sm-4 m_y20">
					<form>
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox"> Played
							</li>
							<li>
								<input type="checkbox"> Played in Events
							</li>
						</ul>
					</form>
				</div>
				<div class="col-sm-8 m_y20 text-right">
					<ul class="list-inline m_b0">
						<!-- after search -->
						<li>
							<a href="###-###" class="m_r5">Filters Reset</a>
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

<div class="container-fluid p_x0" id="game_list">
	<div class="row m_x0">
		<div class="col-md-3 col-sm-6 p_x0 l_blue_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<div style="margin-top:28px"><b><i class="fas fa-check m_r5"></i>PLAYED</b></div>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 yellow_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<a href="###-###" class="btn btn-default">I PLAYED IT</a>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 red_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<div style="margin-top:28px"><b><i class="fas fa-check m_r5"></i>PLAYED</b></div>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 pink_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<a href="###-###" class="btn btn-default">I PLAYED IT</a>
				</a>
			</div>
		</div>
	</div>
	<div class="row m_x0">
		<div class="col-md-3 col-sm-6 p_x0 green_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<div style="margin-top:28px"><b><i class="fas fa-check m_r5"></i>PLAYED</b></div>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 purple_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<a href="###-###" class="btn btn-default">I PLAYED IT</a>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 blue_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<div style="margin-top:28px"><b><i class="fas fa-check m_r5"></i>PLAYED</b></div>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 p_x0 orange_bg text-center shadow_r">
			<div class="p_20">
				<a href="/game-detail.php">
					<img src="https://via.placeholder.com/800x800" class="avatar">
					<h4 class="m_b0"><b>Game lorem ipsum dolor</b></h4>
					<p><b><a href="game-list.php">Category</a></b></p>
					<a href="###-###" class="btn btn-default">I PLAYED IT</a>
				</a>
			</div>
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

<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
