
@include('includes/head')
@include('layouts/header')
@include('messages/modals/deleteChatModal')

@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif


<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center"><b><i class="fas fa-envelope-open-text m_r10"></i>MESSAGES</b></h3>
		</div>
	</div>
</div>
<div class="container-fluid m_t20">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<table class="table sortable_table">
				<tbody>


					@foreach ($users as $user)

					<tr class="" style="background-color: {{ $user->profile_color ?? '#0000fe' }}">
						<td><img src="{{ $user->profile_image ?? '/img/avatar.jpg' }}" class="avatar m_r10" style="width:60px!important">{{ $user->name }}</td>
						<td>{!! $user->message_body !!}</td>
						<td class="text-right">{{ format_messaging_date($user->created_at) }}</td>
						<td class="text-right">
							<ul class="list-inline m_b0">
								<li><a href="{{ route('message-list.show', $user->id) }}" class="btn btn-icon"><i class="fas fa-play"></i></a></li>
								<li><a class="btn btn-icon deleteChatModalClick" data-toggle="modal" data-target="#deleteChatModal" data-id="{{ $user->id }}"  ><i class="fas fa-times"></i></a></li>
							</ul>
						</td>
					</tr>
						
					@endforeach

					


					
				</tbody>
			</table>
		</div>
	</div>

</div>

<script>
	$(document).on('click', '.deleteChatModalClick', function () {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteChatModal').modal('show');
	
    })
	</script>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
