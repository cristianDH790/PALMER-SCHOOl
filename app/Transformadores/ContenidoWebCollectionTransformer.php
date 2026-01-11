<?php

namespace App\Transformadores;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Entities\ContenidoWebEntity;


class ContenidoWebCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param ContenidoWebEntity|array $parametros
     * @return array
     */
    public static function transform($contenidowebs): array
    {
        if ($contenidowebs instanceof ContenidoWebEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [ContenidoWebTransformer::transform($contenidowebs)];
        }

        if (is_array($contenidowebs)) {
            return array_map(fn($u) => ContenidoWebTransformer::transform($u), $contenidowebs);
        }

        return [];
    }
}
