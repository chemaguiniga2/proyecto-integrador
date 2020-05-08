
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

		<!-- GLOABAL LOADER -->
		<div id="global-loader">
			<img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>

		<div class="page">
			<div class="">

				<!-- CONTAINER OPEN -->
				<div class="col col-login mx-auto">
					<div class="text-center">
						<img src="../assets/images/logo.png" class="header-brand-img" style="height: 4.5rem;" alt="">
					</div>
				</div>
				<div class="container-1">
					<div class="access-container p-6">
          <?php
          $foptions = array('id' => "registerform", 'onsubmit' => "return checkOk()");
            echo form_open('register', $foptions)
          ?>
						<form class="login-form validate-form">
							<span class="login-form-title">
								Registration
							</span>
							<div class="access-input validate-input" data-validate = "Username must have 8 characters">
								<input class="login-input" type="text" id="username" name="username" placeholder="Username">
								<span class="input-focus"></span>
								<span class="input-symbol">
									<i class="mdi mdi-account" aria-hidden="true"></i>
								</span>
							</div>
							<div class="access-input validate-input" data-validate = "Valid email is required: ex@abc.xyz">
								<input class="login-input form-control" type="text" id="email" name="email" placeholder="Email">
								<span class="input-focus"></span>
								<span class="input-symbol">
									<i class="zmdi zmdi-email" aria-hidden="true"></i>
								</span>
							</div>
							<div class="access-input validate-input" data-validate = "Password is required">
								<input class="login-input form-control" type="password" id="pass" name="pass" placeholder="Password">
								<span class="input-focus"></span>
								<span class="input-symbol">
									<i class="zmdi zmdi-lock" aria-hidden="true"></i>
								</span>
							</div>
							<label class="custom-control custom-checkbox mt-4 mb-4">
								<input type="checkbox" id="agree" class="custom-control-input">
								<span class="custom-control-label">Agree the <a href="terms.html">terms and policy</a></span>
							</label>
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
<!-- 								<button type="submit" class="btn btn-primary-light btn-block">Register</button> -->
								<p class="mb-0"><a href="<?php echo base_url() . 'billing/showPlans' ?>" class="text-primary ml-1">Register</a></p>
							</div>
							<div class="text-center pt-3">
								<p class="mb-0">Already have account?<a href="<?php echo base_url() . 'login' ?>" class="text-primary ml-1">Sign In</a></p>
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

      $(function() {
          $("input#username").on("keydown", function (e) {
              return e.which !== 32;
          })
      });

      function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }

      var myInput = document.getElementById("pass");
      myInput.onkeyup = function() {
        // Validate lowercase letters
        
        valid = validatePass()

        
        if (valid) {
          document.getElementById("pass").classList.remove('is-invalid');
          document.getElementById("pass").classList.add('is-valid');
        } else {
          document.getElementById("pass").classList.remove('is-valid');
          document.getElementById("pass").classList.add('is-invalid');
        }
      }

      function validatePass() {
        // Validate lowercase letters
        
        valid = true
        var lowerCaseLetters = /[a-z]/g;
        if(!myInput.value.match(lowerCaseLetters)) {  
          valid = false
         
        }
        
        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(!myInput.value.match(upperCaseLetters)) {  
          valid = false
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(!myInput.value.match(numbers)) {  
          valid = false
        }
        
        // Validate length
        if(!myInput.value.length >= 8) {
          valid = false
        }
        
        return(valid)
      }

      function checkOk() {
        if (!validatePass()) {
          $("#warningtext").html('Pasword must contain at least 8 characters, upercase, lowercase and numbers')
          $("#warningdiv").show()
          return(false)
        }
        if(!validateEmail($("#email").val())) {
          $("#warningtext").html('Please verify your email')
          $("#warningdiv").show()
          return(false)
        }
        if($("#username").val().length < 5) {
          $("#warningtext").html('Username is too short')
          $("#warningdiv").show()
          return(false)
        }
        if(!$("#agree").prop('checked')) {
          $("#warningtext").html('You must agree with terms and conditions')
          $("#warningdiv").show()
          return(false)
        }
        return(true)
      }
    </script>
	</body>
</html>
