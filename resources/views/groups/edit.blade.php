@include('includes/head')
@include('layouts/header')
 @include('groups/Modals/invite-friends')

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif

<form action="{{ route('groups.update', $group->id) }}"  method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	@method('put')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="text-center"><b><i class="fas fa-user-friends m_r10"></i>{{ strtoupper($group->name) }}</b></h3>
				<h4><b>GROUP IMAGE</b></h4>
			</div>
		</div>
		<div class="row align">
			<div class="col-sm-2 col-xs-6 m_b10">
				<img src="{{ $group->group_image ?? url('/img/avatar.jpg')}}" id="group-image" class="avatar" style="height: 162px;">
			</div>
			<div class="col-sm-10 col-xs-12 m_b10">
				<input type="file" id="uploadImage" name="file" class="hidden" onchange="document.getElementById('group-image').src = window.URL.createObjectURL(this.files[0])">
				<label for="uploadImage" class="btn btn-default m_b10">Choose your group Image</label>
				<!-- once choosen -->
				<!-- <label for="uploadImage" class="btn btn-default m_b10">Upload your Team Image</label>
				<a class="btn btn-default m_b10">Delete Team Image/a> -->
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h4 class="m_b0"><strong>GROUP COLOR</strong></h4>
				<p>Choose your Cover color</p>
				<ul class="list-inline color_choose">
				@foreach(array("red_bg"=>'#DC0024',"l_blue_bg"=>'#00CCFF',"yellow_bg"=>'#FFCC00',"pink_bg"=>'#FF339A',"green_bg"=>'#34CC67',"orange_bg"=>'#FF6634',"blue_bg"=>'#0000FE',"purple_bg"=>'#990099') as $keyColor =>$keyValue)
						<li><span class="{{ $keyColor }} team_color"><div data-color_code="{{ $keyValue}}"></div><em class="fas <?php if($group->group_color==$keyValue){echo "fa-check";} ?>"></em></span></li>
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
					<p>Insert your Group info</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="m_b10">
						<label>Name*</label>
						<input type="text" class="form-control" name="name" value="{{ $group->name }}" placeholder="Group Name" required>
					</div>
					<div class="m_b10">
						<label>Description</label>
						<textarea class="form-control" rows="10" name="description"  placeholder="Group Description">{{ $group->description }}</textarea>
					</div>
					<div class="m_b10">
						<label>Games</label>
						<select class="form-control" id="groupGames" name="game_id"required>
							 

							@foreach ($games as $game)
								
									<option value="{{ $game->id }}"  
										@if($group->game_id == $game->id) selected @endif  >{{ $game->name }}</option>
								
							@endforeach
					
						</select>
					</div>
					<input type="hidden" name="group_color" id="teamcolour" value="{{$group->group_color}}" />
				</div>
			</div>
			

			<div class="text-center m_y40">
				<a data-toggle="modal" data-target="#InviteGroupFriendsModal" class="btn btn-default">Invite Friends</a>
			</div>

		</div>
	</div>

	<div class="container-fluid p_t20">

		@include('groups/group_members')
 
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 m_y40 text-center">
				<button type="submit" class="btn btn-default btn-lg">Save</button>
			</div>
		</div>
	</div>

</form>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')