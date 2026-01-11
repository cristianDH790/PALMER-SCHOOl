<?php

namespace App\Transformadores;

use App\Entities\NoticiaEntity;
use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;
use App\Models\ParametroModel;

class NoticiaTransformer
{
    public static function transform(NoticiaEntity $noticia)
    {
        return [
            'idNoticia' => (int) $noticia->idnoticia,
            'idEstado' => (int) $noticia->idestado,
            'idNoticiaCategoria' => (int) $noticia->idnoticiacategoria,
            'idpDestacado' => (int) $noticia->idpdestacado,
            'nombre' => $noticia->nombre,
            'urlAmigable' => $noticia->urlamigable,
            'resumen' => $noticia->resumen,
            'contenido' => $noticia->contenido,
            'urlImagen' => $noticia->urlimagen,
            'orden' => $noticia->orden,
            'descripcionSeo' => $noticia->descripcionseo,
            'fecha' => $noticia->fecha,

         
            'noticiaCategoria' => ($categoria = (new NoticiaCategoriaModel())->obtenerPorId($noticia->idnoticiacategoria)) ? NoticiaCategoriaTransformer::transform($categoria) : null,
            'estado' => $noticia->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($noticia->idestado)) : null,
            'pDestacado' => $noticia->idpdestacado ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($noticia->idpdestacado)) : null,
        ];
    }
}
