<?php

namespace App\Transformadores;

use App\Entities\UsuarioEntity;

class UsuarioCollectionTransformer
{
    /**
     * Transforma uno o varios usuarios en un array uniforme
     *
     * @param UsuarioEntity|array $usuarios
     * @return array
     */
    public static function transform($usuarios): array
    {
        if ($usuarios instanceof UsuarioEntity) {
            // Si es un solo usuario, lo envolvemos en array
            return [UsuarioTransformer::transform($usuarios)];
        }

        if (is_array($usuarios)) {
            return array_map(fn($u) => UsuarioTransformer::transform($u), $usuarios);
        }

        return [];
    }
}
