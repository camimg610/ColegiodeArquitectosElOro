<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Lista de items</title>

	<!-- Normalize V8.0.1 -->
<link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

<!-- Bootstrap V4.3 -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

<!-- Bootstrap Material Design V4.0 -->
<link rel="stylesheet" href="{{ asset('css/bootstrap-material-design.min.css') }}">

<!-- Font Awesome V5.9.0 -->
<link rel="stylesheet" href="{{ asset('css/all.css') }}">

<!-- Sweet Alerts V8.13.0 CSS file -->
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

<!-- Sweet Alert V8.13.0 JS file -->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<!-- jQuery Custom Content Scroller V3.1.5 -->
<link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">

<!-- General Styles -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
			background-color: #f9f9f9;
		}

		h1 {
			text-align: center;
			color: #333;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			background-color: #fff;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		th,
		td {
			padding: 10px;
			text-align: center;
			border: 1px solid #ddd;
		}

		th {
			background-color: #D7A643;
			color: white;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		.action-btn {
			padding: 5px 10px;
			text-decoration: none;
			color: white;
			border-radius: 4px;
		}

		.edit-btn {
			background-color: #007BFF;
		}

		.delete-btn {
			background-color: #DC3545;
		}

		.input {
			width: 100%;
			padding: 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
		}

		select.input {
			background-color: white;
			cursor: pointer;
		}

		select.input:focus {
			outline: none;
			border-color: #007BFF;
			box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
		}

		.badge {
			padding: 5px 10px;
			border-radius: 4px;
			font-size: 12px;
			font-weight: bold;
		}
		.badge-success {
			background-color: #28a745;
			color: white;
		}
		.badge-warning {
			background-color: #ffc107;
			color: #212529;
		}
		.badge-danger {
			background-color: #dc3545;
			color: white;
		}
		.badge-secondary {
			background-color: #6c757d;
			color: white;
		}
		.text-center {
			text-align: center;
		}


			max-width: 400px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		}

		.alert-content p {
			margin-bottom: 20px;
			font-size: 16px;
			color: #333;
		}

		.alert-buttons {
			display: flex;
			justify-content: center;
			gap: 15px;
		}

		.alert-buttons button {
			padding: 10px 20px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 14px;
		}

		.alert-buttons button:first-child {
			background-color: #007BFF;
			color: white;
		}

		.alert-buttons button:first-child:hover {
			background-color: #0056b3;
		}

		.alert-buttons button:last-child {
			background-color: #6c757d;
			color: white;
		}

		.alert-buttons button:last-child:hover {
			background-color: #545b62;
		}
	</style>
</head>


<body>
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		@include('layout.header')
		<section class="full-box page-content">
			@include('layout.nav')
			<!-- Page header -->
			<div class="form-container">
				<h1>Lista de Inscripciones</h1>
				<form action="procesar_registro.php" method="POST">
					@csrf
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
							<button class="btn-small" onclick="openModal()" style="background-color: #D7A643;">Nueva inscripción</button>
							<button class="btn-small" onclick="generateReport('pdf')" style="background-color: #28a745;">Reporte PDF</button>
							<button class="btn-small" onclick="generateReport('csv')" style="background-color: #17a2b8;">Reporte CSV</button>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm">
								<thead>
									<tr>
										<th>ID</th>
										<th>Fecha de Inscripción</th>
										<th>Estado</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<tbody id="userTableBody">
									@forelse($inscripciones as $index => $inscripcion)
									<tr data-inscripcion-id="{{ $inscripcion->id_inscripcion }}">
										<td>{{ $inscripcion->id_inscripcion }}</td>
										<td>{{ $inscripcion->fecha_inscripcion ? \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}</td>
										<td>
											@if($inscripcion->estado == 'Activo')
												<span class="badge badge-success">Activo</span>
											@elseif($inscripcion->estado == 'Pendiente')
												<span class="badge badge-warning">Pendiente</span>
											@elseif($inscripcion->estado == 'Cancelado')
												<span class="badge badge-danger">Cancelado</span>
											@else
												<span class="badge badge-secondary">Sin estado</span>
											@endif
										</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
									@empty
									<tr>
										<td colspan="5" class="text-center">No hay inscripciones registradas</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center" id="pagination">
								<li class="page-item"><a class="page-link" href="#"
										onclick="changePage('prev')">Previous</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(2)">2</a></li>
								<li class="page-item"><a class="page-link" href="#" onclick="changePage(3)">3</a></li>
								<li class="page-item"><a class="page-link" href="#"
										onclick="changePage('next')">Next</a></li>
							</ul>
						</nav>
					</div>
					<div id="userModal" class="modalR">
						<div class="modal-content">
							<form id="userForm">
								<div id="error" class="error"></div>
								<h3 style="text-align: center;" id="modalTitle">Registra Inscripción</h3>

								<label for="nombre">Fecha de inscripcion:</label><br>
								<input class="input" type="date" id="fechaI" name="fechaI" required><br><br>

								<label for="nombre">Estado:</label><br>
								<select class="input" id="estado" name="estado" required>
									<option value="">Seleccione un estado</option>
									<option value="Activo">Activo</option>
									<option value="Pendiente">Pendiente</option>
									<option value="Cancelado">Cancelado</option>
								</select><br><br>

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
				// Variables globales para manejar la edición
		let currentEditingRow = null;

		// Funciones específicas para el modal de inscripciones
		function openModal() {
			// Limpiar campos para nueva inscripción
			document.getElementById('fechaI').value = '';
			document.getElementById('estado').value = '';

			// Cambiar título para nueva inscripción
			document.getElementById('modalTitle').textContent = 'Registra Inscripción';

			// Limpiar la fila que se está editando
			currentEditingRow = null;

			document.getElementById('userModal').style.display = 'flex';
		}

		function closeModal() {
			document.getElementById('userModal').style.display = 'none';
		}

		function openAlert(message, action, button) {
			document.getElementById('alertMessage').textContent = message;
			document.getElementById('alertModal').style.display = 'flex';
		}

		function closeAlert() {
			document.getElementById('alertModal').style.display = 'none';
		}

		function confirmAction(action, button) {
			if (action === 'delete') {
				const message = '¿Está seguro de que desea eliminar esta inscripción?';
				openAlert(message, action, button);
			} else if (action === 'edit') {
				const row = button.closest('tr');
				const cells = row.querySelectorAll('td');

				// Guardar la fila que se está editando
				currentEditingRow = row;

				// Obtener los datos de la fila
				const fechaInscripcion = cells[1].textContent; // Fecha de inscripción
				const estadoBadge = cells[2].querySelector('.badge'); // Estado (elemento badge)
				const estado = estadoBadge ? estadoBadge.textContent.trim() : ''; // Extraer texto del badge

				// Convertir fecha de formato dd/mm/yyyy a yyyy-mm-dd para el input date
				const fechaParts = fechaInscripcion.split('/');
				const fechaFormateada = fechaParts.length === 3 ?
					`${fechaParts[2]}-${fechaParts[1].padStart(2, '0')}-${fechaParts[0].padStart(2, '0')}` :
					fechaInscripcion;

				// Rellenar el formulario
				document.getElementById('fechaI').value = fechaFormateada;
				document.getElementById('estado').value = estado;

				// Cambiar título para editar inscripción
				document.getElementById('modalTitle').textContent = 'Editar Inscripción';

				// Abrir el modal
				openModal();
			}
		}

		// Manejar el envío del formulario
		document.getElementById('userForm').addEventListener('submit', function(e) {
			e.preventDefault();

			const formData = new FormData(this);
			const isEdit = document.getElementById('modalTitle').textContent.includes('Editar');

			let url = '/inscripciones';
			let method = 'POST';

			if (isEdit) {
				// Si es edición, necesitamos el ID de la inscripción
				if (currentEditingRow) {
					const idInscripcion = currentEditingRow.getAttribute('data-inscripcion-id');
					console.log('Editando inscripción con ID:', idInscripcion);
					console.log('URL:', `/inscripciones/${idInscripcion}`);
					url = `/inscripciones/${idInscripcion}`;
					method = 'PUT';
				} else {
					console.error('No se encontró la fila que se está editando');
				}
			}

			const requestData = {
				fecha_inscripcion: formData.get('fechaI'),
				estado: formData.get('estado')
			};

			console.log('Enviando datos:', requestData);
			console.log('URL:', url);
			console.log('Método:', method);

			fetch(url, {
				method: method,
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(requestData)
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					alert(data.message);
					closeModal();
					location.reload(); // Recargar la página para mostrar los cambios
				} else {
					alert('Error: ' + data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error al procesar la solicitud');
			});
		});

		// Event listener para el botón de confirmación del alert
		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('alertConfirm').addEventListener('click', function() {
				// Aquí puedes agregar la lógica para eliminar la inscripción
				closeAlert();
			});
		});

		// Función para generar reportes
		function generateReport(format) {
			window.location.href = `/inscripciones/reporte?format=${format}`;
		}
	</script>

	<style>

	</style>
</body>

</html>
