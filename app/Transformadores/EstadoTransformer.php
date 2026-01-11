<?php

namespace App\Transformadores;

use App\Entities\EstadoEntity;
use App\Models\ClaseModel;

class EstadoTransformer
{
    public static function transform(EstadoEntity $estado)
    {
        return [
            'idEstado' => (int)$estado->idestado,
            'nombre' => $estado->nombre,
            'descripcion' => $estado->descripcion,
            // Llama al modelo aquí para traer la clase relacionada
            'clase' => $estado->idclase
                ? ClaseTransformer::transform((new ClaseModel())->obtenerPorId($estado->idclase))
                : null,
        ];
    }
}
