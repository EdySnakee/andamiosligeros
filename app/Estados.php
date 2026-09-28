<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table = "estados";
    public $timestamps = false;
    protected $primaryKey = "idestado";
    protected $fillable = [
      'estado'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipios::class, 'idestado');
    }
}
