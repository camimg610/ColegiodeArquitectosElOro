<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Login</title>

	<!-- Normalize V8.0.1 -->
	<!-- Normalize CSS -->
	<link rel="stylesheet" href="<?php echo e(asset('css/normalize.css')); ?>">

	<!-- Bootstrap V4.3 -->
	<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">

	<!-- Bootstrap Material Design V4.0 -->
	<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-material-design.min.css')); ?>">

	<!-- Font Awesome V5.9.0 -->
	<link rel="stylesheet" href="<?php echo e(asset('css/all.css')); ?>">

	<!-- Sweet Alerts V8.13.0 CSS -->
	<link rel="stylesheet" href="<?php echo e(asset('css/sweetalert2.min.css')); ?>">

	<!-- Sweet Alerts V8.13.0 JS -->
	<script src="<?php echo e(asset('js/sweetalert2.min.js')); ?>"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<link rel="stylesheet" href="<?php echo e(asset('css/jquery.mCustomScrollbar.css')); ?>">

	<!-- General Styles -->
	<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

</head>
<body class="login-page" style="background-color: #002F0D !important;">

	<div class="login-container">
		<div class="login-content">
			<p class="text-center">
				<img src="<?php echo e(asset('assets/logo.png')); ?>" alt="Logo" style="width: 160px; height: auto; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;" />
			</p>
			<p class="text-center">
				Inicia sesión con tu cuenta
			</p>
			<form action="<?php echo e(route('login')); ?>" method="POST">
				<?php echo csrf_field(); ?>
				<?php if($errors->any()): ?>
					<div class="alert alert-danger">
						<ul class="mb-0">
							<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><?php echo e($error); ?></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
					     <input type="text"
						     class="form-control <?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						     id="UserName"
						     name="usuario"
						     pattern="[a-zA-Z0-9_]{1,35}"
						     maxlength="35"
						     value="<?php echo e(old('usuario')); ?>"
						     required
						     autofocus>
					<?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback"><?php echo e($message); ?></div>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
				<div class="form-group">
					<label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
					<input type="password"
						   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						   id="UserPassword"
						   name="password"
						   maxlength="200"
						   required
						   autocomplete="current-password">
					<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div class="invalid-feedback"><?php echo e($message); ?></div>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
	<script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>

	<!-- popper -->
	<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>

	<!-- Bootstrap V4.3 -->
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="<?php echo e(asset('js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="<?php echo e(asset('js/bootstrap-material-design.min.js')); ?>"></script>
	<script>
		$(document).ready(function() {
			$('body').bootstrapMaterialDesign();

			// Mostrar errores con SweetAlert2
			<?php if($errors->any()): ?>
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '<?php echo e($errors->first()); ?>',
					confirmButtonColor: '#002F0D'
				});
			<?php endif; ?>
		});
	</script>

	<script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>
</html>
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/login/login.blade.php ENDPATH**/ ?>