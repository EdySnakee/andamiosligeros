<section class="andamios-section">
    <div class="max-w-2xl mx-auto text-center">
        {{-- <h2>Andamio SBT-6</h2> --}}
        <p>
            Nuestro modelo <span class="font-semibold">SBT-6</span>
            está diseñado para ser resistencia en cada proyecto. Conoce sus beneficios principales:
        </p>

        <div class="andamios-grid">
            <div class="andamios-card">
                <i class="fas fa-hard-hat"></i>
                <h3>Máxima Seguridad</h3>
                <p>Diseñado con materiales de alta resistencia para absorber daños en obra y mantener la seguridad del usuario.</p>
            </div>

            <div class="andamios-card">
                <i class="fas fa-tools"></i>
                <h3>Fácil Montaje</h3>
                <p>Su sistema modular permite un armado rápido para ahorrar tiempo sin importar la circunstancia en la que se presenta.</p>
            </div>

            <div class="andamios-card">
                <i class="fas fa-truck-loading"></i>
                <h3>Ligero y Transportable</h3>
                <p>Su peso reducido facilita el traslado de punto A al punto B sin inconvenientes que detengan el flujo laboral.</p>
            </div>

            <div class="andamios-card">
                <i class="fas fa-building"></i>
                <h3>Versatilidad</h3>
                <p>Ideal para proyectos de construcción en alturas de 20 metros y más, hasta cambiar un foco en una oficina.</p>
            </div>

            <div class="andamios-card">
                <i class="fas fa-recycle"></i>
                <h3>Durabilidad</h3>
                <p>Fabricado en acero galvanizado evitando que este se oxide y pueda resistir el pasar del tiempo</p>
            </div>

            <div class="andamios-card">
                <i class="fas fa-cogs"></i>
                <h3>Compatibilidad</h3>
                <p>Compatible con accesorios y sistemas de altura para una amplia comodidad al momento de laborar en el cualquier tipo de altura.</p>
            </div>
        </div>
    </div>
</section>


<style>
    /* Sección general */
    .andamios-section {
        text-align: center;
        border-radius: 1rem;
    }

    /* Título */
    .andamios-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #FFD60A;
        /* Amarillo corporativo */
        margin-bottom: 1rem;
    }

    /* Subtítulo */
    .andamios-section p {
        /* color: #E5E7EB; */
        /* Gris claro */
        max-width: 700px;
        margin: 0 auto 3rem auto;
        line-height: 1.6;
    }

    /* Grid */
    .andamios-grid {
        display: grid;
        gap: 2.5rem;
        grid-template-columns: 1fr;
    }

    @media (min-width: 768px) {
        .andamios-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Cards */
    .andamios-card {
        background: #1E3A8A;
        /* Azul medio */
        padding: 2rem;
        border-radius: 1.5rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .andamios-card:hover {
        box-shadow: 0 8px 25px rgba(255, 214, 10, 0.4);
        transform: translateY(-5px);
    }

    /* Iconos */
    .andamios-card i {
        font-size: 2.5rem;
        color: #FFD60A;
        /* Amarillo */
        margin-bottom: 1rem;
    }

    /* Títulos dentro de card */
    .andamios-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #FACC15;
        /* Amarillo más suave */
        margin-bottom: 0.75rem;
    }

    /* Texto */
    .andamios-card p {
        color: #E5E7EB;
        /* Gris claro */
        font-size: 0.95rem;
        line-height: 1.6;
    }
</style>
