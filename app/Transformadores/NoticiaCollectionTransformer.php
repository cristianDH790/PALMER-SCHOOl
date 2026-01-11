<?php

namespace App\Transformadores;

use App\Entities\NoticiaEntity;

class NoticiaCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param NoticiaEntity|array $parametros
     * @return array
     */
    public static function transform($noticias): array
    {
        if ($noticias instanceof NoticiaEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [NoticiaTransformer::transform($noticias)];
        }

        if (is_array($noticias)) {
            return array_map(fn($u) => NoticiaTransformer::transform($u), $noticias);
        }

        return [];
    }
}
