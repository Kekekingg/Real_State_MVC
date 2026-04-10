<fieldset>
    <legend>General Information</legend>

    <label for="name">Name:</label>
    <input type="text" id="name" name="seller[name]" placeholder="Seller name" value="<?php echo sanitize($seller->name); ?>"/>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="seller[last_name]" placeholder="Seller last name" value="<?php echo sanitize($seller->last_name); ?>"/>

</fieldset>

<fieldset>
    <legend>Additional Information</legend>

    <label for="phone" >Seller's Phone:</label>
    <input 
        type="number" id="phone" name="seller[phone]" placeholder="Seller phone" 
        value="<?php echo sanitize($seller->phone); ?>" 
        required/>
</fieldset>