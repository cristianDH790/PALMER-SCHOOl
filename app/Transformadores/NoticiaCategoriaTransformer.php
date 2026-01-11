<?php

namespace App\Transformadores;

use App\Entities\NoticiaCategoriaEntity;

use App\Models\EstadoModel;
use App\Models\NoticiaCategoriaModel;


class NoticiaCategoriaTransformer
{
    public static function transform(NoticiaCategoriaEntity $noticiacategoria)
    {
        return [
            'idNoticiaCategoria' => (int) $noticiacategoria->idnoticiacategoria,
            'idEstado' => (int) $noticiacategoria->idestado,
            'idrNoticiaCategoria' => (int) $noticiacategoria->idrnoticiacategoria,
            'nombres' => $noticiacategoria->nombre,
            'orden' => $noticiacategoria->orden,
            'fecha' => $noticiacategoria->fecha,

         
            'rNoticiaCategoria' => ($categoria = (new NoticiaCategoriaModel())->obtenerPorId($noticiacategoria->idrnoticiacategoria)) ? NoticiaCategoriaTransformer::transform($categoria) : null,
            'estado' => $noticiacategoria->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($noticiacategoria->idestado)) : null,
        ];
    }
}
