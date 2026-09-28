<?php

namespace App;

class Utilidades
{
	public function remplaza_caracteres($string){
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                 " "),
            '-',
            $string
        );
        return $string;
    }
    public function remplaza_caracteres_fotos($string)
    {
        $string = trim($string);
         $string = str_replace(
             array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
             array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
             $string
         );
         $string = str_replace(
             array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
             array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
             $string
         );
         $string = str_replace(
             array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
             array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
             $string
         );

         $string = str_replace(
             array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
             array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
             $string
         );
         $string = str_replace(
             array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
             array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
             $string
         );
         $string = str_replace(
             array('ñ', 'Ñ', 'ç', 'Ç'),
             array('n', 'N', 'c', 'C',),
             $string
         );
         //Esta parte se encarga de eliminar cualquier caracter extraño
         $string = str_replace(
             array("\\", "¨", "º", " ", "~",
                  "#", "@", "|", "!", "\"",
                  "·", "$", "%", "&", "/",
                  "(", ")", "?", "'", "¡",
                  "¿", "[", "^", "`", "]",
                  "+", "}", "{", "¨", "´",
                  ">", "< ", ";", ",", ":",
                  " ", "=", "*", "~","°"),
             '_',
             $string
         );
         return $string;
    }
    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

    public function envia_Correos($correo_asesor, $titulo, $mensaje, $mail){

        $mail->ClearAddresses();
        $mail->Subject = $titulo;
        $mail->Username = "no-reply@andamiosligeros.com";
        $mail->Password = "?wj~M)szh+]H";
        $mail->Host = "mail.andamiosligeros.com";
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPAuth = true;
        $mail->IsHTML(true);
        $mail->From = $mail->Username;
        $mail->AddAddress($correo_asesor);
        $mail->Body = $mensaje;  
        if(!$mail->Send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
           return "correcto" . $mail->ErrorInfo;
        }
        $mail->ClearAddresses();

    }
    public static function fecha(){
        $dia=date("w");
        $day=date("d");
        $mes=date("m");
        switch ($dia) {
            case 0:
            $dia ="Domingo";
            break;

          case 1:
          $dia = "Lunes";
            break;
            case 2:
          $dia ="Martes";

                  break;

          case 3:
          $dia ="Miércoles";

                  break;
          case 4:
            $dia ="Jueves";
            break;
          case 5:
          $dia ="Viernes";
            break;
          case 6:
          $dia ="Sábado";
            break;

        }
        switch ($mes){
            case '01':
            $mes="Enero";
            break;
            case '02':
            $mes="Febrero";
            break;
            case '03':
            $mes="Marzo";
            break;
            case '04':
            $mes="Abril";
            break;
            case '05':
            $mes="Mayo";
            break;
            case '06':
            $mes="Junio";
            break;
            case '07':
            $mes="Julio";
            break;
            case '08':
            $mes="Agosto";
            break;
            case '09':
            $mes="Septiembre";
            break;
            case '10':
            $mes="Octubre";
            break;
            case '11':
            $mes="Noviembre";
            break;
            case '12':
            $mes="Diciembre";
            break;
        }
        $fecha="$dia ".$day." de ".$mes." de ".date("Y");
        return $fecha; 
    }

    public static function remplaza_caracteres_web($string){
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "·", "$", "%", "&", "/",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ".", ":",
                 " "),
            ' ',
            $string
        );
        return $string;
    }

    /**
     * Comprueba si un nombre de archivo o ruta corresponde a un formato HEIC/HEIF
     */
    public static function isHeic($filename)
    {
        if (empty($filename)) {
            return false;
        }
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, ['heic', 'heif']);
    }

    /**
     * Convierte y optimiza imágenes HEIC/HEIF a formato WebP (máximo 1920px de ancho y calidad 80%)
     */
    public static function convertHeicToWebp($sourcePath, $destinationWebpPath, $maxWidth = 1920, $quality = 80)
    {
        $tmpJpeg = sys_get_temp_dir() . '/' . uniqid('heic_') . '.jpg';

        // 1. Intentar con Imagick (si está disponible y soporta HEIC)
        if (extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick();
                $imagick->readImage($sourcePath);
                $w = $imagick->getImageWidth();
                $h = $imagick->getImageHeight();
                if ($w > $maxWidth) {
                    $newH = (int) round(($h * $maxWidth) / $w);
                    $imagick->resizeImage($maxWidth, $newH, \Imagick::FILTER_LANCZOS, 1);
                }
                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality($quality);
                $imagick->writeImage($destinationWebpPath);
                $imagick->clear();
                $imagick->destroy();
                if (file_exists($destinationWebpPath) && filesize($destinationWebpPath) > 0) {
                    return true;
                }
            } catch (\Exception $e) {
                // Continuar a otros métodos si falla Imagick
            }
        }

        // 2. Intentar con sips (macOS nativo)
        if (file_exists('/usr/bin/sips')) {
            exec('/usr/bin/sips -s format jpeg ' . escapeshellarg($sourcePath) . ' --out ' . escapeshellarg($tmpJpeg) . ' 2>/dev/null', $out, $ret);
            if ($ret === 0 && file_exists($tmpJpeg)) {
                $img = @imagecreatefromjpeg($tmpJpeg);
                @unlink($tmpJpeg);
                if ($img) {
                    $w = imagesx($img);
                    $h = imagesy($img);
                    if ($w > $maxWidth) {
                        $newH = (int) round(($h * $maxWidth) / $w);
                        $resized = imagecreatetruecolor($maxWidth, $newH);
                        imagecopyresampled($resized, $img, 0, 0, 0, 0, $maxWidth, $newH, $w, $h);
                        imagedestroy($img);
                        $img = $resized;
                    }
                    $res = @imagewebp($img, $destinationWebpPath, $quality);
                    imagedestroy($img);
                    if ($res && file_exists($destinationWebpPath) && filesize($destinationWebpPath) > 0) {
                        return true;
                    }
                }
            }
        }

        // 3. Intentar con heif-convert (Linux / cPanel)
        if (function_exists('exec')) {
            exec('which heif-convert 2>/dev/null', $whichOut, $whichRet);
            if ($whichRet === 0) {
                exec('heif-convert ' . escapeshellarg($sourcePath) . ' ' . escapeshellarg($tmpJpeg) . ' 2>/dev/null', $out, $ret);
                if ($ret === 0 && file_exists($tmpJpeg)) {
                    $img = @imagecreatefromjpeg($tmpJpeg);
                    @unlink($tmpJpeg);
                    if ($img) {
                        $w = imagesx($img);
                        $h = imagesy($img);
                        if ($w > $maxWidth) {
                            $newH = (int) round(($h * $maxWidth) / $w);
                            $resized = imagecreatetruecolor($maxWidth, $newH);
                            imagecopyresampled($resized, $img, 0, 0, 0, 0, $maxWidth, $newH, $w, $h);
                            imagedestroy($img);
                            $img = $resized;
                        }
                        $res = @imagewebp($img, $destinationWebpPath, $quality);
                        imagedestroy($img);
                        if ($res && file_exists($destinationWebpPath) && filesize($destinationWebpPath) > 0) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Procesa una imagen subida: si es HEIC la convierte a WebP; de lo contrario la mueve a su destino.
     * Retorna el nombre final del archivo guardado, o null si falla.
     */
    public static function guardarImagenOptimizada($tmpName, $originalName, $destinationDir, $prefix = '')
    {
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }

        $cleanName = (new self())->remplaza_caracteres_fotos($originalName);
        $finalName = (!empty($prefix) ? $prefix . '_' : '') . $cleanName;

        if (self::isHeic($originalName) || self::isHeic($finalName)) {
            $baseName = pathinfo($finalName, PATHINFO_FILENAME);
            $finalName = $baseName . '.webp';
            $destPath = rtrim($destinationDir, '/') . '/' . $finalName;
            $converted = self::convertHeicToWebp($tmpName, $destPath);
            if ($converted) {
                return $finalName;
            }
        }

        // Si no es HEIC o falló la conversión HEIC, mover archivo estándar
        $destPath = rtrim($destinationDir, '/') . '/' . $finalName;
        if (@move_uploaded_file($tmpName, $destPath)) {
            return $finalName;
        }

        return null;
    }

    /**
     * Retorna una imagen en Base64 convirtiendo WebP a JPEG si es necesario,
     * para asegurar compatibilidad total con DomPDF.
     * Soporta rutas relativas a public_path() o URLs completas.
     *
     * @param string $ruta_relativa_public Ruta relativa desde public_path() (ej: /storage/...) o URL
     * @return string Data URI en base64 o string vacío si no existe/falla
     */
    public static function obtenerImagenBase64($ruta_relativa_public)
    {
        if (empty($ruta_relativa_public)) {
            return "";
        }

        // Si viene como URL completa (http://...), extraer la ruta interna
        if (strpos($ruta_relativa_public, 'http://') === 0 || strpos($ruta_relativa_public, 'https://') === 0) {
            $parsed = parse_url($ruta_relativa_public, PHP_URL_PATH);
            $ruta_relativa_public = $parsed ?: $ruta_relativa_public;
        }

        $path = public_path() . '/' . ltrim($ruta_relativa_public, '/');

        if (!file_exists($path)) {
            return "";
        }

        try {
            $data = @file_get_contents($path);
            if (!$data) {
                return "";
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            // Si es WebP, DomPDF no lo soporta directamente; lo convertimos a JPEG con GD
            if ($ext === 'webp' && extension_loaded('gd')) {
                $srcImg = @imagecreatefromstring($data);
                if ($srcImg !== false) {
                    $w = imagesx($srcImg);
                    $h = imagesy($srcImg);

                    if ($w > 0 && $h > 0) {
                        $dstImg = imagecreatetruecolor($w, $h);
                        $white = imagecolorallocate($dstImg, 255, 255, 255);
                        imagefilledrectangle($dstImg, 0, 0, $w, $h, $white);
                        imagecopy($dstImg, $srcImg, 0, 0, 0, 0, $w, $h);

                        ob_start();
                        imagejpeg($dstImg, null, 90);
                        $convertedData = ob_get_clean();

                        if (PHP_VERSION_ID < 80000) {
                            @imagedestroy($srcImg);
                            @imagedestroy($dstImg);
                        }

                        return 'data:image/jpeg;base64,' . base64_encode($convertedData);
                    }
                }
            }

            return 'data:image/' . ($ext === 'jpg' ? 'jpeg' : $ext) . ';base64,' . base64_encode($data);
        } catch (\Exception $e) {
            return "";
        }
    }

    /**
     * Retorna el banner para la cotización en Base64.
     * Si la imagen es horizontal (estándar ~4:1 o un poco más alta ~2:1), mantiene sus dimensiones completas
     * a ancho total (100% del contenedor), sin bordes blancos laterales ni deformaciones.
     * Sólo si la altura resultante a ancho completo excedería el espacio vertical disponible de la página ($maxHeightPt),
     * se recorta proporcionalmente (cover centrado) para garantizar que no desborde la página del PDF.
     * También convierte WebP y PNG con transparencia a JPEG sobre fondo blanco para compatibilidad con DomPDF.
     *
     * @param string $ruta_relativa_public Ruta relativa desde public_path() o URL
     * @param float|int $maxHeightPt Altura máxima permitida en puntos antes de recortar (default: 320)
     * @param float|int $pageWidthPt Ancho útil de la página en puntos (default: 540)
     * @return string Data URI en base64 o string vacío si no existe
     */
    public static function obtenerBannerCotizacionBase64($ruta_relativa_public, $maxHeightPt = 320, $pageWidthPt = 540)
    {
        if (empty($ruta_relativa_public)) {
            return "";
        }

        if (strpos($ruta_relativa_public, 'http://') === 0 || strpos($ruta_relativa_public, 'https://') === 0) {
            $parsed = parse_url($ruta_relativa_public, PHP_URL_PATH);
            $ruta_relativa_public = $parsed ?: $ruta_relativa_public;
        }

        $path = public_path() . '/' . ltrim($ruta_relativa_public, '/');
        if (!file_exists($path)) {
            return "";
        }

        try {
            $data = @file_get_contents($path);
            if (!$data) {
                return "";
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if (extension_loaded('gd')) {
                $srcImg = @imagecreatefromstring($data);
                if ($srcImg !== false) {
                    $srcW = imagesx($srcImg);
                    $srcH = imagesy($srcImg);

                    if ($srcW > 0 && $srcH > 0) {
                        // Altura que ocuparía en la página al 100% de ancho
                        $naturalHeightPt = $pageWidthPt * ($srcH / $srcW);

                        // Si la altura natural no excede el límite seguro de la página,
                        // no recortamos: se conserva completo y a ancho total
                        if ($naturalHeightPt <= $maxHeightPt) {
                            if ($ext === 'jpg' || $ext === 'jpeg') {
                                if (PHP_VERSION_ID < 80000) { @imagedestroy($srcImg); }
                                return 'data:image/jpeg;base64,' . base64_encode($data);
                            }

                            // Si es WebP o PNG, convertir a JPEG sobre fondo blanco para DomPDF
                            $dstImg = imagecreatetruecolor($srcW, $srcH);
                            $white = imagecolorallocate($dstImg, 255, 255, 255);
                            imagefilledrectangle($dstImg, 0, 0, $srcW, $srcH, $white);
                            imagecopy($dstImg, $srcImg, 0, 0, 0, 0, $srcW, $srcH);

                            ob_start();
                            imagejpeg($dstImg, null, 90);
                            $convertedData = ob_get_clean();

                            if (PHP_VERSION_ID < 80000) {
                                @imagedestroy($srcImg);
                                @imagedestroy($dstImg);
                            }
                            return 'data:image/jpeg;base64,' . base64_encode($convertedData);
                        }

                        // Si excede el tamaño seguro de la página, recortar con cover centrado
                        // al alto máximo permitido para evitar desbordar la página del PDF
                        $targetRatio = $pageWidthPt / $maxHeightPt;
                        $srcRatio = $srcW / $srcH;

                        $targetW = min(1200, max(750, $srcW));
                        $targetH = (int)round($targetW / $targetRatio);

                        $dstImg = imagecreatetruecolor($targetW, $targetH);
                        $white = imagecolorallocate($dstImg, 255, 255, 255);
                        imagefilledrectangle($dstImg, 0, 0, $targetW, $targetH, $white);

                        if ($srcRatio > $targetRatio) {
                            $cropH = $srcH;
                            $cropW = (int)round($srcH * $targetRatio);
                            $srcX = (int)round(($srcW - $cropW) / 2);
                            $srcY = 0;
                        } else {
                            $cropW = $srcW;
                            $cropH = (int)round($srcW / $targetRatio);
                            $srcX = 0;
                            $srcY = (int)round(($srcH - $cropH) / 2);
                        }

                        imagecopyresampled($dstImg, $srcImg, 0, 0, $srcX, $srcY, $targetW, $targetH, $cropW, $cropH);

                        ob_start();
                        imagejpeg($dstImg, null, 88);
                        $croppedData = ob_get_clean();

                        if (PHP_VERSION_ID < 80000) {
                            @imagedestroy($srcImg);
                            @imagedestroy($dstImg);
                        }

                        return 'data:image/jpeg;base64,' . base64_encode($croppedData);
                    }
                }
            }

            return 'data:image/' . ($ext === 'jpg' ? 'jpeg' : $ext) . ';base64,' . base64_encode($data);
        } catch (\Exception $e) {
            return "";
        }
    }

    /**
     * Alias compatible de banner para código existente.
     */
    public static function obtenerImagenCoverBase64($ruta_relativa_public, $targetW = 750, $targetH = 140)
    {
        return self::obtenerBannerCotizacionBase64($ruta_relativa_public);
    }
}

