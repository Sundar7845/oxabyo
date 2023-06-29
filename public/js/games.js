$(document).ready(function () {

    var SITEURL = window.location.origin;

    $(".game_played").click(function () {
        let id = $(this).data("id");

        if ($(this).hasClass('game-played-first-' + id)) {
            $('.game-played-first-' + id).addClass('hidden');
            $('.game-played-second-' + id).removeClass('hidden');
        }
        else {
            $('.game-played-second-' + id).addClass('hidden');
            $('.game-played-first-' + id).removeClass('hidden');
        }

        $.ajax({
            url: APP_URL = SITEURL + '/games/played/' + id,
            type: "get", end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {
        });

    });

    $(".game_play").click(function () {
        let id = $(this).data('id');

        if ($(this).hasClass('game-played-first')) {
            $('.game-played-first').addClass('hidden');
            $('.game-played-second').removeClass('hidden');
        }
        else {
            $('.game-played-second').addClass('hidden');
            $('.game-played-first').removeClass('hidden');
        }

        $.ajax({
            url: APP_URL = SITEURL + '/games/played/' + id,
            type: "get", end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {
        });
    })

    $("#game_filtersearch").click(function () {
        $('.ajax-loading').show();
        fetchFilterResult();
    });
    $("#game_filter_reset").click(function () {
        $("#game_name").val('');
        $("#categories option:selected").val('');
        $("#game_played_by_me").prop('checked', false);
        $("#game_played_friends").prop('checked', false);
        $("#game_played_event").prop('checked', false);
        $("#game_played_by").prop('checked', false);
        fetchFilterResult();
    });
    $('#game_played_by_me').change(function () {
        $('#game_played_by_me').val(this.checked);
        fetchFilterResult();
    });
    $('#game_played_event').change(function () {
        $('#game_played_event').val(this.checked);
        fetchFilterResult();
    });
    $('#game_played_friends').change(function () {
        $('#game_played_friends').val(this.checked);
        fetchFilterResult();
    });
    $('#game_played_by').change(function () {
        $('#game_played_by').val(this.checked);
        fetchFilterResult();
    });
    function fetchFilterResult() {
        var filterurl = SITEURL + "/games?ajaxCall=1"
        $('#append_games_list').empty();
        var search = $("#game_name").val();
        var category = $("#categories option:selected").val();
        let game_played_by_me = $("#game_played_by_me").is(":checked");
        let game_played_friends = $("#game_played_friends").is(":checked");
        let game_played_event = $("#game_played_event").is(":checked");
        let game_played_by = $("#game_played_by").is(":checked");
        if (search) {
            filterurl += '&search=' + search;
        }
        if (category && category != 'Category') {
            filterurl += '&categories=' + category;
        }
        if (game_played_event) {
            filterurl += '&game_played_event_by=' + true;
        }
        if (game_played_by_me) {
            filterurl += '&game_played_by_me=' + true;
        }
        if (game_played_friends) {
            filterurl += '&game_played_friends=' + true;
        }
        if (game_played_by) {
            filterurl += '&game_played_by=' + true;
        }
        console.log("filterurl" + filterurl);
        $.ajax({
            url: filterurl,
            type: "get",
            datatype: "html",
            beforeSend: function () {
                $("#searchGameModal .close").click();
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            $('.ajax-loading').hide();
            $('#append_games_list').empty().append(data);
        });
    };
});
