<!DOCTYPE html>
<html>
	<head>
		<title>Verifica tu cuenta - Forohub</title>
	</head>
	<body>
		<div style="width: 100%; text-align: center;">
			<img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1619185273/logo_black_egzx3x.png" style="margin: auto; width: 300px;">
		</div>
		<h3 style="font-weight: normal;">Bienvenid@ a Forohub, <b>{{ $user['name'] }}</b>!</h3>
		<label>El correo electrónico proporcionado (<b>{{ $user['email'] }}</b>) se ha vinculado a tu cuenta.</label>
		<br>
		<label>No se podrá volver a crear una cuenta con este correo electrónico.</label>
		<br><br>
		<b style="font-size: 14px;">Tus credenciales:</b>
		<br><br>
		<b>Nombre de usuario:</b>
		<label>{{$user['name']}}</label>
		<br>
		<b>Contraseña:</b>
		<label>** La que usaste al registrarte **</label>
		<br><br>
		<label>Por favor, verifica tu correo electrónico a través del siguiente enlace, para poder acceder a todas las funciones de Forohub:</label>
		<br><br>
		<button style="padding: 6px 10px;">
			<b>
				<a style="text-decoration: none; color: black;" href="{{ url('user/verify', $user->verifyUser->token) }}">Verificar Cuenta</a>
			</b>
		</button>
		<br><br>
		<div style="border: solid 1px lightgrey; width: 80%;"></div>
		<br>
		<label>Atentamente,</label>
		<br>
		<b>el equipo de Forohub</b>
		<br><br>
		<label style="font-size: 10px;">Copyright© 2020 Forohub®</label>
	</body>
</html>