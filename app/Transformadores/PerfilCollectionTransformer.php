<?php

namespace App\Transformadores;

use App\Entities\EstadoEntity;
use App\Entities\PerfilEntity;

class PerfilCollectionTransformer
{
    /**
     * Transforma uno o varios usuarios en un array uniforme
     *
     * @param PerfilEntity|array $usuarios
     * @return array
     */
    public static function transform($perfiles): array
    {
        if ($perfiles instanceof PerfilEntity) {
            // Si es un solo usuario, lo envolvemos en array
            return [PerfilTransformer::transform($perfiles)];
        }

        if (is_array($perfiles)) {
            return array_map(fn($u) => PerfilTransformer::transform($u), $perfiles);
        }

        return [];
    }
}
