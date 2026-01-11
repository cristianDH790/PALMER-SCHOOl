<?php

namespace App\Transformadores;

use App\Entities\MensajeEntity;
use App\Entities\ProductoCategoriaEntity;
use App\Entities\ProductoEntity;
use App\Models\ClaseModel;
use App\Models\EstadoModel;
use App\Models\ListaDeseoModel;
use App\Models\ParametroModel;
use App\Models\PedidoModel;
use App\Models\ProductoCategoriaModel;
use App\Models\ProductoColorModel;
use App\Models\ProductoGrupoModel;
use App\Models\ProductoModel;
use App\Models\TipoModel;

class ProductoTransformer
{
    public static function transform(ProductoEntity $producto)
    {
        return [
            'idProducto' => (int) $producto->idproducto,
            'idEstado' => (int) $producto->idestado,
            'idpDestacado' => (int) $producto->idpdestacado,
            'nombre' => $producto->nombre,
            'urlAmigable' => $producto->urlamigable,
            'urlImagen' => $producto->urlimagen,
            'resumen' => $producto->resumen,
            'contenido' => $producto->contenido,
            'orden' => $producto->orden,
            'fechaPublicacion' => $producto->fechapublicacion,
            'fecha' => $producto->fecha,


            'estado' => $producto->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($producto->idestado)) : null,
            'pDestacado' => $producto->idpdestacado ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($producto->idpdestacado)) : null,

        ];
    }
}
