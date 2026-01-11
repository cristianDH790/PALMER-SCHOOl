<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;
use App\Entities\ParametroEntity;
use App\Entities\UsuarioEntity;

class MensajeCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param MensajeEntity|array $parametros
     * @return array
     */
    public static function transform($parametros): array
    {
        if ($parametros instanceof MensajeEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [MensajeTransformer::transform($parametros)];
        }

        if (is_array($parametros)) {
            return array_map(fn($u) => MensajeTransformer::transform($u), $parametros);
        }

        return [];
    }
}
