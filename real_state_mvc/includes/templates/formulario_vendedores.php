<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor/a" value="<?php echo sanitize($vendedor->nombre); ?>"/>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="apellido Vendedor/a" value="<?php echo sanitize($vendedor->apellido); ?>"/>

</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono" >Teléfono:</label>
    <input 
        type="number" id="telefono" name="vendedor[telefono]" placeholder="Teléfono Vendedor/a" 
        value="<?php echo sanitize($vendedor->telefono); ?>" 
        required/>
</fieldset>