<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductoEntity extends Entity
{
   protected $attributes = [
    'idproducto'        => null,
    'idestado'          => null,
    'idpdestacado'      => null,
    'nombre'            => null,
    'urlamigable'       => null,
    'urlimagen'         => null,
    'resumen'           => null,
    'contenido'         => null,
    'orden'             => 0,
    'fechapublicacion'  => null,
    'fecha'             => null,
];



    
}
