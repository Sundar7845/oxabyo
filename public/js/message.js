$(document).ready(function () {
    var SITEURL = window.location.origin;

    var interval = 5000;

    $(".group_message_submit").submit(function (event) {
        event.preventDefault();


        let data = ($('.group_message_submit').serialize());


        let id = $('.group_message_custom_id').val();
        let ajaxCall = $('.group_message_ajaxCall').val();
        let group_message = $('.group_message_value').val();
        let file = $('.group_image').val();

        var form_data = new FormData(this)
        // var file_data = $('.group_image').prop('files')[0];

        // form_data.append('file', file_data);
        // form_data.append('ajaxCall', ajaxCall);
        // form_data.append('group_message', group_message);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: SITEURL + '/groups/' + id + '/message',
            type: 'POST',
            data: form_data,
            cache: false,
            processData: false,
            contentType: false,
            end: function () {
                $('.ajax-loading').show();
            }
        }).done(function (data) {
            $('.group_message_value').val('');
            $('.append-groups-message').empty();

            var form = document.getElementById('group_message_submit');
            form.reset();

            $('.append-groups-message').append(data);


        });
    });

    var interval = 7000;

    function doAjax() {

        let id = $('.group_message_custom_id').val();

        $.ajax({
            type: 'GET',
            url: SITEURL + '/group/' + id + '/all-comments',
            success: function (data) {

                $('.append-groups-message').empty();


                $('.append-groups-message').append(data);
            },
            complete: function (data) {
                setTimeout(doAjax, interval);
            }
        });
    }

    if ($(".append-groups-message").length) {
        setTimeout(doAjax, interval);
    }
});
