@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

<form class="profile-form" role="form" method="POST" action="{{ url('admin/save-profile') }}" autocomplete="off" enctype="multipart/form-data">
	{{ csrf_field() }}

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><i class="fas fa-user-edit m_r10"></i>PROFILE</b></h3>
				<h4><b>AVATAR</b></h4>
			</div>
		</div>
		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<img src="{{ Session::get('user_profile_image') ?? url("img/avatar.jpg") }}" id="profile-image" class="avatar" style="height: 100px;" >
			</div>
			
			<div class="col-sm-10 col-xs-12 m_b10">
				<input type="file" id="uploadAvatar" class="hidden" name="file" onchange="document.getElementById('profile-image').src = window.URL.createObjectURL(this.files[0])">
				<label for="uploadAvatar" class="btn btn-default m_b10">Choose your Avatar</label>
	  
			</div>
		</div>
		 
	</div>

	<div class="gray_bg">
		<div class="container p_y20">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="m_b0"><b></b></h4>
					<p></p>
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
						<input type="password" name="password" class="form-control" placeholder="**********">
					</div>
					<div class="m_b10">
						<label>Confirm Password</label>
						<input type="password" name="confirm_password" class="form-control" placeholder="**********">
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
					
				</div>
			</div>


			<div class="m_y40"></div>
			<div class="m_y40">
				<button type="submit" class="btn btn-primary" >Save</button>
			</div>

		</div>
	</div>
</form>

 
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
</div>
<!-- Main content -->
<section class="content">
<div class="container-fluid">

</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
