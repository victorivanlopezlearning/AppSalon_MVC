<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input id="nombre" type="texto" placeholder="Tu Nombre" name="nombre" value="<?php echo s($usuario->nombre) ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input id="apellido" type="text" placeholder="Tu Apellido" name="apellido" value="<?php echo s($usuario->apellido) ?>">
    </div>

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input id="telefono" type="tel" placeholder="Tu Teléfono" name="telefono" value="<?php echo s($usuario->telefono) ?>">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Tu Email" name="email" value="<?php echo s($usuario->email) ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input id="password" type="password" placeholder="Tu Contraseña" name="password">
    </div>

    <input class="boton" type="submit" value="Regístrate">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? <span>Iniciar Sesión</span></a>
    <p class="politicas">Al registrarte, aceptas nuestra <span>Política de privacidad.</span></p>
</div>