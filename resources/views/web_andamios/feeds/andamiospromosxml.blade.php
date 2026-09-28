
<?php 
use App\ItemFiles;
$titulo = "Promociones Andamios Ligeros";
$host = "andamiosligeros.com";
$descripcion = "Descubre las mejores ofertas del mercado, El mejor andamio de México, Andamio Galvanizado, 50% más ligero, misma resistencia. Ahorra tiempo y esfuerzo en el armado y traslado haciendo más fácil el trabajo.";


?>

<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	<channel>
	  <title><?php echo $titulo; ?></title>
	   <link>https://<?php echo $host; ?></link>
	   <description><![CDATA[<?php echo $descripcion; ?>]]></description>
		@foreach ($Ppromos as $item_promo)
			<?php 
            
            $categorias = 'Economía e industria > Equipo de protección para el trabajo';
            $customlabel = 'PromosAndamiosLigeros';

			?>
			<item>
				<g:id>AP{{$item_promo->id_promo}}</g:id>
				<g:title><![CDATA[<?php echo $item_promo->nombre_promo; ?>]]></g:title>
				<g:description><![CDATA[<?php echo $item_promo->descripcion; ?>]]></g:description>
				<g:google_product_category><![CDATA[<?php echo $categorias; ?>]]></g:google_product_category>
				<g:product_type><![CDATA[<?php echo $categorias; ?>]]></g:product_type>
				<g:link>{{ url('/promociones') }}/<?php echo $item_promo->url_promo; ?></g:link>
				<g:image_link>{{ url('web/prom') }}/<?php echo $item_promo->img_social; ?></g:image_link>

				<g:condition>new</g:condition>
				<g:availability>in_stock</g:availability>
				@if (!empty($item_promo->costo_desc) and $item_promo->costo_desc != 0.00)
				
				<g:price><?php echo number_format($item_promo->costo_desc, 2, '.', ''); ?> MXN</g:price>
				@else
				<g:price><?php echo number_format($item_promo->costo_item, 2, '.', ''); ?> MXN</g:price>
				@endif
				
				<g:brand>Andamios Ligeros</g:brand>
				<g:mpn>AL-<?php echo $item_promo->id_promo ;?></g:mpn>
				<g:custom_label_0><?php echo $customlabel; ?></g:custom_label_0>
				<g:shipping>
					<g:country>MEX</g:country>
					<g:price><?php echo $item_promo->envio ;?> MXN</g:price>
				</g:shipping>
		    </item>
		@endforeach
	</channel>
</rss>
