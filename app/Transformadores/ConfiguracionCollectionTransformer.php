<?php

namespace App\Transformadores;

use App\Entities\ConfiguracionEntity;
use App\Entities\EstadoEntity;


class ConfiguracionCollectionTransformer
{
    /**
     * Transforma uno o varios usuarios en un array uniforme
     *
     * @param ConfiguracionEntity|array $usuarios
     * @return array
     */
    public static function transform($configuraciones): array
    {
        if ($configuraciones instanceof ConfiguracionEntity) {
            // Si es un solo usuario, lo envolvemos en array
            return [ConfiguracionTransformer::transform($configuraciones)];
        }

        if (is_array($configuraciones)) {
            return array_map(fn($u) => ConfiguracionTransformer::transform($u), $configuraciones);
        }

        return [];
    }
}
