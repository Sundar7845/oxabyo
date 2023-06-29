$(document).ready(function () {
    var SITEURL = window.location.origin;
    // Status checker api call for every one seconds
    var interval = 5000;
    function doAjax() {
        let id = $('.private_message_custom_id').val();
        let lastMessageId = $('.lastMessageId').last().val();
        $.ajax({
            type: 'GET',
            url: SITEURL + '/message-list/' + id + '?ajaxCall=true&lastMessageId=' + lastMessageId,
            success: function (data) {
                $('.append-message-list-single').append(data);
            },
            complete: function (data) {
                setTimeout(doAjax, interval);
            }
        });
    }
    if ($(".append-message-list").length) {
        setTimeout(doAjax, interval);
    }
    $(".private_message_submit").click(function () {
        let id = $('.private_message_custom_id').val();
        let ajaxCall = $('.private_message_ajaxCall').val();

        console.log(document.querySelector('#private_message_ifr'))

        let private_message = document.querySelector('#private_message_ifr').contentWindow.document.body.firstChild.innerHTML;
        var dataInput = {
            private_message: private_message,
            ajaxCall: ajaxCall
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: SITEURL + '/users/' + id + '/send-message',
            type: 'POST',
            data: dataInput,
            end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            document.querySelector('#private_message_ifr').contentWindow.document.body.innerHTML = '';
            $('.append-message-list').empty();
            $('.append-message-list').append(data);
            $('#sendMessageModal').modal('hide');
            $('div.flash-message').html('<div class="alert alert-success" >Message sent successfully</div>');
            setTimeout(function () {
                $('div.flash-message').fadeOut('fast');
            }, 5000);
        });
    });
});
