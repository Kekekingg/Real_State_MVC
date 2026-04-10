<main class="contenedor seccion">
    <h1>Real Estate Manager</h1>
    <?php
        if($result) {
            $message = showNoti(intval($result));
            if($message) { ?>
                <p class="alerta exito">
                    <?php echo sanitize($message) ?>
                </p>
            <?php } ?>
        <?php } ?>

    <a href="/properties/create" class="boton boton-verde">New Property</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">New Seller</a>

    <h2>Registered Properties</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody> <!-- Dispaly the properties -->
            <?php foreach( $properties as $propertie ): ?>
            <tr>
                <td> <?php echo $propertie->id; ?> </td>
                <td> <?php echo $propertie->title; ?> </td>
                <td> <img src="/images/<?php echo $propertie->image; ?>" class="imagen-tabla"> </td>
                <td>$ <?php echo $propertie->price; ?></td>
                <td>
                    <form method="POST" class="w-100">

                        <input type="hidden" name="id" value="<?php echo $propertie->id; ?>">
                        <input type="hidden" name="tipo" value="propertie">

                        <input type="submit" class="boton-rojo-block" value="eliminar">
                    </form>
                    <a href="admin/propiedades/actualizar.php?id=<?php echo $propertie->id; ?>" class="boton-amarillo-block">Update</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>