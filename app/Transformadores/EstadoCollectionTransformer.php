<?php

namespace App\Transformadores;

use App\Entities\EstadoEntity;


class EstadoCollectionTransformer
{
    /**
     * Transforma uno o varios usuarios en un array uniforme
     *
     * @param EstadoEntity|array $usuarios
     * @return array
     */
    public static function transform($estados): array
    {
        if ($estados instanceof EstadoEntity) {
            // Si es un solo usuario, lo envolvemos en array
            return [EstadoTransformer::transform($estados)];
        }

        if (is_array($estados)) {
            return array_map(fn($u) => EstadoTransformer::transform($u), $estados);
        }

        return [];
    }
}
