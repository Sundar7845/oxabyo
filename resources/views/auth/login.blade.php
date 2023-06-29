@include('includes/head')
@include('includes/g_header')

<div class="container">

	@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
@elseif (session('error'))
	<div class="alert alert-danger">
		{{ session('error') }}
	</div>
@endif

	<div class="row">
		<div class="col-sm-6 l_blue_bg p_y40">
			<h3 class="text-center m_t0"><b>ALREADY SIGNED?<br>LOGIN</b></h3>
			<form action="{{ url('/login') }}" role="form" method="POST" autocomplete="off">

                {{ csrf_field() }}

				<div class="m_b20 p_x20">
					<label>Email</label>
					<input type="text" class="form-control" name='email' required>
				</div>
				<div class="m_b20 p_x20">
					<label>Password</label>
					<input type="password" name='password' class="form-control" required>
				</div>
				<div class="m_b20 p_x20">
					<input type="checkbox">&nbsp;Remember me
				</div>
				<div class="m_b20 text-center">
					<button type="submit" class="btn btn-default">
						LOGIN
					</button>
					<div class="m_t5">
						<a data-toggle="modal" data-target="#recoverModal"><small>Forgot password?</small></a>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-6 red_bg p_y40">
		<form class="reg-form" role="form" method="POST" action="{{ url('/register') }}" autocomplete="off">

            {{ csrf_field() }}

			<div class="text-center">
				<h3 class="m_t0"><b>NEW ON OXABYO?<br>SIGN UP</b></h3>
			</div>
			<div class="m_b20 p_x20">
				<label>Username*</label>
				<input type="text" class="form-control" name='name' required>
			</div>
			<div class="m_b20 p_x20">
				<label>Email*</label>
				<input type="email" class="form-control" name='email' required>
			</div>
			<div class="m_b20 p_x20">
				<label>Confirm Email*</label>
				<input type="email" class="form-control" required>
			</div>
			<div class="m_b20 p_x20">
				<label>Password*</label>
				<input type="password" class="form-control" name='password' pattern=".{8,}"  title="8 characters minimum" required>
			</div>
			<div class="m_b20 p_x20">
				<label>Confirm Password*</label>
				<input type="password" class="form-control" name='password_confirmation' title="8 characters minimum" pattern=".{8,}"  required>
			</div>
			<!-- <div class="m_b20 p_x20">
				<label>Name*</label>
				<input type="text" class="form-control" required>
			</div>
			<div class="m_b20 p_x20">
				<label>Surname*</label>
				<input type="text" class="form-control" required>
			</div>
			<div class="m_b20 p_x20">
				<label>Birth Date</label>
				<input type="date" class="form-control">
			</div>
			<div class="m_b20 p_x20">
				<label>Address</label>
				<input type="text" class="form-control">
			</div>
			<div class="m_b20 p_x20">
				<label>City</label>
				<input type="text" class="form-control">
			</div>
			<div class="m_b20 p_x20">
				<label>Favourite gaming platform</label>
				<select class="form-control">
					<option></option>
				</select>
			</div> -->


			<div class="m_b20 p_x20 text-center">
				<label class="checkbox p_x20">
					<input type="checkbox" required>&nbsp;*I accept the <a href="/privacy" target="_blank">privacy policy</a>
				</label>
			</div>
			<div class="m_b20 text-center">
				<button type="submit" class="btn btn-default">
					REGISTER
				</button>
			</div>
			</form>
		</div>
	</div>
</div>


@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
