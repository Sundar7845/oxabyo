$(document).ready(function () {
    var SITEURL = window.location.origin;
    if ($("#event_search_form").length > 0) {
        $(".event_search_form").submit(function (event) {
            event.preventDefault();
            fetchFilterResult($('.event_search_form').serialize());
        });
        $(".event_filter_reset").click(function () {
            // Reset the current form
            var form = document.getElementById('event_search_form');
                form.reset();
            fetchFilterResult({});
        });
        $('.event_filter_checkbox').change(function () {
            let event_created_by = $('.event_created_by').is(":checked");
            let event_joined_by = $('.event_joined_by').is(":checked");
            fetchFilterResult({
                event_created_by: event_created_by,
                event_joined_by: event_joined_by
            });
        });
        function fetchFilterResult(data) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITEURL + "/events/search",
                type: 'POST',
                data: data,
                // datatype: "html",
                beforeSend: function () {
                    $("#searchEventModal .close").click();
                    $('.ajax-loading').show();
                }
            }).done(function (data) {
                $('.event_table_append').empty();
                $('.ajax-loading').hide();
                $('.stickyheader').addClass("fixedheader");
                $('.event_table_append').append(data);
            });
        };
    }
});
