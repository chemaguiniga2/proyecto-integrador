<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- TITLE -->
<title>Payment Information</title>

<!-- DASHBOARD CSS -->
<link href="../assets/css/billing.css" rel="stylesheet" type="text/css"
	media="all" />
<link href="../assets/css/listMetrics.css" rel="stylesheet"
	type="text/css" media="all" />

<!-- notas 

Falta a�adir bot�n cancelar suscripci�n
Falta a�adir bot�n otrogar recibo

-->

<!-- notas -->

<!-- A Stripe Element will be inserted here. -->
</head>
<body>

	<div style="margin-top: 60px; border-radius: 15px 15px 15px 15px;">
		<div class="billing-table w3l">
			<div class="wrap" align='center'
				style="border-radius: 15px 15px 15px 15px;">
				<h1><?php echo $ptitleList ?></h1>
				<div class="billing-table-division"></div>
				<div class="list-grid">
					<table class="table-list">
						<thead>
							<tr>
    						<?php foreach ($tableTitles as $title){?>
    							<th><?php echo $title ?></th>
    						<?php }?>
    						</tr>
						</thead>
						<tbody id="cuerpoTabla" class="table-body">
							<?php foreach ($users as $user){?>
							<tr>
								    <td><?php echo $user['id'] ?></td>
								    <td><?php echo $user['username'] ?></td>
								    <td><?php echo $user['email'] ?></td>
								    <td><?php echo $user['id_customer_stripe'] ?></td>
    						</tr>
    						<?php }?>
						</tbody>
					</table>
					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pruebaPDF?ptitleList=' . $ptitleList?>">Download pdf</a>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
</body>

<script type="text/javascript">

const $cuerpoTabla = document.querySelector("#cuerpoTabla");
productos.forEach(producto => {
 // Crear un <tr>
 	const $tr = document.createElement("tr");
 // Creamos el <td> de nombre y lo adjuntamos a tr
 	let $tdNombre = document.createElement("td");
 	$tdNombre.textContent = producto.nombre; // el textContent del td es el nombre
 	$tr.appendChild($tdNombre);
 // El td de precio
 	let $tdPrecio = document.createElement("td");
 	$tdPrecio.textContent = producto.precio;
 	$tr.appendChild($tdPrecio);
 // El td del c�digo
 	let $tdCodigo = document.createElement("td");
 		$tdCodigo.textContent = producto.codigo;
 	$tr.appendChild($tdCodigo);
 // Finalmente agregamos el <tr> al cuerpo de la tabla
 	$cuerpoTabla.appendChild($tr);
 // Y el ciclo se repite hasta que se termina de recorrer todo el arreglo
});
</script>


</html>