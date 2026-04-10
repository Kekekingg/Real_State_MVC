<fieldset>
    <legend>General Information</legend>

    <label for="title">Title:</label>
    <input type="text" id="title" name="property[title]" placeholder="title property" value="<?php echo sanitize($property->title); ?>"/>

    <label for="price">Price:</label>
    <input type="number" id="price" name="property[price]" placeholder="Price property" value="<?php echo sanitize($property->price); ?>"/>

    <label for="image">Image:</label>
    <input type="file" id="image" accept="image/jpeg, image/png" name="property[image]">

    <?php if($property->image): ?>
        <img src="/image/<?php echo $property->images ?>" class="imagen-small">
    <?php endif; ?>

    <label for="description">Description:</label>
    <textarea id="description" name="property[description]"><?php echo sanitize($property->description); ?></textarea>

</fieldset>

<fieldset>
    <legend>Property Information</legend>

    <label for="bedrooms">Bedrooms:</label>
    <input type="number" id="bedrooms" name="property[bedrooms]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitize($property->bedrooms); ?>"/>

    <label for="wc">WC:</label>
    <input type="number" id="wc" name="property[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitize($property->wc); ?>"/>

    <label for="parking_space">Parking Space:</label>
    <input type="number" id="parking_space" name="property[parking_space]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitize($property->parking_space); ?>"/>

</fieldset>

<fieldset>
    <legend>Sellers</legend>
    <label for="seller">Seller</label>
    <select name="property[sellers_id]" id="seller">
        <option selected value="">-- Select --</option>

        <?php foreach($sellers as $seller): ?>
            <option 
                <?php echo $seller->id === $property->sellers_id ? 'selected': '' ?>
                value="<?php echo sanitize($seller->id) ?>">
                <?php echo sanitize($seller->name) . " " . sanitize($seller->last_name); ?>
            </option>
        <?php endforeach; ?>

    </select>
</fieldset>