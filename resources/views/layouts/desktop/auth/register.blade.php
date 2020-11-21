@extends('layouts.desktop.main')

@section('title', 'ForoHub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="css/desktop/register.css">
@endpush
@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
@section('body')
<div id="registerPanel">
        <div id="inputForm">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <p><b>Nombre de usuario</b>*</p><input type="text" name="name" maxlength="20" autocomplete="off" autofocus>
                <p><b>Correo electrónico</b>*</p><input type="text" name="reg_email" maxlength="64" autocomplete="off">
                <p><b>Contraseña</b>*</p><input type="password" name="reg_password" maxlength="64" minlength="8" autocomplete="off">
               
                <p>(Todos los campos son obligatorios)</p>
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" style="margin: 20px 0px 20px 0px;"></div>
                <p id="PTerms">
                    <input type="checkbox" name="reg_terms" style="vertical-align: bottom;">
                    <label>He leído y acepto los términos y condiciones de </label>
                    <b>ForoHub</b>
                </p>
                <input type="button" id="reg_done" value="Registrarse" onclick="formValidation()">
            </form>
        </div>
        <div id="privacyPolicy">
            <img src="/src/media/logo_white.webp"  width="100%">
        </div>
    </div>

@endsection