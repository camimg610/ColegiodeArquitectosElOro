<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Lista de permisos</title>

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

	<style>
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
		.badge-danger {
			background-color: #dc3545;
			color: white;
		}
		.text-center {
			text-align: center;
		}

	</style>
</head>

<body>

	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		@include('layout.header')
		<!-- Page content -->
		<section class="full-box page-content">
			@include('layout.nav')
			<!-- Page header -->
			<div class="form-container">
				<h1>Registro de Permisos</h1>
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
							<button class="btn-small" onclick="openModal()" style="background-color: #D7A643;">Nuevo permiso</button>
							<button class="btn-small" onclick="generateReport('pdf')" style="background-color: #28a745;">Reporte PDF</button>
							<button class="btn-small" onclick="generateReport('csv')" style="background-color: #17a2b8;">Reporte CSV</button>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Permiso</th>
										<th>Nombre del Permiso</th>
										<th>Descripción</th>
										<th>Estado</th>
										<th>Fecha Creación</th>
										<th>Fecha Actualización</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<tbody id="userTableBody">
									@forelse($permisos as $index => $permiso)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $permiso->id_permiso }}</td>
										<td>{{ $permiso->nombre_permiso }}</td>
										<td>{{ $permiso->descripcion ?: 'Sin descripción' }}</td>
										<td>
											@if($permiso->activo)
												<span class="badge badge-success">Activo</span>
											@else
												<span class="badge badge-danger">Inactivo</span>
											@endif
										</td>
										<td>{{ $permiso->created_at ? $permiso->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
										<td>{{ $permiso->updated_at ? $permiso->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
									</tr>
									@empty
									<tr>
										<td colspan="9" class="text-center">No hay permisos registrados</td>
									</tr>
									@endforelse
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
					<div id="userModal" class="permisos-modal">
						<div class="permisos-modal-content">
							<form id="userForm">
								<div id="error" class="error"></div>
								<h3 style="text-align: center;" id="modalTitle">Registrar nuevo permiso</h3>

								<label for="nombre_permiso">Nombre del Permiso:</label><br>
								<input class="input" type="text" id="nombre_permiso" name="nombre_permiso" required><br><br>

								<label for="descripcion">Descripción:</label><br>
								<textarea class="input" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del permiso (opcional)"></textarea><br><br>

								<label for="activo">Estado:</label><br>
								<select class="input" id="activo" name="activo" required>
									<option value="1">Activo</option>
									<option value="0">Inactivo</option>
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
				// Funciones específicas para el modal de permisos
		function openModal() {
			// Limpiar campos para nuevo permiso
			document.getElementById('nombre_permiso').value = '';
			document.getElementById('descripcion').value = '';
			document.getElementById('activo').value = '1';

			// Limpiar errores previos
			const errorDiv = document.getElementById('error');
			if (errorDiv) {
				errorDiv.textContent = '';
				errorDiv.style.display = 'none';
			}

			// Cambiar título para nuevo permiso
			document.getElementById('modalTitle').textContent = 'Registrar nuevo permiso';

			// Limpiar referencia a fila editada
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

		let deleteButton = null; // Variable global para guardar el botón de eliminar
		let currentEditingRow = null; // Variable global para guardar la fila que se está editando

		function confirmAction(action, button) {
			if (action === 'delete') {
				deleteButton = button; // Guardar referencia al botón
				const message = '¿Está seguro de que desea eliminar este permiso?';
				openAlert(message, action, button);
			} else if (action === 'edit') {
				const row = button.closest('tr');
				currentEditingRow = row; // Guardar referencia a la fila editada
				const cells = row.querySelectorAll('td');

				// Obtener los datos de la fila
				const nombrePermiso = cells[2].textContent; // Nombre del permiso
				const descripcion = cells[3].textContent; // Descripción
				const estado = cells[4].textContent; // Estado (texto del badge)

				// Limpiar errores previos
				const errorDiv = document.getElementById('error');
				if (errorDiv) {
					errorDiv.textContent = '';
					errorDiv.style.display = 'none';
				}

				// Rellenar el formulario
				document.getElementById('nombre_permiso').value = nombrePermiso;
				document.getElementById('descripcion').value = descripcion === 'Sin descripción' ? '' : descripcion;
				document.getElementById('activo').value = estado === 'Activo' ? '1' : '0';

				// Cambiar título para editar permiso
				document.getElementById('modalTitle').textContent = 'Editar permiso';

				// Abrir el modal
				openModal();
			}
		}

		// Manejar el envío del formulario
		document.getElementById('userForm').addEventListener('submit', function(e) {
			e.preventDefault();

			const formData = new FormData(this);
			const isEdit = document.getElementById('modalTitle').textContent.includes('Editar');

			let url = '/permisos';
			let method = 'POST';
			let idPermiso = null;

			if (isEdit && currentEditingRow) {
				// Si es edición, necesitamos el ID del permiso
				const cells = currentEditingRow.querySelectorAll('td');
				idPermiso = cells[1].textContent; // ID del permiso
				url = `/permisos/${idPermiso}`;
				method = 'PUT';
			}

			fetch(url, {
				method: method,
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					'Content-Type': 'application/json',
				},
				body: JSON.stringify({
					nombre_permiso: formData.get('nombre_permiso'),
					descripcion: formData.get('descripcion'),
					activo: formData.get('activo')
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					if (isEdit && currentEditingRow && data.permiso) {
						// Actualizar la fila existente con los nuevos datos
						const cells = currentEditingRow.querySelectorAll('td');
						cells[2].textContent = data.permiso.nombre_permiso;
						cells[3].textContent = data.permiso.descripcion || 'Sin descripción';
						cells[4].innerHTML = data.permiso.activo ?
							'<span class="badge badge-success">Activo</span>' :
							'<span class="badge badge-danger">Inactivo</span>';
						cells[5].textContent = data.permiso.created_at ? formatDateTime(data.permiso.created_at) : 'N/A';
						cells[6].textContent = data.permiso.updated_at ? formatDateTime(data.permiso.updated_at) : 'N/A';
					} else if (!isEdit && data.permiso) {
						// Agregar nueva fila a la tabla
						const tbody = document.getElementById('userTableBody');
						const newRow = createTableRow(data.permiso, tbody.children.length + 1);
						tbody.appendChild(newRow);
					}

					closeModal();
					currentEditingRow = null;
				} else {
					// Mostrar error en el modal
					const errorDiv = document.getElementById('error');
					if (errorDiv) {
						errorDiv.textContent = data.message || 'Error al procesar la solicitud';
						errorDiv.style.display = 'block';
					}
				}
			})
			.catch(error => {
				console.error('Error:', error);
				// Mostrar error en el modal
				const errorDiv = document.getElementById('error');
				if (errorDiv) {
					errorDiv.textContent = 'Error de conexión. Intente nuevamente.';
					errorDiv.style.display = 'block';
				}
			});
		});

		// Función para crear una fila de tabla
		function createTableRow(permiso, index) {
			const row = document.createElement('tr');
			row.innerHTML = `
				<td>${index}</td>
				<td>${permiso.id_permiso}</td>
				<td>${permiso.nombre_permiso}</td>
				<td>${permiso.descripcion || 'Sin descripción'}</td>
				<td>${permiso.activo ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'}</td>
				<td>${permiso.created_at ? formatDateTime(permiso.created_at) : 'N/A'}</td>
				<td>${permiso.updated_at ? formatDateTime(permiso.updated_at) : 'N/A'}</td>
				<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
				<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)">Eliminar</button></td>
			`;
			return row;
		}

		// Función para formatear fechas
		function formatDateTime(dateTimeStr) {
			if (!dateTimeStr) return '';
			const d = new Date(dateTimeStr);
			const pad = n => n < 10 ? '0' + n : n;
			return pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
		}

		// Función para generar reportes
		function generateReport(format) {
			window.location.href = `/permisos/reporte?format=${format}`;
		}

		// Event listener para el botón de confirmación del alert
		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('alertConfirm').addEventListener('click', function() {
				if (deleteButton) {
					// Obtener el ID del permiso a eliminar
					const row = deleteButton.closest('tr');
					const cells = row.querySelectorAll('td');
					const idPermiso = cells[1].textContent; // ID del permiso

					// Realizar la petición DELETE
					fetch(`/permisos/${idPermiso}`, {
						method: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
							'Content-Type': 'application/json',
						}
					})
					.then(response => response.json())
										.then(data => {
						if (data.success) {
							// Eliminar la fila de la tabla
							row.remove();

							// Verificar si la tabla está vacía
							const tbody = document.getElementById('userTableBody');
							if (tbody.children.length === 0) {
								// Si no hay filas, mostrar mensaje de "no hay permisos"
								tbody.innerHTML = '<tr><td colspan="9" class="text-center">No hay permisos registrados</td></tr>';
							}
						} else {
							alert('Error: ' + data.message);
						}
					})
					.catch(error => {
						console.error('Error:', error);
						// No mostrar alert para errores de eliminación
					})
					.finally(() => {
						closeAlert();
						deleteButton = null; // Limpiar referencia
					});
				}
			});
		});
	</script>

	<style>
		/* Estilos específicos para el modal de permisos */
		.permisos-modal {
			display: none;
			position: fixed;
			top: 5%;
			left: 35%;
			width: 500px;
			height: 620px;
			background: rgb(255, 255, 255);
			justify-content: center;
			align-items: center;
			border-radius: 8px;
			z-index: 1000;
		}

		.permisos-modal-content {
			background: rgb(230, 165, 44);
			padding: 20px;
			border-radius: 8px;
			width: 800px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			overflow-y: auto;
		}

		.permisos-modal .input {
			width: 90%;
			padding: 1px;
		}

		.permisos-modal textarea.input {
			resize: vertical;
			min-height: 80px;
		}

		.permisos-modal select.input {
			width: 90%;
			padding: 1px;
		}

		.permisos-modal button[type="submit"] {
			background: #007BFF;
			color: white;
			border: none;
			border-radius: 4px;
			padding: 5px 10px;
			cursor: pointer;
			margin-right: 10px;
		}

		.permisos-modal button[type="submit"]:hover {
			background: #0056b3;
		}

		.permisos-modal .modal-close {
			background: red;
			color: white;
			border: none;
			border-radius: 4px;
			padding: 5px 10px;
			float: right;
			cursor: pointer;
		}

		.permisos-modal .modal-close:hover {
			background: darkred;
		}

		.permisos-modal label {
			font-weight: bold;
			color: #333;
		}

		.permisos-modal h3 {
			color: #333;
			margin-bottom: 20px;
		}

		.permisos-modal .error {
			color: red;
			margin-bottom: 10px;
			display: none;
			padding: 10px;
			background-color: #ffe6e6;
			border: 1px solid #ff9999;
			border-radius: 4px;
		}
	</style>
</body>

</html>
