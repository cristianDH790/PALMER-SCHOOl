<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;
use App\Entities\SliderEntity;
use App\Models\ClaseModel;
use App\Models\EstadoModel;
use App\Models\ParametroModel;

class SliderTransformer
{
    public static function transform(SliderEntity $slider)
    {
        return [
            'idSlider' => (int) $slider->idslider,
            'idEstado' => (int) $slider->idestado,
            'idpRecurso' => (int) $slider->idprecurso,
            'nombre' => $slider->nombre,
            'urlRecurso' => $slider->urlrecurso,
            'descripcion' => $slider->descripcion,
            'urlImagen1' => $slider->urlimagen1,
            'urlImagen2' => $slider->urlimagen2,
            'urlArchivo1' => $slider->urlarchivo1,
            'urlArchivo2' => $slider->urlarchivo2,
            'orden' => $slider->orden,
            'fecha' => $slider->fecha,

            'pRecurso' => $slider->idprecurso ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($slider->idprecurso)) : null,
            'estado' => $slider->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($slider->idestado)) : null,
        ];
    }
}
