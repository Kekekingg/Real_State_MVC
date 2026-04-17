<?php 

    use Model\PropertyDB;

    
    if($_SERVER['SCRIPT_NAME'] === '/listing.php') {
        $listing = PropertyDB::all();
    } else {
        $listing = PropertyDB::get(3);
    }
    $properties = $listing; // backward compatibility for views using the old name

?>
<div class="container-anuncios">
    <?php foreach($listing as $property): ?>
    <div class="anuncio">

            <img loading="lazy" src="/imagenes/<?php echo $property->image; ?>" alt="Listing"/>

        <div class="contenido-anuncio">
            <h3><?php echo $property->title; ?></h3>
            <p><?php echo $property->description; ?></p>
            <p class="precio">$ <?php echo $property->price; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc"/>
                    <p><?php echo $property->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento"/>
                    <p><?php echo $property->parking_space; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio"/>
                    <p><?php echo $property->bedrooms; ?></p>
                </li>
            </ul>

            <a href="anuncio.php?id=<?php echo $property->id; ?>" class="button-seller-block">
                See property
            </a>
        </div><!--.contenido-anuncio-->
    </div><!--.anuncio-->
    <?php endforeach; ?>

</div><!--.container-anuncios-->

