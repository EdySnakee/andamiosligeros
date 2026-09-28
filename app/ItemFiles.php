<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFiles extends Model
{
    protected $table = "files";
    public $timestamps = false;
    protected $primaryKey = "id_file";
    protected $fillable = [
        'id_file',
        'id_product',
        'file_url',
        'file_alt',
        'file_ext',
        'file_ext',
        'file_tipo',
        'orden'
    ];

    public function postFile($id_product, $file_destino, $nombre_file, $file_ext, $tipo_imagen, $orden_item)
    {
        $guardaFiles = new ItemFiles();
        $guardaFiles->id_product = (!empty($id_product) ? $id_product : '');
        $guardaFiles->file_url = (!empty($file_destino) ? $file_destino : '');
        $guardaFiles->file_alt = (!empty($nombre_file) ? $nombre_file : '');
        $guardaFiles->file_ext = (!empty($file_ext) ? $file_ext : '');
        $guardaFiles->file_tipo = (!empty($tipo_imagen) ? $tipo_imagen : '');
        $guardaFiles->orden = (!empty($orden_item) ? $orden_item : 1);
        $guardaFiles->save();

        $id_file = $guardaFiles->id_file;
        return $id_file;
    }
}
