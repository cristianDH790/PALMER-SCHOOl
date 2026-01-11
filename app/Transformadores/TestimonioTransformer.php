<?php

namespace App\Transformadores;

use App\Entities\TestimonioEntity;
use App\Models\EstadoModel;
use App\Models\ParametroModel;


class TestimonioTransformer
{
    public static function transform(TestimonioEntity $testimonio)
    {
        return [
            'idTestimonio' => (int) $testimonio->idtestimonio,
            'idEstado' => (int) $testimonio->idestado,
            'idpDestacado' => (int) $testimonio->idpdestacado,
            'nombre' => $testimonio->nombre,
            'descripcion' => $testimonio->descripcion,
            'urlImagen' => $testimonio->urlimagen,
            'dni' => $testimonio->dni,
            'orden' => $testimonio->orden,
            'fecha' => $testimonio->fecha,


            'estado' => $testimonio->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($testimonio->idestado)) : null,
            'pDestacado' => $testimonio->idpdestacado ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($testimonio->idpdestacado)) : null,

        ];
    }
}
