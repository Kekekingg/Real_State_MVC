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