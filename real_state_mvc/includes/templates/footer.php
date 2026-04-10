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

    <script src="/build/js/bundle.min.js"></script>
</body>
</html>