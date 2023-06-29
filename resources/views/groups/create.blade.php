@include('includes/head')
@include('layouts/header')

<form name="creategroup" action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center"><b><i class="fas fa-comments m_r10"></i>YOUR GROUP</b></h3>
                <h4><b>GROUP IMAGE</b></h4>
            </div>
        </div>
        <div class="row align">
            <div class="col-sm-2 col-xs-6 m_b10">
                <img src="{{ $group->group_image ?? url('/img/avatar.jpg') }}" class="avatar" id="group_image" alt="avatar">
            </div>
            <div class="col-sm-10 col-xs-12 m_b10">
                <input type="file"  name="file" id="uploadImage" class="hidden" onchange="document.getElementById('group_image').src = window.URL.createObjectURL(this.files[0])">
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
					<li><span class="red_bg team_color"><div data-color_code="#DC0024"></div><em class="fas fa-check"></em></span></li>
					<li><span class="l_blue_bg team_color"><div data-color_code="#00CCFF"></div><em class="fas"></em></span></li>
					<li><span class="yellow_bg team_color"><div data-color_code="#FFCC00"></div><em class="fas"></em></span></li>
					<li><span class="pink_bg team_color"><div data-color_code="#FF339A"></div><em class="fas"></em></span></li>
					<li><span class="green_bg team_color"><div data-color_code="#34CC67"></div><em class="fas"></em></span></li>
					<li><span class="orange_bg team_color"><div data-color_code="#FF6634"></div><em class="fas"></em></span></li>
					<li><span class="blue_bg team_color"><div data-color_code="#0000FE"></div><em class="fas"></em></span></li>
					<li><span class="purple_bg team_color"><div data-color_code="#990099"></div><em class="fas"></em></span></li>
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
                        <input type="text" class="form-control" name="name" value="" required placeholder="Group Name">
                    </div>
                    <div class="m_b10">
                        <label>Description</label>
                        <textarea class="form-control" rows="10" name="description" placeholder="Group Description"></textarea>
                    </div>
              
                    <div class="m_b10">
						<label>Games</label>
						<select class="form-control" id="groupGames" name="game_id" required>
					

							@foreach ($games as $game)
								<option value="{{ $game->id }}">{{ $game->name }}</option>
							@endforeach
					
						</select>
					</div>

                    <div class="m_b10">
						<label>Members</label>
						<select class="form-control" id="teamUsers" name="groupUsers[]" 
                            multiple="multiple" required>
					

							@foreach ($users as $user)
								<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
					
						</select>
					</div>


                </div>
            </div>
            <input type="hidden" name="group_color" id="teamcolour" value="#DC0024"/>

            <div class="text-center m_y40">
                <ul class="list-inline m_b0">
                    <li>
                        <button type="submit" class="btn btn-default">Save</button>
                    </li>
                    {{-- <li>
                        <a href="" class="btn btn-default">Invite Friends</a>
                    </li> --}}
                </ul>
            </div>

        </div>
    </div>

</form>



 @include('includes/footer') 
  @include('includes/modal') 
 @include('includes/foot') 