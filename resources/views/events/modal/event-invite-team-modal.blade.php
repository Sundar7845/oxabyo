<div class="modal fade" id="InviteTeamPlayerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Invite Teams</h4>
            </div>
            <div class="modal-body">
                <div class="text-center m_t20 m_b10">
                    <table class="table table-hover table-responsive table-condensed table-striped InviteTeamPlayerTable"
                        aria-describedby="mydesc">
                        @foreach ($teams as $team)
                            <tr>
                                <td class="text-left"><label for="inviteUsers">{{ $team->name }}</label></td>
                                <td class="text-right"><input id="inviteTeamUsers" name="inviteTeamUsers[]"
                                        value="{{ $team->id }}" type="checkbox"></td>
                            </tr>
                        @endforeach
                    </table>
                    <!-- dismiss modal and send invites -->
                    <button type="submit" class="btn btn-default invite_team_player_submit">Invite</button>
                </div>
            </div>
        </div>
    </div>
</div>
