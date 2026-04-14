<main class="contenedor seccion">
    <h1>Update Property</h1>

    <a href="/admin" class="boton boton-amarillo">Go back</a>

    <?php foreach($errors as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST">
        <?php include 'sellers_form.php' ?>

        <input type="submit" value="Update Seller" class="boton boton-verde">
    </form>

</main>