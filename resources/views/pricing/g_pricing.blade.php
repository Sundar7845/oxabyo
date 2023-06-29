@include('includes/head')
@include('includes/g_header')

<div class="container">
    <div class="row">
        <div class="col-sm-4 card-margin">
            <div class="card card-height">
                <div class="card-body bg-color-noob">
                    <h5 class="card-title center">NOOB</h5>
                    <h4 class="start-at">Starts at </h4>
                    <p class="amount">FREE</p>
                    <p class="card-text text-color"></p>

                    @foreach ($permissions as $permission)
                        <h6 class="plan-permission">

                            @if ($subscriptionPermissionsForNoob[$permission->id]['is_unlimited'])
                                {{ 'Unlimited ' . ' - ' . $permission->name }}
                            @else
                                {{ $permission->name . ' - ' . $subscriptionPermissionsForNoob[$permission->id]['value'] }}
                            @endif


                        </h6>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-sm-4 card-margin">
            <div class="card card-height">
                <div class="card-body bg-color-geek">
                    <h5 class="card-title center">GEEK</h5>
                    <h4 class="start-at">Starts at </h4>
                    <p class="amount">€ 1.99/mon</p>
                    <h5 class="annual">Annual (discounted 50% for 1 year) Annual <s>23.88€</s> 11.94 €</h5>

                    <p class="card-text text-color"></p>

                    @foreach ($permissions as $permission)
                        <h6 class="plan-permission">


                            @if ($subscriptionPermissionsForGeek[$permission->id]['is_unlimited'])
                                {{ ' Unlimited ' . ' - ' . $permission->name }}
                            @else
                                {{ $permission->name . ' - ' . $subscriptionPermissionsForGeek[$permission->id]['value'] }}
                            @endif
                        </h6>
                    @endforeach
                </div>
            </div>

            @if (Auth::check())
                <div class="btn-center button">
                    <a href="/payment-checkout/geek" class="btn btn-default">Upgrade</a>
                </div>
            @endif

        </div>
        <div class="col-sm-4 card-margin">
            <div class="card card-height">
                <div class="card-body bg-color-pro">
                    <h5 class="card-title center">PRO</h5>
                    <h4 class="start-at">Starts at </h4>
                    <p class="amount">€ 3.99/mon</p>
                    <h5 class="annual">Annual (discounted 50% for 1 year) Annual <s>47.88€</s> 23.94 €</h5>
                    <p class="card-text text-color"></p>

                    @foreach ($permissions as $permission)
                        <h6 class="plan-permission">

                            @if ($subscriptionPermissionsForPro[$permission->id]['is_unlimited'])
                                {{ 'Unlimited ' . ' - ' . $permission->name }}
                            @else
                                {{ $permission->name . '  ' . $subscriptionPermissionsForPro[$permission->id]['value'] }}
                            @endif
                        </h6>
                    @endforeach
                </div>
            </div>

            @if (Auth::check())
                <div class="btn-center button">
                    <a href="/payment-checkout/pro" class="btn btn-default">Upgrade</a>
                </div>
            @endif

        </div>
    </div>




    @if (!Auth::check())
        <div class="btn-center button">
            <a href="/login" class="btn btn-default">REGISTER NOW FOR FREE</a>
        </div>
    @endif

</div>

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
