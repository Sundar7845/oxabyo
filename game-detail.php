<?php include('includes/head.php') ?>
<?php include('includes/header.php') ?>

<div class="shadow_v p_y20" style="background-image:url('https://via.placeholder.com/1920x1080/aaaaaa');background-size:cover;background-position:center top">
	<div class="container">
		<div class="row align">
			<div class="col-sm-2 m_y10 text-center">
				<img src="https://via.placeholder.com/800x800" class="avatar">
			</div>
			<div class="col-sm-10">
				<ul class="list-inline text-right">
					<!-- if not played yet -->
					<li><a href="{{ route('teams.create') }}" class="btn btn-default">I PLAYED IT</a></li>
				</ul>
				<h4><b>Game Lorem ipsum</b></h4>
				<p><b>Category:</b> <a href="#" class="white">Category</a> name</p>
				<p class="m_b40">Anim irure sint ullamco tempor consectetur amet occaecat dolor. Fugiat qui proident sint laboris ex exercitation et proident incididunt minim qui Lorem eu proident aliquip aliquip officia. Ut magna consequat enim cillum cupidatat elit dolore ea minim labore ex enim. Est nulla culpa cupidatat anim ex incididunt nulla qui sit in esse velit non. Proident ullamco voluptate nisi anim ex sunt et dolore nulla fugiat Lorem proident duis.</p>
			</div>
		</div>
	</div>
</div>

<div class="red_bg p_y10 text-center"><a href="/game-list.php" class="btn btn-default">BACK TO GAMES</a></div>

<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
