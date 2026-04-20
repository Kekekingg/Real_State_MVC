<main class="contenedor seccion contenido-centrado">
    <h1>Login</h1>

    <?php foreach($errors as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email and Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Your email" id="email" /> 

            <label for="password" >Password</label>
            <input type="password" name="password" placeholder="Your password" id="password" />

        </fieldset>

        <input type="submit" value="Login" class="boton boton-verde">

    </form>
</main>