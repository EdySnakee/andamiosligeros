<style>
    :root {
        --al-blue: #0052cc;
        --al-yellow: #ffc400;
        --al-dark: #111827;
    }

    .promo-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 10px;
        /* Reducido para dar más espacio al popup en móviles */
        z-index: 9999;
    }

    .promo-popup-overlay.is-visible {
        display: flex;
    }

    /* CONTENEDOR PRINCIPAL */
    .promo-popup {
        position: relative;
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.35);
        animation: promoPopupIn .25s ease-out;
        height: 65vh;
        max-height: 800px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        max-width: 715px;
    }

    .promo-popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--al-blue);
        background: #ffffff;
        color: var(--al-blue);
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 20;
        /* Por encima de todo */
        transition: transform .2s;
    }

    .promo-popup-close:hover {
        transform: scale(1.1);
    }

    /* ÁREA DE CONTENIDO (FLEXIBLE) */
    .promo-popup-content {
        /* Ocupa el 100% del alto del padre (.promo-popup) */
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px;
        box-sizing: border-box;
        height: 100%;
        /* Asegura que llene el padre */
    }

    /* 1. TÍTULO (No se encoge) */
    .promo-popup-content h2 {
        margin: 0 0 10px 0;
        font-weight: 900;
        color: var(--al-dark);
        text-align: center;
        flex-shrink: 0;
    }

    /* 2. ESPACIO DE LA IMAGEN (Flexible) */
    .promo-popup-img-link {
        flex: 1;
        width: 100%;
        position: relative;
        min-height: 0;
        margin-bottom: 10px;
    }

    /* 3. LA IMAGEN REAL (Absoluta) */
    .promo-popup-img {
        position: absolute;
        inset: 0;
        width: min(100%, 700px);
        height: 100%;
        object-fit: contain;
        display: block;
        margin: auto;
    }

    /* 4. BOTÓN (No se encoge) */
    .promo-popup-cta {
        flex-shrink: 0;
        /* PROHIBIDO ENCOGERSE */
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 12px 24px;
        font-size: clamp(14px, 2.5vh, 16px);
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 999px;
        background: var(--al-yellow);
        color: #000;
        border: 2px solid var(--al-blue);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform .15s;
    }

    .promo-popup-cta:hover {
        transform: translateY(-2px);
    }

    @keyframes promoPopupIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Ajuste para pantallas muy apaisadas (Landscape móvil) */
    @media (max-height: 500px) {
        .promo-popup {
            flex-direction: row;
            /* Cambia a horizontal si es muy bajita la pantalla */
            height: 90vh;
            width: 90vw;
            max-width: 700px;
        }

        .promo-popup-content {
            flex-direction: row;
            gap: 15px;
            padding: 15px;
        }

        .promo-popup-img-link {
            flex: 1;
            height: 100%;
            margin-bottom: 0;
        }

        .promo-popup-info-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 40%;
            gap: 10px;
        }

        /* Reestructuración interna para modo landscape */
        .promo-popup-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr;
            align-items: center;
            gap: 20px;
        }

        .promo-popup-img-link {
            order: 1;
            /* Imagen a la izquierda */
            height: 100%;
        }

        .text-group {
            order: 2;
            /* Texto a la derecha */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .promo-popup-content h2 {
            font-size: 18px;
        }
    }
</style>


@php
// Importar modelo (asegúrate que el namespace sea correcto, suele ser App\PromocionesModel)
use App\PromocionesModel;

// Buscar UNA promoción que sea destacada (1) Y activa (1), en orden aleatorio
$promo = PromocionesModel::where('destacado_modal', 1)
->where('status', 1)
->inRandomOrder()
->first();
@endphp

{{-- Solo renderizamos el HTML si existe una promoción válida --}}
@if($promo)

{{-- Popup Promoción  --}}
<div id="promo-popup" class="promo-popup-overlay" inert>
    <div class="promo-popup">

        <button class="promo-popup-close" aria-label="Cerrar promoción">&times;</button>

        <div class="promo-popup-content">

            <h2>⭐{{ $promo->nombre_promo }}⭐</h2>

            <a href="{{ url('promociones/' . $promo->url_promo) }}" class="promo-popup-img-link">
                <img src="{{ url('web/prom/' . $promo->img_banner) }}" alt="{{ $promo->nombre_promo }}" class="promo-popup-img">
            </a>

            <a href="{{ url('promociones/' . $promo->url_promo) }}" class="promo-popup-cta">
                Ver promoción
            </a>

        </div>
    </div>
</div>



<script>
    (function() {
        const POPUP_DELAY_MS = 3200;
        const POPUP_STORAGE_KEY = 'promo_popup_shown_session_v1';

        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('promo-popup');
            if (!overlay) return;

            // Si en esta sesión ya se mostró, no volver a mostrar
            if (sessionStorage.getItem(POPUP_STORAGE_KEY) === '1') {
                return;
            }

            setTimeout(() => {
                // Mostrar popup
                overlay.classList.add('is-visible');
                overlay.removeAttribute('inert');

                // Marcar como mostrado en esta sesión
                sessionStorage.setItem(POPUP_STORAGE_KEY, '1');
            }, POPUP_DELAY_MS);

            const closeBtn = overlay.querySelector('.promo-popup-close');

            const close = () => {
                overlay.classList.remove('is-visible');
                overlay.setAttribute('inert', '');
                // Redundante pero seguro: asegurar flag en sesión
                sessionStorage.setItem(POPUP_STORAGE_KEY, '1');
            };

            if (closeBtn) {
                closeBtn.addEventListener('click', close);
            }

            // Si quieres cerrar haciendo click fuera del popup, descomenta:
            // overlay.addEventListener('click', e => e.target === overlay && close());

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') close();
            });
        });
    })();
</script>
@endif