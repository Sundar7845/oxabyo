<div class="modal fade" id="EventRulesModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><em class="fas fa-user-friends m_r5"></em>Event Rules</h4>
			</div>
			<div class="modal-body">
				<p>{{ $event->rules ?? '' }}</p>
			</div>
		</div>
	</div>
</div>