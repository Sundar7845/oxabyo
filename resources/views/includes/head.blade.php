<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>OXABYO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href={{ url('css/normalize.css') }}>
    <link rel="stylesheet" href={{ url('css/bootstrap.min.css') }}>
    <link rel="stylesheet" href={{ url('css/chosen.min.css') }}>
    <link rel="stylesheet" href={{ url('css/owl.carousel.min.css') }}>
    <link rel="stylesheet" href={{ url('css/user.css') }}>
    <link rel="stylesheet" href={{ url('css/style.css') }}>
    <link rel="stylesheet" href={{ url('css/all.min.css') }}>
    <link rel="stylesheet" href={{ url('css/animate.css') }}>
    <link rel="stylesheet" href={{ url('css/pricing.css') }} >
    <link rel="stylesheet" href={{ url('css/wallet.css') }}>

    <link rel="stylesheet" href={{ url('css/summernote.min.css') }}>
    <link rel="shortcut icon" href={{ url('img/favicon.ico') }}>
    <link rel="apple-touch-icon" href={{ url('img/apple-touch-icon.png') }} />
    <script src={{ url('js/jquery-3.5.1.min.js') }}></script>
    <script src={{ url('js/bootstrap.min.js') }}></script>
    <script src={{ url('js/owl.carousel.min.js') }}></script>
    <script src={{ url('js/chosen.jquery.min.js') }}></script>
    <script src={{ url('js/summernote.min.js') }}></script>
    <script src={{ url('js/ResizeSensor.min.js') }}></script>
    <script src={{ url('js/jquery.viewportchecker.js') }}></script>
    <script src={{ url('js/placeholders.min.js') }}></script>
    <script src={{ url('js/jquery.touchSwipe.min.js') }}></script>
    <script src={{ url('js/custom.js') }}></script>
    <script src={{ url('js/team.js') }}></script>
    <script src={{ url('js/e-players.js') }}></script>
    <script src={{ url('js/send-message.js') }}></script>
    <script src={{ url('js/group.js') }}></script>
     <script src={{ url('js/message.js') }}></script>

    <script src={{ url('js/user-interaction.js') }}></script>
    <script src={{ url('js/event-interaction.js') }}></script>
    <script src={{ url('js/comments.js') }}></script>
    <script src={{ url('js/event.js') }}></script>
    <script src={{ url('js/games.js') }}></script>    

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.css" />
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#teamGames').select2({
                placeholder: 'Select Games',
                width: '100%'
            });
            $('#teamUsers').select2({
                placeholder: 'Select Players',
                width: '100%'
            });
            var SITEURL = "{{ url('/') }}";
        });

        $(window).on('load', function() {
            $('#success_alert').modal('show');
            $(".modal-backdrop").removeClass();
        });

        // COPY HEIGHT
        function bgHeight() {
            $('.heightWrapper').each(function() {
                var copyH = $(this).find('.copyHeight').outerHeight();
                $(this).find('.pasteHeight').outerHeight(copyH);
            })
        }

        $(window).on('load', bgHeight)
        $(window).resize(bgHeight)
    </script>
    <script src={{ url('js/tinymce.min.js') }} referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#private_message',
            height: 400,
            plugins: 'paste, emoticons media image',
            toolbar: 'cut copy paste bold italic underline emoticons media image',
            menubar: false,
            media_url_resolver: function (data, resolve/*, reject*/) {
                if (data.url.indexOf('YOUR_SPECIAL_VIDEO_URL') !== -1) {
                var embedHtml = '<iframe src="' + data.url +
                '" width="400" height="400" ></iframe>';
                resolve({html: embedHtml});
                } else {
                resolve({html: ''});
                }
            },
            paste_data_images: true
        });
    </script>
</head>
<body>
