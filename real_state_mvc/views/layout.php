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
    <meta name="description" content="Discover luxury properties, exclusive listings, and expert real estate advice with Real State - Keke.">
    <meta name="author" content="Real State - Keke">
    <meta property="og:title" content="Real State - Keke">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.yoursite.com/">
    <meta property="og:description" content="Discover luxury properties, exclusive listings, and expert real estate advice with Real State - Keke.">
    <meta property="og:image" content="/build/img/nosotros.jpg">
    <title>Real State - Keke</title>
    <link rel="stylesheet" href="../build/css/app.css">
    <link rel="icon" type="image/png" href="../build/img/house.png">
</head>
<body>

<!-- isset helps verify if a variable is defined -->
<header class="header <?php echo $login ? 'login inicio' : '' ?>">
    <div class="contenedor contenido-header">
        <div class="barra">
            <a href="/" class="logo">
                <img src="/build/img/REN.svg" alt="Logo Real Estate"/>
            </a>

            <div class="mobile-menu">
                <img src="/build/img/bars.svg" alt="icon menu responsive"/>
            </div>

            <div class="derecha">
                <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Dark Mode"/>
                <nav class="navegacion">
                    <a href="/about-us">About us</a>
                    <a href="/properties">Listings</a>
                    <a href="/blog">Blog</a>
                    <a href="/contact">Contact</a>
                    <?php if(!$auth): ?>
                        <a href="/login">Login</a>
                    <?php endif; ?>
                    <?php if($auth): ?>
                        <a href="/logout">Log out</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div><!--.NavBar-->

        <?php 
            if($login) {
                echo "<h1>Sale of Exclusive Luxury Houses and Apartments</h1>";
            }
        ?>
    </div>
</header>

<?php echo $content ?> <!-- Display the layout -->

<footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                    <a href="/about_us">About us</a>
                    <a href="/properties">Listing</a>
                    <a href="/blog">Blog</a>
                    <a href="/contact">Contact</a>
            </nav>
        </div>

    <!-- Be careful with the date function since it is case sensitive: it distinguishes between uppercase and lowercase. For example, "y" will only output the last two digits of the year, while "Y" will output the full year -->
        <p class="copyright">All rights reserved. <?php echo date('Y') ?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>
</html>