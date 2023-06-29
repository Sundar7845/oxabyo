<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OXABYO</title>
    <link rel="shortcut icon" href={{ url('img/favicon.ico') }}>
    <link rel="apple-touch-icon" href={{ url('img/favicon.ico') }} />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href={{ url('css/admin.css') }} rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle  profile-image-custom" src="{{ Session::get('user_profile_image') ?? url("img/avatar.jpg") }}" />
                            <a data-toggle="dropdown" class="dropdown-toggle profile-dropdown-custom" href="#">
                                <span
                                    class="block m-t-xs font-bold">{{ Auth::user()->name . ' ' . Auth::user()->surename }}</span>
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
                    <li class="active">
                        <a href="/admin/dashboard">
                            <i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
                    </li>
                    <li>
                        <a href="/admin/user-management"><i class="fa fa-user"></i> <span
                                class="nav-label">Users
                                Management </span></a>
                    </li>
                    <li>
                        <a href="/admin/event-management"><i class="fa fa-trophy"></i> <span
                                class="nav-label">Events
                                Management </span></a>
                    </li>
                    <li>
                        <a href="/admin/group-management"><i class="fa fa-sitemap"></i> <span
                                class="nav-label">Group
                                Management </span></a>
                    </li>
                    <li>
                        <a href="/admin/team-management"><i class="fa fa-users"></i> <span
                                class="nav-label">Team
                                Management </span></a>
                    </li>
                    <li>
                        <a href="/admin/game-management"><i class="fa fa-gamepad"></i> <span
                                class="nav-label">Games
                                Management</span></a>
                    </li>
                    <li>
                        <a href="/admin/comment-management"><i class="fa fa-comment"></i> <span
                                class="nav-label">Comment
                                Management</span></a>
                    </li>
                    <li>
                        <a href="/admin/slider-management"><i class="fa fa-sliders"></i> <span
                                class="nav-label">Sliders
                                Management</span></a>
                    </li>
               
                    <li>
                        <a href="/admin/setup-prizing"><i class="fa fa-gear"></i> <span
                                class="nav-label">Setup Subscriptions 
                                </span></a>
                    </li>
                    <li>
                        <a href="/admin/subscription-permission"><i class="fa fa-rocket"></i> <span
                                class="nav-label">Setup Permissions
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
                        <form role="search" class="navbar-form-custom">
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
            <div class="wrapper wrapper-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Active Users</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $usersCount }}</h1>
                                    <small>Total users</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Active Events</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $eventsCount }}</h1>
                                    <small>Total events</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Active Games</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $gamesCount }}</h1>
                                    <small>Total games</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Active Teams</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $teamsCount }}</h1>
                                    <small>Total teams</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/user-management">
                            <div class="card-box bg-users-card">
                                <div class="inner">
                                    <h3> Users </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/event-management">
                            <div class="card-box bg-events-card">
                                <div class="inner">
                                    <h3> Events </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-trophy" aria-hidden="true"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/group-management">
                            <div class="card-box bg-groups-card">
                                <div class="inner">
                                    <h3> Group </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-sitemap" aria-hidden="true"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/team-management">
                            <div class="card-box bg-teams-card">
                                <div class="inner">
                                    <h3> Team </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/game-management">
                            <div class="card-box bg-games-card">
                                <div class="inner">
                                    <h3> Games </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-gamepad" aria-hidden="true"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/comment-management">
                            <div class="card-box bg-comments-card">
                                <div class="inner">
                                    <h3> Comments </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="/admin/slider-management">
                            <div class="card-box bg-slider-card">
                                <div class="inner">
                                    <h3> Sliders </h3>
                                    <p> Management </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-sliders"></i>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Flot -->
        <script src="js/plugins/flot/jquery.flot.js"></script>
        <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="js/plugins/flot/jquery.flot.spline.js"></script>
        <script src="js/plugins/flot/jquery.flot.resize.js"></script>
        <script src="js/plugins/flot/jquery.flot.pie.js"></script>

        <!-- Peity -->
        <script src="js/plugins/peity/jquery.peity.min.js"></script>
        <script src="js/demo/peity-demo.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- jQuery UI -->
        <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

        <!-- GITTER -->
        <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

        <!-- Sparkline demo data  -->
        <script src="js/demo/sparkline-demo.js"></script>

        <!-- ChartJS-->
        <script src="js/plugins/chartJs/Chart.min.js"></script>

        <!-- Toastr -->
        <script src="js/plugins/toastr/toastr.min.js"></script>


       
</body>

</html>
