<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  var catalogoProductos = {!! isset($catalogoProductos) ? json_encode($catalogoProductos) : '[]' !!};
  var catalogoVendedores = {!! isset($catalogoVendedores) ? json_encode($catalogoVendedores) : '[]' !!};
  var rutaBaseFormato = "{{ $rutaBaseFormato }}";
  var urlBuscarCotizacion = "{{ route('app_formatos_buscar_cotizacion') }}";
  var urlBuscarClientes = "{{ route('app_formatos_buscar_clientes') }}";

  function escapeHtmlFormato(text) {
    if (text === null || text === undefined) return '';
    return $('<div>').text(String(text)).html();
  }

  function formatMoneyNumber(val) {
    var num = parseFloat(val);
    if (isNaN(num)) num = 0;
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function resaltarCoincidenciaTexto(texto, query) {
    var str = String(texto || '');
    var q = $.trim(String(query || ''));
    if (q === '') return escapeHtmlFormato(str);
    var idx = str.toLowerCase().indexOf(q.toLowerCase());
    if (idx === -1) return escapeHtmlFormato(str);
    var antes = escapeHtmlFormato(str.substring(0, idx));
    var match = escapeHtmlFormato(str.substring(idx, idx + q.length));
    var despues = escapeHtmlFormato(str.substring(idx + q.length));
    return antes + '<span class="item-coincidencia-resaltado">' + match + '</span>' + despues;
  }

  /* =====================================================================
   * 1. SELECTOR DE FECHA (DD/MM/YYYY) EN CAMPOS DE FECHA
   * ===================================================================== */
  function inicializarSelectoresFechaFormato() {
    if (typeof $.fn.daterangepicker === 'undefined' || typeof moment === 'undefined') {
      return;
    }

    $('.input-fecha-picker').each(function() {
      var $input = $(this);
      if ($input.data('daterangepicker')) return;

      var valInicial = $.trim($input.val()).replace(/\s+/g, '');
      var fechaMoment = moment(valInicial, ['DD/MM/YYYY', 'DD/MM/YY', 'YYYY-MM-DD'], true);
      if (!fechaMoment.isValid()) {
        fechaMoment = moment();
      }

      $input.daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        autoApply: true,
        startDate: fechaMoment,
        minYear: 2020,
        maxYear: parseInt(moment().format('YYYY'), 10) + 5,
        locale: {
          format: 'DD/MM/YYYY',
          applyLabel: 'Aplicar',
          cancelLabel: 'Limpiar',
          daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
          firstDay: 1
        }
      });

      $input.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY')).trigger('change');
      });
    });
  }

  $(document).ready(function() {
    inicializarSelectoresFechaFormato();
  });

  $(document).on('click', '.btn-abrir-calendario', function(e) {
    e.preventDefault();
    var target = $(this).attr('data-target');
    var $input = target ? $(target) : $(this).siblings('.input-fecha-picker');
    if ($input.length) {
      $input.focus().trigger('click');
    }
  });

  $(document).on('click', '.btn-limpiar-fecha-picker', function(e) {
    e.preventDefault();
    var target = $(this).attr('data-target');
    var $input = target ? $(target) : $(this).siblings('.input-fecha-picker');
    if ($input.length) {
      $input.val('');
      if ($input.data('daterangepicker')) {
        $input.data('daterangepicker').hide();
      }
    }
  });

  /* =====================================================================
   * 2. BUSCADOR DE COTIZACIONES / VENTAS (BARRA SUPERIOR)
   * ===================================================================== */
  var timerBuscarCoti = null;

  function ejecutarBusquedaCotizacion(term) {
    var dropdown = $('#dropdown-cotizaciones-formato');
    $.ajax({
      url: urlBuscarCotizacion,
      type: 'GET',
      data: { term: term },
      dataType: 'json',
      success: function(items) {
        if (!items || items.length === 0) {
          dropdown.html('<div class="dropdown-coincidencias-vacio">No se encontraron cotizaciones o ventas con ese criterio.</div>').show();
          return;
        }
        var html = '<div class="dropdown-coincidencias-header d-flex justify-content-between align-items-center">' +
                     '<span><i class="fas fa-file-invoice mr-1"></i> Cotizaciones / Ventas (' + items.length + ')</span>' +
                     '<span style="font-weight:normal; font-size:9.5px;">Clic para vincular</span>' +
                   '</div>';
        for (var i = 0; i < items.length; i++) {
          var c = items[i];
          var badgeVenta = c.cod_venta ? '<span class="badge badge-success ml-1" style="font-size:10px;">' + escapeHtmlFormato(c.cod_venta) + '</span>' : '';
          html += '<div class="item-coincidencia item-opcion-navegable item-coti-opcion" data-id-coti="' + c.id_cotizacion + '">' +
                    '<div>' +
                      '<div class="item-coincidencia-nombre">' +
                        resaltarCoincidenciaTexto(c.cod_cotizacion, term) + badgeVenta +
                        ' <span class="text-muted font-weight-normal">- ' + resaltarCoincidenciaTexto(c.cliente, term) + '</span>' +
                      '</div>' +
                      '<div class="small text-muted" style="font-size:10.5px;">' +
                        escapeHtmlFormato(c.status_label) + (c.vendedor ? ' &bull; Vendedor: ' + escapeHtmlFormato(c.vendedor) : '') +
                      '</div>' +
                    '</div>' +
                    '<div class="item-coincidencia-meta">' +
                      '<span class="badge badge-light border text-primary">#' + c.id_cotizacion + '</span>' +
                    '</div>' +
                  '</div>';
        }
        dropdown.html(html).show();
      }
    });
  }

  $(document).on('focus', '#input-buscar-cotizacion-formato', function() {
    $('.dropdown-coincidencias').not('#dropdown-cotizaciones-formato').hide();
    ejecutarBusquedaCotizacion($(this).val().trim());
  });

  $(document).on('input', '#input-buscar-cotizacion-formato', function() {
    var val = $(this).val().trim();
    clearTimeout(timerBuscarCoti);
    timerBuscarCoti = setTimeout(function() {
      ejecutarBusquedaCotizacion(val);
    }, 220);
  });

  $(document).on('click', '.item-coti-opcion', function(e) {
    e.stopPropagation();
    var idCoti = $(this).attr('data-id-coti');
    if (idCoti) {
      window.location.href = rutaBaseFormato + '/' + idCoti;
    }
  });

  /* =====================================================================
   * 3. AUTOCOMPLETADO DE CLIENTE / EMPRESA Y TELÉFONO (BASE DE DATOS)
   * ===================================================================== */
  var timerBuscarCliente = null;

  function ejecutarBusquedaClienteCampo(input, modoCampo) {
    var term = $(input).val().trim();
    var dropdown = $(input).siblings('.dropdown-coincidencias');

    if (term.length < 2) {
      dropdown.hide();
      return;
    }

    $.ajax({
      url: urlBuscarClientes,
      type: 'GET',
      data: { term: term },
      dataType: 'json',
      success: function(items) {
        if (!items || items.length === 0) {
          dropdown.hide();
          return;
        }
        var html = '<div class="dropdown-coincidencias-header d-flex justify-content-between align-items-center">' +
                     '<span><i class="fas fa-users mr-1"></i> Clientes en base de datos (' + items.length + ')</span>' +
                     '<span style="font-weight:normal; font-size:9.5px;">Clic o Enter para autocompletar</span>' +
                   '</div>';
        for (var i = 0; i < items.length; i++) {
          var cli = items[i];
          var metaHtml = '';
          if (cli.telefono) {
            metaHtml += '<span class="badge badge-light border text-primary mr-1" style="font-size:10px;"><i class="fas fa-phone-alt mr-1"></i>' + resaltarCoincidenciaTexto(cli.telefono, term) + '</span>';
          }
          if (cli.rfc) {
            metaHtml += '<span class="badge badge-light border text-muted" style="font-size:10px;">' + resaltarCoincidenciaTexto(cli.rfc, term) + '</span>';
          }
          html += '<div class="item-coincidencia item-opcion-navegable item-cliente-opcion" ' +
                  'data-nombre="' + escapeHtmlFormato(cli.nombre) + '" ' +
                  'data-telefono="' + escapeHtmlFormato(cli.telefono || '') + '">' +
                    '<div class="item-coincidencia-nombre">' + resaltarCoincidenciaTexto(cli.nombre, term) + '</div>' +
                    (metaHtml ? '<div class="item-coincidencia-meta">' + metaHtml + '</div>' : '') +
                  '</div>';
        }
        dropdown.html(html).show();
      }
    });
  }

  $(document).on('focus input', '.input-busqueda-cliente, .input-busqueda-telefono', function() {
    var self = this;
    var esTel = $(self).hasClass('input-busqueda-telefono');
    $('.dropdown-coincidencias').not($(self).siblings('.dropdown-coincidencias')).hide();
    clearTimeout(timerBuscarCliente);
    timerBuscarCliente = setTimeout(function() {
      ejecutarBusquedaClienteCampo(self, esTel ? 'telefono' : 'cliente');
    }, 180);
  });

  $(document).on('click', '.item-cliente-opcion', function(e) {
    e.stopPropagation();
    var nombre = $(this).attr('data-nombre') || '';
    var telefono = $(this).attr('data-telefono') || '';
    var form = $(this).closest('form');

    if (nombre !== '') {
      form.find('input[name="cliente"]').val(nombre);
    }
    if (telefono !== '') {
      form.find('input[name="telefono"]').val(telefono);
    }
    $('.dropdown-coincidencias').hide();
  });

  /* =====================================================================
   * 4. AUTOCOMPLETADO EN CAMPO COTIZACIÓN / PEDIDO / FACTURA (DENTRO DE HOJA)
   * ===================================================================== */
  var timerBuscarCotiCampo = null;

  function ejecutarBusquedaCotizacionEnCampo(input) {
    var term = $(input).val().trim();
    var dropdown = $(input).siblings('.dropdown-coincidencias');

    $.ajax({
      url: urlBuscarCotizacion,
      type: 'GET',
      data: { term: term },
      dataType: 'json',
      success: function(items) {
        if (!items || items.length === 0) {
          dropdown.hide();
          return;
        }
        var html = '<div class="dropdown-coincidencias-header d-flex justify-content-between align-items-center">' +
                     '<span><i class="fas fa-file-invoice-dollar mr-1"></i> Cotizaciones / Ventas (' + items.length + ')</span>' +
                     '<span style="font-weight:normal; font-size:9.5px;">Clic para rellenar datos</span>' +
                   '</div>';
        for (var i = 0; i < items.length; i++) {
          var c = items[i];
          var badgeVenta = c.cod_venta ? '<span class="badge badge-success ml-1" style="font-size:10px;">' + escapeHtmlFormato(c.cod_venta) + '</span>' : '';
          html += '<div class="item-coincidencia item-opcion-navegable item-coti-campo-opcion" ' +
                  'data-id-coti="' + c.id_cotizacion + '" ' +
                  'data-folio="' + escapeHtmlFormato(c.cod_cotizacion) + '" ' +
                  'data-cliente="' + escapeHtmlFormato(c.cliente || '') + '" ' +
                  'data-telefono="' + escapeHtmlFormato(c.telefono || '') + '" ' +
                  'data-vendedor="' + escapeHtmlFormato(c.vendedor || '') + '">' +
                    '<div>' +
                      '<div class="item-coincidencia-nombre">' +
                        resaltarCoincidenciaTexto(c.cod_cotizacion, term) + badgeVenta +
                        ' <span class="text-muted font-weight-normal">- ' + resaltarCoincidenciaTexto(c.cliente, term) + '</span>' +
                      '</div>' +
                      '<div class="small text-muted" style="font-size:10.5px;">' +
                        escapeHtmlFormato(c.status_label) + (c.vendedor ? ' &bull; ' + escapeHtmlFormato(c.vendedor) : '') +
                      '</div>' +
                    '</div>' +
                    '<div class="item-coincidencia-meta">' +
                      '<span class="badge badge-primary btn-vincular-coti-directo" data-id-coti="' + c.id_cotizacion + '" title="Cargar también las partidas de esta cotización" style="font-size:10px;">Cargar partidas #' + c.id_cotizacion + '</span>' +
                    '</div>' +
                  '</div>';
        }
        dropdown.html(html).show();
      }
    });
  }

  $(document).on('focus input', '.input-busqueda-cotizacion-campo', function() {
    var self = this;
    $('.dropdown-coincidencias').not($(self).siblings('.dropdown-coincidencias')).hide();
    clearTimeout(timerBuscarCotiCampo);
    timerBuscarCotiCampo = setTimeout(function() {
      ejecutarBusquedaCotizacionEnCampo(self);
    }, 200);
  });

  $(document).on('click', '.btn-vincular-coti-directo', function(e) {
    e.stopPropagation();
    var idCoti = $(this).attr('data-id-coti');
    if (idCoti) {
      window.location.href = rutaBaseFormato + '/' + idCoti;
    }
  });

  $(document).on('click', '.item-coti-campo-opcion', function(e) {
    e.stopPropagation();
    var folio = $(this).attr('data-folio') || '';
    var cliente = $(this).attr('data-cliente') || '';
    var telefono = $(this).attr('data-telefono') || '';
    var vendedor = $(this).attr('data-vendedor') || '';
    var input = $(this).closest('.contenedor-autocompletado').find('.input-busqueda-cotizacion-campo');
    var form = $(this).closest('form');

    input.val(folio);
    if (cliente !== '' && cliente !== 'Sin cliente') {
      form.find('input[name="cliente"]').val(cliente);
    }
    if (telefono !== '') {
      form.find('input[name="telefono"]').val(telefono);
    }
    if (vendedor !== '') {
      form.find('input[name="vendedor"]').val(vendedor);
    }
    $('.dropdown-coincidencias').hide();
  });

  /* =====================================================================
   * 5. AUTOCOMPLETADO DE VENDEDOR (USUARIOS EN BASE DE DATOS)
   * ===================================================================== */
  function buscarCoincidenciasVendedor(input) {
    var query = $(input).val().trim();
    var queryLower = query.toLowerCase();
    var dropdown = $(input).siblings('.dropdown-coincidencias');

    var matches = [];
    for (var i = 0; i < catalogoVendedores.length; i++) {
      var v = catalogoVendedores[i];
      var nombre = (v.nombre || '').toLowerCase();
      var rol = (v.rol || '').toLowerCase();
      if (queryLower === '' || nombre.indexOf(queryLower) !== -1 || rol.indexOf(queryLower) !== -1) {
        matches.push(v);
      }
    }

    if (matches.length === 0) {
      dropdown.hide();
      return;
    }

    var html = '<div class="dropdown-coincidencias-header d-flex justify-content-between align-items-center">' +
                 '<span><i class="fas fa-user-tie mr-1"></i> Personal / Vendedores (' + matches.length + ')</span>' +
                 '<span style="font-weight:normal; font-size:9.5px;">Clic o Enter</span>' +
               '</div>';

    for (var j = 0; j < matches.length; j++) {
      var vend = matches[j];
      html += '<div class="item-coincidencia item-opcion-navegable item-vendedor-opcion" data-nombre="' + escapeHtmlFormato(vend.nombre) + '">' +
                '<div class="item-coincidencia-nombre">' + resaltarCoincidenciaTexto(vend.nombre, query) + '</div>' +
                '<div class="item-coincidencia-meta"><span class="badge badge-light border text-muted" style="font-size:10px;">' + escapeHtmlFormato(vend.rol) + '</span></div>' +
              '</div>';
    }

    dropdown.html(html).show();
  }

  $(document).on('focus input', '.input-busqueda-vendedor', function() {
    $('.dropdown-coincidencias').not($(this).siblings('.dropdown-coincidencias')).hide();
    buscarCoincidenciasVendedor(this);
  });

  $(document).on('click', '.item-vendedor-opcion', function(e) {
    e.stopPropagation();
    var nombre = $(this).attr('data-nombre') || '';
    var input = $(this).closest('.contenedor-autocompletado').find('.input-busqueda-vendedor');
    input.val(nombre);
    $('.dropdown-coincidencias').hide();
  });

  /* =====================================================================
   * 6. AUTOCOMPLETADO DE CATÁLOGO DE PRODUCTOS EN FILAS
   * ===================================================================== */
  function buscarCoincidenciasProducto(input) {
    var query = $(input).val().trim();
    var queryLower = query.toLowerCase();
    var dropdown = $(input).siblings('.dropdown-coincidencias');

    var matches = [];
    if (queryLower === '') {
      matches = catalogoProductos.slice(0, 15);
    } else {
      for (var i = 0; i < catalogoProductos.length; i++) {
        var p = catalogoProductos[i];
        var nombre = (p.nombre || '').toLowerCase();
        var sku = (p.sku || '').toLowerCase();
        if (nombre.indexOf(queryLower) !== -1 || sku.indexOf(queryLower) !== -1) {
          matches.push(p);
          if (matches.length >= 25) break;
        }
      }
    }

    if (matches.length === 0) {
      dropdown.html(
        '<div class="dropdown-coincidencias-vacio">' +
          '<i class="fas fa-info-circle mr-1 text-muted"></i> Sin coincidencias en catálogo. Se registrará como descripción personalizada.' +
        '</div>'
      ).show();
      return;
    }

    var html = '<div class="dropdown-coincidencias-header d-flex justify-content-between align-items-center">' +
                 '<span><i class="fas fa-boxes mr-1"></i> Catálogo (' + matches.length + ')</span>' +
                 '<span style="font-weight:normal; font-size:9.5px;">Clic o Enter para elegir</span>' +
               '</div>';

    for (var j = 0; j < matches.length; j++) {
      var prod = matches[j];
      var nombreHtml = resaltarCoincidenciaTexto(prod.nombre, query);

      var metaHtml = '';
      if (prod.sku) {
        metaHtml += '<span class="badge badge-light border text-muted mr-1" style="font-size:10px;">' + resaltarCoincidenciaTexto(prod.sku, query) + '</span>';
      }
      if (prod.precio && prod.precio > 0) {
        metaHtml += '<span class="badge badge-light border text-primary" style="font-size:10px;">$' + formatMoneyNumber(prod.precio) + '</span>';
      }

      html += '<div class="item-coincidencia item-opcion-navegable item-prod-opcion" ' +
              'data-id="' + prod.id + '" ' +
              'data-nombre="' + escapeHtmlFormato(prod.nombre) + '" ' +
              'data-precio="' + (prod.precio || 0) + '" ' +
              'data-unidad="' + escapeHtmlFormato(prod.unidad || 'pzas') + '">' +
                '<div class="item-coincidencia-nombre">' + nombreHtml + '</div>' +
                (metaHtml ? '<div class="item-coincidencia-meta">' + metaHtml + '</div>' : '') +
              '</div>';
    }

    dropdown.html(html).show();
  }

  $(document).on('focus input', '.input-busqueda-producto', function() {
    $('.dropdown-coincidencias').not($(this).siblings('.dropdown-coincidencias')).hide();
    buscarCoincidenciasProducto(this);
  });

  $(document).on('click', '.item-prod-opcion', function(e) {
    e.stopPropagation();
    var prod = {
      id: $(this).attr('data-id'),
      nombre: $(this).attr('data-nombre'),
      precio: parseFloat($(this).attr('data-precio')) || 0,
      unidad: $(this).attr('data-unidad') || 'pzas'
    };
    var tr = $(this).closest('tr');
    tr.find('.dropdown-coincidencias').hide();

    if (typeof window.onSelectProductoFormato === 'function') {
      window.onSelectProductoFormato(tr, prod);
    } else {
      tr.find('.input-busqueda-producto').val(prod.nombre);
      tr.find('.input-id-producto').val(prod.id);
    }
  });

  /* =====================================================================
   * 7. NAVEGACIÓN POR TECLADO UNIFICADA EN TODOS LOS AUTOCOMPLETADOS
   * ===================================================================== */
  $(document).on('keydown', '.contenedor-autocompletado input', function(e) {
    var dropdown = $(this).closest('.contenedor-autocompletado').find('.dropdown-coincidencias');
    if (!dropdown.is(':visible')) return;

    var items = dropdown.find('.item-opcion-navegable');
    if (items.length === 0) return;
    var activo = items.filter('.activo');

    if (e.which === 40) {
      e.preventDefault();
      if (activo.length === 0 || activo.is(':last-child')) {
        items.removeClass('activo');
        items.first().addClass('activo');
      } else {
        activo.removeClass('activo').next('.item-opcion-navegable').addClass('activo');
      }
      var nuevoActivo = dropdown.find('.item-opcion-navegable.activo');
      if (nuevoActivo.length > 0) nuevoActivo[0].scrollIntoView({ block: 'nearest' });
    } else if (e.which === 38) {
      e.preventDefault();
      if (activo.length === 0 || activo.is(':first-child')) {
        items.removeClass('activo');
        items.last().addClass('activo');
      } else {
        activo.removeClass('activo').prev('.item-opcion-navegable').addClass('activo');
      }
      var nuevoActivoUp = dropdown.find('.item-opcion-navegable.activo');
      if (nuevoActivoUp.length > 0) nuevoActivoUp[0].scrollIntoView({ block: 'nearest' });
    } else if (e.which === 13) {
      if (activo.length > 0) {
        e.preventDefault();
        activo.trigger('click');
      }
    } else if (e.which === 27) {
      dropdown.hide();
    }
  });

  $(document).on('click', function(e) {
    if (!$(e.target).closest('.contenedor-autocompletado').length) {
      $('.dropdown-coincidencias').hide();
    }
  });
</script>
