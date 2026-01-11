<?php

namespace App\Transformadores;


use App\Entities\TestimonioEntity;

class TestimonioCollectionTransformer
{
    /**
     * Transforma uno o varios testimonios en un array uniforme
     *
     * @param TestimonioEntity|array $testimonios
     * @return array
     */
    public static function transform($testimonios): array
    {
        if ($testimonios instanceof TestimonioEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [TestimonioTransformer::transform($testimonios)];
        }

        if (is_array($testimonios)) {
            return array_map(fn($u) => TestimonioTransformer::transform($u), $testimonios);
        }

        return [];
    }
}
