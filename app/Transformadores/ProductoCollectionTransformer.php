<?php

namespace App\Transformadores;


use App\Entities\ProductoEntity;

class ProductoCollectionTransformer
{
    /**
     * Transforma uno o varios productos en un array uniforme
     *
     * @param ProductoEntity|array $productos
     * @return array
     */
    public static function transform($productos): array
    {
        if ($productos instanceof ProductoEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [ProductoTransformer::transform($productos)];
        }

        if (is_array($productos)) {
            return array_map(fn($u) => ProductoTransformer::transform($u), $productos);
        }

        return [];
    }
}
