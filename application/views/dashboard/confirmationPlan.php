<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
	
<!-- TITLE -->
<title>Confirmation Plan</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />

<link href="https://fonts.googleapis.com/css?family=Monda"
	rel="stylesheet">	

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<!--header start here-->
	<div class="priceing-table w3l">
		<div class="wrap" align='center'>
			<h1>Selected Plan</h1>
			<div class="priceing-table-main">
			<?php foreach ($selected_plan as $plan){?>
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
											<li class="mdi mdi-check-circle">  <?php echo $f['name'] ?></li><br>	
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
				
			</div>
		</div>
		<br /> <br /> <br /> <br />
		</div>

</body>
</html>