@extends('layouts.elements.app')
@section('content')
<section class="bg-light mt-md-2">
    <div class="container-fluid pricing-1">
        <section class="pricing">
            <div class="container ">
                <div class="row">                    
                    @if(empty($userPayment))
                    <!-- Free Tier -->
                    <div class="col-lg-4">
                        <div class="card mb-3 mb-sm-4 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Basic/Free</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$0</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>See compatible matches.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Messaging capabilities. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Rate businesses.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul>                                 
                                <a href="javascript:void(0);" class="btn btn-block btn-primary">Subscribed <i class="fas fa-check-double"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Plus Tier -->
                    <div class="col-lg-4">
                        <div class="card mb-3 mb-sm-4 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Premium</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$45</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul>
                                <a href="javascript:void(0);" class="btn btn-block btn-primary chooseSubscription" rel="2">Upgrade</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pro Tier -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Platinum</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$99</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Promote your business. </li>
                                </ul>
                                <input type="hidden" value="2"  class="subscribedPlan">
                                <a href="javascript:void(0);" class="btn btn-block btn-primary chooseSubscription" rel="3">Upgrade</a>
                            </div>
                        </div>
                    </div>
                    @else                  
                    <div class="col-lg-4 mx-auto">
                        <div class="card mb-3 mb-sm-4 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Basic/Free</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$0</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>See compatible matches.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Messaging capabilities. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Rate businesses.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul> 
                                @if(isset($userPayment) && $userPayment == 1)
                                <a href="javascript:void(0);" class="btn btn-block btn-primary">Subscribed <i class="fas fa-check-double"></i></a>
                                @else
                                <a href="{{route('freeSubscription')}}" class="btn btn-block btn-primary">Subscribe</a>
                                @endif
                            </div>
                        </div>
                    </div>                  
                    <div class="col-lg-4 mx-auto">
                        <div class="card mb-3 mb-sm-4 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Premium</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$45</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul>
                                @if(isset($userPayment) && $userPayment == 2)
                                <a href="javascript:void(0);" class="btn btn-block btn-primary">Subscribed <i class="fas fa-check-double"></i></a>
                                @else
                                <a href="javascript:void(0);" class="btn btn-block btn-primary chooseSubscription" rel="2">Upgrade</a>
                                @endif
                            </div>
                        </div>
                    </div>                  
                    <div class="col-lg-4 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Platinum</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$99</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Promote your business. </li>
                                </ul>
                                @if(isset($userPayment) && $userPayment == 3)
                                <a href="javascript:void(0);" class="btn btn-block btn-primary disabled">Subscribed <i class="fas fa-check-double"></i></a>
                                @else
                                <a href="javascript:void(0);" class="btn btn-block btn-primary chooseSubscription" rel="3">Upgrade</a>
                                @endif
                            </div>
                        </div>
                    </div>                  
                    @endif
                </div>
            </div>
        </section>
    </div>
</section>

<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body text-center border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="premium d-none">
                    <h5 class="card-title text-muted text-uppercase text-center">Premium</h5>
                    <h6 class="card-price text-center"><span class="subscriptionPrice">$45</span><span class="period">/month</span></h6>
                    <hr>
                </div>
                <div  class="platinum d-none">
                    <h5 class="card-title text-muted text-uppercase text-center">Platinum</h5>
                    <h6 class="card-price text-center"><span class="subscriptionPrice">$99</span><span class="period">/month</span></h6>
                    <hr>
                </div>
                <h6 class="text-center mb-3" style="font-size: 15px;">
                    Enter your credit card details to upgrade your ConnectEO account.
                </h6>
                <form action="{{route('payment')}}" method="POST" id="registrationForm">
                    @csrf
                    <div id="card-element" class="uk-form-controls" style="padding-top:8px"></div>
                    <p id="card-errors" class="uk-text-danger uk-margin-small-top"></p>
                    <input type="hidden" name="pay_price" id="payPrice">
                    <input type="hidden" name="selected_plan" id="selectedPlan"> 
                    <div class="showOnlyPremium d-none">
                        <label for="promo" class="text-center ">OR</label>
                        <div class="form-group text-left mt-0 d-flex">
                            <input type="text" autocomplete="off" class="form-control checkPromoCode" id="promo" placeholder="Promo code" value="">
                            <span class="ml-2" style="display: flex;align-items: center;">
                                <i class="far fa-check-circle  d-none matchedPromoCode matched-success"></i>
                                <i class="unMatchedPromoCode d-none fas fa-times-circle text-danger"></i>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success text-uppercase d-none showForPromoCode" style="padding: 11px;font-size: 12px;width: 250px;letter-spacing: .5px;">Start Subscription</button>                    
                    <button type="submit" class="btn btn-success text-uppercase hideForPromoCode" style="padding: 11px;font-size: 12px;width: 250px;letter-spacing: .5px;">Start Subscription</button>                    
                </form>
                <p class="small mt-4 p-0" style="color:#000;line-height: 1.5;">Your subscription will be billed on a monthly basis. You can cancel your subscription at anytime. Your payment is securely processed via <a href="https://stripe.com/" target="_blank">Stripe</a> and we never store your credit card details.</p>
            </div>           
        </div>
    </div>
</div>

<div class="modal fade" id="successPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center" >
                <img src="{{ asset('asset/logo_mobile.png') }}" width="100px"> 
                <hr>
                <!--<img src="{{asset('asset/Success-PNG-Image.png')}}" style="width:150px;height: 150px;border-radius: 50%;margin-bottom: 1rem">-->
                <p style="color:#000;">Thank you for subscribing with ConnectEO! Your subscription is now active.</p>
                <a href="javascript:void(0);"  class="btn btn-success py-2 okay" style="width:100px;" onclick="window.location.reload()">
                    Ok 
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://js.stripe.com/v3/"></script>
<script>
                    $(document).on('click', '.chooseSubscription', function () {
                        var price = $(this).parent('.card-body').find('.subscriptionPrice').html();
                        var card = $(this).parent('.card-body').find('h5').html();
                        var plan = $(this).attr('rel');
                        $("#payPrice").val(price);
                        $("#selectedPlan").val(plan);
                        if (plan == 2) {
                            $('.showOnlyPremium').removeClass('d-none');
                            $('.premium').removeClass('d-none');
                            $('.platinum').addClass('d-none');
                        } else if (plan == 3) {
                            $('.showOnlyPremium').addClass('d-none');
                            $('.premium').addClass('d-none');
                            $('.platinum').removeClass('d-none')
                        }
                        $('#subscriptionModal').modal('show');
                    });
</script>
<script>
<?php if (session('status') == 'success') { ?>

        setTimeout(function () {
            $('#successPayment').modal('show')

        }, 400);
<?php } ?>
    var $errors = $('card-errors');
    var $form = $('#registrationForm');
    var $submit = $form.find('[type=submit]');
    // Create a Stripe client
    var stripe = Stripe('pk_test_A5E4OXjsFCgMpx5vchdw4bR000yeJQA9pH');
    var card = stripe.elements().create('card', {
        classes: {
            base: 'uk-input',
            complete: 'uk-input',
            empty: 'uk-input',
            invalid: 'uk-input uk-form-danger',
            focus: 'uk-input uk-form-focus'
        },
        iconStyle: 'solid',
        hidePostalCode: true,
        style: {
            base: {
                color: '#666',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#db3050',
                iconColor: '#db3050'
            }
        }
    });
    card.mount('#card-element'); // Handle real-time validation errors from the card Element.
    card.on('change', function (_event) {
        $errors.text('');
        $submit.prop('disabled', false);
        if (_event.error) {
            $errors.text(_event.error.message);
            $submit.prop('disabled', true);
        }
    });
    // Intercept form submission to create a client-side token first
    $form.on('submit', function (_event) {
        _event.preventDefault();
        $submit.text('Processing...').prop('disabled', true);
        stripe.createToken(card, {
            name: $('#card-number').val(),
            address_line_1: '',
            address_line_2: '',
            address_city: 'New york',
            address_state: 'New york', // US-AL => AL
            address_zip: '248001',
            address_country: 'USA', // USA => US
            currency: 'usd',
        }).then(function (result) {
            // Inform the user if there was an error
            if (result.error) {
                $errors.text(result.error.message);
                $submit.text('Try Again').prop('disabled', false);
                return;
            }

            // Add the card token and submit for real
            $form.append('<input type="hidden" name="card_token" value="' + result.token.id + '" />');
            $form[0].submit();
        });
    });

    $(document).on('keyup', '.checkPromoCode', function () {
        if ($(this).val() == 'CONNECTEO') {
            $('.matchedPromoCode').removeClass('d-none');
            $('.unMatchedPromoCode').addClass('d-none');
            $('.showForPromoCode').removeClass('d-none');
            $('.hideForPromoCode').addClass('d-none');
        } else if ($(this).val() == '') {
            $('.unMatchedPromoCode').addClass('d-none');
            $('.matchedPromoCode').addClass('d-none');
            $('.showForPromoCode').addClass('d-none');
            $('.hideForPromoCode').removeClass('d-none');
        } else {
            $('.unMatchedPromoCode').removeClass('d-none');
            $('.matchedPromoCode').addClass('d-none');
            $('.showForPromoCode').addClass('d-none');
            $('.hideForPromoCode').removeClass('d-none');
        }
    });

    $(document).on('click', '.okay', function () {
<?php session()->forget('status') ?>
        location.reload();
    });
    $(document).on('click', '.showForPromoCode', function () {
        var value = $('.checkPromoCode').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/userSubscriptionUpdate",
            data: {value: value},
            dataType: 'json',
            success: function (data)
            {
                if (data.status == "success") {
                    location.reload();
                }
            }
        });
    });

</script>
@endpush
@push('styles')
<style>
    .matched-success {
        color: #28a745;
    }
    .pricing-1{
        background-image: url("{{asset('home-style/images/bg-how-to-connect.jpg') }}");
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;   
        width: 100%;       
        position: relative;
        top: 0px;
        padding-top: 1rem;
        padding-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;

    }
    @media (max-width: 992px) {
        .pricing-1{           
            height: auto;
        }
    }
    @media (min-width: 992px) {
        /*        .pricing-1{           
                    height: 87vh;  
                }*/
        .pricing .card:hover {
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
        }
        .pricing .card:hover .btn {
            opacity: 1;
        }

    }
    .qode-appear qode-appeared{
        margin-top: 1rem;
    }
    .card-price {
        font-size: 2rem;
        margin: 0;
    }
    label{
        color: #000;
    }
    .ftco-section {
        padding: 2em 0;
        position: relative;
    }

    .fa-ul li{
        color: #333;
    }
    h6{
        color: #000;
    }
    .pricing .card {
        border: none;
        border-radius: 1rem;
        transition: all 0.2s;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        width: 100%!important;
    }
    .pricing hr {
        margin: 1.5rem 0;
    }
    .pricing .card-title {
        margin: 0.5rem 0;
        font-size: 0.9rem;
        letter-spacing: .1rem;
        font-weight: bold;
    }
    .pricing .card-price {
        font-size: 3rem;
        margin: 0;
    }
    .pricing .card-price .period {
        font-size: 0.8rem;
    }
    .pricing ul li {
        margin-bottom: 1rem;
    }
    .pricing .text-muted {
        opacity: 0.7;
    }
    .pricing .btn {
        font-size: 80%;
        border-radius: 5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        opacity: 0.7;
        transition: all 0.2s;
    }
    /* Hover Effects on Card */

    #card-element{
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.21)!important;
        padding: 10px;
    }
</style> 
@endpush
