<h1 class="nombre-pagina">Crea una Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div id="app">
    <!-- TABS -->
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <!-- SECCIÓN SERVICIOS -->
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación:</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <!-- SECCIÓN DATOS -->
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita:</p>

        <form id="formulario" class="formulario">  <!-- No se va añadir ningún metodo ya que será un formulario interactivo y eso se realiza sólo con JavaScript -->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    id="nombre"
                    type="text"
                    placeholder="Tu nombre"
                    value="<?php echo $nombreUsuario; ?>"
                    disabled
                />
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    id="fecha"
                    type="date"
                />
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    id="hora"
                    type="time"
                />
            </div>
            <input id="id" type="hidden" name="id" value="<?php echo $idUsuario; ?>">
        </form>
    </div>

    <!-- SECCIÓN RESUMEN -->
    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
        <div id="contenidoResumen" class="contenido-resumen"></div>
    </div>

    <!-- PAGINACIÓN -->
    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
        >&laquo; Anterior</button>

        <button
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>