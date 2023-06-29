$(document).ready(function () {

    var SITEURL = window.location.origin;

    var interval = 5000;

    function doAjax() {

        let id = $('.event_id').val();
        let lastCommentId = $('.lastCommentId').last().val();

        $.ajax({
            type: 'GET',
            url: SITEURL + '/comments/' + id + '?lastCommentId=' + lastCommentId,
            success: function (data) {
                $('.comment-list-single').append(data);
            },
            complete: function (data) {
                setTimeout(doAjax, interval);
            }
        });
    }
    if ($(".comment-list-single").length) {
        setTimeout(doAjax, interval);
    }

    $(".event_comment_submit").click(function () {
        let event_id = $('.event_id').val();
        let comment = $('.event_comment').val();
        let lastCommentId = $('.lastCommentId').last().val();
        if (comment) {
            var dataInput = {
                comment: comment,
                event_id: event_id,
                lastCommentId: lastCommentId
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITEURL + '/comment/store',
                type: 'POST',
                data: dataInput,
                end: function () {
                    $('.ajax-loading').show();
                }
            }).done(function (data) {
                $('.event_comment').val('');
                $('.comment-list-single').append(data);
            });
        }
    });

    $(".event_comment_bby_single_user_submit").click(function () {
        let event_id = $(this).data('event-id');
        let user_id = $(this).data('user-id');
        let comment = $(this).parents(".player_event_comment_class").find("textarea").val();
        let lastCommentId =  $(this).parents(".player_event_comment_class").find('.lastPlayerCommentId').last().val();
        $(this).parents(".player_event_comment_class").find("textarea").val('');

        if (comment) {
            var dataInput = {
                comment: comment,
                event_id: event_id,
                player_id: user_id,
                lastCommentId: lastCommentId
            }
 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITEURL + '/comment/store',
                type: 'POST',
                data: dataInput,
                end: function () {
                    $('.ajax-loading').show();
                }
            }).done(function (data) {
                $('.player_event_comment_append-'+user_id).append(data);
            });
        }    
    });
    
    var interval2 = 10000;


    // Auto refresh messages for all the players list
    function doAjaxForPlayerComments() {

        var children = $('.player_event_comment_class').children();        

        $(children).each(function(index, item) {   

            let id = $('.event_id').val();

            if ($(this).hasClass('player_event_comment_div')) {
                        
                let user_id = $(this).data('user-id');
               
                let lastCommentId = $(this).find('input').last().val();
  
                $.ajax({
                    type: 'GET',
                    url: SITEURL + '/comments/' + id + '?lastCommentId=' + lastCommentId + '&userId=' + user_id,
                    success: function (data) {
                        $('.player_event_comment_append-'+user_id).append(data);
                    },
                    complete: function (data) {
                    }
                });
            }
        });  

        setTimeout(doAjaxForPlayerComments, interval2);
    }

    if ($(".player_event_comment_class").length) {
        setTimeout(doAjaxForPlayerComments, interval2);
    }
});
