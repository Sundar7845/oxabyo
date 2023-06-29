$(document).ready(function () {
    var SITEURL = window.location.origin;
    var page = 2;

    $("#group_filtersearch").click(function () {

        $('.ajax-loading').show();
        fetchFilterResult();
    });
    $("#group_filter_reset").click(function () {
        $("#group_name").val('');
        $("#group_created_by").prop('checked', false);
        $("#group_joined_by").prop('checked', false);

        $("#group_created_by_friends").prop('checked', false);
        $("#group_joined_by_friends").prop('checked', false);

        fetchFilterResult();
    });

    $('#group_created_by').change(function () {
        $('#group_created_by').val(this.checked);
        fetchFilterResult();
    });

    $('#group_joined_by').change(function () {
        $('#group_joined_by').val(this.checked);
        fetchFilterResult();
    });

    function fetchFilterResult() {
        var filterurl = SITEURL + "/groups?page=1&ajaxCall=1"
        $('.append-groups-list').empty();
        var search = $("#group_name").val();
        var membercount = $("#memberscount option:selected").val();
        let group_created_by = $("#group_created_by").is(":checked");
        let group_joined_by = $("#group_joined_by").is(":checked");

        let group_created_by_friends = $("#group_created_by_friends").is(":checked");
        let group_joined_by_friends = $("#group_joined_by_friends").is(":checked");


        if (search) {
            filterurl += '&search=' + search
        }
        if ($.isNumeric(membercount) == true) {
            filterurl += '&membercount=' + membercount
        }
        if (group_created_by) {
            filterurl += '&group_created_by=' + true
        }
        if (group_joined_by) {
            filterurl += '&group_joined_by=' + true
        }

        if (group_created_by_friends) {
            filterurl += '&group_created_by_friends=' + true
        }
        if (group_joined_by_friends) {
            filterurl += '&group_joined_by_friends=' + true
        }

        console.log("filterurl" + filterurl);
        $.ajax({
            url: filterurl,
            type: "get",
            datatype: "html",
            beforeSend: function () {
                $("#searchGroupModal .close").click();
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            $('.ajax-loading').hide();
            $('.stickyheader').addClass("fixedheader");
            $('.append-groups-list').append(data);

        });
    };

    $(".groupAdminClass").click(function () {
        let id = $(this).data("id")
        let APP_URL = '';
        if ($(this).hasClass('removeAdmin')) {
            APP_URL = SITEURL + '/groups/' + id + '/removeAdmin'
            $(this).removeClass('removeAdmin');
            $(this).addClass("addAdmin");
            $(this).find('i').removeClass('fal fa-crown')
            $(this).find('i').addClass('fas fa-crown');
            $(this).attr('data-original-title', 'ADD TO ADMIN');

        } else {
            APP_URL = SITEURL + '/groups/' + id + '/addAdmin'
            $(this).removeClass('addAdmin');
            $(this).addClass("removeAdmin");
            $(this).find('i').removeClass('fas fa-crown');
            $(this).find('i').addClass('fal fa-crown');
            $(this).attr('data-original-title', 'REMOVE FROM ADMIN')
        }
        $.ajax({
            url: APP_URL,
            type: "get", end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {

        });
    });

    $(".groupBanClass").click(function () {
        let id = $(this).data("id")
        let APP_URL = '';
        if ($(this).hasClass('banAdmin')) {
            APP_URL = SITEURL + '/groups/' + id + '/ban-member'
            $(this).removeClass('banAdmin');
            $(this).addClass("unbanAdmin");
            $(this).find('i').removeClass('fas fa-user-slash')
            $(this).find('i').addClass('fal fa-user');
            $(this).attr('data-original-title', 'UNBAN USER FROM GROUP');

        } else {
            APP_URL = SITEURL + '/groups/' + id + '/unban-member'
            $(this).removeClass('unbanAdmin');
            $(this).addClass("banAdmin");
            $(this).find('i').removeClass('fal fa-user');
            $(this).find('i').addClass('fas fa-user-slash');
            $(this).attr('data-original-title', 'BAN USER FROM GROUP')
        }
        $.ajax({
            url: APP_URL,
            type: "get", end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {

        });
    });

});

