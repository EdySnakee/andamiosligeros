<style>
    /* ===== Estilos Generales ===== */
    .sbt6-wrap {
        max-width: 960px;
        margin: 4px auto;
        padding: 0 12px;
        position: relative;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    .sbt6-stage {
        position: relative;
        width: 100%;
        overflow: hidden; /* Mantiene todo dentro del marco */
    }

    .sbt6-stage::before {
        content: "";
        display: block;
        padding-top: 133.33%; /* Aspect Ratio */
    }

    .sbt6-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        pointer-events: none;
        user-select: none;
    }

    /* ===== Hotspots ===== */
    .sbt6-hotspot {
        position: absolute;
        transform: translate(-50%, -50%);
        border: 1px solid rgba(0, 0, 0, .12);
        background: #fff;
        border-radius: 9px;
        padding: 4px 14px;
        font-weight: 600;
        font-size: 16px;
        color: #111;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        cursor: pointer;
        transition: background .2s, transform .15s, z-index 0s;
        white-space: nowrap;
    }

    .sbt6-hotspot:hover {
        z-index: 20; /* Traer al frente al hacer hover */
        background: #f9fafb;
    }

    .sbt6-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        animation: sbt6Pulse 1.2s ease-in-out infinite;
    }

    /* Colores del punto */
    .sbt6-hotspot[data-color="amber"] .sbt6-dot { background: #f59e0b; }
    .sbt6-hotspot[data-color="blue"] .sbt6-dot { background: #3b82f6; }
    .sbt6-hotspot[data-color="red"] .sbt6-dot { background: #ef4444; }
    .sbt6-hotspot[data-color="rose"] .sbt6-dot { background: #fb7185; }
    .sbt6-hotspot[data-color="gray"] .sbt6-dot { background: #6b7280; }

    @keyframes sbt6Pulse {
        0% { opacity: .35; transform: scale(.9); }
        50% { opacity: 1; transform: scale(1.15); }
        100% { opacity: .35; transform: scale(.9); }
    }

    /* ===== Tooltip de Escritorio (CSS Puro) ===== */
    .sbt6-tooltip-desktop {
        display: none; /* Oculto por defecto */
        position: absolute;
        bottom: 100%; /* Aparece arriba del botón */
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        width: 240px;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-radius: 8px;
        padding: 12px;
        text-align: left;
        pointer-events: none; /* Evita que el mouse interactúe con el tooltip y parpadee */
        white-space: normal; /* Permite saltos de línea en el texto */
    }
    
    .sbt6-tooltip-desktop h4 {
        margin: 0 0 4px 0;
        font-size: 14px;
        font-weight: 700;
        color: #111;
        line-height: 1.2;
    }
    
    .sbt6-tooltip-desktop p {
        margin: 0;
        font-size: 13px;
        color: #444;
        line-height: 1.4;
    }

    /* Mostrar Tooltip en Hover (Solo Desktop) */
    @media (min-width: 769px) {
        .sbt6-hotspot:hover .sbt6-tooltip-desktop {
            display: block;
            animation: sbt6FadeIn 0.2s ease-out;
        }
    }

    @keyframes sbt6FadeIn {
        from { opacity: 0; transform: translateX(-50%) translateY(0); }
        to { opacity: 1; transform: translateX(-50%) translateY(-8px); }
    }

    /* ===== Bottom sheet móvil ===== */
    .sbt6-sheet {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        background: #fff;
        border-top: 1px solid rgba(0, 0, 0, .1);
        border-radius: 16px 16px 0 0;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, .15);
        padding: 20px 20px 30px 20px;
        transform: translateY(110%);
        transition: transform .25s cubic-bezier(0.32, 0.72, 0, 1);
        z-index: 9999;
    }

    .sbt6-sheet.show {
        transform: translateY(0);
    }

    .sbt6-sheet h4 {
        margin: 0 0 8px 0;
        font-size: 18px;
        font-weight: 700;
        color: #111;
    }

    .sbt6-sheet p {
        margin: 0;
        font-size: 15px;
        color: #555;
        line-height: 1.5;
    }

    /* Ocultar elementos móviles en desktop */
    @media (min-width: 769px) {
        .sbt6-sheet { display: none !important; }
    }
</style>

<div class="sbt6-wrap">
    <div class="sbt6-stage" id="sbt6-stage">
        <img class="sbt6-img" src="/web/img/andamios/SBT-6/andamio-interactiv.webp" alt="Componentes del Andamio Plegable SBT-6">

        <button class="sbt6-hotspot" style="left:75%;top:18%;" data-color="amber">
            <span class="sbt6-dot"></span>Plataforma
            <span class="sbt6-tooltip-desktop">
                <h4>Plataforma</h4>
                <p>Plataforma de 1.60 × 0.20 m, galvanizada y antiderrapante. Carga recomendada 250–300 kg distribuida.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" 
                  data-title="Plataforma" 
                  data-desc="Plataforma de 1.60 × 0.20 m, galvanizada y antiderrapante. Carga recomendada 250–300 kg distribuida."></span>
        </button>

        <button class="sbt6-hotspot" style="left:86%;top:34%;" data-color="blue">
            <span class="sbt6-dot"></span>Seguro
            <span class="sbt6-tooltip-desktop">
                <h4>Seguro Tipo Mariposa</h4>
                <p>Cierre rápido que fija la plataforma al marco y evita vibración.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Seguro Tipo Mariposa" data-desc="Cierre rápido que fija la plataforma al marco y evita vibración."></span>
        </button>

        <button class="sbt6-hotspot" style="left:81.5%;top:43.5%;" data-color="red">
            <span class="sbt6-dot"></span>Diagonal
            <span class="sbt6-tooltip-desktop">
                <h4>Diagonal de Seguridad</h4>
                <p>Cruceta diagonal que rigidiza la estructura y mejora la estabilidad lateral.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Diagonal de Seguridad" data-desc="Cruceta diagonal que rigidiza la estructura y mejora la estabilidad lateral."></span>
        </button>

        <button class="sbt6-hotspot" style="left:16%;top:34%;" data-color="rose">
            <span class="sbt6-dot"></span>Niple
            <span class="sbt6-tooltip-desktop">
                <h4>Niple de Conexión (4 pzas)</h4>
                <p>Permite apilar módulos; usar con anclajes conforme a buenas prácticas.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Niple de Conexión (4 pzas)" data-desc="Permite apilar módulos; usar con anclajes conforme a buenas prácticas."></span>
        </button>

        <button class="sbt6-hotspot" style="left:18%;top:51.3%;" data-color="gray">
            <span class="sbt6-dot"></span>Bisagra
            <span class="sbt6-tooltip-desktop">
                <h4>Bisagra</h4>
                <p>Mecanismo para plegar el cuerpo y facilitar transporte y guardado.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Bisagra" data-desc="Mecanismo para plegar el cuerpo y facilitar transporte y guardado."></span>
        </button>

        <button class="sbt6-hotspot" style="left:80%;top:63.3%;" data-color="gray">
            <span class="sbt6-dot"></span>Peldaño
            <span class="sbt6-tooltip-desktop">
                <h4>Peldaño</h4>
                <p>Escalones integrados para acceso al nivel de trabajo.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Peldaño" data-desc="Escalones integrados para acceso al nivel de trabajo."></span>
        </button>

        <button class="sbt6-hotspot" style="left:29%;top:77.5%;" data-color="blue">
            <span class="sbt6-dot"></span>Patas
            <span class="sbt6-tooltip-desktop">
                <h4>Patas</h4>
                <p>Tubos verticales que soportan la estructura; usar con ruedas o bases.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Patas" data-desc="Tubos verticales que soportan la estructura; usar con ruedas o bases."></span>
        </button>

        <button class="sbt6-hotspot" style="left:58%;top:81.4%;" data-color="amber">
            <span class="sbt6-dot"></span>Ruedas
            <span class="sbt6-tooltip-desktop">
                <h4>Ruedas</h4>
                <p>Juego de 4 ruedas con freno; añaden ~15–18 cm de altura y movilidad.</p>
            </span>
            <span class="sbt6-data-mobile" style="display:none" data-title="Ruedas" data-desc="Juego de 4 ruedas con freno; añaden ~15–18 cm de altura y movilidad."></span>
        </button>

    </div>
</div>

<div class="sbt6-sheet" id="sbt6-sheet" aria-hidden="true">
    <h4 id="sbt6-sheet-title"></h4>
    <p id="sbt6-sheet-desc"></p>
</div>

<script>
    (function() {
        // Solo necesitamos JS para la lógica móvil
        var sheet = document.getElementById('sbt6-sheet');
        var sTitle = document.getElementById('sbt6-sheet-title');
        var sDesc = document.getElementById('sbt6-sheet-desc');
        var activeBtn = null;
        var isMobile = window.innerWidth <= 768;

        function closeSheet() {
            if (sheet) {
                sheet.classList.remove('show');
                sheet.setAttribute('aria-hidden', 'true');
            }
            activeBtn = null;
        }

        function onHotspotClick(e) {
            // Recalcular por si giraron la pantalla
            isMobile = window.innerWidth <= 768;

            // Si es escritorio, no hacemos nada con JS (el CSS maneja el hover)
            if (!isMobile) return;

            e.preventDefault();
            e.stopPropagation(); // Evita que el click llegue al document y cierre inmediatamente
            
            var btn = e.currentTarget;
            var dataSpan = btn.querySelector('.sbt6-data-mobile');

            // Si ya está activo este botón, cerramos (toggle)
            if (activeBtn === btn) {
                closeSheet();
                return;
            }

            activeBtn = btn;
            
            // Llenar datos desde los atributos data del span oculto
            if(dataSpan){
                sTitle.innerHTML = dataSpan.getAttribute('data-title');
                sDesc.innerHTML = dataSpan.getAttribute('data-desc');
            }

            sheet.classList.add('show');
            sheet.setAttribute('aria-hidden', 'false');
        }

        // Listeners para los botones
        var hotspots = document.getElementsByClassName('sbt6-hotspot');
        for (var i = 0; i < hotspots.length; i++) {
            hotspots[i].addEventListener('click', onHotspotClick, false);
        }

        // 1. CERRAR AL HACER SCROLL (Solo móvil)
        window.addEventListener('scroll', function() {
            if (activeBtn) {
                closeSheet();
            }
        }, { passive: true });

        // 2. CERRAR AL HACER CLIC FUERA
        document.addEventListener('click', function(e) {
            // Si el clic no fue dentro del bottom sheet y hay uno abierto
            if (sheet.classList.contains('show') && !sheet.contains(e.target)) {
                closeSheet();
            }
        });

        // Resize handler simple
        window.addEventListener('resize', function() {
            var newIsMobile = window.innerWidth <= 768;
            if (newIsMobile !== isMobile) {
                closeSheet();
                isMobile = newIsMobile;
            }
        });

    })();
</script>