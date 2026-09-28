<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromocionesModel extends Model
{
    protected $table = "promociones";
    public $timestamps = false;
    protected $primaryKey = "id_promo";
    protected $fillable = [
        'id_promo',
        'nombre_promo',
        'nombre_product',
        'cantidad',
        'cant_min',
        'costo_item',
        'costo_desc',
        'envio',
		'img_barra_pago',
		'img_banner',
		'img_social',
		'meta_titulo',
        'descripcion',
		'url_promo',
        'date_post',
        'tipo_promo',
		'status',
        'orden',
        'destacado_modal'
    ];

    public function postPromocion($datos_producto)
    {
        $datosProducto = new PromocionesModel();
        $datosProducto->nombre_promo = $datos_producto["titulo_producto"];
        $datosProducto->nombre_product = $datos_producto["titulo_producto"];
        $datosProducto->cantidad = $datos_producto["cantidad"];
        $datosProducto->cant_min = (!empty($datos_producto["cant_min"]))?$datos_producto["cant_min"]: '';
        $datosProducto->costo_item = $datos_producto["costo_item"];
        $datosProducto->costo_desc = (!empty($datos_producto["costo_desc"]))?$datos_producto["costo_desc"]:'';
        $datosProducto->envio = $datos_producto["envio"];
        $datosProducto->meta_titulo = $datos_producto["ogtitle"];
        $datosProducto->descripcion = $datos_producto["descripcion_corta"];
        $datosProducto->url_promo = (!empty($datos_producto["url-producto"]))?$datos_producto["url-producto"]: '';
        $datosProducto->date_post = date('Y-m-d');
        $datosProducto->tipo_promo = (!empty($datos_producto["tipo_promo"]))?$datos_producto["tipo_promo"]:'';
        $datosProducto->status = 2; // Estatus 2 es para guardado como borrador
        $datosProducto->orden = 1; 
        $datosProducto->save();
        // <----->
 
        $id_product = $datosProducto->id_promo;
        return $id_product;
    }

    public function subeImagenes($data_imagen, $id_producto, $tipo_imagen)
    {
        $carpeta = public_path().'/web/prom';
        $url_carpeta = 'web/prom';

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        if (!empty($id_producto)) {
            $ruta = $carpeta;
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }
            $NombreOriginal ="";
            $filename = $data_imagen['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $valid_ext = array("png","jpeg","jpg","gif", "webp");
            //dd($ext);
            if(in_array($ext, $valid_ext)){
                $nombre_file = pathinfo($filename, PATHINFO_FILENAME);
                $objUtilidades = new Utilidades();
                $NombreOriginal = $id_producto."_".$objUtilidades->remplaza_caracteres_fotos($filename);
                $file_name = pathinfo($NombreOriginal, PATHINFO_FILENAME);
                $tmp_name = $data_imagen['tmp_name'];
                
                $file_destino = ProductosTienda::webpImage($tmp_name, $NombreOriginal, $ruta);
                
                $ruta_web_img =   $file_name . ".webp";
            }
            $file_ext = ".webp";
            $orden_item = 1;

            $objItemFiles = new ItemFiles();
            $return_id_file = $objItemFiles->postFile($id_producto, $ruta_web_img, $file_name, $file_ext, $tipo_imagen, $orden_item);
            
            $return_imgs = [
                'ruta_web_img' => $ruta_web_img,
                'file_name' => $file_name
            ];
            
            $data_imgs = json_decode(json_encode($return_imgs));
            //  dd($data_imgs);
            return $data_imgs;
            /*
            
            $collectionFiles = $objItemFiles->where('id_product',$id_producto)->where('id_item',$id_item)->where('tipo_baner', $tipo_baner)->first();
            if (!empty($collectionFiles)) {
                $return_id_file = $objItemFiles->editFile($id_item, $id_producto, $ruta_web_img, $file_name, $file_ext, $tipo_baner, $orden_item);
            }else{
                $return_id_file = $objItemFiles->postFile($id_item, $id_producto, $ruta_web_img, $file_name, $file_ext, $tipo_baner, $orden_item);
            }
            return $return_id_file;
            */
        }
    }

    public static function webpImage($tmp_name, $NombreOriginal, $ruta, $quality = 65, $removeOld = false)
    {
        $name = pathinfo($NombreOriginal, PATHINFO_FILENAME);
        $destino = $ruta . DIRECTORY_SEPARATOR . $name . '.webp';
        $info = getimagesize($tmp_name);
        $isAlpha = false;
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($tmp_name);
        elseif ($isAlpha = $info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($tmp_name);
        } elseif ($isAlpha = $info['mime'] == 'image/png') {
            $image = imagecreatefrompng($tmp_name);
        } else {
            return $tmp_name;
        }
        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        $resutl_webp = imagewebp($image, $destino, $quality);
        if ($removeOld)
            unlink($tmp_name);
        return $destino;
    }


    // editando
    public function editPromocion($datos_producto)
    {
        $datosProductoEdit = PromocionesModel::find($datos_producto["id_promo"]);
        $datosProductoEdit->nombre_promo = $datos_producto["titulo_producto"];
        $datosProductoEdit->nombre_product = $datos_producto["titulo_producto"];
        $datosProductoEdit->cantidad = $datos_producto["cantidad"];
        $datosProductoEdit->cant_min = (!empty($datos_producto["cant_min"]))?$datos_producto["cant_min"]: '';
        $datosProductoEdit->costo_item = $datos_producto["costo_item"];
        $datosProductoEdit->costo_desc = (!empty($datos_producto["costo_desc"]))?$datos_producto["costo_desc"]:'';
        $datosProductoEdit->envio = $datos_producto["envio"];
        $datosProductoEdit->meta_titulo = $datos_producto["ogtitle"];
        $datosProductoEdit->descripcion = $datos_producto["descripcion_corta"];
        $datosProductoEdit->url_promo = (!empty($datos_producto["url-producto"]))?$datos_producto["url-producto"]: '';
        $datosProductoEdit->date_post = date('Y-m-d');
        $datosProductoEdit->tipo_promo = (!empty($datos_producto["tipo_promo"]))?$datos_producto["tipo_promo"]:'';
        $datosProductoEdit->status = 2; // Estatus 2 es para guardado como borrador
        $datosProductoEdit->orden = 1; 
        $datosProductoEdit->save();
    }

}
