<?php

namespace App\Transformadores;

use App\Entities\MenuEntity;


class MenuCollectionTransformer
{
    /**
     * Transforma uno o varios menu en un array uniforme
     *
     * @param MenuEntity|array $menu
     * @return array
     */
    public static function transform($menus): array
    {
        if ($menus instanceof MenuEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [MenuTransformer::transform($menus)];
        }

        if (is_array($menus)) {
            return array_map(fn($u) => MenuTransformer::transform($u), $menus);
        }

        return [];
    }
}
