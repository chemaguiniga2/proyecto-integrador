<!DOCTYPE HTML>
<html>
<head>

<!-- TITLE -->
<title>Membership cancellation</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />
	
</head>
<body>
	<div style=" margin-top:60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table w3l">
			<div class="wrap" align='center' style="border-radius: 15px 15px 15px 15px;">
				<h1>Account</h1>
				<div class="billing-table-division"></div>
				<div class="option-grid">					
					<button class="button-cancel" id="btnCancel"> Cancel Membership</button>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
</body>

<div id="popup-grid-cancel" class="overlay">
	<div class="popup">
		<h2 id="sel-plan">membership cancellation confirmation</h2>
		<p id="message-cancel"></p>
		<button id="btnCloseCancel" class="cancel">Cancel</button>
		<button id="btnConfirmCancelation" class="confirm">Confirm</button>
		<div class="content"></div>
	</div>
</div>

<script>

	document.getElementById("btnCancel").onclick = function() {

		document.getElementById("popup-grid-cancel").style.visibility = "visible";
		document.getElementById("popup-grid-cancel").style.opacity = "1";
		document.getElementById("message-cancel").innerHTML = 'Are you sure you want to cancel your memebership? ' + name + '.';

	}

	document.getElementById("btnConfirmCancelation").onclick = function() {

		document.getElementById("popup-grid-cancel").style.visibility = "visible";
		document.getElementById("popup-grid-cancel").style.opacity = "1";
		location.href='<?php echo base_url() . 'billing/cancelSubscription'?>';
		
	}

	document.getElementById("btnCloseCancel").onclick = function() {
		  document.getElementById("popup-grid-cancel").style.visibility = "hidden";
		  document.getElementById("popup-grid-cancel").style.opacity = "0";
	}
	
</script>

</html>

