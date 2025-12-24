<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>INICIO</title>

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
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; Inicio
				</h3>
				<p class="text-justify">
					Bienvenido al sistema de gestión del Colegio de Arquitectos El Oro. Aquí puedes administrar usuarios, inscripciones, eventos y alquileres.
				</p>
			</div>

			<!-- Estadísticas -->
			<div class="full-box tile-container">
				<div class="tile">
					<div class="tile-tittle">Total Usuarios</div>
					<div class="tile-icon">
						<i class="fas fa-users fa-fw"></i>
						<p>{{ $stats['total_usuarios'] }}</p>
					</div>
				</div>

				<div class="tile">
					<div class="tile-tittle">Total Eventos</div>
					<div class="tile-icon">
						<i class="fas fa-calendar fa-fw"></i>
						<p>{{ $stats['total_eventos'] }}</p>
					</div>
				</div>

				<div class="tile">
					<div class="tile-tittle">Total Inscripciones</div>
					<div class="tile-icon">
						<i class="fas fa-clipboard-list fa-fw"></i>
						<p>{{ $stats['total_inscripciones'] }}</p>
					</div>
				</div>

				<div class="tile">
					<div class="tile-tittle">Total Alquileres</div>
					<div class="tile-icon">
						<i class="fas fa-building fa-fw"></i>
						<p>{{ $stats['total_alquileres'] }}</p>
					</div>
				</div>
			</div>

			<!-- Content -->
			<div class="full-box tile-container">

				<a href="{{ route('usuarios.index') }}" class="tile">
					<div class="tile-tittle">Usuarios</div>
					<div class="tile-icon">
						<i class="fas fa-users fa-fw"></i>
						<p>Registro de usuarios</p>
					</div>
				</a>

				<a href="{{ route('inscripciones.index') }}" class="tile">
					<div class="tile-tittle">Inscripciones</div>
					<div class="tile-icon">
						<i class="fas fa-pallet fa-fw"></i>
						<p>Registro de Inscripciones</p>
					</div>
				</a>

				<a href="{{ route('eventos.index') }}" class="tile">
					<div class="tile-tittle">Eventos</div>
					<div class="tile-icon">
						<i class="fas fa-file-invoice-dollar fa-fw"></i>
						<p>Registro de eventos</p>
					</div>
				</a>

				<a href="{{ route('alquiler.index') }}" class="tile">
					<div class="tile-tittle">Alquiler</div>
					<div class="tile-icon">
						<i class="fas fa-user-secret fa-fw"></i>
						<p>Registrados de Alquiler</p>
					</div>
				</a>



			</div>


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
</body>

</html>
