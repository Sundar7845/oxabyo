<?php include('includes/head.php') ?>
<?php include('includes/g_header.php') ?>

<div class="container m_y40">
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-tabs" role="tablist">
				<li style="width:50%;" role="presentation" class="text-center active"><a href="#best" role="tab" data-toggle="tab"><h3 class="m_y0"><b>BEST E-PLAYERS</b></h3></a></li>
				<li style="width:50%;" role="presentation" class="text-center"><a href="#recent" role="tab" data-toggle="tab"><h3 class="m_y0"><b>RECENT E-PLAYERS</b></h3></a></li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="best">
					<?php include('includes/player_table.php') ?>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="recent">
					<div class="row m_x0">
						<div class="col-md-3 col-sm-6 p_x0 l_blue_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 yellow_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 red_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 pink_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
					</div>
					<div class="row m_x0">
						<div class="col-md-3 col-sm-6 p_x0 green_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 purple_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 blue_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 p_x0 orange_bg text-center shadow_r">
							<div class="p_20">
								<img src="/img/avatar.jpg" class="avatar">
								<h4><b>Username lorem ipsum dolor</b></h4>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="text-center m_y40">
				<a href="###-###" class="btn btn-default"><b>DISCOVER MORE</b></a>
			</div>

			<img src="https://via.placeholder.com/1200x600">

		</div>
	</div>
</div>


<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
