<?php

namespace App\Transformadores;

use App\Entities\NivelEntity;
use App\Entities\NoticiaEntity;
use App\Models\EstadoModel;
use App\Models\ParametroModel;

class NivelTransformer
{
    public static function transform(NivelEntity $nivel)
    {
        return [
            'idNivel' => (int) $nivel->idnivel,
            'idEstado' => (int) $nivel->idestado,
            'idpDestacado' => (int) $nivel->idpdestacado,
            'nombre' => $nivel->nombre,
            'urlAmigable' => $nivel->urlamigable,
            'resumen' => $nivel->resumen,
            'contenido' => $nivel->contenido,
            'urlImagen' => $nivel->urlimagen,
            'orden' => $nivel->orden,
            'descripcionSeo' => $nivel->descripcionseo,
            'fecha' => $nivel->fecha,

            'estado' => $nivel->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($nivel->idestado)) : null,
            'pDestacado' => $nivel->idpdestacado ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($nivel->idpdestacado)) : null,
        ];
    }
}
