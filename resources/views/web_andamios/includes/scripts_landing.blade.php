<script>
    if (window.location.href == 'https://www.andamiosligeros.com/andamio-ligero-plegable-sbt-10-landing' ||
        'https://andamiosligeros.com/andamio-ligero-plegable-sbt-10-landing') {
        document.querySelector('#navbar').remove()
        document.querySelector('footer').remove()
        document.querySelector('.social-whats-footer').remove()
        localStorage.removeItem('landing');

    }

    botonesLocal = document.querySelectorAll('#setLocalStorage')

    botonesLocal.forEach(button => {
            button.addEventListener('click', () => {
                console.log("hey")
                localStorage.setItem('landing', true);
            })
        })

    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const faqAnswer = button.nextElementSibling;
            button.classList.toggle('active');
            if (button.classList.contains('active')) {
                faqAnswer.style.maxHeight = faqAnswer.scrollHeight + 'px';
            } else {
                faqAnswer.style.maxHeight = 0;
            }
        });
    });

    // cronometro circular
    document.addEventListener('DOMContentLoaded', function() {
        const cronometro = document.querySelector('.cta-cronometro')
        const countdownElement = document.getElementById('cronometro-text');
        let time = 300; // Tiempo en segundos (5 minutos)

        function updateCountdown() {
            const minutes = Math.floor(time / 60);
            const seconds = time % 60;
            countdownElement.textContent =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (time < 61) {
                cronometro.classList.add('urgente')
            }
            if (time > 0) {
                time--;
            } else {
                cronometro.classList.remove('urgente');
                cronometro.classList.add('oferta-terminada')
                clearInterval(countdownInterval);
                // Aquí puedes agregar código para manejar la expiración del tiempo
                countdownElement.textContent =
                    '¡Oferta Terminada!';
            }
        }

        // Actualiza el cronómetro cada segundo
        const countdownInterval = setInterval(updateCountdown, 1000);
    });

    document.addEventListener("DOMContentLoaded", function() {
        const counterElement = document.getElementById("counter");
        const targetNumber = 8;
        let currentNumber = 0;

        function animateCounter() {
            const interval = setInterval(() => {
                counterElement.textContent = currentNumber;
                if (currentNumber < targetNumber) {
                    currentNumber++;
                } else {
                    clearInterval(interval);
                }
            }, 100); // Controla la velocidad de incremento (en milisegundos)
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        animateCounter();
                        observer
                            .disconnect(); // Desconectar el observer después de que la animación se ejecute una vez
                    }, 300);
                }
            });
        });

        observer.observe(document.querySelector(".counter"));
    });

    //borrar después
    document.addEventListener("DOMContentLoaded", function() {
        const counterElement = document.getElementById("counter2");
        const targetNumber = 8;
        let currentNumber = 0;

        function animateCounter() {
            const interval = setInterval(() => {
                counterElement.textContent = currentNumber;
                if (currentNumber < targetNumber) {
                    currentNumber++;
                } else {
                    clearInterval(interval);
                }
            }, 100); // Controla la velocidad de incremento (en milisegundos)
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        animateCounter();
                        observer
                            .disconnect(); // Desconectar el observer después de que la animación se ejecute una vez
                    }, 300);
                }
            });
        });

        observer.observe(document.querySelector(".counter2"));
    });

    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    let currentIndex = 0;
    let startX;
    let isSwiping = false;

    function getVisibleSlides() {
        if (window.innerWidth >= 1024) return 4;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }

    function moveSlider(direction) {
        const visibleSlides = getVisibleSlides();
        const maxIndex = slides.length - visibleSlides;

        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % (maxIndex + 1);
        } else {
            currentIndex = (currentIndex - 1 + maxIndex + 1) % (maxIndex + 1);
        }

        slider.style.transform = `translateX(-${currentIndex * (100 / visibleSlides)}%)`;
    }

    prevButton.addEventListener('click', (e) => {
        e.preventDefault();
        moveSlider('prev');
    });

    nextButton.addEventListener('click', (e) => {
        e.preventDefault();
        moveSlider('next');
    });

    slider.addEventListener('mousedown', (e) => {
        startX = e.clientX;
        isSwiping = true;
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isSwiping) return;
        const diffX = e.clientX - startX;
        if (Math.abs(diffX) > 50) {
            moveSlider(diffX > 0 ? 'prev' : 'next');
            isSwiping = false;
        }
    });

    slider.addEventListener('mouseup', () => {
        isSwiping = false;
    });

    slider.addEventListener('mouseleave', () => {
        isSwiping = false;
    });

    // Soporte táctil
    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isSwiping = true;
    });

    slider.addEventListener('touchmove', (e) => {
        if (!isSwiping) return;
        const diffX = e.touches[0].clientX - startX;
        if (Math.abs(diffX) > 50) {
            moveSlider(diffX > 0 ? 'prev' : 'next');
            isSwiping = false;
        }
    });

    slider.addEventListener('touchend', () => {
        isSwiping = false;
    });

    window.addEventListener('resize', () => {
        currentIndex = 0;
        slider.style.transform = 'translateX(0)';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.medidas-btn');
        const images = document.querySelectorAll('.medidas-img-container img');

        function removeActiveClass() {
            buttons.forEach(btn => btn.classList.remove('active'));
        }

        function addActiveClass(hash) {
            const activeButton = document.querySelector(`a[href="${hash}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                removeActiveClass();
                addActiveClass(this.hash);
            });
        });


    });
</script>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
