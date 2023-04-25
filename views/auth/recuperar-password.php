<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Escribe tu nueva contraseña a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>


<?php if($mostrarFormulario) : ?>

<form class="formulario" method="POST"> <!-- No se indica action para evitar que se elimine el token de la URL --> 

    <div class="campo">
        <label for="password">Contraseña</label>
        <input id="password" type="password" placeholder="Indica tu nueva contraseña" name="password">
    </div>

    <input class="boton" type="submit" value="Guardar Nueva Contraseña">
</form>

<div class="acciones">
    <a href="/">O <span>Iniciar Sesión</span></a>
</div>

<?php endif; ?>