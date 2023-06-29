<div class="dropdown">
	<a onclick="$('.dropdown-menu').toggle()">
		<div style="height:48px;width:48px;display:inline-block">
			<img src="{{ Session::get('user_profile_image') ??  url('/img/avatar.jpg') }}" class="avatar">
		</div>
		<span class="notification_ribbon"><?php

use App\Notification;

			$notificaiton_count = Notification::where('sender_user_id',Auth()->user()->id)->count();
			echo $notificaiton_count;
		?></span>
	</a>
	<div class="dropdown-menu profile">
		<div class="p_20">
			<div class="text-right"><a onclick="$('.dropdown-menu').toggle()" class="white"><i class="fas fa-times"></i></a></div>

			<div class="text-center">
				<div style="position:relative;height:140px;width:140px;display:inline-block">
					<img src="{{ Session::get('user_profile_image') ??  url('/img/avatar.jpg') }}" class="avatar">
					<span class="notification_ribbon" style="right:auto;right:7%;bottom:7%;font-size:14px;width:26px;height:26px;line-height:26px;"><?php



			$notificaiton_count = Notification::where('sender_user_id',Auth()->user()->id)->count();
			echo $notificaiton_count;
		?></span>
				</div>
				<h4 class="m_b0"><b>{{ isset(Auth::user()->name) ? Auth::user()->name : "" }}</b></h4>
				<p class="l_blue"><i class="fas fa-star"></i>&nbsp;last achievement&nbsp;<i class="fas fa-star"></i></p>
			</div>

			<ul class="list-unstyled" style="margin-top:20px;">
				<li<?php if (strpos($_SERVER['REQUEST_URI'], "profile") !== false){echo ' class="active"';}?>><a href="/profile"><i class="fas fa-user-edit m_r5"></i>PROFILE</a></li>
				<li<?php if (strpos($_SERVER['REQUEST_URI'], "message-list") !== false){echo ' class="active"';}?>><a href="/message-list"><i class="fas fa-envelope-open-text m_r5"></i>MESSAGES</a></li>
				<li<?php if (strpos($_SERVER['REQUEST_URI'], "/notification") !== false){echo ' class="active"';}?>><a href="/notification"><i class="fas fa-bell m_r5"></i>NOTIFICATION</a></li>
				<li<?php if (strpos($_SERVER['REQUEST_URI'], "/wallet") !== false){echo ' class="active"';}?>><a href="/wallet"><i class="fas fa-wallet m_r5"></i>WALLET</a></li>
				<li><a href="/logout"><i class="fas fa-sign-out m_r5"></i>LOGOUT</a></li>
			</ul>
		</div>
		<hr class="white m_y0">
		<div class="p_x20 p_y5">
			<p><small><b>RUNNING EVENTS</b></small></p>

			<?php
				$events = \App\Event::with(['player_types', 'games', 'event_types', 'organizer'])
					->whereDate('match_date', now())
					->oldest('match_date')
					->limit(3)
					->get();

					foreach ($events as $event) {
						if ($event->image) {
							$event->image = app()->make('\App\Services\FileService')->fetchS3File($event->image);
						}
					}
			?>
			@foreach ($events as $event)
				<div class="row latest">
					<div class="col-xs-4">
						<a href="{{ route('events.show',  $event->id) }}"><img src="{{ $event->image }}" class="bordered"></a>
					</div>
					<div class="col-xs-8 p_l0">
						<a href="{{ route('events.show',  $event->id) }}"><b>{{ $event->name }}</b></a><br>
						<b>Game:</b> {{ $event->games->name ?? '' }}<br>
						<b>Type:</b> {{ $event->event_types->name ?? '' }}<br>
						<b>Data:</b> {{ $event->match_date }}<br>
						<b>Prize Money:</b> {{ $event->prize_money . " €" }}
					</div>
				</div>
			@endforeach

			{{-- <div class="row latest">
				<div class="col-xs-4">
					<a href="/event-detail.php"><img src="https://via.placeholder.com/400x400" class="bordered"></a>
				</div>
				<div class="col-xs-8 p_l0">
					<a href="/event-detail.php"><b>Event Name lorem ipsum dolor sit amet</b></a><br>
					<b>Game:</b> Game name<br>
					<b>Type:</b> Game type<br>
					<b>Data:</b> 01/01/2022<br>
					<b>Prize Money:</b> 18940,00 €
				</div>
			</div>

			<div class="row latest">
				<div class="col-xs-4">
					<a href="/event-detail.php"><img src="https://via.placeholder.com/400x400" class="bordered"></a>
				</div>
				<div class="col-xs-8 p_l0">
					<a href="/event-detail.php"><b>Event Name</b></a><br>
					<b>Game:</b> Game name<br>
					<b>Type:</b> Game type<br>
					<b>Data:</b> 01/01/2022<br>
					<b>Prize Money:</b> 270,00 €
				</div>
			</div> --}}


			<div class="text-center m_y20">
				<a href="/events" class="btn btn-default">SEE ALL EVENTS</a>
			</div>
		</div>
		<img src="https://via.placeholder.com/300x350">
	</div>
</div>
