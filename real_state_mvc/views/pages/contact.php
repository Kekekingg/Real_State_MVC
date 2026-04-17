<main class="contenedor seccion">
    <h1>Contact</h1>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp"/>
        <source srcset="build/img/destacada3.jpg" type="image/jpeg"/>
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Contact Image"/>
    </picture>

    <h2>Fill out the contact form</h2>

    <form class="formulario" action="/contact" method="POST">
        <fieldset>
            <legend>Personal Information</legend>
            
            <label for="nombre">Name</label>
            <input type="text" placeholder="Your name" id="nombre" name="contact[name]" required/>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Your email" id="email" name="contact[email]" required/> 

            <label for="telefono">Phone</label>
            <input type="tel" placeholder="Your phone" id="telefono" name="contact[phone]"/>

            <label for="mensaje">Message</label>
            <textarea id="mensaje" name="contact[message]" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Property Information</legend>

            <label for="mensaje">Sell or Buy</label>
            <select id="opciones" name="contact[type]" required>
                <option value="" disabled selected>-- Select --</option>
                <option value="Buy">Buy</option>
                <option value="Sell">Sell</option>
            </select>

            <label for="presupuesto">Price or Budget</label>
            <input type="number" placeholder="Your budget" id="presupuesto" name="contact[price]" required/>
        </fieldset>

        <fieldset>
            <legend>Contact</legend>

            <p>How would you like to be contacted</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Phone</label>
                <input name="contacto" type="radio" value="phone" id="contactar-telefono" name="contact[contact]" required/>

                <label for="contactar-email">E-mail</label>
                <input name="contacto" type="radio" value="email" id="contactar-email" name="contact[contact]" required/>
            </div>

            <p>If you chose phone, select the date and time</p>

            <label for="fecha">Date:</label>
            <input type="date" id="fecha" name="contact[date]"/>

            <label for="hora">Time:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contact[time]"/>
        </fieldset>

        <input type="submit" value="Send" class="boton-verde"/>
    </form>
</main>
