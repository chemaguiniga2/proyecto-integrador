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



<!-- A Stripe Element will be inserted here. -->
</head>
<body>
	<div style="margin-top: 60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table" style="margin-bottom: 20px;">
			<div class="wrap" align='center'
				style="border-radius: 15px 15px 15px 15px;">
				<h1>Add New Plan</h1>
				<div class="billing-table-division"></div>
				<form method="post" action='addPlan'>
					<div class="row" style="margin-left: 33%;">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="planName">Plan Name</label> <input type="text"
									class="form-control" id="name" name="name"
									placeholder="Test Plan 1">
							</div>
						</div>
					</div>

					<div class="row" style="margin-left: 33%;">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="monthly">Monthly Price</label> <input input
									type="number" min="0.00" max="10000.00" step="1.00"
									class="form-control" id="monthly-price" name="monthly-price"
									placeholder="15">
							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 33%;">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label for="monthlyprice">Annual Price</label> <input input
									type="number" min="0.00" max="10000.00" step="1.00"
									class="form-control" id="annual-price" name="annual-price"
									placeholder="150">
							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 33%;">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label class="form-label">Allowed Users</label> <input
									type="number" min="0.00" class="form-control" id="users" name="users"
									placeholder="10">
							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 33%;">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								<label class="form-label">Allowed Clouds</label> <input
									type="number" min="0.00" class="form-control" id="clouds" name="clouds"
									placeholder="5">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-success-light mt-2">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
	
</script>

</body>
</html>