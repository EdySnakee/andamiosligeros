<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = "clientes";
    public $timestamps = false;
    protected $primaryKey = "idcl";
    protected $fillable = [
        'idcl',
        'nombrecl',
        'rfccl',
        'direccioncl',
        'cpcl',
        'lugarcl',
        'telefonocl',
        'celularcl',
        'emailcl',
        'comentarioscl'
    ];
    public static function postClienteWeb($data_post)
    {
        //dd($data_post->datos_factura);
        if (!empty($data_post->nombre_c)) {
            $objDataCliente = new Clientes();
            $objDataCliente->nombrecl = $data_post->nombre_c;
            $objDataCliente->direccioncl = $data_post->direccion_c;
            $objDataCliente->telefonocl = $data_post->numero_c;
            $objDataCliente->celularcl = $data_post->numero_c;
            $objDataCliente->emailcl = $data_post->email_c;
            $objDataCliente->comentarioscl = "CLIENTE REGISTRADO DESDE PÁGINA WEB";
            $objDataCliente->save();

            if ($data_post->iva == "si") {
                $objEmpresa = new Empresas();
                $objEmpresa->razon_social = $data_post->datos_factura->razon_social;
                $objEmpresa->rfc = $data_post->datos_factura->rfc;
                $objEmpresa->direccion_fiscal = $data_post->datos_factura->direccion_fiscal;
                $objEmpresa->estatus = 1;
                $objEmpresa->save();

                $datos_cliente_edit = $objDataCliente->find($objDataCliente->idcl);
                $datos_cliente_edit->id_empresa = $objEmpresa->id_empresa;
                $datos_cliente_edit->save();
            }

            return $objDataCliente;
        }
    }
    public static function validaCliente($data_post)
    {
        $datos_cliente = Clientes::where('celularcl', $data_post->numero_c)->first();
        if (!empty($datos_cliente)) {
            if ($data_post->iva == "si") {
                $objEmpresa = new Empresas();
                $objEmpresa->razon_social = $data_post->datos_factura->razon_social;
                $objEmpresa->rfc = $data_post->datos_factura->rfc;
                $objEmpresa->direccion_fiscal = $data_post->datos_factura->direccion_fiscal;
                $objEmpresa->estatus = 1;
                $objEmpresa->save();

                $datos_cliente_edit = $datos_cliente->find($datos_cliente->idcl);
                $datos_cliente_edit->id_empresa = $objEmpresa->id_empresa;
                $datos_cliente_edit->save();
            }
        }

        return $datos_cliente;
    }

    public static function postClienteTienda($data_post)
    {
        // $data_post es el objeto creado desde $request->all()
        if (!empty($data_post->nombre_c)) {

            // 1. Concatenar la dirección de envío desde los campos separados
            $direccion_envio = $data_post->direccion . ' ' . $data_post->cp . '. ' . $data_post->municipio . ', ' . $data_post->estado;

            $objDataCliente = new Clientes();
            $objDataCliente->nombrecl = $data_post->nombre_c;
            $objDataCliente->direccioncl = $direccion_envio; // <-- FIX 1: Usamos la dirección concatenada
            $objDataCliente->telefonocl = $data_post->telefono; // <-- FIX 2: Usamos 'telefono'
            $objDataCliente->celularcl = $data_post->telefono; // <-- FIX 3: Usamos 'telefono'
            $objDataCliente->emailcl = $data_post->email; // <-- FIX 4: Usamos 'email'

            // Usamos el operador '??' para asignar un valor por defecto si 'comentarios_adicionales' no existe
            $objDataCliente->comentarioscl = $data_post->comentarios_adicionales ?? "CLIENTE REGISTRADO AL COMPRAR EN TIENDA EN LINEA";
            $objDataCliente->save();

            // 2. Manejar datos de facturación (si existen)
            // Asumimos que los campos de factura vienen planos (no en un objeto 'datos_factura')
            if (!empty($data_post->iva) && $data_post->iva == "si") {

                // Debes asegurarte de tener un modelo 'Empresas' en 'App'
                // o ajustar esto si el namespace es diferente.
                $objEmpresa = new \App\Empresas();
                $objEmpresa->razon_social = $data_post->razon_social; // <-- FIX 5
                $objEmpresa->rfc = $data_post->rfc; // <-- FIX 6
                $objEmpresa->direccion_fiscal = $data_post->direccion_fiscal; // <-- FIX 7
                $objEmpresa->estatus = 1;
                $objEmpresa->save();

                $datos_cliente_edit = $objDataCliente->find($objDataCliente->idcl);
                $datos_cliente_edit->id_empresa = $objEmpresa->id_empresa;
                $datos_cliente_edit->save();
            }

            return $objDataCliente;
        }

        // Retornar null o un error si 'nombre_c' estaba vacío
        return null;
    }
}
