<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="theme-color" content="#4188c9">
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

		<!--- FONT-ICONS CSS -->
		<link href="../assets/css/icons.css" rel="stylesheet"/>

	</head>
	<body class="app sidebar-mini rtl body-dark">


	<div id='stars2'></div>

	    <!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>

		<div class="page">
		   <!-- PAGE-CONTENT OPEN -->
			<div class="page-content error-page">
				<div class="container text-center">
					<div class="error-template">
						<h3 class="display-2 floating text-white mb-2">Check your Email!</h3>
						<h5 class="error-details text-white">
							You will receive an confirmation email to activate your account.
						</h5>
						<h6 class="error-details text-white">
							Email: <?php echo $email ?>
						</h6>
						<div class="text-center">
							<a class="btn btn-primary-light mt-5 mb-5" href="<?php echo base_url() . 'site/login' ?>"> <i class="fa fa-long-arrow-left"></i> Home </a>
						</div>
                    </div>
				</div>
			</div>
			<!-- PAGE-CONTENT OPEN CLOSED -->
		</div>

		<!-- JQUERY SCRIPTS -->
		<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>


		<!-- CUSTOM JS-->
		<script>
      $(window).on("load", function(e) {
       $("#global-loader").fadeOut("slow");
      })
    </script>

	</body>
</html>