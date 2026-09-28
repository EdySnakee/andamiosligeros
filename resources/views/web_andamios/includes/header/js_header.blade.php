<script>
    document.addEventListener('DOMContentLoaded', function() {
        // VARIABLES
        let tamanoPantalla = window.screen.width;
        let header = document.querySelector('.andamios-header');
        let navLogo = document.querySelector('.nav-logo');
        let navPromociones = document.querySelector('.nav-promociones');
        let navHamburger = document.querySelector('.nav-hamburger');
        let navOverlay = document.querySelector('.nav-overlay-mobile')
        let navOpciones = document.querySelector('.nav-opciones');
        let navSupermenuTrigger = document.querySelector('.nav-opcion-supermenu');
        let navSupermenuOpciones = document.querySelector('.nav-opciones-supermenu');
        let navSupermenuRegresar = document.querySelector('.supermenu-regresar');

        //Desplegar menú en móvil
        navHamburger.addEventListener('click', () => {
            navOpciones.classList.toggle('nav-opciones-active');
            navOverlay.classList.toggle('nav-overlay-mobile-active')
        });

        // Lógica para dispositivos hasta tablet
        if (tamanoPantalla < 1026) {
            //Cerrar menú dando click al overlay
            navOverlay.addEventListener('click', () => {
                navOpciones.classList.toggle('nav-opciones-active');
                navOverlay.classList.toggle('nav-overlay-mobile-active')
            })

            // Abrir supermenu
            navSupermenuTrigger.addEventListener('click', () => {
                navSupermenuOpciones.classList.add('nav-opciones-supermenu-active');
            });

            // Cerrar supermenu
            navSupermenuRegresar.addEventListener('click', () => {
                navSupermenuOpciones.classList.remove('nav-opciones-supermenu-active');
            });

        }

        navSupermenuTrigger.addEventListener('mouseover', () => {
            navSupermenuOpciones.classList.add('nav-opciones-supermenu-active')
        })

        navSupermenuTrigger.addEventListener('mouseleave', () => {
            setTimeout(() => {
                navSupermenuOpciones.classList.remove('nav-opciones-supermenu-active')
            }, 50);
        })

        // Lógica para estilos al hacer scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) { // Se activa cuando se ha hecho scroll más de 50px
                header.classList.add('scrolled');
                navLogo.classList.add('scrolled');
                navPromociones.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
                setTimeout(() => {
                    navLogo.classList.remove('scrolled');
                    navPromociones.classList.remove('scrolled');
                }, 500)
            }
        });
    });
</script>