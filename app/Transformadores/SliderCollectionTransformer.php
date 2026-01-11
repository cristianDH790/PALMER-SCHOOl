<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;
use App\Entities\ParametroEntity;
use App\Entities\SliderEntity;
use App\Entities\UsuarioEntity;

class SliderCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param SliderEntity|array $parametros
     * @return array
     */
    public static function transform($sliders): array
    {
        if ($sliders instanceof SliderEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [SliderTransformer::transform($sliders)];
        }

        if (is_array($sliders)) {
            return array_map(fn($u) => SliderTransformer::transform($u), $sliders);
        }

        return [];
    }
}
