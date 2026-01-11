<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;
use App\Entities\MenuEntity;
use App\Models\ClaseModel;
use App\Models\EstadoModel;
use App\Models\MenuModel;
use App\Models\ParametroModel;

class MenuTransformer
{
    public static function transform(MenuEntity $menu)
    {
        return [
            'idMenu' => (int) $menu->idmenu,
            'idEstado' => (int) $menu->idestado,
            'idrMenu' => (int) $menu->idrmenu,
            'idpUbicacion' => (int) $menu->idpubicacion,
            'idpDestino' => (int) $menu->idpdestino,
            'nombre' => $menu->nombre,
            'destino' => $menu->destino,
            'seccion' => $menu->seccion,
            'orden' => $menu->orden,
            'fecha' => $menu->fecha,

            'pDestino' => $menu->idpdestino ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($menu->idpdestino)) : null,
            'pUbicacion' => $menu->idpubicacion ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($menu->idpubicacion)) : null,
            'pTipo' => $menu->idptipo ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($menu->idptipo)) : null,
            'rMenu' => $menu->idrmenu ? MenuTransformer::transform((new MenuModel())->obtenerPorId($menu->idrmenu)) : null,
            'estado' => $menu->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($menu->idestado)) : null,
        ];
    }
}
