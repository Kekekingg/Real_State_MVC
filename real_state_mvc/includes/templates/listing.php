<?php 

    use Model\PropertyDB;

    
    if($_SERVER['SCRIPT_NAME'] === '/listing.php') {
        $listing = PropertyDB::all();
    } else {
        $listing = PropertyDB::get(3);
    }
    $properties = $listing; // backward compatibility for views using the old name

?>
<div class="container-ads">
    <?php foreach($listing as $property): ?>
    <div class="ads">

            <img loading="lazy" src="/imagenes/<?php echo $property->image; ?>" alt="Listing"/>

        <div class="content-ads">
            <h3><?php echo $property->title; ?></h3>
            <p><?php echo $property->description; ?></p>
            <p class="price">$ <?php echo $property->price; ?></p>

            <ul class="feature-icons">
                <li>
                    <img class="icon" loading="lazy" src="build/img/icon_wc.svg" alt="icon wc"/>
                    <p><?php echo $property->wc; ?></p>
                </li>
                <li>
                    <img class="icon" loading="lazy" src="build/img/icon_estacionamiento.svg" alt="icon estacionamiento"/>
                    <p><?php echo $property->parking_space; ?></p>
                </li>
                <li>
                    <img class="icon" loading="lazy" src="build/img/icon_dormitorio.svg" alt="icon dormitorio"/>
                    <p><?php echo $property->bedrooms; ?></p>
                </li>
            </ul>

            <a href="ads.php?id=<?php echo $property->id; ?>" class="button-seller-block">
                See property
            </a>
        </div><!--.content-ads-->
    </div><!--.ads-->
    <?php endforeach; ?>

</div><!--.container-adss-->

