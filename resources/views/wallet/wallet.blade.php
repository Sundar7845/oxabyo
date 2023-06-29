@include('includes/head')
@include('layouts/header')

<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <h3 class="text-center"><b><i class="fas fa-wallet m_r10"></i>WALLET</b></h3>
 
        </div>
    </div>
</div>

<div class="container m_t20">
    <div class="row">
            <div class="col-sm-6">
                <div class="subscription-plan">
                    <p>Your subscription plan is : <span style="color:red;">{{ strtoupper($subscriptionPlans['event_participation']['plan_name'])  }} </span>
                    </p>
                </div>
            </div>  
        <div class="col-sm-6">
            <div class="subscription-plan-expiry">
                <p>expire on : <span style="color:red;">{{ $subscriptionPlans['event_participation']['end_date']}} </span>     
                <a href="{{('/pricing')}}"type="submit" name="submit" class="btn btn-default btn-lg btn-css">RENEW</a> </p>
            </div>
        </div>
    </div>

    <br><br><br><br>
        
    <div class="row">
            <div class="col-sm-12">
                <div class="event-partecipate">
                    <p>Event partecipate : <span class="clr-red"> {{ $getTotalNumberOfEventJoined . "/" . $subscriptionPlans['event_participation']['is_allowed']}} </span></p>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="event-organization">
                    <p>Event organization : <span class="clr-red"> {{ $getTotalNumberOfEventJoined . "/" . $subscriptionPlans['event_organization']['is_allowed']}} </span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="created-team">
                    <p>Created Team : <span class="clr-red"> {{ $getTotalNumberOfTeamCreated . "/" . $subscriptionPlans['team_create']['is_allowed']}} </span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="joined-team">
                    <p>Joined Team : <span class="clr-red"> {{ $getTotalNumberOfTeamJoined . "/" . $subscriptionPlans['team_join']['is_allowed']}}</span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="created-group">
                    <p>Created Group : <span class="clr-red">  {{ $getTotalNumberOfGroupCreated . "/" . $subscriptionPlans['group_create']['is_allowed']}}</span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="joined-group">
                    <p>Joined Group : <span class="clr-red"> {{ $getTotalNumberOfGroupJoined . "/" . $subscriptionPlans['group_join']['is_allowed']}} </span></p>
                </div>
            </div>

        </div>

<br><br><br><br>
        
        <div class="row">

            <div class="col-sm-12 table-responsive">
                <table class="table sortable_table">
                    <thead style="border-bottom: 1px solid rgb(255, 255, 255);">
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
                        <th scope="col" style="text-align:right;">Amount</th>
                    </thead>
                    <tbody>

                        <tr style="border-bottom: 1px solid rgb(255, 255, 255);">
                            

                            <td class="date-clr">{{ $subscriptionPlans['event_participation']['date_paid']}}</td>
                            <td class="description-clr">{{ $subscriptionPlans['event_participation']['is_allowed']}}</td>
                            <td align="right" class="amount-clr">{{ $subscriptionPlans['event_participation']['invoice_amount']}}</td>

                        </tr> 


                        
                    </tbody>

                   
                </table>

                <br><br>


                {{-- <div class="btn-center">
                    <button type="submit" name="submit" class="btn btn-default btn-lg btn-css">LOAD MORE</button>
                 </div> --}}
            </div>
        </div>
    </div>
</div>



@include('includes/footer')
@include('includes/modal')
@include('includes/foot')