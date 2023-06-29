@include('includes/head')
@include('layouts/header')

@if (session('subscription-alert-model'))
    <div class="modal" tabindex="-1" role="dialog" id="success_alert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <div class="submission-notes">
                        <span class="note-text">{{ session('subscription-alert-model') }} </span>
                        <form class="js-passnote-form">

                            <div class="text-right">

                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="shadow_v p_y20" style="background-color: {{$group->group_color}}">
    <div class="container">
        <div class="row align">
            <div class="col-sm-2 m_y10 text-center">
                <img src="{{ $group->group_image ?? "https://via.placeholder.com/800x800" }}" class="avatar" style="height: 162px;">
            </div>
            <div class="col-sm-10">
                <h4><b>{{ $group->name }}</b></h4>
                <p>
                    <b>Date:</b>{{ date_format($group->created_at,"d/m/Y") }}<br>
                    <b>Members:</b><br>
                    @php
					$my_string = '';
						foreach($members as $member)
						{
							$my_string = $my_string .  $member->members .',';
						 
						}
					@endphp

					{{ rtrim($my_string, ',') }}
                </p>
                <p>{{ $group->description }}</p>
                <ul class="list-inline">
                    <li><a data-toggle="collapse" href="#memberCollapse" class="btn btn-default btn-sm">See Members</a>
                    </li>
                    @if($isContactAdminVisible)
                    <li><a href="{{ route('users.player-detail', $group->group_admin_id) }}" class="btn btn-default btn-sm">Contact the admin</a></li>
                    @endif
                    @if($isJoinButtonVisible)
                    <li class="m_t10_m"><a href="{{ route('groups.join', $group->id)}}" class="btn btn-default btn-sm">Join Group</a></li>
                    @endif
                    <!-- if group is yours -->
                   @if($isEditButtonVisible)
                    <li class="m_t10_m"><a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-edit m_r5"></i>Edit Group</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="height:20px;" class="red_bg m_b20"></div>

<div class="container-fluid collapse" id="memberCollapse">
    @include('groups/group_members')
</div>
@if($isEnableSendComment)
<div class="container append-groups-message">
   @include('groups/message')
</div>

<div class="row m_t40">

            <form  action="javascript:void(0)"
                class="group_message_submit" 
                id="group_message_submit" 
                name="group_message_submit"
                method="POST"
                enctype="multipart/form-data"
                >

            <div class="col-sm-10 col-sm-offset-1 m_b10">
                <label>Leave a Comment</label>
                <div class="m_b10">
                    <textarea class="form-control group_message_value" name="group_message" rows="14" id="group_message"></textarea>
                    <input type="hidden" class="group_message_custom_id" name="id" value="{{ $group->id }}" />
                    <input type="hidden" class="group_message_ajaxCall" name="ajaxCall" value="1" />
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="file" id="uploadImage" name="file" class="hidden group_image" onchange="document.getElementById('group_image').src = window.URL.createObjectURL(this.files[0])">
                        <label for="uploadImage" id="group_image" class="btn btn-default m_b10 group_image_submit">Upload Image</label>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="submit" class="btn btn-default group_message_submit">SEND</button> 
                    </div>
                </div>
            </div>

            </form>

        </div>
@endif
</div>

@include('includes/footer') 
@include('includes/modal') 
@include('includes/foot') 