 @include('includes/head')

 @include('includes/g_header')

 <div class="container m_y40">
     <div class="row">
         <div class="col-sm-12">
             <ul class="nav nav-tabs" role="tablist">
                 <li style="width:50%;" role="presentation" class="text-center active"><a href="#best" role="tab"
                         data-toggle="tab">
                         <h3 class="m_y0"><b>BEST E-PLAYERS</b></h3>
                     </a></li>
                 <li style="width:50%;" role="presentation" class="text-center"><a href="#recent" role="tab"
                         data-toggle="tab">
                         <h3 class="m_y0"><b>RECENT E-PLAYERS</b></h3>
                     </a></li>
             </ul>
         </div>
     </div>
 </div>
 <div class="container-fluid">
     <div class="row">
         <div class="col-sm-12">
             <div class="tab-content">
                 <div role="tabpanel" class="tab-pane fade in active" id="best">
                     @include('users/players-table')
                 </div>
                 <div role="tabpanel" class="tab-pane fade" id="recent">
                     <div class="row m_x0">
                    @foreach($players as $player)
                         <div class="col-md-3 col-sm-6 p_x0 text-center shadow_r" style="background-color: {{ $player->profile_color ?? "#0000fe !important" }}">
                             <div class="p_20">
                                 <img src="{{ $player->profile_image ?? url('/img/avatar.jpg') }}" class="avatar">
                                 <h4><b>{{ $player->name }}</b></h4>
                             </div>
                         </div>
                      @endforeach
                    </div>
                 </div>
             </div>

             {{-- <div class="text-center m_y40">
                 <a href="###-###" class="btn btn-default"><b>DISCOVER MORE</b></a>
             </div> --}}

             <img src="https://via.placeholder.com/1200x600">

         </div>
     </div>
 </div>


 @include('includes/footer')
 @include('includes/modal')
 @include('includes/foot')