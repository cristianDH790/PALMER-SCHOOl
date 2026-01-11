<?php

namespace App\Transformadores;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Entities\MensajeEntity;
use App\Entities\ParametroEntity;
use App\Entities\SliderEntity;
use App\Entities\UsuarioEntity;

class ContenidoWebCategoriaCollectionTransformer
{
    /**
     * Transforma uno o varios parametros en un array uniforme
     *
     * @param ContenidoWebCategoriaEntity|array $parametros
     * @return array
     */
    public static function transform($contenidowebcategorias): array
    {
        if ($contenidowebcategorias instanceof ContenidoWebCategoriaEntity) {
            // Si es un solo parametro, lo envolvemos en array
            return [ContenidoWebCategoriaTransformer::transform($contenidowebcategorias)];
        }

        if (is_array($contenidowebcategorias)) {
            return array_map(fn($u) => ContenidoWebCategoriaTransformer::transform($u), $contenidowebcategorias);
        }

        return [];
    }
}
