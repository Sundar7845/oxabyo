@include('includes/head')
@include('layouts/header')

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif

<form class="profile-form" role="form" method="POST" action="{{ url('/profile') }}" autocomplete="off" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><strong><em class="fas fa-user-edit m_r10"></em>PROFILE</strong></h3>
				<h4><strong>AVATAR</strong></h4>
			</div>
		</div>
		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<img src="{{ Session::get('user_profile_image') ?? url('/img/avatar.jpg') }}" class="avatar" id="profile-image" alt="">
			</div>
			<div class="col-sm-10 col-xs-12 m_b10">
				<input type="file" id="uploadAvatar" class="hidden" name="file" onchange="document.getElementById('profile-image').src = window.URL.createObjectURL(this.files[0])">
				<label for="uploadAvatar" class="btn btn-default m_b10">Choose your Avatar</label>
			
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h4 class="m_b0"><strong>YOUR COLOR</strong></h4>
				<p>Choose your Cover color</p>
				<ul class="list-inline color_choose">
				@foreach(array("red_bg"=>'#DC0024',"l_blue_bg"=>'#00CCFF',"yellow_bg"=>'#FFCC00',"pink_bg"=>'#FF339A',"green_bg"=>'#34CC67',"orange_bg"=>'#FF6634',"blue_bg"=>'#0000FE',"purple_bg"=>'#990099') as $keyColor =>$keyValue)
						<li><span class="{{ $keyColor }} team_color"><div data-color_code="{{ $keyValue}}"></div><em class="fas <?php if($user->profile_color==$keyValue){echo "fa-check";} ?>"></em></span></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>

	<div class="gray_bg">
		<div class="container p_y20">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="m_b0"><strong>INFO</strong></h4>
					<p>Insert your personal info</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-2">
					<div class="m_b10">
						<label>Username*</label>
						<input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
					</div>
					<div class="m_b10">
						<label>Email*</label>
						<input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
					</div>
					<div class="m_b10">
						<label>Confirm Email*</label>
						<input type="email" class="form-control" name="confirm_email" value="{{ $user->email }}" required>
					</div>
					<div class="m_b10">
						<label>Password</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="m_b10">
						<label>Confirm Password</label>
						<input type="password" name="confirm_password" class="form-control">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="m_b10">
						<label>Name*</label>
						<input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
					</div>
					<div class="m_b10">
						<label>Surname*</label>
						<input type="text" class="form-control" name="surename" value="{{ $user->surename }}" required>
					</div>
					<div class="m_b10">
						<label>Birth Date</label>
						<input type="date" class="form-control" name="dob" value="{{ $user->dob }}" >
					</div>
					<div class="m_b10">
						<label>Address</label>
						<input type="text" class="form-control" name="address" value = "{{ $user->address }}">
					</div>
					<div class="m_b10">
						<label>City</label>
						<input type="text" class="form-control" name="city" value = "{{ $user->city }}">
					</div>
					<div class="m_b10">
						<label>Favourite gaming platform</label>
						<select class="form-control">
							<option></option>
						</select>
					</div>
				</div>
			</div>
			<input type="hidden" name="profile_color" id="teamcolour" value="{{$user->profile_color}}"/>
			<div class="row">
				<div class="col-sm-12">
					<h4 class="m_b0"><strong>BIO</strong></h4>
					<p>Insert your Bio</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="m_b10">
						<label>Your BIO*</label>
						<textarea class="form-control" name="bio_data" value="Username" rows="12">{{ $user->bio_data }}</textarea>
					</div>
				</div>
			</div>

			<div class="text-center m_y40">
				<button type="submit" class="btn btn-default">Save</button>
			</div>

		</div>
	</div>
</form>

<div style="background-color:#469bdb" class="white">
	<div class="container p_y20">
		<div class="row">
			<div class="col-sm-3">
				<img src="/img/paypal.png" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4><strong>PAYPAL ACCOUNT</strong></h4>
				<p>Connect your PayPal account to receive the money earned thanks to your activities on OXABYO</p>
				<form>
					<label>PayPal Account Email</label>
					<div class="row">
						<div class="col-sm-4 m_b10">
							<input type="email" class="form-control">
						</div>
						<div class="col-sm-4 m_b10">
							<button type="submit" class="btn btn-default">CONNECT</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div style="background-color:#9147ff" class="white">
	<div class="container p_y20">
		<div class="row">
			<div class="col-sm-3">
				<img src="/img/twitch.png" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4><strong>TWITCH ACCOUNT</strong></h4>
				<p>Connect your Twitch account to integrate your streaming sessions into OXABYO and make them available to all users of the platform, increasing your viewers.</p>

				<form class="twitch-form" role="form" method="POST" action="{{ route('twitch.user') }}" 
					autocomplete="off" enctype="multipart/form-data">
					{{ csrf_field() }}
					<label>Twitch Account Username</label>
					<div class="row">
						<div class="col-sm-4 m_b10">
							<input type="text" class="form-control" name="twitch_username" value="{{ $twitch->twitch_login ?? ''}}">
						</div>
						<div class="col-sm-4 m_b10">
							<button type="submit" class="btn btn-default">CONNECT</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x600" alt="">
		</div>
	</div>
</div>


@include('includes/footer')
@include('includes/modal')
@include('includes/foot')