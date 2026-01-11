<?php

namespace App\Transformadores;

use App\Entities\ContenidoWebCategoriaEntity;
use App\Entities\ContenidoWebEntity;
use App\Models\ContenidoWebCategoriaModel;
use App\Models\EstadoModel;
use App\Models\ParametroModel;

class ContenidoWebTransformer
{
    public static function transform(ContenidoWebEntity $contenidoweb)
    {
        return [
            'idContenidoWeb' => (int) $contenidoweb->idcontenidoweb,
            'idEstado' => (int) $contenidoweb->idestado,
            'idContenidoWebCategoria' => (int) $contenidoweb->idcontenidowebcategoria,
            'idpTipo' => (int) $contenidoweb->idptipo,
            'nombre' => $contenidoweb->nombre,
            'urlAmigable' => $contenidoweb->urlamigable,
            'resumen' => $contenidoweb->resumen,
            'contenido' => $contenidoweb->contenido,
            'seccion' => $contenidoweb->seccion,
            'urlImagen' => $contenidoweb->urlimagen,
            'urlBanner' => $contenidoweb->urlbanner,
            'orden' => $contenidoweb->orden,
            'tituloSeo' => $contenidoweb->tituloseo,
            'descripcionSeo' => $contenidoweb->descripcionseo,
            'palabrasClaveSeo' => $contenidoweb->palabrasclaveseo,
            'fecha' => $contenidoweb->fecha,

            'pTipo' => $contenidoweb->idptipo ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($contenidoweb->idptipo)) : null,
            'contenidoWebCategoria' => ($categoria = (new ContenidoWebCategoriaModel())->obtenerPorId($contenidoweb->idcontenidowebcategoria)) ? ContenidoWebCategoriaTransformer::transform($categoria) : null,
            'estado' => $contenidoweb->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($contenidoweb->idestado)) : null,
        ];
    }
}
