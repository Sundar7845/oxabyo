<script>
    // PUSH MENU
    (function ($) {
        $.fn.jPushMenu = function (customOptions) {
    
            var o = $.extend({}, $.fn.jPushMenu.defaultOptions, customOptions);
            $('body').addClass(o.bodyClass);
            $(this).addClass('jPushMenuBtn');
            $(this).click(function () {
                var target = '.cbp-spmenu-left', push_direction = 'toright';
                $(this).toggleClass(o.activeClass);
                $(target).toggleClass(o.menuOpenClass);
                if ($(this).is('.' + o.pushBodyClass)) {
                    $('body').toggleClass('cbp-spmenu-push-' + push_direction);
                }
                $('.jPushMenuBtn').not($(this)).toggleClass('disabled');
                return false;
            });
    
            var jPushMenu = {
                close: function (o) {
                    $('.jPushMenuBtn,body,.cbp-spmenu').removeClass('disabled active cbp-spmenu-open cbp-spmenu-push-toleft cbp-spmenu-push-toright');
                }
            }
            if (o.closeOnClickOutside) {
                $(document).click(function () {
                    jPushMenu.close();
                });
                $(document).on('click touchstart', function () {
                    jPushMenu.close();
                });
                $('.cbp-spmenu,.toggle-menu').click(function (e) {
                    e.stopPropagation();
                });
                $('.cbp-spmenu,.toggle-menu').on('click touchstart', function (e) {
                    e.stopPropagation();
                });
            }
    
            if (o.closeOnClickLink) {
                $('.cbp-spmenu a').on('click', function () {
                    jPushMenu.close();
                });
            }
        };
    
        $.fn.jPushMenu.defaultOptions = {
            bodyClass: 'cbp-spmenu-push',
            activeClass: 'menu-active',
            showLeftClass: 'menu-left',
            menuOpenClass: 'cbp-spmenu-open',
            pushBodyClass: 'push-body',
            closeOnClickOutside: true,
            closeOnClickInside: true,
            closeOnClickLink: false
        };
    
    })(jQuery);
    
    $(document).ready(function () {
        $('.toggle-menu').jPushMenu();
    });
    
    // VIEWPORTCHECKER
    $(document).ready(function () {
        $('.vpc').viewportChecker({
            classToRemove: 'vpc',
            offset: 100,
        });
    });
    
    
    // CHOSEN RESIZE
    function resizeChosenWidth() {
        $('.chosen-container').css('width', '100%');
    }
    
    $(document).ready(function(){
        $(".chosen-select").chosen();
        resizeChosenWidth()
    })
    
    $(window).resize(function(){
        resizeChosenWidth()
    })
    
    // TOOLTIP
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html: 'true',
            container: 'body'
        })
    })
    
    // SUMMERNOTE
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Il mio commento...',
            height: '250',
            toolbar: [
              ['font', ['bold', 'italic', 'clear']],
              ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    });
    
    // OWL
    $(document).ready(function() {
        $('.eventsCar').owlCarousel({
            loop:true,margin:0,responsiveClass:true,nav:true,autoplay:true,autoplaySpeed: 2000,
            navClass: ['btn btn-link owl-prev pull-left', 'btn btn-link owl-next pull-right'],
            navText:["<span class='far fa-chevron-left'></span>","<span class='far fa-chevron-right'></span>"],
            navSpeed: 2000,autoplayHoverPause:true,navContainer:'#eventsCarNav',dots: false,
            responsive:{
                0:{items:1},
                767:{items:1},
                991:{items:2},
                1199:{items:2}
            }
        })
    })
    

    
    </script>
    </body>
    </html>
    