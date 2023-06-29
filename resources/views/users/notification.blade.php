
@include('includes/head')
@include('layouts/header')

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
				<h3><b><i class="fas fa-bell m_r10"></i>Notification</b></h3>
			</div>

			<hr>
            <br>
			<div class="row">
            <div  class="accordion" id="accordionExample">
                @foreach($notifications as $notification)
               
				<div class="col-sm-2">{{ format_messaging_date($notification->created_at) }}</div>
				<div class="col-sm-10" data-toggle="collapse" data-target="#collapse-{{$notification->id}}" aria-expanded="true">
                    <b>{{$notification->title}} 
                   
                    <span class="accicon" style="float: right"><i class="fas fa-angle-right rotate-icon"></i></span></b>

                 <div id="collapse-{{$notification->id}}"  class="collapse" data-parent="#accordionExample" style="margin-bottom: 10px;">
               <span class="accicon"> 
               {{$notification->message}} 
               <br>
               <br>
                  <b style="margin-left: 80px;"> 

				  @if($notification->accept_href && $notification->decline_href)
				  
				  <button class="btn btn-success"><a href="{{$notification->accept_href}}" style="color: white;">Accept</a></button> 
                       <button class="btn btn-danger"><a href="{{$notification->decline_href}}" style="color: white;">Decline</a></button>
				  
				  @endif
					</b>
                    </span>    
                       </div>      
                       </div>  
                                                         
                 @endforeach
                 </div>  
			</div>

		

			
			<hr>
			<img src="https://via.placeholder.com/1200x600">

		</div>
	</div>
</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
