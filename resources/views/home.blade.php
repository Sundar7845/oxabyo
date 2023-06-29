@include('includes/head')

@include('includes/g_header')
 

<div class="container-fluid no_ov">

	<div class="row">
		<div class="col-sm-12 text-center">
			<div class="visible-xs"><video autoplay="autoplay" loop="loop" style="width:100%" muted="muted"><source src="/img/clip_m.mp4"></video>
			</div>
			<div class="hidden-xs"><video autoplay="autoplay" loop="loop" style="width:100%" muted="muted"><source src="/img/clip.mp4"></video>
			</div>
			<div id="cosa-fa" class="m_b"></div>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 vpc" data-vp-add-class="animated fadeIn">
					<p class="m_b40">Console? PC? Smartphone? No matter what your favorite device is, in OXABYO you will find what you love.</p>
					<p class="m_b40">Join our community of gamers, make friends, and play against the world's best players during exciting live events. From New Delhi to Rome, from Nairobi to London: eSports have no borders.</p>
					<a href="/login" class="btn btn-default btn-lg">Log in/Sign up</a>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container">
	<div class="vpc" data-vp-add-class="animated fadeIn slower">
		<div class="row text-center m_t40">
			<div class="col-sm-12">
				<h3><b><i class="fas fa-trophy m_r10"></i>CURRENT EVENTS</b></h3>
			</div>
		</div>
		<div class="row" style="position:relative">
			<div id="eventsCarNav"></div>
			<div class="col-xs-12">
				<div class="owl-carousel eventsCar">
  				    @foreach ($currentEvents as $event)
					<div class="item">
						<div class="p_x p_y40">
							<div class="row align">
								<div class="col-sm-5 col-sm-offset-0 col-xs-6 col-xs-offset-3 m_b20">
								<a href="{{ route('events.event-detail',  $event->id) }}">
								  <img src="{{ $event->image ?? "https://via.placeholder.com/800x800" }}" class="bordered"style="height:143px;">
								</a>
								</div>
								<div class="col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1 m_b20">
									<b>{{ $event->name }}</b><br>
									<b>Game:</b> <span class="black">{{ $event->games->name ?? '' }}</span><br>
									<b>Type:</b> <span class="black"> {{ $event->event_types->name ?? '' }}</span><br>
									<b>Date:</b> <span class="black">{{ $event->match_date ?? '' }}</span><br>
									<b>Prize Money:</b> <span class="black">{{ $event->prize_money . " €" }}</span><br>
								</div>
							</div>
							
							<div class="text-center">
								<p><a href="{{ route('events.event-detail',  $event->id) }}" class="btn btn-default">View event</a></p>
							</div>
						</div>
					</div>
         			    @endforeach
					
				</div>
			</div>
		</div>
	</div>

	<div class="row text-center">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x300">
		</div>
	</div>

</div>

<div class="container-fluid">


	<div class="row text-center">
		<div class="col-sm-12">
			<div class="vpc" data-vp-add-class="animated fadeIn slow">
				<div class="row m_t">
					<div class="col-sm-4 m_t40 m_b">
						<div class="p_x20">
							<img src="img/performance.svg" style="max-height:80px">
							<h3><b>PERF<img src="img/o_red.svg" style="height:20px;width:auto;margin:0 2px 2px">RMANCE</b></h3>
							<p>Players from all over the world, welcome home. Attend or organize events and go for it. Whatever your favorite video game, you will find your place here. Train hard, work hard, and go hard!</p>
						</div>
					</div>
					<div class="col-sm-4 m_t40 m_b">
						<div class="p_x20">
							<img src="img/influence.svg" style="max-height:80px">
							<h3><b><img src="img/y_yellow.svg" style="height:18px;width:auto;margin:0 2px 3px 0">NFLUENCE</b></h3>
							<p>Join a global community that shares the same passions as you. Organize and participate in social gaming events, regardless of your favorite console or where you come from. Bring your passions, in Oxabyo there are thousands of people to share them with.</p>
						</div>
					</div>
					<div class="col-sm-4 m_t40 m_b">
						<div class="p_x20">
							<img src="img/monetization.svg" style="max-height:80px">
							<h3><b>MONETIZ<img src="img/a_green.svg" style="height:18px;width:auto;margin:0 0 5px 2px">TION</b></h3>
							<p>Earn money by playing? In Oxabyo it is possible. Organize events and tournaments or give your best and join a team as an gamers. Unleash your passions and monetize them.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="vpc" data-vp-add-class="animated fadeIn slower">
		<div class="row text-center m_t40 m_b10">
			<div class="col-sm-12">
				<h3><b><i class="fas fa-clipboard-list m_r10"></i>RANKING</b></h3>
			</div>
		</div>
        @include('users/players-table')
  
	</div>
</div>

<div class="container-fluid">

	<div id="eventi" class="p_t">
		<div class="row no_ov">
			<div class="col-md-5 col-md-offset-1 col-sm-6 vpc" data-vp-add-class="animated fadeInUp">
				<img src="img/eventi.jpg">
			</div>
			<div class="col-md-3 col-sm-5">
				<img class="m_t20 vpc title_img" data-vp-add-class="animated fadeInRight" src="img/eventi.png">
				<p class="m_t40 vpc" data-vp-add-class="animated fadeInRight delay02">Esports are the engine of sociality. Organize and participate in live streaming events and connect with gamers from around the world. Beyond the geographical barriers, in Oxabyo there are already those who are cheering for you!</p>
			</div>
		</div>
	</div>




	<div id="algo" class="p_t">
		<div class="row no_ov m_b40">
			<div class="visible-xs">
				<div class="col-sm-6 vpc" data-vp-add-class="animated fadeInUp">
					<img src="img/algo.jpg">
				</div>
			</div>
			<div class="col-md-3 col-md-offset-3 col-sm-6 text-right">
				<img class="m_t20 vpc title_img" data-vp-add-class="animated fadeInLeft" src="img/algo.png">
				<p class="m_t40 vpc" data-vp-add-class="animated fadeInLeft delay02">What kind of gamers are you?<br>Find it out through our proprietary algorithm that takes into account your performance, ability to create connections and monetize.</p>
			</div>
			<div class="hidden-xs">
				<div class="col-md-5 col-sm-6 vpc" data-vp-add-class="animated fadeInUp">
					<img src="img/algo.jpg">
				</div>
			</div>
		</div>
	</div>




	<div id="social" class="p_t">
		<div class="row no_ov m_b40">
			<div class="col-md-5 col-md-offset-1 col-sm-6 vpc" data-vp-add-class="animated fadeInUp">
				<img src="img/social.jpg">
			</div>
			<div class="col-md-3 col-sm-5">
				<img class="m_t20 vpc title_img" data-vp-add-class="animated fadeInRight" src="img/social.png">
				<p class="m_t40 vpc" data-vp-add-class="animated fadeInRight delay02">Connect, text and have fun. It's like playing with your best friend on the couch. But now your friends can be thousands and live anywhere in the world.</p>
			</div>
		</div>
	</div>





	<div class="p_t text-center">
		<div class="vpc" data-vp-add-class="animated fadeInUp">
			<a href="/login" class="btn btn-default">Log in/Sign up</a>
		</div>
		<div>
			<img src="img/avatar.svg" style="max-width:1440px;margin-top:-4%">
		</div>
	</div>
	<div id="per-chi" class="text-center">
		<div class="row text-center">
			<div class="col-sm-12 m_t40">
				<h2 class="vpc" data-vp-add-class="animated fadeInUp slow"><b>THE PLACE FOR YOU, THE PLACE FOR ALL GAMERS</b></h2>
			</div>
		</div>
		<div class="row text-center no_ov">
			<div class="col-sm-4 m_y40">
				<div class="vpc p_x40" data-vp-add-class="animated fadeInLeft slow">
					<h2><b>GAMERS</b></h2>
					<p>Oxabyo, where your passions are at home: events, tournaments, challenges. Gamers' paradise is here! Have you already chosen who to play against?</p>
				</div>
			</div>
			<div class="col-sm-4 m_y40">
				<div class="vpc p_x40" data-vp-add-class="animated fadeInUp slow delay03">
					<h2><b>INFLUENCERS</b></h2>
					<p>Connect with your community, increase your fan base and create greater engagement. Free your passions, there are millions of people ready to cheer for you!</p>
				</div>
			</div>
			<div class="col-sm-4 m_y40">
				<div class="vpc p_x40" data-vp-add-class="animated fadeInRight slow">
					<h2><b>EVENT ORGANIZERS</b></h2>
					<p>In Oxabyo you will find close- knit communities and gamers from all over the world. Break down the barriers, and get ready to organize next generation events!</p>
				</div>
			</div>
		</div>
		<div class="m_y vpc" data-vp-add-class="animated fadeInUp">
			<a href="/login" class="btn btn-default btn-lg">Log in/Sign up</a>
		</div>
	</div>

	<div class="row text-center">
		<div class="col-sm-12">
			<img src="https://via.placeholder.com/1200x600">
		</div>
	</div>

</div>
@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
