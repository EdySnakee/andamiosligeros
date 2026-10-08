@php
    // SDK de Mercado Pago
    require base_path('vendor/autoload.php');
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    $products = [];

    // 1. Ítem del Producto de la promoción
    $item = new MercadoPago\Item();
    $item->title = $nombre_product;
    $item->quantity = (int) $cantidad;
    $item->unit_price = (float) $costo_item;
    $products[] = $item;

    // 2. Ítem de Costo de Envío
    $costo_envio_total = (float) $envio * (int) $cantidad;
    if ($costo_envio_total > 0) {
        $item_envio = new MercadoPago\Item();
        $item_envio->title = 'Costo de Envío';
        $item_envio->quantity = 1;
        $item_envio->unit_price = $costo_envio_total;
        $products[] = $item_envio;
    }

    // 3. Ítem de IVA (si fue solicitado)
    if (!empty($datos_orden->iva) && (float) $datos_orden->iva > 0) {
        $item_iva = new MercadoPago\Item();
        $item_iva->title = 'Impuesto IVA (16%)';
        $item_iva->quantity = 1;
        $item_iva->unit_price = (float) $datos_orden->iva;
        $products[] = $item_iva;
    }

    $arrDatosOrden = [
        'id_orden' => $datos_orden->id_orden,
    ];

    $preference->back_urls = array(
        "success" => route('webhooks_post_web', $arrDatosOrden),
        "failure" => route('webhooks_post_web', $arrDatosOrden),
        "pending" => route('webhooks_post_web', $arrDatosOrden)
    );

    $preference->auto_return = "approved";
    $preference->items = $products;
    $preference->save();

    $clienteNombre = !empty($datos_cliente->nombrecl) ? $datos_cliente->nombrecl : '';
@endphp

<div class="info-btn-pagos" style="margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px; width: 100%;">
    <p style="font-weight: 700; font-size: 15px; color: #232323; margin-bottom: 12px; text-align: left;">
        Selecciona tu método de pago:
    </p>

    <!-- Contenedor de opciones de pago -->
    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">

        <!-- 1. Opción Mercado Pago -->
        <label class="metodo-pago-promo-card" id="promo-card-mp" style="display: flex; align-items: center; justify-content: space-between; border: 2px solid #009ee3; background-color: #f7fbff; border-radius: 8px; padding: 12px 14px; margin-bottom: 0; cursor: pointer; transition: all 0.25s ease;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="radio" name="promo_metodo_pago" value="mercadopago" checked style="cursor: pointer; transform: scale(1.15);">
                <div style="text-align: left;">
                    <span style="display: block; font-weight: 700; font-size: 14px; color: #009ee3;">Mercado Pago</span>
                    <small style="display: block; color: #666; font-size: 11px;">Tarjetas, Dinero en cuenta, SPEI, Efectivo</small>
                </div>
            </div>
            <img src="https://http2.mlstatic.com/frontend-assets/ui-navigation/5.18.9/mercadopago/logo__small@2x.png" alt="Mercado Pago" style="height: 22px; max-width: 90px; object-fit: contain;">
        </label>

        <!-- Contenedor Botón Mercado Pago -->
        <div id="promo-mp-container" style="background: #ffffff; border: 1.5px solid #009ee3; border-top: none; border-radius: 0 0 8px 8px; padding: 16px; margin-top: -11px; margin-bottom: 8px;">
            <div class="text-left" style="margin-bottom: 12px;">
                <div class="group-flex" style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-weight: 600; font-size: 13px; color: #333;">Paga seguro con tu cuenta o tarjeta</span>
                    <div class="badgespan-seguro"><p class="andes-badge__content" style="margin: 0; font-size: 11px;">Compra Protegida <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.640015 3.0649C0.640015 6.71094 1.94452 9.03851 4.54271 9.96529L4.64001 10L4.73732 9.96529C7.33551 9.03851 8.64001 6.71094 8.64001 3.0649V2.73563H8.33232C7.17893 2.73563 6.01526 2.21963 4.83635 1.17412L4.64001 1L4.44368 1.17412C3.26477 2.21963 2.1011 2.73563 0.947707 2.73563H0.640015V3.0649Z" stroke="#00A650"></path><path d="M3.118 5.2201L2.64001 5.6522L4.14767 7L6.64001 4.39759L6.12631 4L4.10919 6.1062L3.118 5.2201Z" fill="#00A650"></path></svg></p></div>
                </div>
                <p class="text" style="margin: 4px 0 0 0; font-size: 12px; color: #666;"><span>Si tu paquete no llega, te devolvemos tu dinero.</span></p>
            </div>
            <div class="cho-container"></div>
        </div>

        <!-- 2. Opción Openpay BBVA -->
        <label class="metodo-pago-promo-card" id="promo-card-openpay" style="display: flex; align-items: center; justify-content: space-between; border: 1.5px solid #dcdcdc; background-color: #ffffff; border-radius: 8px; padding: 12px 14px; margin-bottom: 0; cursor: pointer; transition: all 0.25s ease;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="radio" name="promo_metodo_pago" value="openpay" style="cursor: pointer; transform: scale(1.15);">
                <div style="text-align: left;">
                    <span style="display: block; font-weight: 700; font-size: 14px; color: #002f6c;">
                        Tarjeta de Crédito / Débito <span style="font-size: 11px; font-weight: 600; color: #004481; background: #e8f0fe; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Openpay BBVA</span>
                    </span>
                    <small style="display: block; color: #666; font-size: 11px;">Pago directo y seguro sin salir de la página</small>
                </div>
            </div>
            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 24px; max-width: 105px; object-fit: contain;">
        </label>

        <!-- Formulario Tarjeta Openpay Embebido -->
        <div id="promo-openpay-container" style="display: none; background: #fdfefe; border: 1.5px solid #002f6c; border-top: none; border-radius: 0 0 8px 8px; padding: 16px; margin-top: -11px; margin-bottom: 8px; box-shadow: 0 4px 12px rgba(0,47,108,0.06); text-align: left;">
            
            <div style="margin-bottom: 12px;">
                <label for="promo_openpay_holder" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">Nombre del titular como aparece en la tarjeta *</label>
                <input class="form-control-cart" type="text" id="promo_openpay_holder" placeholder="Como aparece en la tarjeta" style="margin-bottom: 0; background: #fff; width: 100%; border: 1px solid #dadada; border-radius: 8px; padding: 8px 12px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 12px;">
                <label for="promo_openpay_card" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                    <span>Número de tarjeta *</span>
                    <span id="promo_card_type" style="font-size: 11px; font-weight: 700; color: #004481;"></span>
                </label>
                <input class="form-control-cart" type="text" id="promo_openpay_card" placeholder="0000 0000 0000 0000" maxlength="19" style="margin-bottom: 0; background: #fff; width: 100%; border: 1px solid #dadada; border-radius: 8px; padding: 8px 12px; font-family: monospace; font-size: 14px; letter-spacing: 1px;">
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <div style="flex: 1; min-width: 0;">
                    <label for="promo_openpay_expiry" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">Vigencia (MM / AA) *</label>
                    <input class="form-control-cart" type="text" id="promo_openpay_expiry" placeholder="MM / AA" maxlength="7" style="margin-bottom: 0; background: #fff; width: 100%; border: 1px solid #dadada; border-radius: 8px; padding: 8px 12px; text-align: center; font-family: monospace; font-size: 14px; letter-spacing: 1px;">
                    <input type="hidden" id="promo_openpay_exp_month">
                    <input type="hidden" id="promo_openpay_exp_year">
                </div>
                <div style="flex: 1; min-width: 0;">
                    <label for="promo_openpay_cvv" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">CVV *</label>
                    <input class="form-control-cart" type="password" id="promo_openpay_cvv" placeholder="123" maxlength="4" style="margin-bottom: 0; background: #fff; width: 100%; border: 1px solid #dadada; border-radius: 8px; padding: 8px 12px; text-align: center; font-family: monospace; font-size: 14px; letter-spacing: 1px;">
                </div>
            </div>

            <div id="promo-openpay-error" style="display: none; background: #fff1f0; border: 1px solid #ffa39e; color: #cf1322; padding: 8px 12px; border-radius: 6px; font-size: 12px; margin-bottom: 12px; line-height: 1.4;">
            </div>

            <button type="button" id="btn-pagar-openpay-promo" style="width: 100%; background: #ffc107; color: #000; border: none; font-weight: 800; font-size: 15px; padding: 12px; border-radius: 8px; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 10px rgba(255,193,7,0.3); text-transform: uppercase;">
                Pagar ${{ number_format($datos_orden->total, 2, '.', ',') }} con Tarjeta
            </button>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 12px; padding-top: 10px; border-top: 1px solid #eef2f7;">
                <small style="color: #666; font-size: 11px;">🔒 Tus datos viajan encriptados directo a Openpay by BBVA (PCI-DSS)</small>
                <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 16px; max-width: 85px; object-fit: contain; opacity: 0.9;">
            </div>
        </div>

    </div>
</div>

<script>
  // 1. Inicializar Mercado Pago
  try {
    const mp = new MercadoPago("{{config('services.mercadopago.key')}}", {
      locale: 'es-AR'
    });

    mp.checkout({
      preference: {
        id: '{{$preference->id}}'
      },
      render: {
        container: '.cho-container',
        label: 'Pagar con Mercado Pago',
      }
    });
  } catch(e) {
    console.warn("Error inicializando MP:", e);
  }

  // 2. Inicializar Openpay (soporta carga bajo demanda si el script no estuviera)
  function setupPromoOpenPay() {
    try {
      OpenPay.setId("{{ config('services.openpay.merchant_id') }}");
      OpenPay.setApiKey("{{ config('services.openpay.public_key') }}");
      OpenPay.setSandboxMode({{ config('services.openpay.sandbox') ? 'true' : 'false' }});
      window.promoDeviceSessionId = OpenPay.deviceData.setup();
    } catch(err) {
      console.warn("OpenPay setup warning:", err);
    }
  }

  if (typeof OpenPay === 'undefined') {
    $.getScript('https://js.openpay.mx/openpay.v1.min.js', function() {
      $.getScript('https://js.openpay.mx/openpay-data.v1.min.js', function() {
        setupPromoOpenPay();
      });
    });
  } else {
    setupPromoOpenPay();
  }

  // 3. Alternar visualmente entre métodos de pago
  $(document).off('change', 'input[name="promo_metodo_pago"]').on('change', 'input[name="promo_metodo_pago"]', function() {
    if ($(this).val() === 'mercadopago') {
      $('#promo-card-mp').css({'border-color': '#009ee3', 'background-color': '#f7fbff'});
      $('#promo-card-openpay').css({'border-color': '#dcdcdc', 'background-color': '#ffffff'});
      $('#promo-mp-container').slideDown(200);
      $('#promo-openpay-container').slideUp(200);
    } else {
      $('#promo-card-openpay').css({'border-color': '#002f6c', 'background-color': '#f8faff'});
      $('#promo-card-mp').css({'border-color': '#dcdcdc', 'background-color': '#ffffff'});
      $('#promo-openpay-container').slideDown(250);
      $('#promo-mp-container').slideUp(200);
    }
  });

  // 4. Formateo y detección de tarjeta Openpay
  $(document).off('input', '#promo_openpay_card').on('input', '#promo_openpay_card', function() {
    var raw = $(this).val().replace(/\D/g, '');
    if (raw.length > 16) raw = raw.substring(0, 16);
    var formatted = raw.match(/.{1,4}/g)?.join(' ') || raw;
    $(this).val(formatted);

    try {
      var cardType = OpenPay.card.cardType(raw);
      if (cardType) {
        $('#promo_card_type').text(cardType.toUpperCase()).fadeIn();
      } else {
        $('#promo_card_type').text('').hide();
      }
    } catch(e) {}
  });

  $(document).off('input', '#promo_openpay_expiry').on('input', '#promo_openpay_expiry', function() {
    var val = $(this).val().replace(/\D/g, '');
    if (val.length > 4) val = val.substring(0, 4);
    if (val.length >= 3) {
      $(this).val(val.substring(0, 2) + ' / ' + val.substring(2));
    } else if (val.length === 2 && !$(this).data('deleting')) {
      $(this).val(val + ' / ');
    } else {
      $(this).val(val);
    }

    var m = val.substring(0, 2);
    var y = val.substring(2);
    $('#promo_openpay_exp_month').val(m);
    $('#promo_openpay_exp_year').val(y);
  });

  $(document).off('keydown', '#promo_openpay_expiry').on('keydown', '#promo_openpay_expiry', function(e) {
    if (e.key === 'Backspace') {
      $(this).data('deleting', true);
      var val = $(this).val();
      if (val.endsWith(' / ') || val.endsWith('/ ') || val.endsWith('/')) {
        e.preventDefault();
        var digits = val.replace(/\D/g, '');
        digits = digits.substring(0, digits.length - 1);
        $(this).val(digits);
        $('#promo_openpay_exp_month').val(digits.substring(0, 2));
        $('#promo_openpay_exp_year').val(digits.substring(2));
      }
    } else {
      $(this).data('deleting', false);
    }
  });

  $(document).off('input', '#promo_openpay_cvv').on('input', '#promo_openpay_cvv', function() {
    $(this).val($(this).val().replace(/\D/g, ''));
  });

  // 5. Procesar cargo con Tarjeta en Promociones
  $(document).off('click', '#btn-pagar-openpay-promo').on('click', '#btn-pagar-openpay-promo', function(e) {
    e.preventDefault();
    $('#promo-openpay-error').hide().text('');

    var holderName = $.trim($('#promo_openpay_holder').val());
    var rawCard = $('#promo_openpay_card').val().replace(/\s+/g, '');
    var expVal = $('#promo_openpay_expiry').val() || '';
    var expDigits = expVal.replace(/\D/g, '');
    var expMonth = expDigits.substring(0, 2);
    var expYear = expDigits.substring(2);
    var cvv = $.trim($('#promo_openpay_cvv').val());

    if (!holderName) {
      $('#promo-openpay-error').text('Por favor ingresa el nombre del titular de la tarjeta.').slideDown(150);
      $('#promo_openpay_holder').focus();
      return false;
    }

    if (!rawCard || !OpenPay.card.validateCardNumber(rawCard)) {
      $('#promo-openpay-error').text('El número de tarjeta no es válido. Verifica los dígitos.').slideDown(150);
      $('#promo_openpay_card').focus();
      return false;
    }

    if (!expMonth || !expYear || expMonth.length < 2 || expYear.length < 2 || !OpenPay.card.validateExpiry(expMonth, expYear)) {
      $('#promo-openpay-error').text('La fecha de vencimiento es inválida (MM / AA).').slideDown(150);
      $('#promo_openpay_expiry').focus();
      return false;
    }

    if (!cvv || !OpenPay.card.validateCVC(cvv, rawCard)) {
      $('#promo-openpay-error').text('El código de seguridad (CVV) es inválido.').slideDown(150);
      $('#promo_openpay_cvv').focus();
      return false;
    }

    var $btn = $(this);
    var origText = $btn.text();
    $btn.prop('disabled', true).text('PROCESANDO PAGO SEGURO...');

    var yearNormal = expYear.length === 4 ? expYear.substring(2) : expYear;

    OpenPay.token.create({
      "holder_name": holderName,
      "card_number": rawCard,
      "cvv2": cvv,
      "expiration_month": expMonth,
      "expiration_year": yearNormal
    }, function(response) {
      $.ajax({
        url: '{{ route("openpay_pagar_promo") }}',
        type: 'POST',
        dataType: 'json',
        data: {
          _token: '{{ csrf_token() }}',
          id_orden: '{{ $datos_orden->id_orden }}',
          token_id: response.data.id,
          device_session_id: window.promoDeviceSessionId || ''
        },
        success: function(res) {
          if (res.success && res.redirect_url) {
            console.log("¡Pago exitoso con Openpay!", res);
            $btn.css({'background': '#28a745', 'color': '#fff', 'box-shadow': '0 4px 10px rgba(40,167,69,0.3)'}).text('PAGO EXITOSO. REDIRIGIENDO...');
            window.location.href = res.redirect_url;
          } else {
            $btn.prop('disabled', false).text(origText);
            $('#promo-openpay-error').text(res.message || 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.').slideDown(150);
          }
        },
        error: function(xhr) {
          $btn.prop('disabled', false).text(origText);
          var msg = 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }
          $('#promo-openpay-error').text(msg).slideDown(150);
        }
      });
    }, function(response) {
      $btn.prop('disabled', false).text(origText);
      var msg = 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.';
      $('#promo-openpay-error').text(msg).slideDown(150);
    });
  });
</script>
