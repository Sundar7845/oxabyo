<?php include('includes/head.php') ?>
<?php include('includes/header.php') ?>

<div class="orange_bg shadow_v p_y20">
	<div class="container">
		<div class="row align">
			<div class="col-sm-2 m_y10 text-center">
				<img src="https://via.placeholder.com/800x800" class="avatar">
			</div>
			<div class="col-sm-10">
				<h4><b>Group Lorem ipsum</b></h4>
				<p>
					<b>Date:</b> 01/01/2022<br>
					<b>Members:</b> 10<br>
				</p>
				<p>Anim irure sint ullamco tempor consectetur amet occaecat dolor. Fugiat qui proident sint laboris ex exercitation et proident incididunt minim qui Lorem eu proident aliquip aliquip officia. Ut magna consequat enim cillum cupidatat elit dolore ea minim labore ex enim. Est nulla culpa cupidatat anim ex incididunt nulla qui sit in esse velit non. Proident ullamco voluptate nisi anim ex sunt et dolore nulla fugiat Lorem proident duis.</p>
				<ul class="list-inline">
					<li><a data-toggle="collapse" href="#memberCollapse" class="btn btn-default btn-sm">See Members</a></li>
					<li><a href="###-###" class="btn btn-default btn-sm">Contact the admin</a></li>
					<li class="m_t10_m"><a href="###-###" class="btn btn-default btn-sm">Join Group</a></li>
					<!-- if group is yours -->
					<li class="m_t10_m"><a href="/group-create.php" class="btn btn-primary btn-sm"><i class="fas fa-edit m_r5"></i>Edit Group</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div style="height:20px;" class="red_bg m_b20"></div>

<div class="container-fluid collapse" id="memberCollapse">
	<?php include('includes/player_table.php') ?>
</div>

<div class="container">

	<div class="row align">
		<div class="col-lg-1 col-sm-2 col-xs-3">
			<a href="/player-detail.php"><img src="/img/avatar.jpg" class="avatar"></a>
		</div>
		<div class="col-sm-8 col-xs-9">
			<h4><b>Username lorem ipsum</b></h4>
			<div class="visible-xs">01/01/2022 - 12:00:00</div>
		</div>
		<div class="col-lg-3 col-sm-2 col-xs-12 text-right hidden-xs">
			01/01/2022 - 12:00:00
		</div>
	</div>
	<div class="row m_t10">
		<div class="col-sm-10 col-sm-offset-1">
			<p>Ad nostrud nostrud quis sint sunt dolor proident sunt tempor cillum esse adipisicing. Et non enim anim culpa occaecat sit ex dolore laborum ullamco duis sint Lorem sit exercitation eiusmod. Cupidatat voluptate dolore est voluptate magna id voluptate cupidatat proident enim aliqua dolor Lorem duis do proident minim.</p>
		</div>
	</div>
	<hr>

	<div class="row align">
		<div class="col-lg-1 col-sm-2 col-xs-3">
			<a href="/player-detail.php"><img src="/img/avatar.jpg" class="avatar"></a>
		</div>
		<div class="col-sm-8 col-xs-9">
			<h4><b>Username lorem ipsum</b></h4>
			<div class="visible-xs">01/01/2022 - 12:00:00</div>
		</div>
		<div class="col-lg-3 col-sm-2 col-xs-12 text-right hidden-xs">
			01/01/2022 - 12:00:00
		</div>
	</div>
	<div class="row m_t10">
		<div class="col-sm-10 col-sm-offset-1">
			<p>Ad nostrud nostrud quis sint sunt dolor proident sunt tempor cillum esse adipisicing. Et non enim anim culpa occaecat sit ex dolore laborum ullamco duis sint Lorem sit exercitation eiusmod. Cupidatat voluptate dolore est voluptate magna id voluptate cupidatat proident enim aliqua dolor Lorem duis do proident minim.</p>
			<img src="https://via.placeholder.com/600x400" style="max-width:600px;">
		</div>
	</div>
	<hr>

	<form id="comment">
		<div class="row m_t40">
			<div class="col-sm-10 col-sm-offset-1 m_b10">
				<label>Leave a Comment</label>
				<div class="m_b10">
					<textarea class="form-control" rows="14"></textarea>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<input type="file" id="uploadImage" class="hidden">
						<label for="uploadImage" class="btn btn-default m_b10">Upload Image</label>
					</div>
					<div class="col-sm-6 text-right">
						<button type="submit" class="btn btn-default">SEND</button>
					</div>
				</div>
			</div>
		</div>
	</form>

</div>

<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
