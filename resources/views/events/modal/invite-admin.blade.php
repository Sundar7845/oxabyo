<div class="modal fade" id="InviteAdminModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Invite Event Admin</h4>
            </div>
            <div class="modal-body">
                    <div class="text-center m_t20 m_b10">
                        <table class="table table-hover table-responsive table-condensed table-striped inviteEventAdminTable"
                            aria-describedby="mydesc">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-left"><label for="inviteEventAdmin">{{ $user->name }}</label></td>
                                    <td class="text-right"><input id="inviteEventAdmin" name="inviteEventAdmin[]"
                                            value="{{ $user->id }}" type="checkbox"></td>
                                </tr>
                            @endforeach
                        </table>
                        <!-- dismiss modal and send invites -->
                        <button type="submit" class="btn btn-default invite_admin_submit">Invite</button>
                    </div>                 
            </div>
        </div>
    </div>
</div>
