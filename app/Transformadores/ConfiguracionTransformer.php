<?php

namespace App\Transformadores;

use App\Entities\ConfiguracionEntity;

use App\Models\ParametroModel;

class ConfiguracionTransformer
{
    public static function transform(ConfiguracionEntity $configuracion)
    {
        return [
            'idConfiguracion' => (int)$configuracion->idconfiguracion,
            'idpTipo' => (int)$configuracion->idptipo,
            'idpRecurso' => (int)$configuracion->idprecurso,
            'nombre' => $configuracion->nombre,
            'valor' => $configuracion->valor,
            'descripcion' => $configuracion->descripcion,
            'urlImagen' => $configuracion->urlimagen,
            'fecha' => $configuracion->fecha,
            // Llama al modelo aquí para traer la clase relacionada
            'pTipo' => $configuracion->idptipo
                ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($configuracion->idptipo))
                : null,
            'pRecurso' => $configuracion->idprecurso
                ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($configuracion->idprecurso))
                : null,
        ];
    }
}
