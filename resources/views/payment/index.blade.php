@extends('layouts.front')

@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('extra-script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

    <div class="col-md-12">
        <h1>Page de paiement</h1>

        <div class="row">
            <div class="col-md-6">
                <form id="payment-form" class="my-4" action="{{route('payment.store')}}" method="post">
                    @csrf
                    <div id="card-element">
                        <!-- Elements will create input elements here -->
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>

                    <button id="submit" class="btn btn-success mt-4">Procéder au paiement</button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('extra-JS')
    <script>
        //Create an instance of Elements
        var stripe = Stripe('pk_test_o0SHlCe0igc8rgfY0O3wAQ3M00U8dzEfih');
        var elements = stripe.elements();

        //adding style to the form
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };
        //, create an instance of an Element and mount it to the Element container:
        var card = elements.create("card", { style: style });
        card.mount("#card-element");

        //Display error card numbers
        card.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.classList.add('alert','alert-warning');
                displayError.textContent = error.message;
            } else {
                displayError.classList.remove('alert','alert-warning');
                displayError.textContent = '';
            }
        });

        //Submit the payment to strap
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();
            submit.disabled = true;
            stripe.confirmCardPayment("{{ $clientSecret }}", {
                payment_method: {
                    card: card,
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error to your customer (e.g., insufficient funds)
                    submitButton.disabled = false;
                    console.log(result.error.message);
                } else {
                    // The payment has been processed!
                    if (result.paymentIntent.status === 'succeeded') {
                        //variables declaration
                        var paymentIntent = result.paymentIntent;
                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        var form = document.getElementById('payment-form');
                        var url = form.action;
                        var redirect = '/merci';

                        //query
                        fetch(
                            url,
                            {
                                headers: {
                                    'Accept': 'application/json, text-plain, */*',
                                    'Content-Type': 'application/json',
                                    'X-Requested-with': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': token
                                },
                                method: 'post',
                                body: JSON.stringify({
                                    paymentIntent:  paymentIntent
                                })
                            }
                        ).then((data)=>{
                            console.log(data)
                           window.location.href = redirect;
                        }).catch((error)=>{
                            console.log(error)
                        })
                    }
                }
            });
        });
    </script>
@endsection
