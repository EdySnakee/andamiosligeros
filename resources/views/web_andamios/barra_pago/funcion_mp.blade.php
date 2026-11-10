@php
    $clienteNombre = !empty($datos_cliente->nombrecl) ? strtoupper($datos_cliente->nombrecl) : '';
@endphp

<div class="info-btn-pagos" style="margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px; width: 100%;">
    <p style="font-weight: 700; font-size: 15px; color: #232323; margin-bottom: 12px; text-align: left;">
        Método de pago:
    </p>

    <input type="hidden" name="promo_metodo_pago" value="openpay">

    <!-- Contenedor de pago Openpay BBVA -->
    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">

        <!-- Opción Openpay BBVA -->
        <div class="metodo-pago-promo-card active" id="promo-card-openpay" style="display: flex; align-items: center; justify-content: space-between; border: 1.5px solid #002f6c; border-bottom: none; background-color: #f8faff; border-radius: 8px 8px 0 0; padding: 12px 14px; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="text-align: left;">
                    <span style="display: block; font-weight: 700; font-size: 14px; color: #002f6c;">
                        Tarjeta de Crédito / Débito <span style="font-size: 11px; font-weight: 600; color: #004481; background: #e8f0fe; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Openpay BBVA</span>
                    </span>
                    <small style="display: block; color: #666; font-size: 11px;">Pago directo y seguro sin salir de la página</small>
                </div>
            </div>
            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 24px; max-width: 105px; object-fit: contain;">
        </div>

        <!-- Formulario Tarjeta Openpay Embebido -->
        <div id="promo-openpay-container" style="display: block; background: #fdfefe; border: 1.5px solid #002f6c; border-top: none; border-radius: 0 0 8px 8px; padding: 16px; margin-top: -11px; margin-bottom: 8px; box-shadow: 0 4px 12px rgba(0,47,108,0.06); text-align: left;">
            
            <div style="margin-bottom: 12px;">
                <label for="promo_openpay_holder" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">Nombre del titular como aparece en la tarjeta *</label>
                <input class="form-control-cart" type="text" id="promo_openpay_holder" value="{{ $clienteNombre }}" placeholder="Como aparece en la tarjeta" style="margin-bottom: 0; background: #fff; width: 100%; border: 1px solid #dadada; border-radius: 8px; padding: 8px 12px; font-size: 14px;">
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
  // Inicializar Openpay (soporta carga bajo demanda si el script no estuviera)
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

  // Formateo y detección de tarjeta Openpay
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
