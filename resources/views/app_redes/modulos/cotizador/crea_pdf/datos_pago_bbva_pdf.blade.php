<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: {{ $bbva_td_width ?? '76px' }}; vertical-align: middle; padding: 0;">
            @if(!empty($logo_bbva))
                <img src="{{ $logo_bbva }}" alt="BBVA" style="width: {{ $bbva_img_width ?? '68px' }}; display: block;">
            @endif
        </td>
        <td style="vertical-align: middle; padding: 0 0 0 8px;">
            <div style="font-family: sans-serif; color: #333; line-height: 1.35;">
                <div style="font-size: {{ $tit_font_size ?? '10.5px' }}; font-weight: bold; color: #222; margin-bottom: 3px; text-transform: uppercase;">
                    REDES ANTICAÍDAS
                </div>
                <div style="font-size: {{ $txt_font_size ?? '8.8px' }}; color: #333; margin-bottom: 2px;">
                    <b>CUENTA:</b> <span style="font-weight: bold;">012 059 1289</span>
                </div>
                <div style="font-size: {{ $txt_font_size ?? '8.8px' }}; color: #444;">
                    <b>CLABE:</b> <span style="font-weight: bold;">012 91000120591289 2</span>
                </div>
            </div>
        </td>
    </tr>
</table>

