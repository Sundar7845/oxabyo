<?php include('includes/head.php') ?>
<?php include('includes/g_header.php') ?>

<div class="green_bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h3>CONTACTS</h3>
				<p>Sounds good?<br>Contact us,<br>we are waiting for you!</p>
			</div>
			<div class="col-sm-6 col-sm-offset-3">
				<form>
					<div class="m_b20 p_x20">
						<label>Name</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="m_b20 p_x20">
						<label>Surname*</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="m_b20 p_x20">
						<label>E-mail*</label>
						<input type="email" class="form-control" required>
					</div>
					<div class="m_b20 p_x20">
						<label>Phone</label>
						<input type="text" class="form-control">
					</div>
					<div class="m_b20 p_x20">
						<label>Message*</label>
						<textarea class="form-control" required rows="10"></textarea>
					</div>
					<div class="m_b20 p_x20">
						<input type="checkbox" required>&nbsp;*I accept the <a href="/privacy-policy.php" target="_blank">privacy policy</a>
					</div>
					<div class="m_b20 text-center">
						<button type="submit" class="btn btn-default btn-lg">
							SEND
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php') ?>
<?php include('includes/modal.php') ?>
<?php include('includes/foot.php') ?>
