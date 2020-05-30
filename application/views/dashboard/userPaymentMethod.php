<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
<link href="../assets/css/payment_form.css" rel="stylesheet" type="text/css" media="all" />
<style>
            /**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container.
    */
    .StripeElement {
    box-sizing: border-box;

    height: 46px;

    padding: 10px 12px;

    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;

    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
    border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
    }
</style>
<script src="https://js.stripe.com/v3/"></script>
<div class="wrapper">
  <div class="payment-box">
    <form class="form" action="createStripeUser" method="post" id="payment-form">
      <div class="card space icon-relative">
        <label class="label">Card holder:</label>
        <input type="text" class="input" placeholder="OneCloud Ops">
        <i class="fas fa-user"></i>
      </div>
      <div class="card space icon-relative">
        <div id="card-element" >
        <!-- <label class="label">Card number:</label>
        <input type="text" class="input" data-mask="0000 0000 0000 0000" placeholder="Card Number">
        <i class="far fa-credit-card"></i>
      </div>
      <div class="card-grp space">
        <div class="card icon-relative">
          <label class="label">Expiry date:</label>
          <input type="text" name="expiry-data" class="input"  placeholder="00 / 00">
          <i class="far fa-calendar-alt"></i>
        </div>
        <div class="card icon-relative">
          <label class="label">CVC:</label>
          <input type="text" class="input" data-mask="000" placeholder="000">
          <i class="fas fa-lock"></i>
        </div> -->
      </div>  
      <div class="btn">
        <button>Update</button>
      </div> 
      
    </form>
  </div>
</div>
<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_PTOEOqFvaAZ69shGcfHc4Jud00Hh9l9Z9C');

  // Create an instance of Elements.
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
  base: {
      color: '#32325d',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
      color: '#aab7c4'
      }
  },
  invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
  }
  };

  // Create an instance of the card Element.
  var card = elements.create('card', {style: style});

  // Add an instance of the card Element into the `card-element` <div>.
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
      displayError.textContent = event.error.message;
  } else {
      displayError.textContent = '';
  }
  });

  // Handle form submission.
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
      if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
      } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
      }
  });
  });

  // Submit the form with the token ID.
  function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
  }
</script>