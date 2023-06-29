$(document).ready(function () {
    var SITEURL = window.location.origin;

    /**
     * Jquery for Connect and Unconnect the user
     */
    $(".userToFriends").click(function () {
        let id = $(this).data("id")  
        let APP_URL = '';
        if ($(this).hasClass('connectFriends')) {
            APP_URL = SITEURL + '/users/' + id + '/connect'
            $(this).removeClass('connectFriends');
            $(this).addClass("pendingConnection");
            $(this).attr('data-target', '');
            $(this).text("Pending Connection");
            $.ajax({
                url: APP_URL,
                type: "get", end: function () {
                    $('.ajax-loading').show();
                }
            }).done(function (data) {    
            });
        } 
        // else {
        //     $(this).removeClass('unconnectFriends');
        //     $(this).addClass("connectFriends");
        //     $(this).attr('data-target', '#unconnectUserModal');
        // }

    });

    /**
     * Jquery for like and unlike users
     */
    $(".userLikeAction").click(function () {
        let id = $(this).data("id")  
        let APP_URL = '';

        if ($(this).hasClass('likeUser')) {
            APP_URL = SITEURL + '/users/' + id + '/like'
            $(this).removeClass('likeUser');
            $(this).addClass("unlikeUser");
            $(this).text("Unlike");
            
        } 
        else {
            APP_URL = SITEURL + '/users/' + id + '/un-like';
            $(this).removeClass('unlikeUser');
            $(this).addClass("likeUser");
            $(this).text("Like");
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
