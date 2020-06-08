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



<!-- notas 

Falta a�adir bot�n cancelar suscripci�n
Falta a�adir bot�n otrogar recibo

-->

<!-- notas -->

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style=" margin-top:60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table w3l">
			<div class="wrap" align='center' style="border-radius: 15px 15px 15px 15px;">
				<h1>Payment Method</h1>
				<div class="billing-table-division"></div>
				<div class="payment-grid">
					<div class="card-info">
						<p><?php echo $username ?></p><br>
						<i class="mdi mdi-credit-card"></i><i>   <?php echo $last4 ?></i>
						<a href="<?php echo base_url() . 'billing/paymentMethod'?>">Change</a>
					</div>
					<div class="payment-division"></div>
<!-- 					<div class="payment-info"> -->
<!-- 						<p>Last Payment</p><br> -->
<!-- 						<i class="mdi mdi-calendar"></i><i>   May 11, 2011</i> -->
<!-- 					</div> -->
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
</body>
</html>