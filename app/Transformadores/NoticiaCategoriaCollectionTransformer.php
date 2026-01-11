<?php

namespace App\Transformadores;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Entities\ContenidoWebEntity;
use App\Entities\NoticiaCategoriaEntity;

class NoticiaCategoriaCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param NoticiaCategoriaEntity|array $parametros
     * @return array
     */
    public static function transform($noticiacategorias): array
    {
        if ($noticiacategorias instanceof NoticiaCategoriaEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [NoticiaCategoriaTransformer::transform($noticiacategorias)];
        }

        if (is_array($noticiacategorias)) {
            return array_map(fn($u) => NoticiaCategoriaTransformer::transform($u), $noticiacategorias);
        }

        return [];
    }
}
