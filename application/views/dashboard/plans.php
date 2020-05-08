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

<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-TileColor" content="#0061da">
		<meta name="theme-color" content="#1643a3">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<link rel="icon" href="../assets/images/favicon.png" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png"/>

		<!-- TITLE -->
		<title>The OneCloud Management Framework</title>

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
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style="background-color:#413d57 ;">
			<!--header start here-->
	<div class="priceing-table w3l">
		<div class="wrap" align='center'>
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
									href="<?php echo base_url() . 'billing/addPaymentMethod' ?>">Select</a>
							</div>
						</div>
					</div>
			<?php } ?>
				</div>
			</div>
			<br /> <br /> <br /> <br />
		</div>
	</div>


</body>
</html>