<main class="contenedor seccion">
        <h1>Create</h1>

        <?php foreach($errors as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>;   
            </div>
        <?php endforeach; ?>

        <a href="/admin" class="boton boton-amarillo">Go Back</a>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include __DIR__ . '/properties_form.php'; ?>

            <input type="submit" value="Create Property" class="boton boton-verde">
        </form>
</main>