<div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog">
    {{ csrf_field() }} <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Send Message</h4>
            </div>
            <div class="modal-body">
                <textarea name="private_message" id="private_message" cols="75" rows="10" style="color: black;"></textarea>
                <input type="hidden" class="private_message_custom_id" name="id" value="{{ $player->id }}" />
                <input type="hidden" class="private_message_ajaxCall" name="ajaxCall" value="0" />
            </div>
            <div class="text-center m_t20 m_b10">
                <!-- dismiss modal and show results -->
                <button class="btn btn-default private_message_submit"><em class="fas m_r5"></em>Send</button>
            </div>
        </div>    
    </div>
</div>
