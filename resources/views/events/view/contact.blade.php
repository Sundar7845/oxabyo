@include('includes/head')
@include('includes/g_header')

<div class="green_bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h3>CONTACTS</h3>
				<p>Sounds good?<br>Contact us,<br>we are waiting for you!</p>
			</div>
			<div class="col-sm-6 col-sm-offset-3">

				<form action="{{ route('contacts') }}" method="POST">

                @csrf
					<div class="m_b20 p_x20">
						<label>Name</label>
						<input type="text" name="name" class="form-control" autocomplete="off" required>
					</div>
					<div class="m_b20 p_x20">
						<label>Surname*</label>
						<input type="text" name="surname" class="form-control" autocomplete="off" required>
					</div>
					<div class="m_b20 p_x20">
						<label>E-mail*</label>
						<input type="email" name="email" class="form-control" autocomplete="off" required>
					</div>
					<div class="m_b20 p_x20">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control" autocomplete="off">
					</div>
					<div class="m_b20 p_x20">
						<label>Message*</label>
						<textarea class="form-control" name="message" autocomplete="off" required rows="10"></textarea>
					</div>
					<div class="m_b20 p_x20">
						<input type="checkbox" required>&nbsp;*I accept the <a href="/privacy" target="_blank">privacy policy</a>
					</div>
					<div class="m_b20 text-center">
						<button type="submit" name="submit" class="btn btn-default btn-lg">
							SEND
						</button>
					</div>
				</form>
               
			</div>
		</div>
	</div>
</div>


@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
