$(document).ready(function () {

    var APP_URL = window.location.origin;

    $("#event_type_id").change(function () {		
        var end = this.value;
		if (end == 2) {
			$(".player-champion-class").removeClass("hidden");
		} else  {
			$(".player-champion-class").addClass("hidden");
		}		 
    });

    $("#player_type_id").change(function () {		
        var end = this.value;
		if (end == 2) {
			$(".e-player-team-class").removeClass("hidden");
			$(".e-player-class").addClass("hidden");
		} else  {
            $(".e-player-class").removeClass("hidden");
			$(".e-player-team-class").addClass("hidden");
		}
    });


    
    $(".invite_admin_submit").click(function () {
        var adminId = $(".inviteEventAdminTable input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        $('.InviteAdminModal').val(adminId);
        $('#InviteAdminModal').modal('hide');

        let currentEventId = $('.currentEventId').val();
        var dataInput = {
            currentEventId: currentEventId,
            inviteEventAdmin: $('.InviteAdminModal').val()
        }
        if (currentEventId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: APP_URL + '/event-invite-custom',
                type: 'POST',
                data: dataInput
            }).done(function (data) {
            });
        }
    });

    $(".invite_player_submit").click(function () {
        var userId = $(".inviteEventPlayerTable input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        $('.InviteEPlayerModal').val(userId);
        $('#InviteEPlayerModal').modal('hide');

        let currentEventId = $('.currentEventId').val();
        var dataInput = {
            currentEventId: currentEventId,
            inviteUsers: $('.InviteEPlayerModal').val()
        }
        if (currentEventId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: APP_URL + '/event-invite-custom',
                type: 'POST',
                data: dataInput
            }).done(function (data) {
            });
        }
    });

    $(".invite_team_player_submit").click(function () {
        var userId = $(".InviteTeamPlayerTable input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        $('.InviteTeamPlayerModal').val(userId);
        $('#InviteTeamPlayerModal').modal('hide');

        let currentEventId = $('.currentEventId').val();
        var dataInput = {
            currentEventId: currentEventId,
            inviteTeamPlayers: $('.InviteTeamPlayerModal').val()
        }
        if (currentEventId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: APP_URL + '/event-invite-custom',
                type: 'POST',
                data: dataInput
            }).done(function (data) {
            });
        }
    });


    $(".invite_champion_submit").click(function () {
        var adminId = $(".inviteEventChampionTable input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        $('.InviteChampionModal').val(adminId);
        $('#InviteChampionModal').modal('hide');

        let currentEventId = $('.currentEventId').val();
        var dataInput = {
            currentEventId: currentEventId,
            inviteChampions: $('.InviteChampionModal').val()
        }
        if (currentEventId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: APP_URL + '/event-invite-custom',
                type: 'POST',
                data: dataInput
            }).done(function (data) {
            });
        }
    });


    $('.winner-list .toggle-class-switch-winner').click(function() {
 
        var id = $(this).data('id');
        var event_id = $(this).data('event_id');

        if ($(this).find('i').hasClass('fa-toggle-off')) {
            $(this).find('i').removeClass('fas fa-toggle-off');
            $(this).find('i').addClass('fas fa-toggle-on');  
        } else {
            $(this).find('i').removeClass('fas fa-toggle-on');
            $(this).find('i').addClass('fas fa-toggle-off');  
        }
        
        //   console.log($(this).parent().parent().find('div').hasClass('challenger1-text-success winners-text-decoration'))
        //  alert($(this).parent().find('span').hasClass('winner-failure-'+id+' hidden'))

        if ($(this).parent().find('span').hasClass('winner-success-'+id+' hidden')) {
            $('.winner-success-'+id).removeClass('hidden'); 
            $('.winner-failure-'+id).addClass('hidden');
        } else {
            $('.winner-failure-'+id).removeClass('hidden'); 
            $('.winner-success-'+id).addClass('hidden'); 
        }

        if ($(this).parent().parent().find('div').hasClass('challenger1-text-success winners-text-decoration')) {
            $(this).parent().parent().find('div#challenger1-text-success').removeClass('winners-text-decoration')
            $(this).parent().parent().find('div#challenger2-text-success').addClass('winners-text-decoration')
         } else if ($(this).parent().parent().find('div').hasClass('challenger2-text-success winners-text-decoration')) {
            $(this).parent().parent().find('div#challenger2-text-success').removeClass('winners-text-decoration')
            $(this).parent().parent().find('div#challenger1-text-success').addClass('winners-text-decoration')
        }
        
        $.ajax({
            url: APP_URL + '/switch-winner/'+ id + '/' + event_id,
            type: "get",
            datatype: "html",
            beforeSend: function () { 
                $('.ajax-loading').show();
            }
        }).done(function (data) { 

            // $('.winner-list').empty();
            // $('.winner-list').append(data);

        });

    })

});
