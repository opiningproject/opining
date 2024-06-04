@extends('layouts.user-app')

@section('content')

<div class="main">
  <div class="main-view">
     <div class="container-fluid bd-gutter bd-layout">
       @include('layouts.user.side_nav_bar')
        <main class="bd-main order-1">
          <div class="main-content d-flex flex-column ">
            <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
              <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                <h1 class="page-title">Order payment</h1>
              </div>
            </div>
            <form id="payment-form">
              <!--
                Using a label with a for attribute that matches the ID of the
                Element container enables the Element to automatically gain focus
                when the customer clicks on the label.
              -->
              <label for="ideal-bank-element" class="mb-3">
                iDEAL Banks
              </label>
              <div id="ideal-bank-element">
                <!-- A Stripe Element will be inserted here. -->
              </div>

              <button type="submit">Pay</button>

              <!-- Used to display form errors. -->
              <div id="error-message" role="alert"></div>
            </form>

            <div id="messages" role="alert" style="display: none;"></div>
          </div>
        </main>
     </div>
  </div>
   <!-- start footer -->
   @include('layouts.user.footer_design')
   <!-- end footer -->
</div>

@endsection

@section('script')

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script>
      var public_key = '{{ config('params.stripe.sandbox.public_key') }}';

      document.addEventListener('DOMContentLoaded', async () => {
        const stripe = Stripe(public_key, {
          apiVersion: '2020-08-27'
        });

        const elements = stripe.elements();
        const idealBank = elements.create('idealBank');
        idealBank.mount('#ideal-bank-element');

        const paymentForm = document.querySelector('#payment-form');

        paymentForm.addEventListener('submit', async (e) => {
          // Avoid a full page POST request.
          e.preventDefault();

          // Customer inputs
          const nameInput = document.querySelector('#name');

          // Confirm the payment that was created server side:
          const {error, paymentIntent} = await stripe.confirmIdealPayment(
            '<?= $paymentIntent->client_secret; ?>', {
              payment_method: {
                ideal: idealBank,
              },
              return_url: 'http://localhost/',
            },
          );

          if(error) 
          {
            alert(error.message);
            return;
          }
          addMessage('Payment (${paymentIntent.id}): ${paymentIntent.status}');
        });
      });
      
    </script>

@endsection

