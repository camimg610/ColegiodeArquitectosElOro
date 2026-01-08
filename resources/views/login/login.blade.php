<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Login</title>

	<!-- Normalize V8.0.1 -->
	<!-- Normalize CSS -->
	<link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

	<!-- Bootstrap V4.3 -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

	<!-- Bootstrap Material Design V4.0 -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap-material-design.min.css') }}">

	<!-- Font Awesome V5.9.0 -->
	<link rel="stylesheet" href="{{ asset('css/all.css') }}">

	<!-- Sweet Alerts V8.13.0 CSS -->
	<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

	<!-- Sweet Alerts V8.13.0 JS -->
	<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">

	<!-- General Styles -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body class="login-page" style="background-color: #002F0D !important;">

	<div class="login-container">
		<div class="login-content">
			<p class="text-center">
				<img src="{{ asset('assets/logo.png') }}" alt="Logo" style="width: 160px; height: auto; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;" />
			</p>
			<p class="text-center">
				Inicia sesión con tu cuenta
			</p>
			<form action="{{ route('login') }}" method="POST">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger">
						<ul class="mb-0">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="form-group">
					<label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
					     <input type="text"
						     class="form-control @error('usuario') is-invalid @enderror"
						     id="UserName"
						     name="usuario"
						     pattern="[a-zA-Z0-9_]{1,35}"
						     maxlength="35"
						     value="{{ old('usuario') }}"
						     required
						     autofocus>
					@error('usuario')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group">
					<label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
					<input type="password"
						   class="form-control @error('password') is-invalid @enderror"
						   id="UserPassword"
						   name="password"
						   maxlength="200"
						   required
						   autocomplete="current-password">
					@error('password')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group" style="margin-top: 20px;">
					<button type="submit" class="btn-login text-center" style="width: 100%;">LOGIN</button>
				</div>
			</form>
		</div>
	</div>

	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

	<!-- popper -->
	<script src="{{ asset('js/popper.min.js') }}"></script>

	<!-- Bootstrap V4.3 -->
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="{{ asset('js/bootstrap-material-design.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('body').bootstrapMaterialDesign();

			// Mostrar errores con SweetAlert2
			@if($errors->any())
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '{{ $errors->first() }}',
					confirmButtonColor: '#002F0D'
				});
			@endif
		});
	</script>

	<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
