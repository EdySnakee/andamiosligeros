@php
    $heWidgetSol = null;
    try {
        if (\Auth::check() && \Illuminate\Support\Facades\Schema::hasTable('horas_extra_solicitudes')) {
            $heWidgetSol = \App\HoraExtraSolicitud::where('user_id', \Auth::id())
                ->where('estatus', \App\HoraExtraSolicitud::ESTATUS_EN_CURSO)
                ->select('id', 'inicio_at')
                ->first();
        }
    } catch (\Throwable $e) {
        $heWidgetSol = null;
    }
@endphp

@if ($heWidgetSol && $heWidgetSol->inicio_at)
<div id="he-widget-sesion"
     data-inicio-ts="{{ $heWidgetSol->inicio_at->timestamp }}"
     data-latido-url="{{ route('app_horas_extra_latido') }}"
     data-intervalo-ms="{{ (int) config('horas_extra.intervalo_latido_seg', 60) * 1000 }}"
     data-inactividad-ms="{{ (int) config('horas_extra.inactividad_seg', 120) * 1000 }}"
     style="position: fixed; right: 18px; bottom: 18px; z-index: 1060; background: #fffbeb; border: 1px solid #f59e0b; color: #92400e; padding: 8px 14px; border-radius: 999px; box-shadow: 0 8px 22px rgba(15, 23, 42, 0.16); font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
    <span style="display:inline-block; width:9px; height:9px; border-radius:50%; background:#d97706;"></span>
    <span>&#9201; Horas extra en curso &middot; <strong id="he-widget-timer">{{ \App\HoraExtraSolicitud::formatearMinutos($heWidgetSol->minutosTranscurridos()) }}</strong></span>
    <a href="{{ route('app_horas_extra_ver', $heWidgetSol->id) }}" style="color:#b45309; text-decoration:underline; margin-left:4px;">Ver</a>
</div>
<script>
(function() {
    var widget = document.getElementById('he-widget-sesion');
    if (!widget) { return; }

    var timerEl = document.getElementById('he-widget-timer');
    var inicioTs = parseInt(widget.getAttribute('data-inicio-ts'), 10) || Math.floor(Date.now() / 1000);
    var latidoUrl = widget.getAttribute('data-latido-url');
    var intervaloMs = parseInt(widget.getAttribute('data-intervalo-ms'), 10) || 60000;
    var inactividadMs = parseInt(widget.getAttribute('data-inactividad-ms'), 10) || 120000;
    var ultimaInteraccion = Date.now();
    var metaCsrf = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = metaCsrf ? metaCsrf.getAttribute('content') : '';

    function actualizarCronometro() {
        if (!timerEl) { return; }
        var diffMin = Math.max(0, Math.floor((Math.floor(Date.now() / 1000) - inicioTs) / 60));
        if (diffMin === 0) {
            timerEl.textContent = '0 min';
        } else if (diffMin < 60) {
            timerEl.textContent = diffMin + ' min';
        } else {
            var h = Math.floor(diffMin / 60);
            var m = diffMin % 60;
            timerEl.textContent = m === 0 ? (h + ' h') : (h + ' h ' + m + ' min');
        }
    }

    function registrarInteraccion() {
        ultimaInteraccion = Date.now();
    }

    var eventos = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];
    for (var i = 0; i < eventos.length; i++) {
        try {
            window.addEventListener(eventos[i], registrarInteraccion, { passive: true });
        } catch (e) {
            window.addEventListener(eventos[i], registrarInteraccion, false);
        }
    }

    actualizarCronometro();
    var relojInterval = setInterval(actualizarCronometro, 15000);

    var latidoInterval = setInterval(function() {
        if (document.visibilityState && document.visibilityState !== 'visible') {
            return;
        }
        if ((Date.now() - ultimaInteraccion) >= inactividadMs) {
            return;
        }
        if (typeof window.jQuery !== 'function') {
            return;
        }

        window.jQuery.post(latidoUrl, {
            _token: csrfToken,
            ruta: window.location.pathname
        }).done(function(resp) {
            if (resp && resp.activa === false) {
                widget.style.display = 'none';
                clearInterval(latidoInterval);
                clearInterval(relojInterval);
            }
        });
    }, intervaloMs);
})();
</script>
@endif

