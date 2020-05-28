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
<link href="../assets/css/dashboard.css" rel="stylesheet" />

<!--- FONT-ICONS CSS -->
<link href="../assets/css/icons.css" rel="stylesheet" />



<!-- extrasssss -->

<link href="../assets/css/billingRegistration.css" rel="stylesheet"
	type="text/css" media="all" />




<link href="https://fonts.googleapis.com/css?family=Monda"
	rel="stylesheet">


<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/confirmationpopup.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body
	style="background: rgb(81, 53, 125); background: radial-gradient(circle, rgba(81, 53, 125, 1) 0%, rgba(56, 55, 55, 1) 100%);">

	<div class="top-div">
		<img src="../assets/images/logo.png" class="header-image"
			alt="OneCloud logo">
	</div>

	<div style="margin-top: 60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table">
			<div class="wrap" align='center'
				style="border-radius: 15px 15px 15px 15px;">
				<h1>Choose the OneCloud plan that fits your needs</h1>
				<div class="billing-table-division"></div>
			<?php
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
								onclick="confirmPlan(<?php echo $plan['id']?>, '<?php echo $plan['name'] ?>', <?php echo $plan['monthly_price']?>, <?php echo $plan['annual_price']?>)">Suscribe</button>


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
			<p id="message-top"></p>
			<div class="container-1">
				<div class="access-container p-6">
          <?php
        $foptions = array(
            'id' => "registerform",
            'onsubmit' => "return checkOk()"
        );
        echo form_open('site/register', $foptions)?>
						<form class="login-form validate-form">

						<div class="input-icons access-input validate-input"
							data-validate="Username must have 8 characters">
							<i class="mdi mdi-account icon" aria-hidden="true"></i> <input
								class="input-field" type="text" id="username" name="username"
								placeholder="Username">
						</div>

						<div class="input-icons access-input validate-input"
							data-validate="Valid email is required: ex@abc.xyz">
							<i class="zmdi zmdi-email icon" aria-hidden="true"></i> <input
								class="input-field" type="text" id="email" name="email"
								placeholder="Email">
						</div>

						<div class="input-icons access-input validate-input"
							data-validate="Password is required">
							<i class="zmdi zmdi-lock icon" aria-hidden="true"></i> <input
								class="input-field" type="password" id="pass" name="pass"
								placeholder="Password">
						</div>

						<label class="custom-control custom-checkbox mt-4 mb-4"> <input
							type="checkbox" id="agree" class="custom-control-input"> <span
							class="custom-control-label">Agree the <a href="terms.html">terms
									and policy</a></span>
						</label>
						<div class="alert alert-warning form-control" id="warningdiv" style="max-width:300px;<?php if (!isset($message)){echo 'display:none;';} ?>" role="alert">
							<span class="alert-inner--icon"></span> <span
								class="alert-inner--text" id="warningtext">
                  <?php
                if (isset($message)) {
                    echo ($message);
                }
                ?>
                  </span>
						</div>
						<div class="">
							<button type="submit" class="btn btn-primary-light btn-block">Register</button>
						</div>
<!-- 						<div class="text-center pt-3"> -->
<!-- 							<p class="mb-0"> -->
<!-- 								Already have account?<a 
									href="<?php// echo base_url() . 'login' ?>"-->
<!-- 									class="text-primary ml-1">Sign In</a> -->
<!-- 							</p> -->
<!-- 						</div> -->

						<?php echo form_close() ?>	
				
				
				
				
				</div>
			</div>
<!-- 			<p id="info-payment">Payment Information</p> -->

<!-- 			<div class="card__container"> -->
<!-- 				<div class="card"> -->

<!-- 					<div class="row credit"> -->
<!-- 						<div class="left"> -->
<!-- 							<label for="cd">Enter your payment information.</label> -->
<!-- 						</div> -->
<!-- 						<div class="right"></div> -->
<!-- 					</div> -->
<!-- 					<div class="row cardholder"> -->
<!-- 						<div class="info"> -->
<!-- 							<label for="cardholdername">Name</label> <input -->
<!-- 								placeholder="e.g. Carmelo Milan" id="cardholdername" type="text" /> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div class="row number"> -->
<!-- 						<div class="info"> -->
<!-- 							<label for="cardnumber">Card number</label> <input -->
<!-- 								id="cardnumber" type="text" pattern="[0-9]{16,19}" -->
<!-- 								maxlength="19" placeholder="6969-6969-6969-6969" /> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div class="row details"> -->
<!-- 						<div class="left"> -->
<!-- 							<label for="expiry-date">Expiry</label> <select id="expiry-date"> -->
<!-- 								<option>MM</option> -->
<!-- 								<option value="1">01</option> -->
<!-- 								<option value="2">02</option> -->
<!-- 								<option value="3">03</option> -->
<!-- 								<option value="4">04</option> -->
<!-- 								<option value="5">05</option> -->
<!-- 								<option value="6">06</option> -->
<!-- 								<option value="7">07</option> -->
<!-- 								<option value="8">08</option> -->
<!-- 								<option value="9">10</option> -->
<!-- 								<option value="11">11</option> -->
<!-- 								<option value="12">12</option> -->
<!-- 							</select> <span>/</span> <select id="expiry-date"> -->
<!-- 								<option>YYYY</option> -->
<!-- 								<option value="2020">2020</option> -->
<!-- 								<option value="2021">2021</option> -->
<!-- 								<option value="2022">2022</option> -->
<!-- 								<option value="2023">2023</option> -->
<!-- 								<option value="2024">2024</option> -->
<!-- 								<option value="2025">2025</option> -->
<!-- 								<option value="2026">2026</option> -->
<!-- 								<option value="2027">2027</option> -->
<!-- 								<option value="2028">2028</option> -->
<!-- 								<option value="2029">2029</option> -->
<!-- 								<option value="2030">2030</option> -->
<!-- 							</select> -->
<!-- 						</div> -->
<!-- 						<div class="right"> -->
<!-- 							<label for="cvv">CVC/CVV</label> <input type="text" maxlength="4" -->
<!-- 								placeholder="123" /> <span data-balloon-length="medium" -->
<!-- 								data-balloon="The 3 or 4-digit number on the back of your card." -->
<!-- 								data-balloon-pos="up">i</span> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 			</div> -->

			<button id="btnClose" class="cancel">Cancel</button>
			<div class="content"></div>
		</div>
	</div>

	<script>

	document.getElementById("btnClose").onclick = function() {
		
		  document.getElementById("popup-grid").style.visibility = "hidden";
		  document.getElementById("popup-grid").style.opacity = "0";

	}
	
   $(window).on("load", function(e) {
	        $("#global-loader").fadeOut("slow");
  	})

	$(function() {
		$("input#username").on("keydown", function (e) {
			return e.which !== 32;
          })
	});

	function confirmPlan(id,name,monthly,annnual) {	
		
		document.getElementById("popup-grid").style.visibility = "visible";
		document.getElementById("popup-grid").style.opacity = "1";
		document.getElementById("message-top").innerHTML = 'You choose ' + name + '.';
		document.getElementById("message-down").innerHTML = 'Confirm the payment period and will start on next bill date.';
		document.getElementById("btnConfirmAnnual").setAttribute("plan", id);
		document.getElementById("btnConfirmMonthly").setAttribute("plan", id);				
		  
	}



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

