<?php

return [
    'limite_horas_dia'      => 3,
    'limite_dias_semana'    => 3,
    'limite_horas_semana'   => 9,
    'intervalo_latido_seg'  => 60,
    'inactividad_seg'       => 120,
    'dedupe_latido_seg'     => 40,
    'dedupe_accion_get_seg' => 30,
    'hueco_alerta_min'      => 30,
    'distancia_alerta_m'    => 1000,
    'respaldo_minimo_pct'   => 50,
    'aviso_version'         => '2026-11',
    'contacto_privacidad'   => env('HE_CONTACTO_PRIVACIDAD', 'el área de Recursos Humanos'),
    'evidencias_max'        => 5,
    'evidencia_max_kb'      => 5120,
];

