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

Falta añadir botón cancelar suscripción
Falta añadir botón otrogar recibo

-->

<!-- notas -->

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style=" margin-top:60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table w3l">
			<div class="wrap" align='center' style="border-radius: 15px 15px 15px 15px;">
				<h1>Account</h1>
				<div class="billing-table-division"></div>
				<div class="payment-grid">					
					<button class="button-cancel" id="btnCancel"> Cancel Membership</button>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
</body>

<script>

	document.getElementById("btnCancel").onclick = function() {
		location.href='<?php echo base_url() . 'billing/cancelSubscription'?>';
	}
	
</script>

</html>

