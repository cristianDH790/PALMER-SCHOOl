<?php

namespace App\Transformadores;

use App\Entities\TipoEntity;
use App\Models\ClaseModel;
use App\Models\EstadoModel;

class TipoTransformer
{
    public static function transform(TipoEntity $tipo)
    {
        return [
            'idTipo' => (int)$tipo->idtipo,
            'nombre' => $tipo->nombre,
            'descripcion' => $tipo->descripcion,

            'clase' => $tipo->idclase
                ? ClaseTransformer::transform((new ClaseModel())->obtenerPorId($tipo->idclase))
                : null,
            'estado' => $tipo->idestado
                ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($tipo->idestado))
                : null,
        ];
    }
}
