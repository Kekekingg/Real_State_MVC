<div class="contenedor-anuncios">
    <?php foreach($listing as $property): ?>
        <div class="anuncio">
            <img loading="lazy" src="/images/<?php echo $property->image; ?>" alt="listing"/>
            <div class="contenido-anuncio">
                <h3><?php echo $property->title; ?></h3>
                <p><?php echo $property->description; ?></p>
                <p class="precio">$ <?php echo $property->price; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="wc icon"/>
                        <p><?php echo $property->wc; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="parking space icon"/>
                        <p><?php echo $property->parking_space; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio"/>
                        <p><?php echo $property->bedrooms; ?></p>
                    </li>
                </ul>

                <a href="/listing?id=<?php echo $property->id; ?>" class="boton-amarillo-block">
                    See Property
                </a>
            </div><!--.listing-content-->
        </div><!--.listing-->
    <?php endforeach; ?>
</div><!--.listing-container-->