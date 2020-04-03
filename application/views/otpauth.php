<!doctype html>
<html lang="en" dir="ltr">
<head>
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

		<!-- SINGLE-PAGE CSS -->
		<link href="../assets/plugins/single-page/css/main.css" rel="stylesheet" type="text/css">

		<!--- FONT-ICONS CSS -->
		<link href="../assets/css/icons.css" rel="stylesheet"/>

	</head>
	<body class="app sidebar-mini rtl body-dark">


	<div id='stars2'></div>

		<!-- GLOABAL LOADER -->
		<div id="global-loader">
			<img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>

		<div class="page">
			<div class="">
				<!-- CONTAINER OPEN -->
				<div class="col col-login mx-auto">
					<div class="text-center">
            <img src="../assets/images/oclogo1.png" class="header-brand-img" style="height: 4.5rem;" alt="">
					</div>
				</div>
				<div class="container-1">
					<div class="access-container p-6">
            <?php
            $foptions = array('id' => "authform", 'onsubmit' => "return checkOk()");
              echo form_open('security/otpauth', $foptions)
            ?>
							<span class="login-form-title">
								2FA Authentication
							</span>
							<div class="access-input validate-input" data-validate ="">
                <label for="">Enter your OTP Code</label>
								<input class="login-input" type="text" name="token" id="token" placeholder="OTP Code">
								<span class="input-focus"></span>
								<span class="input-symbol">
									<i class="zmdi zmdi-email" aria-hidden="true"></i>
								</span>
							</div>

              <div class="alert alert-warning form-control" id="warningdiv" style="max-width:300px;<?php if (!isset($message)){echo 'display:none;';} ?>" role="alert">
                  <span class="alert-inner--icon"></span>
                  <span class="alert-inner--text" id="warningtext">
                  <?php
                    if (isset($message)) {
                      echo($message);
                    }
                  ?>
                  </span>
              </div>

							<div class="">
                <button type="submit" class="btn btn-primary-light btn-block">Submit</button>
                <a href="<?php echo base_url() . 'security/otpcancel' ?>" class="btn btn-warning-light btn-block">Cancel</button>
							</div>


						<?php echo form_close() ?>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
			</div>
		</div>

		<!-- JQUERY SCRIPTS -->
		<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>


		<!-- INPUT MASK PLUGIN-->
		<script src="../assets/plugins/input-mask/jquery.mask.min.js"></script>

		<!-- CUSTOM JS-->

    <script>
      $(window).on("load", function(e) {
        $("#global-loader").fadeOut("slow");
      })

    </script>

	</body>
</html>
