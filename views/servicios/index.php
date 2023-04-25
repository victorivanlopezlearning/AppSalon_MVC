<h1 class="nombre-pagina">Administración de Servicios</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<?php
if($resultado) :
    $mensaje = mostrarNotificacion(intval($resultado));

    if($mensaje) : ?>
        <p class="alerta exito"><?php echo s($mensaje) ?></p>
    <?php endif; 
endif;  ?>

<ul class="servicios">
    <?php foreach($servicios as $servicio) : ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Editar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input class="boton-eliminar" type="submit" value="Eliminar">
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<?php 
    $script = "
        <script src='build/js/servicios.js'></script>
    ";
?>