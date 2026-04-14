<main class="contenedor seccion">
        <h1>Seller Registration</h1>

        <a href="/admin" class="boton boton-amarillo">Go Back</a>

        <?php foreach($errors as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>;   
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/sellers/create" >

            <?php include 'sellers_form.php' ?>
            <input type="submit" value="Register Seller" class="boton boton-verde"/>
        </form>
    </main>