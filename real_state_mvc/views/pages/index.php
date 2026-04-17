<main class="contenido seccion">
    <h1>More About Us</h1>
    <?php include 'icons.php' ?>
</main>

<section class="contenedor">
    <h2>Houses and Apartments for Sale</h2>

    <?php 
        include 'ads.php';
    ?> 

    <div class="alinear-derecha">
        <a href="/properties" class="boton-verde">View All</a>
    </div>
</section>

<section class="imagen-contacto">
    <h2>Find the Home of Your Dreams</h2>
    <p>Fill out the contact form and an advisor will get in touch with you shortly</p>
    <a href="contacto.php" class="boton-amarillo">Contact Us</a>
</section>

<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h3>Our Blog</h3>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp"/>
                    <source srcset="build/img/blog1.jpg" type="image/jpeg"/>
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Blog Entry Text"/>
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Rooftop Terrace for Your Home</h4>
                    <p class="informacion-meta">Written on: <span> 20/01/2026</span> by: <span>Admin</span> </p>

                    <p>
                        Tips for building a rooftop terrace with the best materials while saving money.
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp"/>
                    <source srcset="build/img/blog2.jpg" type="image/jpeg"/>
                    <img loading="lazy" src="build/img/blog2.jpg" alt="Blog Entry Text"/>
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guide to Decorating Your Home</h4>
                    <p class="informacion-meta">Written on: <span>20/01/2026</span> by: <span>Admin</span> </p>

                    <p>
                        Maximize space in your home with this guide, learn to combine furniture and colors to bring life to your space.
                    </p>
                </a>
            </div>
        </article>
    </section>

    <section class="testimoniales">
        <h3>Testimonials</h3>
        <div class="testimonial">
            <blockquote>
                The staff behaved in an excellent manner, very good service, and the house they offered me meets all my expectations.
            </blockquote>
            <p>- Erik Reyes</p>
        </div>
    </section>
</div>
