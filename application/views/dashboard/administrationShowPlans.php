<!DOCTYPE HTML>


<!-- Vista userPlans
     Contenido para la vista de accountBilling. Muestra los planes de OneCloud con el plan del usuario seleccionado de la siguiente forma:
        Plan seleccionado activo: color verde.
        Plan seleccionado trial: color morado.
        Otras opciones de planes para cambiar: color azul.
    Acciones de la vista:
        button-change: habilita un popup (popup-grid) para confirmar el cambio de plan
        btnClose: cierra el Popup
        btConfirm: confirma el cambio del plan de pago. Redirige a c/bi/confirmPlanChange con el id del plan como parametro
        
     -->

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TITLE -->
<title>User's Membership plan</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />

<link href="https://fonts.googleapis.com/css?family=Monda"
	rel="stylesheet">


<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/confirmationpopup.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style="margin-top: 60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table">
			<div class="wrap" align='center'
				style="border-radius: 15px 15px 15px 15px;">
				<h1>Current Plans</h1>
				<div class="billing-table-division"></div>
			<?php
$id_plan_selected = 0;

foreach ($payment_plans as $plan) {
    ?>
				<div class="price-grid">
					<div class="price-block agile">
						<div class="price-gd-top">
							<h4><?php echo $plan['name'] ?></h4>
							<h3>$<?php echo $plan['monthly_price'] ?>/ month </h3>
							<h5>$<?php echo $plan['annual_price'] ?>/ year</h5>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<li class="mdi mdi-check-circle">  <?php echo $plan['allowed_users'] ?> Users</li>
									<br>
									<li class="mdi mdi-check-circle">  <?php echo $plan['allowed_clouds'] ?> Clouds</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
		    <?php
}
?>
			</div>
		</div>
	</div>

	<script>

	function changeConfirmation(id,name,monthly,annnual) {
		
		document.getElementById("popup-grid").style.visibility = "visible";
		document.getElementById("popup-grid").style.opacity = "1";
		document.getElementById("message-top").innerHTML = 'Your membership will change to ' + name + '.';
		document.getElementById("message-down").innerHTML = 'Confirm the payment period and will start on next bill date.';
		document.getElementById("btnConfirmAnnual").setAttribute("plan", id);
		document.getElementById("btnConfirmMonthly").setAttribute("plan", id);

	}

	document.getElementById("btnClose").onclick = function() {
		  document.getElementById("popup-grid").style.visibility = "hidden";
		  document.getElementById("popup-grid").style.opacity = "0";
	}

	document.getElementById("btnConfirmAnnual").onclick = function() {
		var plan = document.getElementById("btnConfirmAnnual").getAttribute("plan");
		location.href='<?php echo base_url() . 'billing/confirmAnnualPlanChange?id_plan='?>' + plan;
	}

	document.getElementById("btnConfirmMonthly").onclick = function() {
		var plan = document.getElementById("btnConfirmAnnual").getAttribute("plan");
		location.href='<?php echo base_url() . 'billing/confirmMonthlyPlanChange?id_plan='?>' + plan;
	}

	document.getElementById("btnCancel").onclick = function() {
		location.href='<?php echo base_url() . 'billing/cancelSubscription'?>';
	}
	
</script>

</body>
</html>