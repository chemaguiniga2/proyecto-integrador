<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
	
<!-- TITLE -->
<title>Pricing Plans and Subscription Payment | by PHPJabbers.com</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />



<!-- extrasssss -->




<!-- extrasssss -->

<link href="https://fonts.googleapis.com/css?family=Monda"
	rel="stylesheet">
	

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style="text-align: center; margin: 65px;">
		<h3>You currently have debit balance of</h3>
		<h6><?php echo $monthly_price_user[0]['monthly_price'], ".00 USD"?></h6>
	</div>
	<!--header start here-->
	<div class="priceing-table w3l">
		<div class="wrap" align='center'>
			<h1>Current Plan</h1>
			<div class="priceing-table-main">
			<?php foreach ($current_payment_plan as $plan){?>
				<div class="price-grid">
					<div class="price-block agile">
						<div class="price-gd-top-selected pric-clr1">
							<h4><?php echo $plan['name'] ?></h4>
							<h3>$<?php echo $plan['monthly_price'] ?></h3>
							<h5>$<?php echo $plan['annual_price'] ?></h5>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<?php foreach ($feature_current_plan as $f){?>
										<?php if($f['id'] == $plan['id_plan']){ ?>
												<li class="mdi mdi-check-circle">  <?php echo $f['name'] ?></li><br>	
										<?php } ?>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<h1>Choose a new Membership Plan</h1>
				<div class="priceing-table-main">
			<?php foreach ($payment_plans as $plan){?>
				<div class="price-grid">
						<div class="price-block agile">
							<div class="price-gd-top pric-clr1">
								<h4><?php echo $plan['name'] ?></h4>
								<h3>$<?php echo $plan['monthly_price'] ?></h3>
								<h5>$<?php echo $plan['annual_price'] ?></h5>
							</div>
							<div class="price-gd-bottom">
								<div class="price-list">
									<ul>
									<?php foreach ($feature_current_plan as $f){?>
										<?php if($f['id'] == $plan['id']){ ?>
												<li class="mdi mdi-check-circle"><?php echo $f['name'] ?></li><br>	
										<?php } ?>
									<?php } ?>
								</ul>
								</div>
							</div>
							<div class="price-selet pric-sclr1">
								<a class="popup-with-zoom-anim" data-plan=<?php echo $f['id'] ?>
									data-price="5.00"
									<?php $id_plan = $plan['id']?>
									href="<?php echo base_url() . 'billing/confirmPlanChange?id_plan=' . $id_plan?>">Select</a>
							</div>
						</div>
					</div>
			<?php } ?>
<!-- 				<div class="price-grid"> -->
					<!-- 					<div class="price-block agile"> -->
					<!-- 						<div class="price-gd-top pric-clr2"> -->
					<!-- 							<h4>Standard</h4> -->
					<!-- 							<h3>$10</h3> -->
					<!-- 							<h5>per month</h5> -->
					<!-- 						</div> -->
					<!-- 						<div class="price-gd-bottom"> -->
					<!-- 							<div class="price-list"> -->
					<!-- 								<ul> -->
					<!-- 									<li>Full access</li> -->
					<!-- 									<li>Documentation</li> -->
					<!-- 									<li>Customers Support</li> -->
					<!-- 									<li>Free Updates</li> -->
					<!-- 									<li>Unlimited Domains</li> -->
					<!-- 								</ul> -->
					<!-- 							</div> -->
					<!-- 						</div> -->
					<!-- 						<div class="price-selet pric-sclr2"> -->
					<!-- 							<div id="payment-request-button"> -->
					<!-- 								<a class="popup-with-zoom-anim" data-plan="standart" -->
					<!-- 									data-price="10.00" href="#small-dialog">Sign Up</a> -->
					<!-- 							</div> -->
					<!-- 						</div> -->
					<!-- 					</div> -->

					<!-- 					<div class="clear"></div> -->
					<!-- 				</div> -->
				</div>
			</div>
			<br /> <br /> <br /> <br />

</body>
</html>