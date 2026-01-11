<?php

namespace App\Transformadores;

use App\Entities\PerfilEntity;
use App\Models\EstadoModel;

class PerfilTransformer
{
    public static function transform(PerfilEntity $perfil)
    {
        return [
            'idPerfil' => (int)$perfil->idperfil,
            'nombre' => $perfil->nombre,
            'estado' => $perfil->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($perfil->idestado)) : null,

            'descripcion' => $perfil->descripcion,
        ];
    }
}
