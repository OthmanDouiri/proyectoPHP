window.addEventListener('DOMContentLoaded', event => {

    // Función para hacer el navbar "shrink" al hacer scroll
    var navbarShrink = function () {
        const navbarCollapsible = document.getElementById('mainNav'); // Usar getElementById
        if (!navbarCollapsible) return; // Verificar si el navbar existe
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Ejecutar la función para aplicar el "shrink" en el navbar
    navbarShrink();

    // Activar el navbar "shrink" cuando se hace scroll
    document.addEventListener('scroll', navbarShrink);

    // Activar Bootstrap scrollspy para el navbar
    const mainNav = document.getElementById('mainNav'); // Mejor usar getElementById
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    }


});
