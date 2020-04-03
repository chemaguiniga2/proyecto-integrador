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

      <div class="col col-login mx-auto">
					<div class="text-center">
            <img src="../assets/images/oclogo1.png" class="header-brand-img" style="height: 4.5rem;" alt="">
					</div>
				</div>
				<!-- CONTAINER OPEN -->
				<div class="container-1">
					<div class="row">
						<div class="col col-login mx-auto">
                <?php
                $foptions = array('class' => "card", 'id' => "recover", 'onsubmit' => "return checkOk()");
                  echo form_open('recovery', $foptions)
                ?>
                <?php
                  if (isset($uid)) {
                    echo('<input type="hidden" name="uid" value="' . $uid .'">');
                  }
                ?>
								<div class="card-body p-6">
                  <h3 class="text-center card-title">New Password</h3>
                    <div class="access-input validate-input" data-validate = "">
                      <label for=""><?php echo $qtext ?></label>
                      <input type="hidden" name="qid" value="<?php echo $qid ?>">
											<input <?php if ($disableb) {echo "disabled";} ?> class="login-input" type="text" id="sresponse" name="sresponse" placeholder="">
											<span class="input-focus"></span>

										</div>
										<div class="access-input validate-input" data-validate = "">
											<input <?php if ($disableb) {echo "disabled";} ?>class="login-input" type="password" id="pass" name="pass" placeholder="New Password">
											<span class="input-focus"></span>
											<span class="input-symbol">
												<i class="zmdi zmdi-lock" aria-hidden="true"></i>
											</span>
										</div>
                    <div class="access-input validate-input" data-validate = "">
											<input <?php if ($disableb) {echo "disabled";} ?>class="login-input" type="password" id="pass2" name="pass2" placeholder="Confirm your password">
											<span class="input-focus"></span>
											<span class="input-symbol">
												<i class="zmdi zmdi-lock" aria-hidden="true"></i>
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
										<div class="form-footer">
											<button <?php if ($disableb) {echo "disabled";} ?> type="submit" class="btn btn-primary-light btn-block">Send</button>
										</div>
										<div class="text-center text-muted mt-3 ">
										
									</div>
								</div>
							<?php echo form_close() ?>
						</div>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
			</div>
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
      function validatePass() {
        // Validate lowercase letters
        var myInput = document.getElementById("pass");
        
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

        if(!validatePass()) {
          $("#warningtext").html('Pasword must contain at least 8 characters, upercase, lowercase and numbers')
          $("#warningdiv").show()
          return(false)
        }

        if($("#pass").val() != $("#pass2").val()) {
          $("#warningtext").html('Paswords must match')
          $("#warningdiv").show()
          return(false)
        }

        return(true)
      }

    </script>

	</body>
</html>
