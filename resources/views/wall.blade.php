@include('includes/head')
@include('layouts/header')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="modal" tabindex="-1" role="dialog" id="success_alert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body">

                    <div class="submission-notes">
                        <span class="note-text">{{ session('success') }} </span>
                        <form class="js-passnote-form">

                            <div class="text-right">

                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="purple_bg shadow_v p_y20">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h4><b> {{ $user->name }} </b></h4>
                <h4 class="black"><i class="fas fa-star m_r5"></i>Last achievement<i
                        class="fas fa-star m_l5"></i></h4>
                <img src="{{ Session::get('user_profile_image') ?? url('/img/avatar.jpg') }}" class="avatar m_b10"
                    style="width:150px!important">
                <ul class="list-inline player_numbers">
                    <li data-toggle="tooltip" data-original-title="LIKE"><i class="fas fa-heart"></i><br>{{ $totalLikes }}</li>
                    <li data-toggle="tooltip" data-original-title="FRIENDS"><i class="fas fa-user-headset"></i><br>{{ $totalFriends }}
                    </li>
                    <li data-toggle="tooltip" data-original-title="TEAMS"><i class="fas fa-user-friends"></i><br>{{ $totalTeams }}
                    </li>
                    <li data-toggle="tooltip" data-original-title="WINS"><i class="fas fa-trophy"></i><br>{{ $wins }}</li>
                    <li data-toggle="tooltip" data-original-title="GROUPS"><i class="fas fa-comments"></i><br>{{ $totalGroups }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row text-center">
        <div class="col-sm-3 col-sm-offset-0 col-xs-6 col-xs-offset-3 m_y20">
            <img src="/img/x.svg" style="width:50%">
            <h3><b>O<span class="blue">X</span>ARATE</b></h3>
            <h1 class="blue m_y0"><b>{{ $oxarate .'%' }}</b></h1>
        </div>
        <div class="col-sm-3 col-xs-4 m_y20">
            <img src="/img/o.svg" class="m_t20" style="width:40%">
            <h4 class="fs_12_m"><b>PERF<span class="red">O</span>RMANCE</b></h4>
            <h2 class="red m_y0"><b>{{ $performance . '%' }}</b></h2>
        </div>
        <div class="col-sm-3 col-xs-4 m_y20">
            <img src="/img/y.svg" class="m_t20" style="width:40%">
            <h4 class="fs_12_m"><b><span class="yellow">Y</span>NFLUENCE</b></h4>
            <h2 class="yellow m_y0"><b>{{ $social . '%' }}</b></h2>
        </div>
        <div class="col-sm-3 col-xs-4 m_y20">
            <img src="/img/a.svg" class="m_t20" style="width:40%">
            <h4 class="fs_12_m"><b>MONETIZ<span class="green">A</span>TION</b></h4>
            <h2 class="green m_y0"><b>{{ $monetization . '%' }}</b></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p>{{$user->bio_data}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <img src="https://via.placeholder.com/1200x300">
        </div>
    </div>
    <div class="row m_x0 vpc" data-vp-add-class="animated fadeIn slower">
        <div class="col-sm-6 p_x0">
            <div class="p_x40 p_y20 red_bg shadow_r">
                <h3><b><i class="fas fa-trophy m_r10"></i><span class="black">EVENTS</span></b></h3>
                <p>
                    <b>Played:</b> <span class="black">{{ $eventPlayed }}</span><br>
                    <b>Wins:</b> <span class="black">{{ $wins }}</span><br>
                    <b>Organized:</b> <span class="black">{{ $totalGroups }}</span><br>
                </p>
                @if($lastEventPlayed)
                <div class="m_t40">
                    <p><b>Last Event Joined/Played:</b></p>
                    <div class="row align">
                        <div class="col-sm-5 col-xs-6 m_b20">
                            <a href="{{ route('events.show',  $lastEventPlayed->id) }}">
                                <img src="{{ $lastEventPlayed->image ?? 'https://via.placeholder.com/800x800' }}" class="bordered">
                            </a>
                        </div>
                        <div class="col-sm-7 col-xs-12 m_b20">
                            <b>{{ $lastEventPlayed->name ?? '' }}</b><br>
                            <b>Game:</b> <span class="black">{{ $lastEventPlayed->games->name ?? '' }}</span><br>
                            <b>Type:</b> <span class="black">{{ $lastEventPlayed->event_types->name ?? '' }}</span><br>
                            <b>Date:</b> <span class="black">{{ $lastEventPlayed->match_date ?? '' }}</span><br>
                            <b>Prize Money:</b> <span class="black">{{ $lastEventPlayed ? $lastEventPlayed->prize_money . " €" : '' }}</span><br>
                        </div>
                    </div>
                    <div class="text-center">
                        <p><a href="{{ route('events.show',  $lastEventPlayed->id) }}" class="btn btn-default">Go to event</a></p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-6 p_x0">
            <div style="background-color:#9147ff" class="p_x40 p_y20 shadow_r">
                <h3><b><i class="fas fa-desktop m_r10"></i><span class="black">TWITCH CHANNEL</span></b></h3>
                <p>
                    <b>Channel:</b> <span class="black">{{ $twitch->channel_name1 ?? ''}}</span><br>
                    <b>Username:</b> <span class="black">{{ $twitch->twitch_login ?? ''}}</span><br>
                    <b>Status:</b> <span class="black">{{ $twitch->online_status ?? ''}}</span><br>
                    <b>Last Streaming:</b> <span class="black">{{ $twitch->last_streaming ?? ''}}</span><br>
                    <b>Followers:</b> <span class="black">{{ $twitch->followers ?? ''}}</span><br>
                    <b>Subscribers:</b> <span class="black">{{ $twitch->subscribers ?? ''}}</span><br>
                    {{-- <b>Last Cover:</b>last_cover --}}
                </p>
                <img src="/img/twitch.png">
                @if(isset($twitch->channel_name1))
                    <div class="text-center">
                        <p><a href="{{ 'https://www.twitch.tv/'. $twitch->channel_name1 }}" class="btn btn-default" target="_blank">Go to your channel</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row m_x0">
        <div class="col-sm-6 p_x0">
            <div class="row m_x0">
                <div class="col-sm-6 p_x0">
                    <div class="p_x40 p_y20 yellow_bg shadow_r">
                        <h3><b><i class="fas fa-user-friends m_r10"></i><span class="black">TEAM</span></b>
                        </h3>
                        <p class="m_y20">
                            <b>Joined:</b> <span class="black">{{ $totalTeamJoined }}</span><br>
                            <b>Created:</b> <span class="black">{{ $teamCreated }}</span><br>
                        </p>
                        <div class="text-center">
                            <p><a href="/teams" class="btn btn-default">See all Teams</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 p_x0">
                    <div class="p_x40 p_y20 green_bg shadow_r">
                        <h3><b><i class="fas fa-comments m_r10"></i><span class="black">GROUPS</span></b></h3>
                        <p class="m_y20">
                            <b>Joined:</b> <span class="black">{{ $groupJoined }}</span><br>
                            <b>Created:</b> <span class="black">{{ $groupCreated }}</span><br>
                        </p>
                        <div class="text-center">
                            <p><a href="/groups" class="btn btn-default">See all Groups</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 p_x0">
            <img src="https://via.placeholder.com/800x300">
        </div>
    </div>
    <div class="row m_x0">
        <div class="col-sm-12 p_x0">
            <div class="p_x40 p_y20 pink_bg shadow_r">
                <h3><b><i class="fas fa-layer-group m_r10"></i><span class="black">ACHIEVEMENTS</span></b>
                </h3>
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-1 text-center">
                        <img src="https://via.placeholder.com/400x400">
                        <h5 class="black"><b>Achievement name</b></h5>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="https://via.placeholder.com/400x400">
                        <h5 class="black"><b>Achievement name</b></h5>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="https://via.placeholder.com/400x400">
                        <h5 class="black"><b>Achievement name</b></h5>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="https://via.placeholder.com/400x400">
                        <h5 class="black"><b>Achievement name</b></h5>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="https://via.placeholder.com/400x400">
                        <h5 class="black"><b>Achievement name</b></h5>
                    </div>
                </div>
                <div class="text-center">
                    <p><a href="/teams" class="btn btn-default">See all Achievements</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <img src="https://via.placeholder.com/1200x600">
        </div>
    </div>
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
