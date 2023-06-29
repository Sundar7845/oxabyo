@include('includes/head')
@include('layouts/header')

@include('teams/modal/unconnect')
@include('teams/modal/block-user')
@include('teams/modal/unblock-user')
@include('messages/modals/reportContentModal')
@include('messages/modals/deleteChatModal')

<link rel="stylesheet" href={{ url('css/chat.css') }}>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container-fluid m_t20">
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table class="table sortable_table">
                <tbody>
                    <tr class="" style="background-color: {{ $player->profile_color ?? '#0000fe' }}">
                        <td><img src="{{ $player->profile_image ?? '/img/avatar.jpg' }}" class="avatar m_r10"
                                style="width:60px!important">{{ $player->name }}</td>
                        <td class="text-right">
                            <ul class="list-inline m_b0">
                                @if ($userFriend && !$userFriend->is_connected && !$userFriend->status)
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="PENDING CONNECTION">
                                            <a href="#" class="btn btn-icon"><i class="fal fa-user-plus"></i></a>
                                        </div>
                                    </li>
                                @elseif ($userFriend && !$userFriend->is_connected)
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="ADD FRIEND">
                                            <a href="{{ route('users.add-friend', $player->id) }}"
                                                class="btn btn-icon"><i class="fas fa-user-plus"></i></a>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="REMOVE FRIEND">
                                            <a data-toggle="modal" data-target="#unconnectUserModal"
                                                class="btn btn-icon"><i class="fas fa-user-minus"></i></a>
                                        </div>
                                    </li>
                                @endif
                                @if ($userFriend && !$userFriend->is_abuse)
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="REPORT ABUSE">
                                            <a data-toggle="modal" data-target="#reportContentModal"
                                                class="btn btn-icon"><i class="fas fa-minus-circle"></i></a>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="ABUSED">
                                            <a class="btn btn-icon"><i class="fal fa-minus-circle"></i></a>
                                        </div>
                                    </li>
                                @endif

                                @if ($userFriend && !$userFriend->is_blocked)
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="BLOCK E-PLAYER">
                                            <a data-toggle="modal" data-target="#block-UserModal"
                                                class="btn btn-icon"><i class="fas fa-user-slash"></i></a>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div data-toggle="tooltip" data-placement="top" data-container="body"
                                            data-original-title="UNBLOCK E-PLAYER">
                                            <a data-toggle="modal" data-target="#unblock-UserModal"
                                                class="btn btn-icon"><i class="fas fa-user"></i></a>
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    <div data-toggle="tooltip" data-placement="top" data-container="body"
                                        data-original-title="BACK TO MESSAGES">
                                        <a href="{{ route('message-list.index') }}" class="btn btn-icon"><i
                                                class="fas fa-play"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <div data-toggle="tooltip" data-placement="top" data-container="body"
                                        data-original-title="DELETE THIS CHAT">
                                        <a data-toggle="modal" data-target="#deleteChatModal" class="btn btn-icon"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('messages/chat')
<div class="container">
    <div class="row m_t40">
        <div class="col-sm-12 m_b10">
            <label>Write Message</label>
            <div class="m_b10">
                <textarea class="form-control" rows="14" name="private_message" id="private_message"></textarea>
                <input type="hidden" class="private_message_custom_id" name="id" value="{{ $player->id }}" />
                <input type="hidden" class="private_message_ajaxCall" name="ajaxCall" value="1" />
            </div>
            <div class="text-right">
                <button class="btn btn-default private_message_submit">SEND</button>
            </div>
        </div>
    </div>
</div>

<style>
.chat-bubble {
    background: {{ $player->profile_color ?? '#cc5e56' }}
}
.chat-bubble--left:after {
    border-right-color: {{ $player->profile_color ?? '#cc5e56' }}
}
.chat-bubble--right:after {
    border-left-color: {{ Auth()->user()->profile_color ?? '#74b9ff' }}
}
.offset-md-9 .chat-bubble {
    background: {{ Auth()->user()->profile_color ?? '#74b9ff' }}
}
</style>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
