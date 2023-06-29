$(document).ready(function () {
    var SITEURL = window.location.origin;
    var page = 2;

    // Render on Page Load
    load_more(page);

    // Page scroll
    $('#team_list').scroll(function () {
        if ($('#team_list').scrollTop() + $('#team_list').height() >= $('#team_list').height()) {
            console.log("entered scrolling");
            page++;
            load_more(page);
        }
    });

    // Function for getting the Team List Ajax
    function load_more(page) {
        var search = $("#team_name").val();
        var membercount = $("#memberscount option:selected").val();
        let url = SITEURL + "/teams?page=" + page + '&ajaxCall=1'
        if (search) {
            url += '&search=' + search
        }
        if ($.isNumeric(membercount) == true) {
            url += '&membercount=' + membercount
        }

        let team_created_by = $("#team_created_by").is(":checked");
        let team_joined_by = $("#team_joined_by").is(":checked");

        let team_created_by_friends = $("#team_created_by_friends").is(":checked");
        let team_joined_by_friends = $("#team_joined_by_friends").is(":checked");


        if (team_created_by) {
            url += '&team_created_by=' + true
        }
        if (team_joined_by) {
            url += '&team_joined_by=' + true
        }

        if (team_created_by_friends) {
            url += '&team_created_by_friends=' + true
        }
        if (team_joined_by_friends) {
            url += '&team_joined_by_friends=' + true
        }

        console.log("URL" + url);
        $.ajax({
            url: url,
            type: "get",
            datatype: "html",
            beforeSend: function () {
                $('.ajax-loading').show();
            }
        })
            .done(function (data) {
                $('.ajax-loading').hide();
                $('.stickyheader').addClass("fixedheader");
                $('.append-teams-list').append(data);
            });
    }
    $(".team_color").click(function () {
        if ($(this).find('em').hasClass("fa-check") == true) {
            // $("em").removeClass("fa-check");
        }
        else {
            $("em").removeClass("fa-check");
            $(this).find('em').addClass("fa-check");
        }
        $("#teamcolour").val($(this).find('div').attr("data-color_code"));
    });

    $("#team_filtersearch").click(function () {

        $('.ajax-loading').show();
          fetchFilterResult();
    });

    $("#team_filter_reset").click(function () {
        $("#team_name").val('');
        $("#memberscount option:selected").val('');
        $("#team_created_by").prop('checked', false);
        $("#team_joined_by").prop('checked', false);

        $("#team_created_by_friends").prop('checked', false);
        $("#team_joined_by_friends").prop('checked', false);

        fetchFilterResult();
    });

    $('#team_created_by').change(function () {
        $('#team_created_by').val(this.checked);
        fetchFilterResult();
    });

    $('#team_joined_by').change(function () {
        $('#team_joined_by').val(this.checked);
        fetchFilterResult();
    });

    function fetchFilterResult() {
        var filterurl = SITEURL + "/teams?page=1&ajaxCall=1"
        $('.append-teams-list').empty();
        var search = $("#team_name").val();
        var membercount = $("#memberscount option:selected").val();
        let team_created_by = $("#team_created_by").is(":checked");
        let team_joined_by = $("#team_joined_by").is(":checked");

        let team_created_by_friends = $("#team_created_by_friends").is(":checked");
        let team_joined_by_friends = $("#team_joined_by_friends").is(":checked");

        
        if (search) {
            filterurl += '&search=' + search
        }
        if ($.isNumeric(membercount) == true) {
            filterurl += '&membercount=' + membercount
        }
        if (team_created_by) {
            filterurl += '&team_created_by=' + true
        }
        if (team_joined_by) {
            filterurl += '&team_joined_by=' + true
        }

        if (team_created_by_friends) {
            filterurl += '&team_created_by_friends=' + true
        }
        if (team_joined_by_friends) {
            filterurl += '&team_joined_by_friends=' + true
        }

        console.log("filterurl" + filterurl);
        $.ajax({
            url: filterurl,
            type: "get",
            datatype: "html",
            beforeSend: function () {
                $("#searchTeamModal .close").click();
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            $('.ajax-loading').hide();
            $('.stickyheader').addClass("fixedheader");
            $('.append-teams-list').append(data);

            load_more(2)
        });
    };

    $(".teamAdminClass").click(function () {
            let id = $(this).data("id")
            let APP_URL = '';
            if ($(this).hasClass('removeAdmin')) {
                APP_URL = SITEURL + '/teams/'+id+'/removeAdmin'
                $(this).removeClass('removeAdmin'); 
                $(this).addClass("addAdmin");            
                $(this).find('i').removeClass('fal fa-crown')
                $(this).find('i').addClass('fas fa-crown');    
                $(this).attr('data-original-title', 'ADD TO ADMIN');

            } else {
                APP_URL = SITEURL + '/teams/'+id+'/addAdmin'
                $(this).removeClass('addAdmin');
                $(this).addClass("removeAdmin");                
                $(this).find('i').removeClass('fas fa-crown');
                $(this).find('i').addClass('fal fa-crown');    
                $(this).attr('data-original-title','REMOVE FROM ADMIN')
            }           
            $.ajax({
                url: APP_URL,
                type: "get",end: function () {
                    $('.ajax-loading').show();            
                }
            }).done(function (data) {
                
             });
        });

    $(".teamBanClass").click(function () {
        let id = $(this).data("id")
        let APP_URL = '';
        if ($(this).hasClass('banAdmin')) {
            APP_URL = SITEURL + '/teams/'+id+'/ban-member'
            $(this).removeClass('banAdmin'); 
            $(this).addClass("unbanAdmin");            
            $(this).find('i').removeClass('fas fa-user-slash')
            $(this).find('i').addClass('fal fa-user');    
            $(this).attr('data-original-title', 'UNBAN USER FROM TEAM');

        } else {
            APP_URL = SITEURL + '/teams/'+id+'/unban-member'
            $(this).removeClass('unbanAdmin');
            $(this).addClass("banAdmin");                
            $(this).find('i').removeClass('fal fa-user');
            $(this).find('i').addClass('fas fa-user-slash');    
            $(this).attr('data-original-title','BAN USER FROM TEAM')
        }           
        $.ajax({
            url: APP_URL,
            type: "get",end: function () {
                $('.ajax-loading').show();            
            }
        }).done(function (data) {
            
            });
    });
});
