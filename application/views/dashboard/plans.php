<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TITLE -->
<title>Membership Plans</title>




<!-- extrasssss -->

		<!-- DASHBOARD CSS -->
		<link href="../assets/css/dashboard.css" rel="stylesheet"/>
		<link href="../assets/css/boxed.css" rel="stylesheet"/>

		<!-- COLOR-THEMES CSS -->
		<link href="../assets/css/color-themes.css" rel="stylesheet"/>

		<!-- C3.JS CHARTS PLUGIN -->
		<link href="../assets/plugins/charts-c3/c3-chart.css" rel="stylesheet"/>

		<!-- TABS CSS -->
		<link href="../assets/plugins/tabs/tabs-style2.css" rel="stylesheet" type="text/css">

    <link href="../assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="../assets/plugins/mcustomscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="../assets/css/icons.css" rel="stylesheet"/>

		<!-- RIGHT-MENU CSS -->
		<link href="../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- LEFT-SIDEMENU CSS -->
		<link href="../assets/plugins/jquery-jside-menu-master/css/jside-menu.css" rel="stylesheet"/>
		<link href="../assets/plugins/jquery-jside-menu-master/css/jside-skins.css" rel="stylesheet"/>

		<!-- Sidemenu css -->
		<link href="../assets/plugins/side-menu/sidemenu-model2.css" rel="stylesheet" />

		<!-- Sidebar Accordions css -->
		<link href="../assets/plugins/sidemenu-responsive-tabs/css/easy-responsive-tabs.css" rel="stylesheet">
    <link href="../assets/css/sweetalert2.css" rel="stylesheet">

    <link href="../assets/plugins/formwizard/smart_wizard.css" rel="stylesheet">
    <link href="../assets/plugins/form-wizard/css/form-wizard.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_dots.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_circles.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_arrows.css" rel="stylesheet">
    <style>
    /* Hide all steps by default: */
    .wtab {
      display: none;
    }
    </style>


<!-- extrasssss -->

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
				<h1>Choose the OneCloud plan that fits your needs</h1>
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
        									<?php foreach ($feature_current_plan as $f){?>
        										<?php if($f['id'] == $plan['id']){ ?>
        												<li class="mdi mdi-check-circle">  <?php echo $f['name'] ?></li>
									<br>	
        										<?php } ?>
        									<?php } ?>
        								</ul>
							</div>
						</div>
						<div class="price-selet">
							<button class="button-change"
								onclick="myFunction(<?php echo $plan['id']?>, '<?php echo $plan['name'] ?>', <?php echo $plan['monthly_price']?>, <?php echo $plan['annual_price']?>)">Change</button>


						</div>
					</div>
				</div>
			<?php
}

?>
			</div>
		</div>
	</div>

	<div id="popup-grid" class="overlay">
		<div class="popup">
			<h2 id="sel-plan">Membership Change Confirmation</h2>
			<p id="message-top"></p>
			<p id="message-down"></p>
			<button id="btnClose" class="cancel">Cancel</button>
			<button id="btnConfirmAnnual" class="confirm">Confirm annual plan</button>
			<button id="btnConfirmMonthly" class="confirm" onclick="close()">Confirm
				monthly plan</button>
			<div class="content"></div>
		</div>
	</div>

	<script>

	function myFunction(id,name,monthly,annnual) {	
		
// 		  var division = document.getElementsByClassName("example");
// // 		  division[0].innerHTML = id;
// 		  document.getElementsByClassName("overlay")[0].style.visibility = "visible";
// 		  document.getElementsByClassName("overlay")[0].style.opacity = "1";
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

		location.href='<?php echo base_url() . 'billing/confirmPlanChange?id_plan=3'?>';
		var plan = document.getElementById("btnConfirmAnnual").getAttribute("plan");
		location.href='<?php echo base_url() . 'billing/confirmAnnualPlanChange?id_plan='?>' + plan;
	}

	document.getElementById("btnConfirmMonthly").onclick = function() {

		location.href='<?php echo base_url() . 'billing/confirmPlanChange?id_plan=3'?>';
		var plan = document.getElementById("btnConfirmAnnual").getAttribute("plan");
		location.href='<?php echo base_url() . 'billing/confirmMonthlyPlanChange?id_plan='?>' + plan;
	}

	
	
// function myFunction(id) {
//   document.getElementsByClassName("overlay").style.visibility = "visible";
//   document.getElementsByClassName("overlay").style.opacity = 1;
// }
</script>

</body>
</html>

