<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductosTiendaDetalle;
use App\ProductosTiendaMeta;
class ProductosTienda extends Model
{
    protected $table = "productos_tienda";
    public $timestamps = false;
    protected $primaryKey = "id_product";
    protected $fillable = [
        'id_product',
        'id_rel_p',
        'categoria',
        'tipo_cobro',
        'post_titulo',
        'post_autor',
        'post_fecha',
        'post_hora',
        'precio',
        'precio2',
        'descripcion_corta',
        'post_url',
        'post_estatus',
        'envio'
    ];

    public function postProductoTienda($datos_producto)
    {
        $datosProducto = new ProductosTienda();
        $datosProducto->id_rel_p = $datos_producto["id_product_ref"];
        $datosProducto->post_titulo = $datos_producto["titulo_producto"];
        $datosProducto->categoria = (!empty($datos_producto["cate_product"]))?$datos_producto["cate_product"]:'';
        $datosProducto->modelo = (!empty($datos_producto["modelo"]))?$datos_producto["modelo"]:'';
        $datosProducto->modelo_ref = (!empty($datos_producto["modelo_ref"]))?$datos_producto["modelo_ref"]:'';
        $datosProducto->tipo_cobro = (!empty($datos_producto["tipo_cobro"]))?$datos_producto["tipo_cobro"]:'';
        $datosProducto->post_autor = \Auth::User()->id;
        $datosProducto->post_fecha = date('Y-m-d');
        $datosProducto->post_hora = date('H:i:s');
        $datosProducto->descripcion_corta = $datos_producto["descripcion_corta"];
        $datosProducto->precio = $datos_producto["precio1"];
        $datosProducto->precio2 = $datos_producto["precio2"];
        $datosProducto->post_fecha = date('Y-m-d');
        $datosProducto->post_hora = date('H:i:s');
        $datosProducto->post_url = $datos_producto["url-producto-original"];
        $datosProducto->post_estatus = 2;// Estatus 2 es para guardado como borrador
        $datosProducto->envio = $datos_producto["envio"];
        $datosProducto->save();

        $id_product = $datosProducto->id_product;

        return $id_product;
    }
    public function postProductosTiendaDetalle($datos_producto, $id_product)
    {
        $datosProductoDet = new ProductosTiendaDetalle();
        $datosProductoDet->id_product = $id_product;
        $datosProductoDet->descripcion_producto = $datos_producto["descripcion_producto"];
        $datosProductoDet->caracteristicas_producto = $datos_producto["caracteristica_producto"];
        $datosProductoDet->extra_info_producto = $datos_producto["adicional_producto"];
        $datosProductoDet->alto = $datos_producto["alto"];
        $datosProductoDet->ancho = $datos_producto["ancho"];
        $datosProductoDet->profundidad = $datos_producto["profundidad"];
        $datosProductoDet->diametro = $datos_producto["diametro"];
        $datosProductoDet->peso_soportado = $datos_producto["peso_soportado"];
        $datosProductoDet->multiuso = $datos_producto["multiuso"];
        $datosProductoDet->imagen_portada = '';
        $datosProductoDet->save();
    }
    public function postProductosTiendaMeta($datos_producto, $id_product)
    {
        $datosProductoMeta = new ProductosTiendaMeta();
        $datosProductoMeta->id_product = $id_product;
        $datosProductoMeta->meta_title = $datos_producto["ogtitle"];
        $datosProductoMeta->meta_keywords = $datos_producto["keywords"];
        $datosProductoMeta->meta_descripcion = $datos_producto["ogdescripcion"];
        $datosProductoMeta->meta_url = $datos_producto["ogurl"];
        $datosProductoMeta->meta_canonical = $datos_producto["canonical"];
        $datosProductoMeta->meta_alt_imagen = $datos_producto["imagealt"];
        $datosProductoMeta->meta_url_imagen = '';
        $datosProductoMeta->save();
    }
    public function subeImagenes($data_imagen, $id_producto, $tipo_imagen)
    {
        $carpeta = public_path().'/storage/files';
        $url_carpeta = url("/").'/storage/files';

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
                
                $ruta_web_img = $url_carpeta . "/" . $file_name . ".webp";
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
            //dd($data_imgs);
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
    /****EDITANDO****/
    public function editProductoTienda($datos_producto)
    {
        //dd($datos_producto["id_product"]);
        $datosProductoEdit = ProductosTienda::find($datos_producto["id_product"]);
        $datosProductoEdit->post_titulo = $datos_producto["titulo_producto"];
        $datosProductoEdit->categoria = (!empty($datos_producto["cate_product"]))?$datos_producto["cate_product"]:'';
        $datosProductoEdit->modelo = (!empty($datos_producto["modelo"]))?$datos_producto["modelo"]:'';
        $datosProductoEdit->modelo_ref = (!empty($datos_producto["modelo_ref"]))?$datos_producto["modelo_ref"]:'';
        $datosProductoEdit->tipo_cobro = (!empty($datos_producto["tipo_cobro"]))?$datos_producto["tipo_cobro"]:'';
        $datosProductoEdit->descripcion_corta = $datos_producto["descripcion_corta"];
        $datosProductoEdit->precio = $datos_producto["precio1"];
        $datosProductoEdit->precio2 = $datos_producto["precio2"];
        $datosProductoEdit->post_url = $datos_producto["url-producto-original"];
        $datosProductoEdit->envio = $datos_producto["envio"];
        $datosProductoEdit->save();
    }
    public function editProductosTiendaDetalle($datos_producto)
    {
        //dd($datos_producto["alto"]);
        $datosProductoDetEdit = ProductosTiendaDetalle::where('id_product', $datos_producto["id_product"])->first();
        $datosProductoDetEdit->descripcion_producto = $datos_producto["descripcion_producto"];
        $datosProductoDetEdit->caracteristicas_producto = $datos_producto["caracteristica_producto"];
        $datosProductoDetEdit->extra_info_producto = $datos_producto["adicional_producto"];
        $datosProductoDetEdit->alto = $datos_producto["alto"];
        $datosProductoDetEdit->ancho = $datos_producto["ancho"];
        $datosProductoDetEdit->profundidad = $datos_producto["profundidad"];
        $datosProductoDetEdit->diametro = $datos_producto["diametro"];
        $datosProductoDetEdit->peso_soportado = $datos_producto["peso_soportado"];
        $datosProductoDetEdit->multiuso = $datos_producto["multiuso"];
        $datosProductoDetEdit->save();
    }
    public function editProductosTiendaMeta($datos_producto)
    {
        $datosProductoMetaEdit = ProductosTiendaMeta::where('id_product', $datos_producto["id_product"])->first();
        $datosProductoMetaEdit->meta_title = $datos_producto["ogtitle"];
        $datosProductoMetaEdit->meta_keywords = $datos_producto["keywords"];
        $datosProductoMetaEdit->meta_descripcion = $datos_producto["ogdescripcion"];
        $datosProductoMetaEdit->meta_url = $datos_producto["ogurl"];
        $datosProductoMetaEdit->meta_canonical = $datos_producto["canonical"];
        $datosProductoMetaEdit->meta_alt_imagen = $datos_producto["imagealt"];
        $datosProductoMetaEdit->save();
    }
    
    public function subeImagenesGalerias($imagenes, $id_producto, $num_index, $orden, $tipo_imagen)
    {       
        if (!empty($imagenes)) {
            $carpeta = public_path().'/storage/files';
            $url_carpeta = url("/").'/storage/files';

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            if (!empty($id_producto)) {
                $ruta = $carpeta;
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
                $NombreOriginal ="";
                $filename = $imagenes['name'][$num_index];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $valid_ext = array("png","jpeg","jpg","gif", "webp");

                if(in_array($ext, $valid_ext)){
                    $nombre_file = pathinfo($filename, PATHINFO_FILENAME);
                    $objUtilidades = new Utilidades();
                    $NombreOriginal = $id_producto."_".$objUtilidades->remplaza_caracteres_fotos($filename);
                    $file_name = pathinfo($NombreOriginal, PATHINFO_FILENAME);
                    $tmp_name = $imagenes['tmp_name'][$num_index];
                    $file_destino = ProductosTienda::webpImage($tmp_name, $NombreOriginal, $ruta);
                    $ruta_web_img = $url_carpeta . "/" . $file_name . ".webp";
                }
                $file_ext = ".webp";
                $objItemFiles = new ItemFiles();
                $return_id_file = $objItemFiles->postFile($id_producto, $ruta_web_img, $file_name, $file_ext, $tipo_imagen, $orden);
                return $return_id_file;
            }
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
}
