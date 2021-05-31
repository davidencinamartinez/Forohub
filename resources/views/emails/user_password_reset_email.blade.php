<!DOCTYPE html>
  <html>
  <body>
    <div style="width: 100%; text-align: center;">
      <img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1619185273/logo_black_egzx3x.png" style="margin: auto; width: 300px;">
    </div>
    <h2>Recuperación de cuenta</h2>
    <br>
    <label>El siguiente mensaje contiene un enlace, el cuál te permitirá recuperar tu cuenta rellenando los campos correspondientes.</label>
    <br><br>
    <b>* Dispones de 60 minutos para acceder al enlace. Pasado este tiempo, el enlace dejará de ser válido *</b>
    <br><br>
    <label>Haz click en el siguiente enlace para cambiar tu contraseña:</label>
    <br><br>
    <button style="padding: 6px 10px;">
      <b>
        <a style="text-decoration: none; color: black;" href="{{ url($link) }}">Restablecer Contraseña</a>
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