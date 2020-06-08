
<link href="../assets/css/payment_form.css" rel="stylesheet"
	type="text/css" media="all" />
<style>
/**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container.
    */
.StripeElement {
	background: #616b78;
	border: 1px solid;
	border-color: rgba(172, 180, 189, 0.5);
	border-radius: 5px 5px 5px 5px;
	width: 100%;
	padding: 5px;
	text-align: center;
	color: #ebebeb;
	padding: 13px 0px 13px 25px;
	width: 100%;
	word-spacing: 3px;
	outline: none;
	font-size: 16px;
	box-sizing: border-box;
	height: 46px;
	padding: 10px 12px;
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

<body>

	<div class="top-div">
		<img src="../assets/images/logo.png" class="header-image"
			alt="OneCloud logo">
	</div>
	
	<div class="wrapper">

		<div class="payment-box">
			<h2>Payment Method</h2>
			<div class="payment-division"></div>
			<form class="form"
				action="createCustomerSubscription?id_user=<?php echo $id_user ?>"
				method="post" id="payment-form">
				<div class="card space icon-relative">
					<label class="label">Enter payment infromation</label> <input
						type="text" class="input" placeholder="Card holder"> <i
						class="fas fa-user"></i>
				</div>
				<div class="card space icon-relative">
					<div id="card-element"></div>
					<button class="btn">Finish Registration</button>
			
			</form>
		</div>
	</div>
</body>
<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_PTOEOqFvaAZ69shGcfHc4Jud00Hh9l9Z9C');

  // Create an instance of Elements.
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
  base: {
      color: '#ffffff',
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