<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Lista usuarios</title>

	<!-- Normalize V8.0.1 -->
<link rel="stylesheet" href="<?php echo e(asset('css/normalize.css')); ?>">

<!-- Bootstrap V4.3 -->
<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">

<!-- Bootstrap Material Design V4.0 -->
<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-material-design.min.css')); ?>">

<!-- Font Awesome V5.9.0 -->
<link rel="stylesheet" href="<?php echo e(asset('css/all.css')); ?>">

<!-- Sweet Alerts V8.13.0 CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('css/sweetalert2.min.css')); ?>">

<!-- Sweet Alert V8.13.0 JS file -->
<script src="<?php echo e(asset('js/sweetalert2.min.js')); ?>"></script>

<!-- jQuery Custom Content Scroller V3.1.5 -->
<link rel="stylesheet" href="<?php echo e(asset('css/jquery.mCustomScrollbar.css')); ?>">

<!-- General Styles -->
<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

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
				<h1>Lista de Alquiler</h1>
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
							<button class="btn-small" onclick="openModal()" style="background-color: #D7A643;">Nuevo alquiler</button>
							<button class="btn-small" onclick="generateReport('pdf')" style="background-color: #28a745;">Reporte PDF</button>
							<button class="btn-small" onclick="generateReport('csv')" style="background-color: #17a2b8;">Reporte CSV</button>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm">
								<thead>
									<tr>
										<th>#</th>
										<th>Fecha</th>
										<th>Hora Inicio</th>
										<th>Hora Fin</th>
										<th>Costo</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<tbody id="userTableBody">
									<tr>
										<td>1</td>
										<td>2025-01-25</td>
										<td>08:00</td>
										<td>12:00</td>
										<td>$50.00</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
									<tr>
										<td>2</td>
										<td>2025-01-26</td>
										<td>14:00</td>
										<td>18:00</td>
										<td>$60.00</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
									<tr>
										<td>3</td>
										<td>2025-01-27</td>
										<td>09:00</td>
										<td>11:00</td>
										<td>$30.00</td>
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
					<div id="userModal" class="modalR">
						<div class="modal-content">
							<form id="userForm">
								<div id="error" class="error"></div>
								<h3 style="text-align: center;">Registrar nuevo alquiler</h3>

								<label for="nombre">Fecha:</label><br>
								<input class="input" type="date" id="fecha" name="fecha" required><br><br>

								<label for="nombre">Hora inicio:</label><br>
								<input class="input" type="datetime" id="horaI" name="horaI" required><br><br>

								<label for="nombre">Hora fin:</label><br>
								<input class="input" type="text" id="horaF" name="horaF" required><br><br>

								<label for="direccion">Costo:</label><br>
								<input class="input" type="text" id="costo" name="costo" required><br><br>

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
				</form>
		</section>
	</main>


	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="./js/jquery-3.4.1.min.js" ></script>

	<!-- popper -->
	<script src="./js/popper.min.js" ></script>

	<!-- Bootstrap V4.3 -->
	<script src="./js/bootstrap.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="./js/jquery.mCustomScrollbar.concat.min.js" ></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="./js/bootstrap-material-design.min.js" ></script>
	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

	<script src="./js/main.js" ></script>
	<script src="./js/editar.js"></script>

	<script>
		// Función para generar reportes
		function generateReport(format) {
			window.location.href = `/alquiler/reporte?format=${format}`;
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
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/alquiler/alquiler.blade.php ENDPATH**/ ?>