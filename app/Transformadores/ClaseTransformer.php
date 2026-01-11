<?php

namespace App\Transformadores;

use App\Entities\ClaseEntity;


class ClaseTransformer
{
    public static function transform(ClaseEntity $clase)
    {
        return [
            'idClase' => $clase->idclase,
            'nombre' => $clase->nombre,
            'descripcion' => $clase->descripcion,
        ];
    }
}
