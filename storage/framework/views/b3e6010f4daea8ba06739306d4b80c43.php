<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title>Lista de roles</title>

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
		<?php echo $__env->make('layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<!-- Page content -->
		<section class="full-box page-content">
			<?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			<!-- Page header -->
			<div class="form-container">
				<h1>Registro de roles</h1>
				<form action="procesar_registro.php" method="POST">
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
							<button class="btn-small" onclick="openModal()" style="background-color: #D7A643;">Nuevo rol</button>
							<button class="btn-small" onclick="generateReport('pdf')" style="background-color: #28a745;">Reporte PDF</button>
							<button class="btn-small" onclick="generateReport('csv')" style="background-color: #17a2b8;">Reporte CSV</button>
						</div>
						<div class="table-responsive">
							<table class="table table-dark table-sm">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Rol</th>
										<th>Tipo de Rol</th>
										<th>Descripción</th>
										<th>Estado</th>
										<th>Fecha Creación</th>
										<th>Fecha Actualización</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<tbody id="userTableBody">
									<?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
									<tr>
										<td><?php echo e($index + 1); ?></td>
										<td><?php echo e($role->id_rol); ?></td>
										<td><?php echo e($role->tipo_rol); ?></td>
										<td><?php echo e($role->descripcion ?? 'Sin descripción'); ?></td>
										<td>
											<?php if($role->activo): ?>
												<span class="badge badge-success">Activo</span>
											<?php else: ?>
												<span class="badge badge-danger">Inactivo</span>
											<?php endif; ?>
										</td>
										<td><?php echo e($role->created_at ? $role->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
										<td><?php echo e($role->updated_at ? $role->updated_at->format('d/m/Y H:i') : 'N/A'); ?></td>
										<td><button class="action-btn edit-btn" onclick="confirmAction('edit', this)">Editar</button></td>
										<td><button class="action-btn delete-btn" onclick="confirmAction('delete', this)" data-role-id="<?php echo e($role->id_rol); ?>">Eliminar</button></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
									<tr>
										<td colspan="9" class="text-center">No hay roles registrados</td>
									</tr>
									<?php endif; ?>
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
					<div id="userModal" class="modal">
						<div class="modal-content">
							<form id="userForm" method="POST" action="/roles">
								<?php echo csrf_field(); ?>
								<input type="hidden" id="edit_mode" name="edit_mode" value="0">
								<input type="hidden" id="role_id" name="role_id" value="">
								<div id="error" class="error"></div>
								<h3 style="text-align: center;" id="modalTitle">Registrar nuevo rol</h3>

								<label for="tipo_rol">Tipo de Rol:</label><br>
								<input class="input" type="text" id="tipo_rol" name="tipo_rol" required><br><br>

								<label for="descripcion">Descripción:</label><br>
								<textarea class="input" id="descripcion" name="descripcion" required></textarea><br><br>

								<label for="activo">Estado:</label><br>
								<select class="input" id="activo" name="activo" required>
									<option value="1">Activo</option>
									<option value="0">Inactivo</option>
								</select><br><br>

								<button type="submit">Guardar</button>
								<button class="modal-close" onclick="closeModal()" type="button">X</button>
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
		// Variables globales para saber si es edición
		let editMode = false;
		let editingRoleId = null;

		function openModal(isEdit = false, roleId = null, tipoRol = '', activo = '1', descripcion = '') {
			document.getElementById('userModal').style.display = 'flex';
			document.getElementById('tipo_rol').value = tipoRol;
			document.getElementById('activo').value = activo;
			document.getElementById('edit_mode').value = isEdit ? '1' : '0';
			document.getElementById('role_id').value = roleId ? roleId : '';
			document.getElementById('modalTitle').textContent = isEdit ? 'Editar rol' : 'Registrar nuevo rol';
			document.getElementById('descripcion').value = descripcion === 'Sin descripción' ? '' : descripcion;
			document.getElementById('error').textContent = '';
			editingRoleId = isEdit ? roleId : null;
			editMode = isEdit;
			// Cambiar action y method
			const form = document.getElementById('userForm');
			if (isEdit && roleId) {
				form.action = `/roles/${roleId}`;
				// Agregar input hidden para PUT
				if (!document.getElementById('_method')) {
					const methodInput = document.createElement('input');
					methodInput.type = 'hidden';
					methodInput.name = '_method';
					methodInput.id = '_method';
					methodInput.value = 'PUT';
					form.appendChild(methodInput);
				}
			} else {
				form.action = '/roles';
				// Eliminar input hidden para PUT si existe
				const methodInput = document.getElementById('_method');
				if (methodInput) methodInput.remove();
			}
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
				// Guardar el id del rol a eliminar
				const row = button.closest('tr');
				const cells = row.querySelectorAll('td');
				const roleId = button.getAttribute('data-role-id') || (cells[1] && cells[1].textContent.trim());
				window.roleIdToDelete = roleId;
				const message = '¿Está seguro de que desea eliminar este rol?';
				openAlert(message, action, button);
			} else if (action === 'edit') {
				const row = button.closest('tr');
				const cells = row.querySelectorAll('td');
				const roleId = cells[1].textContent.trim();
				const tipoRol = cells[2].textContent.trim();
				const descripcion = cells[3].textContent.trim();
				const estado = cells[4].textContent.trim() === 'Activo' ? '1' : '0';
				editingRoleId = roleId;
				openModal(true, roleId, tipoRol, estado, descripcion);
			}
		}

		// Event listener para el botón de confirmación del alert
		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('alertConfirm').addEventListener('click', function() {
				if (window.roleIdToDelete) {
					// AJAX DELETE
					fetch(`/roles/${window.roleIdToDelete}`, {
						method: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
						},
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							closeAlert();
							location.reload();
						} else {
							closeAlert();
							alert(data.message || 'Error al eliminar el rol');
						}
					})
					.catch(error => {
						closeAlert();
						alert('Error al procesar la solicitud');
					});
					window.roleIdToDelete = null;
				} else {
					closeAlert();
				}
			});
		});

		// Función para generar reportes
		function generateReport(format) {
			window.location.href = `/roles/reporte?format=${format}`;
		}

		// Envío AJAX del formulario del modal de roles
		document.getElementById('userForm').addEventListener('submit', function(e) {
			e.preventDefault();
			const formData = new FormData(this);
			const isEdit = document.getElementById('modalTitle').textContent.includes('Editar');
			let url = '/roles';
			let method = 'POST';
			if (isEdit) {
				if (!editingRoleId) {
					document.getElementById('error').textContent = 'No se pudo obtener el ID del rol a editar.';
					return;
				}
				url = `/roles/${editingRoleId}`;
				method = 'POST';
				formData.append('_method', 'PUT');
			}
			fetch(url, {
				method: method,
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				},
				body: formData
			})
			.then(response => {
				if (response.headers.get('content-type') && response.headers.get('content-type').includes('application/json')) {
					return response.json();
				} else {
					location.reload();
				}
			})
			.then(data => {
				if (!data) return;
				if (data.success) {
					closeModal();
					location.reload();
				} else {
					document.getElementById('error').textContent = data.message || 'Error al guardar el rol';
				}
			})
			.catch(error => {
				document.getElementById('error').textContent = 'Error al procesar la solicitud';
				console.error('Error:', error);
			});
		});
	</script>
</body>

</html>
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/roles/roles.blade.php ENDPATH**/ ?>