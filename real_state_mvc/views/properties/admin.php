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
    <a href="/sellers/create" class="boton boton-amarillo">New Seller</a>

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
            <?php foreach( $properties as $property ): ?>
            <tr>
                <td> <?php echo $property->id; ?> </td>
                <td> <?php echo $property->title; ?> </td>
                <td> <img src="/images/<?php echo $property->image; ?>" class="imagen-tabla"> </td>
                <td>$ <?php echo $property->price; ?></td>
                <td>
                    <form method="POST" class="w-100" action="/properties/delete">

                        <input type="hidden" name="id" value="<?php echo $property->id; ?>">
                        <input type="hidden" name="tipo" value="property">

                        <input type="submit" class="boton-rojo-block" value="Delete">
                    </form>
                    <a href="/properties/update?id=<?php echo $property->id; ?>" class="boton-amarillo-block">Update</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Sellers</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody> <!-- Display the result -->
                <?php foreach( $sellers as $seller ): ?>
                <tr>
                    <td> <?php echo $seller->id; ?> </td>
                    <td> <?php echo $seller->name . " " . $seller->last_name; ?> </td>
                    <td><?php echo $seller->phone; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/sellers/delete">

                            <input type="hidden" name="id" value="<?php echo $seller->id; ?>">
                            <input type="hidden" name="tipo" value="seller">

                            <input type="submit" class="boton-rojo-block" value="Delete">
                        </form>
                        <a href="/sellers/update?id=<?php echo $seller->id; ?>" class="boton-amarillo-block">Update</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>