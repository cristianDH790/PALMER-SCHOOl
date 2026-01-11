<?php

namespace App\Transformadores;

use App\Entities\ParametroEntity;
use App\Models\EstadoModel;
use App\Models\TipoModel;

class ParametroTransformer
{
    public static function transform(ParametroEntity $parametro)
    {
        return [
            'idParametro' => (int) $parametro->idparametro,
            'nombre' => $parametro->nombre,
            'descripcion' => $parametro->descripcion,
            'tipo' => $parametro->idtipo ? TipoTransformer::transform((new TipoModel())->obtenerPorId($parametro->idtipo)) : null,
            'estado' => $parametro->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($parametro->idestado)) : null,
        ];
    }
}
