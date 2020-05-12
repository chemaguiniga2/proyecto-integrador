<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TITLE -->
<title>Payment Information</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />



<!-- extrasssss -->




<!-- extrasssss -->

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style="text-align: center; margin: 65px;">
		<div class="billing-table w3l">
			<div class="wrap" align='center'>
				<h1>Payment Method</h1>
				<div class="payment-grid">
					<div class=payment-cat>
						<h2>Alexis Rubio</h2>
						<h2>Last Payment</h2>
					</div>
					<div class="payment-division"></div>
					<div class="payment-info">
						<div class="payment-card">
							<div class="card-info">
								<p class= "mdi mdi-credit-card">  4444</p>
							</div>		
							<a href="<?php echo base_url() . 'billing/paymentMethod'?>">Change</a>
						</div>					
						<div class="date-info">
							<p class= "mdi mdi-calendar">  May 11, 2020</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>