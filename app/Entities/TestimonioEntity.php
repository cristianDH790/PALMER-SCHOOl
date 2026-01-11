<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TestimonioEntity extends Entity
{
   protected $attributes = [
    'idtestimonio'        => null,
    'idestado'          => null,
    'idpdestacado'      => null,
    'nombre'            => null,
    'descripcion'       => null,
    'urlimagen'         => null,
    'dni'           => null,
    'orden'             => 0,
    'fecha'             => null,
];



    
}
