<footer class="footer seccion">
        <div class="contenedor contenedor-foooter">
            <nav class="navegacion">
                    <a href="nosotros.php">Nosotros</a>
                    <a href="anuncios.php">Anuncios</a>
                    <a href="blog.php">Blog</a>
                    <a href="contacto.php">Contacto</a>
            </nav>
        </div>

    <!-- Hay que tener cuidado con el date ya que es case sensitive osea que sabe distinguir entre mayusculas y minusculas: si pones "y" solo pondra los ultimos numeros del año en cuestion, si es "Y" pondra el año completo -->
        <p class="copyright">Todos los derechos Reservados <?php echo date('Y') ?> &copy;</p>
    </footer>
    

    <script src="/build/js/bundle.min.js"></script>
</body>
</html>