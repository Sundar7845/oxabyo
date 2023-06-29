<?php include('includes/head.php') ?>
<?php include('includes/header.php') ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-comments m_r10"></i>GROUPS</b></h3>
			<div class="row">
				<div class="col-sm-4 m_y20">
					<form>
						<ul class="list-inline m_b0">
							<li>
								<input type="checkbox"> Created
							</li>
							<li>
								<input type="checkbox"> Joined
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
							<a data-toggle="modal" data-target="#searchGroupModal" class="btn btn-default"><i class="fa fa-search m_r5"></i>SEARCH GROUP</a>
						</li>
						<li class="m_t10_m">
							<a href="/group-create.php" class="btn btn-primary"><i class="fa fa-comments m_r5"></i>CREATE GROUP</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
	<?php include('includes/group_table.php') ?>
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
