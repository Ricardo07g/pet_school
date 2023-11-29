<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>Pet School</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="login/images/img-02.webp" alt="IMG">
				</div>
				<form class="login100-form validate-form" action="/login/auth" method="POST">
				@csrf
					<div class="wrap-input100 validate-input" data-validate = "Campo está vazio ou  possui um formato inválido.">
						<input 
							class="input100"
							type="text"
							id="email" 
							name="email" 
							placeholder="E-mail" 
							value ="demonstracao@gmail.com" 
						>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "obrigatório">
						<input 
							class="input100" 
							type="password" 
							id="senha" 
							name="senha" 
							placeholder="*******" 
							value ="Demonstracao@123" 
						>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					@if ($message = Session::get('error'))
					    <div class="alert alert-danger" style="text-align:center;">
					        {{ $message }}
					    </div>
					@endif
					
					<div class="container-login100-form-btn">
						<button type="button" id="btn_submit_form_login" class="login100-form-btn">
							Entrar
						</button>
					</div>
					<!--
					<div class="text-center p-t-12">
						<a class="txt2" href="#">
                            Esqueceu sua senha?
						</a>
					</div>
					-->

				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>
</html>