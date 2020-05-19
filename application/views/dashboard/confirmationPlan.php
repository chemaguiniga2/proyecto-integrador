<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TITLE -->
<title>Confirmation Plan</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/confirmationPlan.css" rel="stylesheet" type="text/css"
	media="all" />

<link href="https://fonts.googleapis.com/css?family=Monda"
	rel="stylesheet">

<script src="js/confirmationPlan.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- A Stripe Element will be inserted here. -->
</head>
<body>

	<div class="side-app">
		
		<div class="confirmation-table">
			<h1>Your membership plan has been successfully changed!</h2>
			<div class="confirmation-table-division"></div>
			<h2>New membership Plan</h3>
			<p><?php echo $selected_plan[0]['name']?></p>
			<h2>Type</h3>
			<p><?php echo $type?></p>
			<p class="informative" >Your next charge will be on</p>
			<button class="generic-button">Back to Dashboard</button>
		</div>

	</div>

</body>
</html>


