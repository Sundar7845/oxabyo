@include('includes/head')
@include('layouts/header')

@if (session('subscription-alert-model'))
    <div class="modal" tabindex="-1" role="dialog" id="success_alert">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <div class="submission-notes">
                        <span class="note-text">{{ session('subscription-alert-model') }} </span>
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

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-center"><b><i class="fas fa-comments m_r10"></i>GROUPS</b></h3>
            <div class="row">
                <div class="col-sm-4 m_y20">
                    
                        <ul class="list-inline m_b0">
                            <li>
                                <input type="checkbox" name="group_created_by" id="group_created_by"> Created
                            </li>
                            <li>
                                <input type="checkbox" name="group_joined_by" id="group_joined_by"> Joined
                            </li>
                        </ul>
                     
                </div>
                <div class="col-sm-8 m_y20 text-right">
                    <ul class="list-inline m_b0">
                        <!-- after search -->
                        <li>
                            <a class="m_r5" id="group_filter_reset">Filters Reset</a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#searchGroupModal" class="btn btn-default"><i
                                    class="fa fa-search m_r5"></i>SEARCH GROUP</a>
                        </li>
                        <li class="m_t10_m">
                            <a href="{{ route('groups.create') }}" class="btn btn-primary"><i
                                    class="fa fa-comments m_r5"></i>CREATE GROUP</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid append-groups-list">
    @include('includes/group_table')
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <img src= "{{ $group->group_image ?? "https://via.placeholder.com/1200x600" }}">
        </div>
    </div>
</div>

@include('includes/footer') 
@include('includes/modal') 
@include('includes/foot') 