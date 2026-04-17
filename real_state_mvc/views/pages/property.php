<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $property->title; ?></h1>

    <img loading="lazy" src="/images/<?php echo $property->image; ?>" alt="Imagen de la propiedad"/>
    

    <div class="resumen-propiedad">
        <p class="precio">$ <?php echo $property->price; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img loading="lazy" src="build/img/icono_wc.svg" alt="icono wc"/>
                <p><?php echo $property->wc; ?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento"/>
                <p><?php echo $property->parking_space; ?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio"/>
                <p><?php echo $property->bedrooms; ?></p>
            </li>
        </ul>

        <p><?php echo $property->description; ?></p>
    </div>
</main>