<?php

namespace App\Transformadores;

use App\Entities\NivelEntity;
use App\Entities\NoticiaEntity;

class NivelCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param NivelEntity|array $parametros
     * @return array
     */
    public static function transform($niveles): array
    {
        if ($niveles instanceof NivelEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [NivelTransformer::transform($niveles)];
        }

        if (is_array($niveles)) {
            return array_map(fn($u) => NivelTransformer::transform($u), $niveles);
        }

        return [];
    }
}
