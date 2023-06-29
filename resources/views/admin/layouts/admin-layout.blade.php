<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OXABYO</title>
    <link rel="shortcut icon" href={{ url('img/favicon.ico') }}>
    <link rel="apple-touch-icon" href={{ url('img/favicon.ico') }} />
    <link href={{ url("admin/css/bootstrap.min.css") }} rel="stylesheet">
    <link href={{ url("admin/font-awesome/css/font-awesome.css") }} rel="stylesheet">
    <!-- Toastr style -->
    <link href={{ url("admin/css/plugins/toastr/toastr.min.css") }} rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href={{ url("admin/js/plugins/gritter/jquery.gritter.css") }} rel="stylesheet">
    <link href={{ url("admin/css/animate.css") }} rel="stylesheet">
    <link href={{ url("admin/css/style.css") }} rel="stylesheet">
    <link href={{ url('css/admin.css') }} rel="stylesheet"> 
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/> 
    <link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle profile-image-custom" src="{{ Session::get('user_profile_image') ?? url("img/avatar.jpg") }}" />
                            <a data-toggle="dropdown" class="dropdown-toggle profile-dropdown-custom" href="#">
                                <span class="block m-t-xs font-bold">{{ Auth::user()->name. " ". Auth::user()->surename }}</span>
                                <span class="text-muted text-xs block">Administrator<b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="/admin/profile">Profile</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                        </div>
                    </li>
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard">
                            <i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
                    </li>
                    <li class="{{ ( request()->is('admin/user-management') || request()->is('admin/user-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/user-management"><i class="fa fa-user"></i> <span class="nav-label">Users
                                Management </span></a>
                    </li>
                    <li class="{{ ( request()->is('admin/event-management') || request()->is('admin/event-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/event-management"><i class="fa fa-trophy"></i> <span class="nav-label">Events
                                Management </span></a>
                    </li>
                    <li class="{{ ( request()->is('admin/group-management') || request()->is('admin/group-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/group-management"><i class="fa fa-sitemap"></i> <span class="nav-label">Group
                                Management </span></a>
                    </li>

                    <li class="{{ ( request()->is('admin/team-management') || request()->is('admin/team-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/team-management"><i class="fa fa-users"></i> <span class="nav-label">Team
                                Management </span></a>
                    </li>
                    <li class="{{ ( request()->is('admin/game-management') || request()->is('admin/game-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/game-management"><i class="fa fa-gamepad"></i> <span class="nav-label">Games
                                Management</span></a>
                    </li>
                    <li class="{{ ( request()->is('admin/comment-management') || request()->is('admin/comment-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/comment-management"><i class="fa fa-comment"></i> <span class="nav-label">Comment
                                Management</span></a>
                    </li>
                    <li class="{{ ( request()->is('admin/slider-management') || request()->is('admin/slider-management/*') ) ? 'active' : '' }}">
                        <a href="/admin/slider-management"><i class="fa fa-sliders"></i> <span class="nav-label">Sliders
                                Management</span></a>
                    </li>
                    {{-- <li class="{{ ( request()->is('permission-Management') || request()->is('permission-Management/*') ) ? 'active ' : '' }}">
                           <a href="permission-Management"><i class="fa fa-lock"></i><span class="nav-lable">Permission 
                               Management</span></a>
                    </li> --}}
                     <li class="{{ ( request()->is('admin/setup-prizing') || request()->is('admin/setup-prizing/*') ) ? 'active ' : '' }}">
                           <a href="/admin/setup-prizing"><i class="fa fa-gear"></i><span class="nav-lable">Setup Subscriptions
                               </span></a>
                    </li>
                     <li class="{{ ( request()->is('admin/subscription-permission') || request()->is('admin/subscription-permission/*') ) ? 'active ' : '' }}">
                           <a href="/admin/subscription-permission"><i class="fa fa-gear"></i><span class="nav-lable">Setup Permissions
                               </span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1 index-dashboard">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li style="padding: 20px">
                            <span class="m-r-sm text-muted welcome-message"></span>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            @yield('content')
           

            </div>


        </div>



        <!-- Mainly scripts -->
        <script src={{ url("admin/js/jquery-3.1.1.min.js") }}></script>
        <script src={{ url("admin/js/popper.min.js") }}></script>
        <script src={{ url("/admin/js/bootstrap.js") }}></script>
        <script src={{ url("admin/js/plugins/metisMenu/jquery.metisMenu.js") }}></script>
        <script src={{ url("admin/js/plugins/slimscroll/jquery.slimscroll.min.js") }}></script>

        <!-- Flot -->
        <script src={{ url("admin/js/plugins/flot/jquery.flot.js") }}></script>
        <script src={{ url("admin/js/plugins/flot/jquery.flot.tooltip.min.js") }}></script>
        <script src={{ url("admin/js/plugins/flot/jquery.flot.spline.js") }}></script>
        <script src={{ url("admin/js/plugins/flot/jquery.flot.resize.js") }}></script>
        <script src={{ url("admin/js/plugins/flot/jquery.flot.pie.js") }}></script>

        <!-- Peity -->
        <script src={{ url("admin/js/plugins/peity/jquery.peity.min.js") }}></script>
        <script src={{ url("admin/js/demo/peity-demo.js") }}></script>

        <!-- Custom and plugin javascript -->
        <script src={{ url("admin/js/inspinia.js") }}></script>
        <script src={{ url("admin/js/plugins/pace/pace.min.js") }}></script>

        <!-- jQuery UI -->
        <script src={{ url("admin/js/plugins/jquery-ui/jquery-ui.min.js") }}></script>

        <script src= {{ url("js/custom.js") }}></script>
 
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#groupMembers').select2({
                    placeholder: 'Select Members',
                    dropdownParent:$(".modal-body"),
                    width: '100%' 
                });

                $('#teamMembers').select2({
                    placeholder: 'Select Members',
                    dropdownParent:$(".modal-body"),
                    width: '100%' 
                });

                $('#slider-event').select2({
                    placeholder: 'Select Events',
                    width: '100%' 
                });

                

            });
        </script>

        <script> 
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#id_password');
            togglePassword.addEventListener('click', function (e) {                
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });

            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const password_confirmation = document.querySelector('#id_password_confirmation');
            togglePasswordConfirmation.addEventListener('click', function (e) {                
                const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                password_confirmation.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
   
        </script>
   

</body>

</html>
