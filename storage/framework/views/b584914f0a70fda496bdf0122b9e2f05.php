<!DOCTYPE html>
<html lang="es">

<head>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Lista de clientes</title>

	<!-- Normalize V8.0.1 -->
	<link rel="stylesheet" href="./css/normalize.css">

	<!-- Bootstrap V4.3 -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">

	<!-- Bootstrap Material Design V4.0 -->
	<link rel="stylesheet" href="./css/bootstrap-material-design.min.css">

	<!-- Font Awesome V5.9.0 -->
	<link rel="stylesheet" href="./css/all.css">

	<!-- Sweet Alerts V8.13.0 CSS file -->
	<link rel="stylesheet" href="./css/sweetalert2.min.css">

	<!-- Sweet Alert V8.13.0 JS file-->
	<script src="./js/sweetalert2.min.js"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">

	<!-- General Styles -->
	<link rel="stylesheet" href="./css/style.css">
</head>

<body>

	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php echo $__env->make('layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<!-- Page content -->
		<section class="full-box page-content">
			<?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<!-- Page header -->
			<div class="form-container">
				<h1>Registro de Usuarios</h1>
				   <form action="procesar_registro.php" method="POST">
					   <?php echo csrf_field(); ?>
					<nav class="navbar navbar-light bg-light">
						<div class="col-xs-12 lead">
							<select id="rowLimit" class=" letra-selec" onchange="showRows(); updateRowsPerPage()"
								style=" margin-right: 670px;">
								<option value="all">Todas </option>
								<option value="5">Mostrar 5 filas</option>
								<option value="10">Mostrar 10 filas</option>
								<option value="15">Mostrar 15 filas</option>
								<option value="20">Mostrar 20 filas</option>
							</select>
							<form class="d-flex" role="search" style="text-align: right;">
								<input type="text" id="searchInput" placeholder="Buscar..." onkeyup="searchTable()">
								<button class="btn btn-outline-success" type="submit">Search</button>
							</form>
						</div>
					</nav>
					<!-- Content here-->
					<div class="container-fluid">
						<div style="display: flex; gap: 10px; margin-bottom: 15px;">
							<button class="btn-small" onclick="openModal()" style="background-color: #D7A643;">Nuevo usuario</button>
							<button class="btn-small" onclick="generateReport('pdf')" style="background-color: #28a745;">Reporte PDF</button>
							<button class="btn-small" onclick="generateReport('csv')" style="background-color: #17a2b8;">Reporte CSV</button>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm">
								<thead>
									<tr>
										<th>#</th>
										<th>Cédula</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Dirección</th>
										<th>Email</th>
										<th>Contraseña</th>
										<th>Activo</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<tbody id="userTableBody">
									<tr>
										<td>1</td>
										<td>1102345678</td>
										<td>María</td>
										<td>Pérez</td>
										<td>Av. Siempre Viva 123</td>
										<td>maria.perez@example.com</td>
										<td>********</td>
										<td >Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
									<tr>
										<td>2</td>
										<td>1103456789</td>
										<td>José</td>
										<td>Ramírez</td>
										<td>Calle Los Pinos 456</td>
										<td>jose.ramirez@example.com</td>
										<td>********</td>
										<td>Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>3</td>
										<td>1104567890</td>
										<td>Ana</td>
										<td>Fernández</td>
										<td>Barrio La Pradera</td>
										<td>ana.fernandez@example.com</td>
										<td>********</td>
										<td>No</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>4</td>
										<td>1105678901</td>
										<td>Pedro</td>
										<td>López</td>
										<td>Av. Quito 789</td>
										<td>pedro.lopez@example.com</td>
										<td>********</td>
										<td>Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>5</td>
										<td>1106789012</td>
										<td>Sofía</td>
										<td>Martínez</td>
										<td>Colinas del Sur</td>
										<td>sofia.martinez@example.com</td>
										<td>********</td>
										<td>No</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>6</td>
										<td>1107890123</td>
										<td>Ricardo</td>
										<td>Díaz</td>
										<td>Ciudad Jardín 23</td>
										<td>ricardo.diaz@example.com</td>
										<td>********</td>
										<td>Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>7</td>
										<td>1108901234</td>
										<td>Carla</td>
										<td>Mendoza</td>
										<td>Centro Histórico</td>
										<td>carla.mendoza@example.com</td>
										<td>********</td>
										<td>No</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>8</td>
										<td>1109012345</td>
										<td>Diego</td>
										<td>Ortega</td>
										<td>Av. Las Palmeras</td>
										<td>diego.ortega@example.com</td>
										<td>********</td>
										<td>Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>9</td>
										<td>1110123456</td>
										<td>Elena</td>
										<td>Vásquez</td>
										<td>Urbanización Santa Fe</td>
										<td>elena.vasquez@example.com</td>
										<td>********</td>
										<td>No</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>10</td>
										<td>1111234567</td>
										<td>Fernando</td>
										<td>González</td>
										<td>Residencial La Fuente</td>
										<td>fernando.gonzalez@example.com</td>
										<td>********</td>
										<td>Sí</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>

									<tr>
										<td>11</td>
										<td>1112345678</td>
										<td>Gabriela</td>
										<td>Ríos</td>
										<td>Parque Industrial</td>
										<td>gabriela.rios@example.com</td>
										<td>********</td>
										<td>No</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
								</tbody>
							</table>
						</div>
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center" id="pagination">
								<li class="page-item"><a class="page-link" href="#" onclick="changePage('prev')">Previous</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(2)">2</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(3)">3</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage('next')">Next</a></li>
							</ul>
						</nav>
					</div>
					   </form> <!-- Cierre del formulario exterior para evitar formularios anidados -->
					   <div id="userModal" class="modal">
						   <div class="modal-content">
							   <form id="userForm">
								<div id="error" class="error"></div>
								<h3 style="text-align: center;">Registrar nuevo usuario</h3>

								<label for="nombre">Cedula:</label><br>
								<input class="input" type="number" id="cedula" name="cedula" required><br><br>

								<label for="nombre">Nombre:</label><br>
								<input class="input" type="text" id="nombre" name="nombre" required><br><br>

								<label for="nombre">Apellido:</label><br>
								<input class="input" type="text" id="apellido" name="apellido" required><br><br>

								<label for="direccion">Dirección:</label><br>
								<input class="input" type="text" id="direccion" name="direccion" required><br><br>

								<label for="email">Email:</label><br>
								<input class="input" type="email" id="email" name="email" required><br><br>

								<label for="cedula">Contraseña:</label><br>
								<input class="input" type="text" id="contraseña" name="contraseña" required><br><br>

								<label for="cedula">Activo:</label><br>
								<input class="input" type="text" id="activo" name="activo" required><br><br>

								<button type="submit">Guardar</button>
								<button class="modal-close" onclick="closeModal()">X</button>
							</form>
						</div>
					   </div>
					   <div id="alertModal" class="alert-modal">
						<div class="alert-content">
							<p id="alertMessage">¿Está seguro?</p>
							<div class="alert-buttons">
								<button id="alertConfirm">Sí</button>
								<button onclick="closeAlert()">No</button>
							</div>
						</div>
					   </div>
				   <!-- Eliminado el cierre extra del formulario exterior aquí -->
		</section>

	</main>


	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="./js/jquery-3.4.1.min.js"></script>

	<!-- popper -->
	<script src="./js/popper.min.js"></script>

	<!-- Bootstrap V4.3 -->
	<script src="./js/bootstrap.min.js"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="./js/bootstrap-material-design.min.js"></script>
	<script>$(document).ready(function () { $('body').bootstrapMaterialDesign(); });</script>

	<script src="./js/main.js"></script>
	<script src="./js/editar.js"></script>

	<script>
		// Función para generar reportes
		function generateReport(format) {
			window.location.href = `/usuarios/reporte?format=${format}`;
		}
	</script>

	<style>
		.pdf-btn {
			background-color: #28a745 !important;
			color: white !important;
		}
		.pdf-btn:hover {
			background-color: #218838 !important;
		}
	</style>
</body>

</html>
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/registro de usuarios/registro_de_usuario.blade.php ENDPATH**/ ?>