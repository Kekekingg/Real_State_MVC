//"Escucha" que el documento este cargado tanto el html, css y js
document.addEventListener('DOMContentLoaded', function () {
    
    eventListeners();

    darkMode();
});

function darkMode () {

    //Preferencia de color en el sistema operativo del usuario
    const preferedDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(preferedDarkMode.matches);
    if (preferedDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    preferedDarkMode.addEventListener('change', function() {
        if(preferedDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

});

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        //Agrega en el Body del html la clase de dark-mode para toda la pag
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    //Apunta a la imagen de las barras de hamburgruesa
    const mobileMenu = document.querySelector('.mobile-menu');
    
    //Escucha el click, osea cada vez que se da click
    mobileMenu.addEventListener('click', navegacionResponsive);

    // Show conditional fields
    const contactMethod = document.querySelectorAll('input[name="contact[contact]"]');
    contactMethod.forEach(input => input.addEventListener('click', showContactMethods));
}

//Ejecuta o muestra el nav de hamburgruesa
function navegacionResponsive () {

    const navegacion = document.querySelector('.navegacion');

    //Forma 1 de agregar la clase de "mostrar a la navegacion"
    // if(navegacion.classList.contains('mostrar')) {
    //     navegacion.classList.remove('mostrar');
    // } else {
    //     navegacion.classList.add('mostrar');
    // }

    //Forma 2 con toggle (mas limpia y profesional)
    navegacion.classList.toggle('mostrar')

}

function showContactMethods(e) {
    const contactDiv = document.querySelector('#contact');

    if(e.target.value === 'phone') {
        contactDiv.innerHTML = `
            <label for="telefono">Phone Number</label>
            <input type="tel" placeholder="Your phone" id="telefono" name="contact[phone]"/>

            <p>Select the date and time for the call</p>

            <label for="fecha">Date:</label>
            <input type="date" id="fecha" name="contact[date]"/>

            <label for="hora">Time:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contact[time]"/>
        `;
    } else {
        contactDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Your email" id="email" name="contact[email]" required/> 
        `;
    }
}