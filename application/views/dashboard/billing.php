<!DOCTYPE HTML>
<html>
	<head>
		<title>Pricing Plans and Subscription Payment | by PHPJabbers.com</title>
		<link href="../assets/css/billing.css" rel="stylesheet" type="text/css" media="all"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Monda" rel="stylesheet">

		<script src="js/jquery-1.11.0.min.js"></script>
		<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
		<script src="js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="https://js.stripe.com/v3/"></script>
		
  <!-- A Stripe Element will be inserted here. -->
		</div>
	</head>
	<body>
		<!--header start here-->
		<div class="priceing-table w3l">
			<div class="wrap">
				<h1>Choose your plan.</h1>
				<div class="priceing-table-main">
						<div class="price-grid">
							<div class="price-block agile">
								<div class="price-gd-top pric-clr1">
									<h4>Trial</h4>
									<h3>$0</h3>
									<h5>30 day trial.</h5>
								</div>
								<div class="price-gd-bottom">
									<div class="price-list">
										<ul>
											<li>Full access</li>
											<li>Documentation</li>
											<li>Customers Support</li>
											<li>Free Updates</li>
											<li>Unlimited Domains</li>
										</ul>
									</div>
								</div>
								<div class="price-selet pric-sclr1">
									<a class="popup-with-zoom-anim" data-plan="basic" data-price="5.00" href="#small-dialog">Sign Up</a>
								</div>
							</div>
						</div>
						<div class="price-grid">
							<div class="price-block agile">
								<div class="price-gd-top pric-clr2">
									<h4>Standard</h4>
									<h3>$10</h3>
									<h5>per month</h5>
								</div>
								<div class="price-gd-bottom">
									<div class="price-list">
										<ul>
											<li>Full access</li>
											<li>Documentation</li>
											<li>Customers Support</li>
											<li>Free Updates</li>
											<li>Unlimited Domains</li>
										</ul>
									</div>
								</div>
								<div class="price-selet pric-sclr2">
								<div id="payment-request-button">
									<a class="popup-with-zoom-anim" data-plan="standart" data-price="10.00" href="#small-dialog">Sign Up</a>
								</div>
							</div>
						</div>
						
						<div class="clear"> </div>
				</div>
			</div>
		</div>
		<br /><br /><br /><br />
	</body>
</html>