@include('includes/head')
@include('layouts/header')
@include('messages/modals/deleteChatModal')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif 

<div class="container">
    <div class="row">
        <div class="col-sm-4 card-margin center"></div>
        <div class="col-sm-4 card-margin ">
            <div class="card">
                <div class="card-body bg-color-geek check-out">
                    <h5 class="card-title center">{{ strtoupper($pricingPlan->plan_name) }}</h5>
                    <div style="text-align: center;">
                        <input type="hidden" class="paypal_price_hidden" value="{{ $pricingPlan->month_price }}">
                        <p class="amount"> <input type="radio" class="paypal_price" name="price" value="{{ $pricingPlan->month_price }}" checked/>{{ " € " . $pricingPlan->month_price . "/month" }} </p>
                        <p class="amount"><input type="radio" class="paypal_price" name="price" value="{{ $pricingPlan->year_price }}" />{{ " € " . $pricingPlan->year_price . "/year" }}</p>
                    </div>
                    <div id="smart-button-container">
                        <div style="text-align: center;">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 card-margin center"></div>
    </div>
</div>

<script
src="https://www.paypal.com/sdk/js?client-id=ARdAXTZC6tS0zkLKScPgGTwhdmDk3GMObis-gBKTylqdVDqKKHzvCa3Feqlkx0z7eeyDMnM0w_Lpq8zU&currency=EUR"
data-sdk-integration-source="button-factory"></script>
 

<script src={{ url('js/paypal.js') }}></script>    
 

@include('includes/footer')
@include('includes/modal')
@include('includes/foot')
