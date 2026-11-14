<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .card-formato {
    border-radius: 8px;
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.12);
  }
  .badge-azul {
    background-color: #1a4189;
    color: #ffffff;
  }
  .btn-azul {
    background-color: #1a4189;
    border-color: #1a4189;
    color: #ffffff;
  }
  .btn-azul:hover {
    background-color: #14326b;
    border-color: #14326b;
    color: #ffffff;
  }
  .progress-bar-azul {
    background-color: #1a4189;
  }

  /* PESTAÑAS */
  .nav-pills.nav-pills-andamios .nav-link.active {
    background-color: #1a4189 !important;
    color: #ffffff !important;
  }
  .nav-pills.nav-pills-andamios .nav-link {
    color: #4e555b;
    font-size: 0.85rem;
    padding: 0.55rem 1.1rem;
    border-radius: 5px;
    margin-right: 6px;
    transition: all 0.2s ease;
  }
  .nav-pills.nav-pills-andamios .nav-link:hover {
    background-color: #eef3fb;
    color: #1a4189;
  }
  .nav-pills.nav-pills-andamios .nav-link.active .badge {
    background-color: #ffffff !important;
    color: #1a4189 !important;
  }

  /* HOJA INTERACTIVA DEL FORMATO */
  .hoja-formato {
    background: #ffffff;
    max-width: 920px;
    margin: 0 auto;
    padding: 36px 44px;
    border: 1px solid #dce3ee;
    box-shadow: 0 0.25rem 1.2rem rgba(26, 65, 137, 0.08);
    font-family: Arial, Helvetica, sans-serif;
    color: #2b2b2b;
    border-radius: 4px;
  }
  .formato-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding-bottom: 10px;
    border-bottom: 3px solid #f2bc1c;
    position: relative;
  }
  .formato-header .titulos h2 {
    color: #1a4189;
    font-size: 24px;
    font-weight: 800;
    margin: 0;
    letter-spacing: 0.4px;
    line-height: 1.15;
  }
  .formato-header .titulos p {
    color: #1d63b8;
    font-size: 11.5px;
    font-weight: 700;
    margin: 5px 0 6px 0;
    letter-spacing: 0.4px;
    text-transform: uppercase;
  }
  .formato-header .logo-bloque {
    text-align: center;
    min-width: 175px;
  }
  .formato-header .logo-bloque img.logo-andamios {
    max-height: 54px;
    max-width: 168px;
    object-fit: contain;
    display: block;
    margin: 0 auto;
  }
  .formato-header .logo-eslogan {
    font-size: 10px;
    color: #555555;
    margin-top: 3px;
    margin-bottom: 4px;
    font-weight: 600;
  }
  .formato-header .cinta-header-bloque {
    width: 168px;
    height: 5px;
    object-fit: cover;
    display: block;
    margin: 4px auto -10px auto;
  }

  .formato-seccion-titulo {
    color: #1a4189;
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    margin-top: 20px;
    margin-bottom: 8px;
    letter-spacing: 0.3px;
  }

  .formato-tabla {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6px;
    background-color: #ffffff;
  }
  .formato-tabla td, .formato-tabla th {
    border: 1px solid #d6deeb;
    padding: 5px 10px;
    vertical-align: middle;
  }
  .formato-tabla td.etiqueta {
    color: #1a4189;
    font-weight: 700;
    font-size: 10.5px;
    text-transform: uppercase;
    background-color: #f5f7fa;
    width: 22%;
  }
  .formato-tabla td.valor {
    font-size: 12.5px;
    width: 28%;
    color: #222222;
  }

  /* TABLA DE PRODUCTOS */
  .tabla-productos {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
  }
  .tabla-productos th {
    background-color: #1a4189;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 7px 10px;
    border: 1px solid #1a4189;
  }
  .tabla-productos td {
    border: 1px solid #d6deeb;
    padding: 6px 8px;
    font-size: 12.5px;
    vertical-align: middle;
  }

  .input-formato {
    border: 1px solid transparent;
    background: transparent;
    width: 100%;
    padding: 3px 6px;
    font-size: 12.5px;
    color: #222222;
    border-radius: 3px;
    transition: all 0.2s;
  }
  .input-formato:hover, .input-formato:focus {
    border-color: #1a4189;
    background: #ffffff;
    box-shadow: 0 0 0 2px rgba(26, 65, 137, 0.14);
    outline: none;
  }
  .input-formato-manual {
    border: 1px dashed #b9c8e0;
    background: #fafcff;
  }
  .input-formato-manual:focus {
    border: 1px solid #1a4189;
    background: #ffffff;
  }
  .input-cantidad-prod {
    font-weight: 700;
    text-align: center;
    max-width: 85px;
    display: inline-block;
  }

  /* OBSERVACIONES CON LÍNEAS GUÍA */
  .lineas-observaciones {
    border: 1px solid #d6deeb;
    border-radius: 3px;
    padding: 6px 10px;
    background: repeating-linear-gradient(
      transparent,
      transparent 25px,
      #8b95a5 26px,
      #8b95a5 27px
    );
    line-height: 27px;
    min-height: 84px;
  }
  .textarea-observaciones {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 12.5px;
    line-height: 27px;
    color: #222222;
    resize: vertical;
    outline: none;
  }

  .texto-legal {
    font-size: 11px;
    color: #3d3d3d;
    line-height: 1.45;
    margin-top: 12px;
    margin-bottom: 26px;
  }

  /* FIRMAS */
  .firmas-container {
    display: flex;
    justify-content: space-around;
    margin-top: 42px;
    padding-bottom: 18px;
  }
  .firma-bloque {
    text-align: center;
    width: 38%;
  }
  .firma-bloque-triple {
    text-align: center;
    width: 29%;
  }
  .firma-linea {
    border-top: 1.5px solid #4c6ea8;
    margin-bottom: 6px;
  }
  .firma-titulo {
    color: #1a4189;
    font-weight: 800;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
  }

  .formato-footer-legal {
    text-align: center;
    color: #1a4189;
    font-size: 10.5px;
    margin-top: 32px;
    padding-top: 10px;
  }

  /* AUTOCOMPLETADO PRODUCTOS Y COTIZACIONES */
  .contenedor-autocompletado {
    position: relative;
    width: 100%;
  }
  .dropdown-coincidencias {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #b9c8e0;
    border-radius: 4px;
    box-shadow: 0 8px 24px rgba(26, 65, 137, 0.16);
    max-height: 250px;
    overflow-y: auto;
    z-index: 1060;
    margin-top: 2px;
  }
  .item-coincidencia {
    padding: 7px 10px;
    cursor: pointer;
    border-bottom: 1px solid #eef2f8;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.15s;
    font-size: 12.5px;
    color: #333333;
  }
  .item-coincidencia:last-child {
    border-bottom: none;
  }
  .item-coincidencia:hover, .item-coincidencia.activo {
    background: #eef4fc;
    color: #1a4189;
  }
  .item-coincidencia-nombre {
    font-weight: 600;
  }
  .item-coincidencia-meta {
    font-size: 11px;
    margin-left: 8px;
    white-space: nowrap;
  }
  .item-coincidencia-resaltado {
    background-color: #ffe699;
    color: #1a4189;
    font-weight: 800;
    padding: 0 1px;
    border-radius: 2px;
  }
  .dropdown-coincidencias-header {
    background: #f5f8fd;
    padding: 5px 10px;
    font-size: 10.5px;
    color: #1a4189;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #dce5f2;
  }
  .dropdown-coincidencias-vacio {
    padding: 10px;
    text-align: center;
    font-size: 12px;
    color: #777777;
    font-style: italic;
  }
  .dropdown-coincidencias-cargando {
    padding: 10px 12px;
    display: flex;
    align-items: center;
    font-size: 12px;
    color: #1a4189;
    font-weight: 600;
    background: #f8fafe;
  }

  /* RESUMEN DE CAMBIO */
  .resumen-cambio-bar {
    background: #f5f8fd;
    border: 1px solid #dce5f2;
    border-radius: 6px;
    padding: 10px 15px;
  }

  /* DATEPICKER PERSONALIZADO ANDAMIOS */
  .daterangepicker {
    font-family: 'Nunito', Arial, sans-serif;
    border: 1px solid #b9c8e0;
    box-shadow: 0 8px 24px rgba(26, 65, 137, 0.18);
    z-index: 2050 !important;
  }
  .daterangepicker td.active, .daterangepicker td.active:hover {
    background-color: #1a4189 !important;
    color: #ffffff !important;
  }
  .daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
    font-size: 12px;
  }
  .input-fecha-picker {
    cursor: pointer;
  }

  @media print {
    body {
      background: #ffffff !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    #sidebarToggleTop, .navbar, .sidebar, footer, .no-print, .scroll-to-top, .dropdown-coincidencias {
      display: none !important;
    }
    #content-wrapper, .container-fluid {
      margin: 0 !important;
      padding: 0 !important;
      background: #ffffff !important;
    }
    .hoja-formato {
      border: none !important;
      box-shadow: none !important;
      max-width: 100% !important;
      margin: 0 !important;
      padding: 10px 15px !important;
    }
    .input-formato, .input-formato-manual, .input-cantidad-prod, input, select, textarea {
      border: none !important;
      background: transparent !important;
      box-shadow: none !important;
    }
  }
</style>

