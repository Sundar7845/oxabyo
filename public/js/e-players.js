$(document).ready(function () {

    var SITEURL = window.location.origin;

    $("#e_player_filtersearch").click(function () {
        $('.ajax-loading').show();
        fetchFilterResult();         
    });

    $("#e_player_filter_reset").click(function () {

        $("#player_name").val('');
        $("#player_friends_only").prop('checked', false);
        $("#player_friends_only1").prop('checked', false);

        fetchFilterResult();
    });
    
    $('#player_friends_only1').change(function () {
        $('#player_friends_only1').val(this.checked);
        fetchFilterResult();
    });

    function fetchFilterResult() {
        var filterurl = SITEURL + "/player-list?&ajaxCall=1"
        $('.append-player-list').empty();

        var search = $("#player_name").val();
        let player_friends_only = $("#player_friends_only").is(":checked");
        player_friends_only = player_friends_only ? player_friends_only : $("#player_friends_only1").is(":checked");

        
        if (search) {
            filterurl += '&search=' + search
        }
         
        if (player_friends_only) {
            filterurl += '&player_friends_only=' + true
        }

        $.ajax({
            url: filterurl,
            type: "get",
            datatype: "html",
            beforeSend: function () {
                $("#searchPlayerModal .close").click();
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            $('.ajax-loading').hide();
            $('.stickyheader').addClass("fixedheader");
            $('.append-player-list').append(data);
        });
    };
});
