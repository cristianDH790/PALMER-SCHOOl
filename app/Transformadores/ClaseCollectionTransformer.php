<?php

namespace App\Transformadores;

use App\Entities\ClaseEntity;
use App\Entities\ConfiguracionEntity;
use App\Entities\EstadoEntity;


class ClaseCollectionTransformer
{
    /**
     * Transforma uno o varios usuarios en un array uniforme
     *
     * @param ClaseEntity|array $usuarios
     * @return array
     */
    public static function transform($clases): array
    {
        if ($clases instanceof ClaseEntity) {
            // Si es un solo usuario, lo envolvemos en array
            return [ClaseTransformer::transform($clases)];
        }

        if (is_array($clases)) {
            return array_map(fn($u) => ClaseTransformer::transform($u), $clases);
        }

        return [];
    }
}
