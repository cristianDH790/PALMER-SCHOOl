<?php

namespace App\Transformadores;

use App\Entities\ParametroEntity;
use App\Entities\UsuarioEntity;

class ParametroCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param ParametroEntity|array $parametros
     * @return array
     */
    public static function transform($parametros): array
    {
        if ($parametros instanceof ParametroEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [ParametroTransformer::transform($parametros)];
        }

        if (is_array($parametros)) {
            return array_map(fn($u) => ParametroTransformer::transform($u), $parametros);
        }

        return [];
    }
}
