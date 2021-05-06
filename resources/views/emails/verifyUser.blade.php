<!DOCTYPE html>
  <html>
    <head>
      <title>Mail de Bienvenida</title>
    </head>
  <body>
    <div style="width: 100%; text-align: center;">
      <img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1619185273/logo_black_egzx3x.png" style="margin: auto; width: 300px;">
    </div>
    <h2>Bienvenido a Forohub {{$user['name']}}</h2>
    <br/>
    <label>El correo <b style="all: unset;">{{$user['email']}}</b> se ha vinculado a tu cuenta. No se podrá volver a crear una cuenta con este correo electrónico.</label>
    <br /><br />
    <b style="font-size: 14px;">Tus credenciales:</b>
    <br /><br />
    <b>Nombre de usuario: </b>
    <label>{{$user['name']}}</label>
    <br />
    <b>Contraseña: </b>
    <label>{{$user['password']}}</label>
    <br /><br />
    <label>Por favor, verifica tu correo electrónico para poder acceder a todas las funciones de Forohub:</label>
    <br /><br />
    <button style="border: solid 1px black; background-color: #ffb600; padding: 6px;"><a style="text-decoration: none; font-size: 16px; font-weight: bold; color: black;" href="{{url('user/verify', $user->verifyUser->token)}}"><b>Verificar Cuenta</b></a></button>
    <br />
    <br />
    <div style="width: 100%; text-align: center;">
      <label style="font-size: 10px;">Copyright© 2020 Forohub®</label>
    </div>
  </body>
</html>