<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                id="fecha"
                type="date"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">
        <?php
            if(!empty($citas)):
                $idCita = 0;
                foreach($citas as $key => $cita): 
                    if($idCita !== $cita->id): // Evitar tener duplicados
                        $idCita = $cita->id;
                        $total = 0; ?>
                        <li>
                            <h3>Información de la Cita</h3>
                            <!-- <p>ID: <span><?php echo $cita->id; ?></span></p> -->
                            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                            <p>Email: <span><?php echo $cita->email; ?></span></p>
                            <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>

                            <h3>Servicios Solicitados</h3>
                    <?php endif; 
                            $total += $cita->precio; ?>
                            <p class="servicio"><?php echo $cita->servicio . ' $' . $cita->precio; ?></p>
                        <!-- </li> * Se limina para dejar que HTML lo agregue y evite que el primer servicio tenga un espacio  -->
                        <?php
                            // Posicionarnos en el último elemento de la iteración
                            $idActual = $cita->id;
                            $idProximo = $citas[$key + 1]->id ?? 0;

                            if(esUltimo($idActual, $idProximo)) : ?>
                                <p class="total">Total: <span>$<?php echo $total; ?>.00</span></p>
                                <form action="/api/eliminar" method="POST">
                                    <input 
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $cita->id; ?>"
                                    />
                                    <input 
                                        type="submit"
                                        class="boton-eliminar"
                                        value="Eliminar"
                                    />
                                </form>
                            <?php endif; 
                endforeach;
            else: ?>
                <p class="sin-citas">Sin citas para esta fecha.</p>
            <?php endif ?>
    </ul>
</div>

<?php 
    $script = "
        <script src='build/js/buscador.js'></script>
    ";
?>