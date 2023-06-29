<?php include('includes/head.php') ?>
<?php include('includes/header.php') ?>

<form>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><i class="fas fa-comments m_r10"></i>YOUR GROUP</b></h3>
				<h4><b>GROUP IMAGE</b></h4>
			</div>
		</div>
		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<img src="img/avatar.jpg" class="avatar">
			</div>
			<div class="col-sm-10 col-xs-12 m_b10">
				<input type="file" id="uploadImage" class="hidden">
				<label for="uploadImage" class="btn btn-default m_b10">Choose your Group Image</label>
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Upload your Group Image</label>
				<a class="btn btn-default m_b10">Delete Group Image/a> -->
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h4 class="m_b0"><b>GROUP COLOR</b></h4>
				<p>Choose your Cover color</p>
				<ul class="list-inline color_choose">
					<li><span class="red_bg"><i class="fas fa-check"></i></span></li>
					<li><span class="l_blue_bg"><i class="fas"></i></span></li>
					<li><span class="yellow_bg"><i class="fas"></i></span></li>
					<li><span class="pink_bg"><i class="fas"></i></span></li>
					<li><span class="green_bg"><i class="fas"></i></span></li>
					<li><span class="orange_bg"><i class="fas"></i></span></li>
					<li><span class="blue_bg"><i class="fas"></i></span></li>
					<li><span class="purple_bg"><i class="fas"></i></span></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="gray_bg">
		<div class="container p_y20">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="m_b0"><b>INFO</b></h4>
					<p>Insert your Group info</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="m_b10">
						<label>Name*</label>
						<input type="text" class="form-control" value="Group Name" required>
					</div>
					<div class="m_b10">
						<label>Description</label>
						<textarea class="form-control" rows="10" placeholder="Group Description"></textarea>
					</div>
					<div class="m_b10">
						<label>Games</label>
						<select class="form-control">
							<option hidden>Choose...</option>
							<option>Game 1</option>
							<option>Game 2</option>
							<option>Game 3</option>
							<option>Game 4</option>
							<option>Game ...</option>
						</select>
					</div>
				</div>
			</div>

			<div class="text-center m_y40">
				<ul class="list-inline m_b0">
					<li>
						<button type="submit" class="btn btn-default">Save</button>
					</li>
					<li>
						<a href="###-###" class="btn btn-default">Invite Friends</a>
					</li>
				</ul>
			</div>

		</div>
	</div>

</form>

<div class="container-fluid p_t20">
	<?php include('includes/player_table2.php') ?>
</div>

<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
