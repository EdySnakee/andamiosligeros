<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class GiroEmpresas extends Model
{
    protected $table = "giro_empresas";
    public $timestamps = false;
    protected $primaryKey = "id_giro";
    protected $fillable = [
        'id_giro',
        'cod_giro',
        'nombre_empresa',
		'status'
    ];

    public function selectGiroEmpresas()
    {
    	$objUsuarios = new User();
    	$usuarios_permisos = $objUsuarios
                            ->select("us.id", "us.email", "pnu.id_permiso", "ctp.titulo", "ctp.codigo")
                            ->from("users as us")
                            ->join("permisos_nivel_usr as pnu", "us.id", "=", "pnu.usuario")
                            ->join("cat_tipo_permisos as ctp", "ctp.id_permiso_modulo", "=", "pnu.id_permiso")
                            ->where("us.id", \Auth::user()->id)
                            ->get();

        foreach ($usuarios_permisos as $item_up) {
            $array_usuarios[] = $item_up->codigo;
        }

        $arr1 = (!empty($array_usuarios[0])) ? $array_usuarios[0] : '';
        $arr2 = (!empty($array_usuarios[1])) ? $array_usuarios[1] : '';
        $arr3 = (!empty($array_usuarios[2])) ? $array_usuarios[2] : '';
        $arr4 = (!empty($array_usuarios[3])) ? $array_usuarios[3] : '';

        $result_giros = GiroEmpresas::whereIn("cod_giro", [$arr1, $arr2, $arr3, $arr4])->where("status", 1)->get();

        return $result_giros;
    }

}
