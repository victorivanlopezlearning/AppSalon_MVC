<div class="campo">
    <label for="nombre">Nombre</label>
    <input
        id="nombre"
        name="nombre"
        type="text"
        placeholder="Nombre del Servicio"
        value="<?php echo $servicio->nombre; ?>"
    />
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input
        id="precio"
        name="precio"
        type="number"
        placeholder="Precio del Servicio"
        min= "0"
        value="<?php echo $servicio->precio; ?>"
    />
</div>