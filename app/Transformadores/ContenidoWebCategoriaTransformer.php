<?php

namespace App\Transformadores;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Models\ContenidoWebCategoriaModel;
use App\Models\EstadoModel;
use App\Models\ParametroModel;

class ContenidoWebCategoriaTransformer
{
    public static function transform(ContenidoWebCategoriaEntity $contenidowebcategoria)
    {
        return [
            'idContenidoWebCategoria' => (int) $contenidowebcategoria->idcontenidowebcategoria,
            'idEstado' => (int) $contenidowebcategoria->idestado,
            'idrContenidoWebCategoria' => (int) $contenidowebcategoria->idrcontenidowebcategoria,
            'nombre' => $contenidowebcategoria->nombre,
            'miniatura' => $contenidowebcategoria->miniatura,
            'banner' => $contenidowebcategoria->banner,
            'orden' => $contenidowebcategoria->orden,
            'fecha' => $contenidowebcategoria->fecha,

            'rContenidoWebCategoria' => $contenidowebcategoria->idrcontenidowebcategoria ? ContenidoWebCategoriaTransformer::transform((new ContenidoWebCategoriaModel())->obtenerPorId($contenidowebcategoria->idrcontenidowebcategoria)) : null,
            'estado' => $contenidowebcategoria->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($contenidowebcategoria->idestado)) : null,
        ];
    }
}
