<h1 class="nombre-pagina">¿Has olvidado la contraseña?</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/olvide-password">

    <div class="campo">
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Tu Email" name="email">
    </div>

    <input class="boton" type="submit" value="Restablecer Contraseña">
</form>

<div class="acciones">
    <a href="/">O <span>Iniciar Sesión</span></a>
</div>