<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;

use App\Models\ClaseModel;
use App\Models\EstadoModel;


class MensajeTransformer
{
    public static function transform(MensajeEntity $mensaje)
    {
        return [
            'idMensaje' => (int) $mensaje->idmensaje,
            'idEstado' => (int) $mensaje->idestado,
            'idClase' => (int) $mensaje->idclase,
            'nombre' => $mensaje->nombre,
            'contenido' => $mensaje->contenido,
            'asunto' => $mensaje->asunto,
            'observacion' => $mensaje->observacion,
            'fecha' => $mensaje->fecha,

            'clase' => $mensaje->idclase ? ClaseTransformer::transform((new ClaseModel())->obtenerPorId($mensaje->idclase)) : null,
            'estado' => $mensaje->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($mensaje->idestado)) : null,
        ];
    }
}
