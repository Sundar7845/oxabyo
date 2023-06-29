<div class="modal fade" id="reportContentModal" tabindex="-1" role="dialog">
    <form action="{{ route('users.report-abuse', $player->id) }}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Report Abuse</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to report this content?
                    <div class="text-center m_y20">
                        <a data-dismiss="modal" class="btn btn-default">No, cancel</a>

                        <button type="submit" class="btn btn-danger">Yes, report</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
