<div class="barra">
    <p>Hola: <span><?php echo $nombreUsuario ?? ''; ?></span></p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])): ?>
        <div class="barra-servicios">
            <?php if($_SERVER['PATH_INFO'] === '/admin') : ?>
                    <a class="boton" href="/servicios">Ver Servicios</a>
                    <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
                <?php elseif($_SERVER['PATH_INFO'] === '/servicios'): ?>
                    <a class="boton" href="/admin">Ver Citas</a>
                    <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
                <?php elseif($_SERVER['PATH_INFO'] === '/servicios/crear' || $_SERVER['PATH_INFO'] === '/servicios/actualizar'): ?>
                    <a class="boton" href="/admin">Ver Citas</a>
                    <a class="boton" href="/servicios">Ver Servicios</a>
                <?php endif; ?>
        </div>
<?php endif; ?>