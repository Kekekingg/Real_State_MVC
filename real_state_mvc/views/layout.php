<?php 

    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? null;

    if(!isset($login)) {
        $login = false;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real State - Keke</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>

<!-- isset helps verify if a variable is defined -->
<header class="header <?php echo $login ? 'login' : '' ?>">
    <div class="container contenido-header">
        <div class="barra">
            <a href="/">
                <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices"/>
            </a>

            <div class="mobile-menu">
                <img src="/build/img/barras.svg" alt="Icono menu responsive"/>
            </div>

            <div class="derecha">
                <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Dark Mode"/>
                <nav class="navegacion">
                    <a href="nosotros.php">About us</a>
                    <a href="anuncios.php">Listings</a>
                    <a href="blog.php">Blog</a>
                    <a href="contacto.php">Contact</a>
                    <?php if(!$auth): ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                    <?php if($auth): ?>
                        <a href="cerrar_sesion.php">Log out</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div><!--.barra-->

        <?php 
            if($login) {
                echo "<h1>Sale of Exclusive Luxury Houses and Apartments</h1>";
            }
        ?>
    </div>
</header>

<?php echo $content ?> <!-- Display the layout -->

<footer class="footer section">
        <div class="container container-foooter">
            <nav class="navegacion">
                    <a href="about_us.php">About us</a>
                    <a href="listing.php">Listing</a>
                    <a href="blog.php">Blog</a>
                    <a href="contact.php">Contact</a>
            </nav>
        </div>

    <!-- Be careful with the date function since it is case sensitive: it distinguishes between uppercase and lowercase. For example, "y" will only output the last two digits of the year, while "Y" will output the full year -->
        <p class="copyright">All rights reserved. <?php echo date('Y') ?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>
</html>