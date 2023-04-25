<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Tu Email" name="email" value="<?php echo s($auth->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input id="password" type="password" placeholder="Tu Contraseña" name="password">
    </div>

    <input class="boton" type="submit" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes una cuenta? <span>Regístrate</span></a>
    <a href="/olvide-password"><span>He olvidado la contraseña</span></a>
</div>